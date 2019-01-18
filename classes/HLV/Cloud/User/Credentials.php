<?php

namespace HLV\Cloud\User;

use \HLV\Cloud\Encrypt\EncryptHandler as EncryptHandler;
use \HLV\Functions as Functions;

class Credentials extends CredentialsAbstract{

	public function isReady($password = ''){

		if(Functions::USETTING('is_encrypt') && Functions::USETTING('credential_user') != '' && Functions::USETTING('credential_password') != '' && Functions::USETTING('credential_password') == Functions::USETTING('credential_passwordagain')){
			
			$ocs = new \HLV\Cloud\Api\OCS($password);
			$ocs->rawData(false);
			$statuscode = $ocs->allShares()->meta->statuscode;

			if($statuscode == 200 || $statuscode == 404){ //404 - couldn't fetch shares

				return true;
			}else{

				register_error(elgg_echo('cloudintegration:usersettings:error:credential'));
			}
		}

		return false;
	}

	public function user($password = ''){

		$user = elgg_get_logged_in_user_entity()->username;

		if(Functions::SETTING_BOOL('enable_customcredentials') && $userdecrypt = EncryptHandler::DECRYPT(Functions::USETTING('credential_user'),$password) ){

			$user = $userdecrypt;
		}

		return $user;
	}

	public function password($password = ''){

		$pass = ''; // TODO

		if(Functions::SETTING_BOOL('enable_customcredentials') && $passdecrypt = EncryptHandler::DECRYPT(Functions::USETTING('credential_password'),$password) ){

			$pass = $passdecrypt;
		}

		return $pass;
	}

	public function server(){

		$server = Functions::SETTING('custom_urldefault');

		if(Functions::SETTING_BOOL('enable_custom_url')){

			$server = Functions::USETTING('user_custom_url');
		}

		return $server;
	}

}

?>
