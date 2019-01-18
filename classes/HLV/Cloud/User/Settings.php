<?php

namespace HLV\Cloud\User;

use \HLV\Functions as Functions;
use \HLV\Cloud\Encrypt\EncryptHandler as EncryptHandler;

class Settings {

	private $_password = '';

	public function __construct($password = '') {

		$this->_password = $password;
	}

	public function verifyCloudIntegrationServer(){

		if(Functions::SETTING_BOOL('enable_custom_url')){

			$server = Functions::USETTING('user_custom_url');

			if(empty($server)){
				$server = Functions::SETTING('custom_urldefault');
			}else{
				if(!Functions::SETTING_BOOL('disable_secure_url')){

					if(parse_url($server, PHP_URL_SCHEME) != 'https'){
						register_error(elgg_echo('cloudintegration:settings:error:cloudintegration:url:secure'));
						$server = Functions::SETTING('custom_urldefault');
					}
				}
			}

			elgg_set_plugin_user_setting('user_custom_url', $server, elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);
			return $server;
		}

		return false;
	}

	public function newCredentials(){

		$credential_user = Functions::USETTING('credential_user');	
		$credential_password = Functions::USETTING('credential_password');	
		$credential_passwordagain = Functions::USETTING('credential_passwordagain');

		if(Functions::USETTING_BOOL('enable_unlink')){

		    elgg_set_plugin_user_setting('enable_unlink', 'false', elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);

			$credential_user = '';
			$credential_password = '';
			$credential_passwordagain = '';
		}

		if(empty($credential_user) || empty($credential_password) || $credential_password != $credential_passwordagain){

		    elgg_set_plugin_user_setting('is_encrypt', 'false', elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);

			// Error
			if(!(empty($credential_user) && empty($credential_password) && empty($credential_passwordagain))){
				if($credential_password != $credential_passwordagain || $credential_password == ''){
					register_error(elgg_echo('cloudintegration:usersettings:error:password'));
				}
				if(empty($credential_user)){
					register_error(elgg_echo('cloudintegration:usersettings:error:empty'));
				}
			}

			// Clear credentials
			elgg_set_plugin_user_setting('credential_user', '', elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);
			elgg_set_plugin_user_setting('credential_password', '', elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);
			elgg_set_plugin_user_setting('credential_passwordagain', '', elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);

			return true;
		}

		return false;
	}

	public function encryptCredentials(){

		$credential_user = Functions::USETTING('credential_user');	
		$credential_password = Functions::USETTING('credential_password');	
		$credential_passwordagain = Functions::USETTING('credential_passwordagain');

		if(!empty($credential_user) && !empty($credential_password) && $credential_password == $credential_passwordagain && !Functions::USETTING_BOOL('is_encrypt')){

			$encrypt_user = EncryptHandler::ENCRYPT($credential_user,$this->_password);
			$encrypt_password = EncryptHandler::ENCRYPT($credential_password,$this->_password);

			// save credentials
			elgg_set_plugin_user_setting('credential_user', $encrypt_user, elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);
			elgg_set_plugin_user_setting('credential_password', $encrypt_password, elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);
			elgg_set_plugin_user_setting('credential_passwordagain', $encrypt_password, elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);

			elgg_set_plugin_user_setting('is_encrypt', 'true', elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);

			return true;
		}

		elgg_set_plugin_user_setting('is_encrypt', 'false', elgg_get_logged_in_user_entity()->guid, \HLV\PLUGIN_ID);

		return false;
	}

}

?>
