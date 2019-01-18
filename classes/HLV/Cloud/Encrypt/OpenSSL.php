<?php

namespace HLV\Cloud\Encrypt;

class OpenSSL extends EncryptAbstract{

	private static $algorithm = "AES-256-CBC"; 
	private static $options = OPENSSL_RAW_DATA;

	protected function encryptData($data,$password){

		if (!function_exists("openssl_digest")) {
			throw new Exception("Encrypt needs openssl php module.");
		}
	
		$iv = self::getIV();

		$encrypted = openssl_encrypt($data, self::$algorithm, self::getKey($password), self::$options, $iv);
		$binary = $iv.$encrypted;
		
		return base64_encode($binary);
	}

	protected function decryptData($data,$password){

		if (!function_exists("openssl_digest")) {
			throw new Exception("Encrypt needs openssl php module.");
		}
		
		$binary = base64_decode($data);
		$size = self::getSize();
		$iv = substr($binary, 0, $size);
		$encrypted = substr($binary, $size);
		
		$text = openssl_decrypt($encrypted, self::$algorithm, self::getKey($password), self::$options, $iv);
		
		return $text;
	}
	
	private static function getKey($password) {
		
		return openssl_digest($password, 'sha256');
	}
	
	private static function getIV() {
		
		return openssl_random_pseudo_bytes(self::getSize());
	}
	
	private static function getSize() {
		
		return openssl_cipher_iv_length(self::$algorithm);
	}

}

?>