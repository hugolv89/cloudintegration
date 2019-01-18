<?php

namespace HLV\Cloud\Api;

use \HLV\Cloud\User\CredentialsHandler as CredentialsHandler;

class WebDAV extends \HLV\Utils\Curl{

	private $_rawResponse = true;
	private $_uriApi = 'remote.php/webdav';

	public function __construct($password = '') {

		$auth = CredentialsHandler::USER($password).':'.CredentialsHandler::PASSWORD($password);
		
		$schema = parse_url(CredentialsHandler::SERVER(), PHP_URL_SCHEME);
		$host = parse_url(CredentialsHandler::SERVER(), PHP_URL_HOST);
		$path = parse_url(CredentialsHandler::SERVER(), PHP_URL_PATH);

		$url = $this->cleanString($schema.'://'.$host.rtrim($path,'/').'/'.$this->_uriApi);

		parent::__construct($url,$auth);
	}

	/**
	 * Get raw data?
	 * True  => RAW
	 * False => SimpleXMLElement Object (If posible, Otherwise RAW)
	 */
	public function rawData($bool = true){

		$this->_rawResponse = $bool;
	}

	/**
	 * Response
	 */
	private function response($data){

		if(!$this->_rawResponse){

			if($sXMLe = simplexml_load_string($data, null, 0, 'd', true)){

				return $sXMLe;
			}
		}

		return $data;
	}

	public function getProperties($URIPath = ''){

		if( $request = $this->CUSTOMREQUEST('PROPFIND', $URIPath) ){

			return $this->response($request);
		}
		
		return false;
	}

	public function remove($URIPath){

		if($URIPath != '' && $URIPath != null){

			if( $request = $this->DELETE($URIPath) ){

				return $this->response($request);
			}

		}

		return false;
	}

	public function mkdir($URIPath){

		if($URIPath != '' && $URIPath != null){

			if( $request = $this->CUSTOMREQUEST('MKCOL', $URIPath) ){

				return $this->response($request);
			}

		}
		
		return false;
	}

	public function move($URIpath, $newURIPath){

		if($URIpath != '' && $URIpath != null && $newURIPath != '' && $newURIPath != null){

			$httpheader_array = array(
				'Destination:'.$this->buildURL($this->getURL(), $newURIPath),
			);

			if( $request = $this->CUSTOMREQUEST('MOVE', $URIpath, null, $httpheader_array) ){

				return $this->response($request);
			}

		}
		
		return false;
	}

	public function download($serverFileURI){

		if($serverFileURI != '' && $serverFileURI != null){

			if( $request = $this->GET($serverFileURI) ){

				return $this->response($request);
			}
		}
		
		return false;
	}

	public function upload($serverFileURI, $absoluteFilePath){

		if($serverFileURI != '' && $serverFileURI != null && $absoluteFilePath != '' && $absoluteFilePath != null){

			if( $request = $this->PUT_UPLOAD($serverFileURI,$absoluteFilePath) ){

				return $this->response($request);
			}

		}
		
		return false;
	}

}

?>
