<?php

namespace HLV\Utils;

class Response{

	private $_header;
	private $_response;
	private $_httpCode;
	private $_curlInfo;

	public function __construct($curlInfo, $response) {

		$this->_curlInfo = $curlInfo;
		$this->_httpCode = $this->_curlInfo['http_code'];

		$this->_header = substr($response, 0, $this->_curlInfo['header_size']);
		
		if($this->_curlInfo['download_content_length'] < 0){
			
			$this->_response = $response;
		}else{
			
			$this->_response = substr($response, -$this->_curlInfo['download_content_length']);
		}
		
	}

	public function getHeader(){

		return $this->_header;
	}

	public function getResponse(){

		return $this->_response;
	}

	public function getHttpCode(){

		return $this->_httpCode;
	}

	public function getCurlInfo(){

		return $this->_httpCode;
	}

	public function __toString(){

		if(empty($this->getResponse())){
		
			return "";
		}

		return $this->getResponse();
	}
	
}

?>