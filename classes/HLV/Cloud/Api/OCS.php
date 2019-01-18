<?php

namespace HLV\Cloud\Api;

use \HLV\Cloud\User\CredentialsHandler as CredentialsHandler;

class OCS extends \HLV\Utils\Curl {

	private $_uriApi = 'ocs/v2.php/apps/files_sharing/api/v1'; //https://docs.nextcloud.com/server/14/developer_manual/core/ocs-share-api.html

	private $_rawResponse = true;

	public function __construct($password = '') {

		$schema = parse_url(CredentialsHandler::SERVER(), PHP_URL_SCHEME);
		$auth = CredentialsHandler::USER($password).':'.urlencode(CredentialsHandler::PASSWORD($password)).'@';
		$host = parse_url(CredentialsHandler::SERVER(), PHP_URL_HOST);
		$path = parse_url(CredentialsHandler::SERVER(), PHP_URL_PATH);

		$url = $schema.'://'.$auth.$host.rtrim($path,'/').'/'.$this->_uriApi;

		parent::__construct($url);
	}

	/**
	 * Get raw data?
	 * True  => RAW
	 * False => SimpleXMLElement Object (If Posible, Otherwise RAW)
	 */
	public function rawData($bool = true){

		$this->_rawResponse = $bool;
	}

	/**
	 * Response
	 */
	private function response($data){

		if(!$this->_rawResponse){

			if($sXMLe = simplexml_load_string($data)){

				return $sXMLe;
			}
		}

		return $data;
	}

	/**
	 * Get all shares from the user.
	 */
	public function allShares(){

		if( $request = $this->GET('/shares', array('OCS-APIRequest: true')) ){

			return $this->response($request);
		}

		return false;
	}

	/**
	 * Get all shares from a given file/folder.
	 * URL Arguments: path - (string) path to file/folder
	 * URL Arguments: reshares - (boolean) returns not only the shares from the current user but all shares from the given file.
	 * URL Arguments: subfiles - (boolean) returns all shares within a folder, given that path defines a folder
	 * Mandatory fields: path
	 */
	public function getShares($path, $reshares = false, $subfiles = false){

		if(!empty($path)){

			/*$fields_array = array(
				    'path' => $path,
				    'reshares' => var_export($reshares,true),
				    'subfiles' => var_export($subfiles,true)
			);http_build_query($fields_array)*/
			
			$GetQuery = 'path='.$path.'&reshares='.var_export($reshares,true).'&subfiles='.var_export($subfiles,true);

			if( $request = $this->GET('/shares?'.$GetQuery, array('OCS-APIRequest: true')) ){

				return $this->response($request);
			}
		}

		return false;
	}

	/**
	 * Get information about a given share.
	 * Arguments: share_id - (int) share ID
	 * Mandatory fields: share_id
	 */
	public function getShareByID($share_id){

		if(!empty($share_id) || $share_id == 0){

			if( $request = $this->GET('/shares/'.$share_id, array('OCS-APIRequest: true')) ){

				return $this->response($request);
			}
		}

		return false;
	}

	/**
	 * Share a file/folder with a user/group or as public link.
	 * POST Arguments: path - (string) path to the file/folder which should be shared
	 * POST Arguments: shareType - (int) '0' = user; '1' = group; '3' = public link
	 * POST Arguments: shareWith - (string) user / group id with which the file should be shared
	 * POST Arguments: publicUpload - (boolean) allow public upload to a public shared folder (true/false)
	 * POST Arguments: password - (string) password to protect public link Share with
	 * POST Arguments: permissions - (int) 1 = read; 2 = update; 4 = create; 8 = delete; 16 = share; 31 = all (default: 31, for public shares: 1)
	 * Mandatory fields: shareType, path and shareWith for shareType 0 or 1.
	 */
	public function createShare($path, $shareType = 3, $shareWith = '', $publicUpload = false, $password = '', $permissions = 1){

		if(!empty($path) && (!empty($shareType) || $shareType == 0)){

			if( !( ($shareType == 0 || $shareType == 1) && empty($shareWith) ) ){

				$fields_array = array(
				    'path' => urldecode($path), // Path sin modificar ni codificar
				    'shareType' => $shareType,
				    'shareWith' => $shareWith,
				    'publicUpload' => var_export($publicUpload,true),
				    'password' => $password,
				    'permissions' => $permissions
				);

				if( $request = $this->POST('/shares',$fields_array, array('OCS-APIRequest: true')) ){

					return $request->getHttpCode();
				}
			}
		}

		return false;
	}

	/**
	 * Remove the given share.
	 * Arguments: share_id - (int) share ID
	 */
	public function deleteShare($share_id){

		if(!empty($share_id) || $share_id == 0){

			if( $request = $this->DELETE('/shares/'.$share_id, null, array('OCS-APIRequest: true')) ){

				return $request->getHttpCode();
			}
		}

		return false;
	}

	/**
	 * Update a given share. Only one value can be updated per request.
	 * Arguments: share_id - (int) share ID
	 * PUT Arguments: permissions - (int) update permissions (see "Create share" above)
	 * PUT Arguments: password - (string) updated password for public link Share
	 * PUT Arguments: publicUpload - (boolean) enable (true) /disable (false) public upload for public shares
	 *
	 * Note that only one of "password" or "publicUpload" can be specified at once.
	 * password	=> $password != '' && $publicUpload == null
	 * publicUpload	=> $password == '' && $publicUpload != null
	 */
	public function updateShare($share_id, $permissions = 1, $password = '', $publicUpload = null){

		if(!empty($path) && (!empty($shareType) || $shareType == 0)){

			if( !( ($shareType == 0 || $shareType == 1) && empty($shareWith) ) ){

				$fields_array = array(
				    'share_id' => $share_id,
				    'permissions' => $permissions
				);

				if($password != '' && $publicUpload == null){
					
					$fields_array += array('password' => $password);
				}else if($password == '' && $publicUpload != null){
					
					$fields_array += array('publicUpload' => var_export($publicUpload,true));
				}

				if( $request = $this->PUT('/shares/'.$share_id,$fields_array, array('OCS-APIRequest: true')) ){

					return $request->getHttpCode();
				}
			}
		}

		return false;
	}

}

?>
