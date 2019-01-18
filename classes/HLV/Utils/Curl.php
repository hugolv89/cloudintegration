<?php

namespace HLV\Utils;

class Curl{

	private $_boolHeader = false;
	private $_SSL_verifypeer = false;
	private $_url = null;
	private $_userpwd = null;

	public function __construct($url,$userpwd = null) {

		$this->setURL($url);
		$this->setUSERPWD($userpwd);
	}

	public function setURL($url){

		$this->_url = rtrim(trim($url),'/').'/';
	}

	public function setUSERPWD($userpwd = null){

		$this->_userpwd = $this->cleanString($userpwd);
	}

	public function header($bool = false){

		$this->_boolHeader = $bool;
	}

	protected function getURL(){

		if($this->_url != null){

			return $this->_url;
		}

		return false;
	}

	private function getUSERPWD(){

		if($this->_userpwd != null){

			return $this->_userpwd;
		}

		return false;
	}

	/**
	 * Clean invisible characters
	 */
	protected function cleanString($string){

		return preg_replace('/[^[:print:]]/', '',$string); 
	}

	/**
	 * Build a clean url
	 */
	protected function buildURL($url, $uri){

		$url = trim($url);
		$uri = ltrim(trim($uri),'/');

		return $this->cleanString($url.$uri);
	}

	public function GET($uri = '', $httpheader_array = null){

		return $this->CUSTOMREQUEST('GET', $uri, null, $httpheader_array);
	}

	public function POST($uri, $fields_array = null, $httpheader_array = null){

		return $this->CUSTOMREQUEST('POST', $uri, $fields_array, $httpheader_array);
	}

	public function DELETE($uri, $fields_array = null, $httpheader_array = null){

		return $this->CUSTOMREQUEST('DELETE', $uri, $fields_array, $httpheader_array);
	}

	public function PUT($uri, $fields_array = null, $httpheader_array = null){

		return $this->CUSTOMREQUEST('PUT', $uri, $fields_array, $httpheader_array);
	}

	public function PUT_UPLOAD($uriPath, $absolutePath){

		if($this->getURL()){

			if(is_readable($absolutePath) && !is_dir($absolutePath)){
			 
				$fp = fopen ($absolutePath, "rb");

				// Get cURL resource
				$curl = curl_init();

				// Set some options
				$options = array(
					CURLOPT_HEADER => $this->_boolHeader,
					CURLOPT_SSL_VERIFYPEER => $this->_SSL_verifypeer,
					CURLOPT_USERPWD => $this->getUSERPWD(),
					CURLOPT_URL => $this->buildURL($this->getURL(),$uriPath),
				    CURLOPT_PUT => 1,
				    CURLOPT_BINARYTRANSFER => 1,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_INFILE => $fp,
				    CURLOPT_INFILESIZE => filesize($absolutePath),
				);

				curl_setopt_array($curl, $options);

				// Send the request & save response to $resp
				$data = curl_exec($curl);
				$curlInfo = curl_getinfo($curl);
				// Close request to clear up some resources
				curl_close($curl);

				fclose($fp);

				$response = new Response($curlInfo, $data);

				return $response;
			}
		}

		return false;
	}

	public function CUSTOMREQUEST($type, $uri = '', $fields_array = null, $httpheader_array = null, $binary_transfer = false){

		if($type != ''){

			if($url = $this->getURL()){

				// Get cURL resource
				$curl = curl_init();

				// Set some options
				$options = array(
					CURLOPT_HEADER => $this->_boolHeader,
					CURLOPT_SSL_VERIFYPEER => $this->_SSL_verifypeer,
				    CURLOPT_RETURNTRANSFER => true,
				    CURLOPT_URL => $this->buildURL($url,$uri),
				    CURLOPT_CUSTOMREQUEST => $this->cleanString($type)
				);

				if($auth = $this->getUSERPWD()){

					$options += array(
					    	CURLOPT_HTTPAUTH => CURLAUTH_DIGEST || CURLAUTH_BASIC,
					    	CURLOPT_USERPWD => $auth
					); 
				}
				
				if($httpheader_array != null){

					$options += array(
						    	CURLOPT_HTTPHEADER => $httpheader_array
					); 
				}

				if($fields_array != null && !$binary_transfer){
					$options += array(
					    	CURLOPT_POSTFIELDS => http_build_query($fields_array)
					); 
				}

				curl_setopt_array($curl, $options);

				// Send the request & save response to $data
				$data = curl_exec($curl);
				$curlInfo = curl_getinfo($curl);
				// Close request to clear up some resources
				curl_close($curl);

				$response = new Response($curlInfo, $data);

				return $response;
			}
		}

		return false;
	}

}

?>
