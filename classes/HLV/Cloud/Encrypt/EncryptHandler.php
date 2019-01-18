<?php

namespace HLV\Cloud\Encrypt;

class EncryptHandler{

	private static $_instance = null;
	// Default class
	private static $_classname = '\HLV\Cloud\Encrypt\Encryption';

	// Default seed
	private static $_seed = 'ufK!{+f%&9>T")nEM"s_<Vr2UPv";g-3Kr&w<q4eaq68]u>P"MS&bg7E83byey2X';

	private static function GET_INSTANCE(){

		if(EncryptHandler::$_instance == null){

			EncryptHandler::$_instance = new EncryptHandler::$_classname();

			if(!is_a(EncryptHandler::$_instance,'\HLV\Cloud\Encrypt\EncryptAbstract')){

				EncryptHandler::$_instance = null;
				return null;
			}

			EncryptHandler::$_instance->setSeed(EncryptHandler::$_seed);
		}
		
		return EncryptHandler::$_instance;
	}

	public static function SET_HANDLER($classname){

		EncryptHandler::$_instance = null;
		EncryptHandler::$_classname = $classname;
	}

	public static function SET_SEED($seed){

		EncryptHandler::$_instance = null;
		EncryptHandler::$_seed = $seed;
	}

	public static function ENCRYPT($data,$password = ''){

		return EncryptHandler::GET_INSTANCE()->encrypt($data,$password);
	}

	public static function DECRYPT($data,$password = ''){

		return EncryptHandler::GET_INSTANCE()->decrypt($data,$password);
	}

}

?>
