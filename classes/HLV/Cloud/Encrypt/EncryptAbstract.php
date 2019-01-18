<?php

namespace HLV\Cloud\Encrypt;

abstract class EncryptAbstract{

	// Default seed
	private $_seed = 'ufK!{+f%&9>T")nEM"s_<Vr2UPv";g-3Kr&w<q4eaq68]u>P"MS&bg7E83byey2X';

	public function setSeed($seed){

		$this->_seed = $seed;
	}

	protected function getSeed(){

		return $this->_seed;
	}

	protected function secret(){

		return hash('sha256',elgg_get_logged_in_user_entity()->username.$this->getSeed());
	}

	public function encrypt($data,$password = ''){

		return $this->encryptData($data,$this->secret().$password);
	}

	public function decrypt($data,$password = ''){

		return $this->decryptData($data,$this->secret().$password);
	}

	abstract protected function encryptData($data,$password);

	abstract protected function decryptData($data,$password);

}

?>
