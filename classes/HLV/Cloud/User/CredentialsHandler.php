<?php

namespace HLV\Cloud\User;

class CredentialsHandler{

	private static $_instance = null;
	// Default class
	private static $_classname = '\HLV\Cloud\User\Credentials';

	private static function GET_INSTANCE(){

		if(CredentialsHandler::$_instance == null){

			CredentialsHandler::$_instance = new CredentialsHandler::$_classname();

			if(!is_a(CredentialsHandler::$_instance,'\HLV\Cloud\User\CredentialsAbstract')){

				CredentialsHandler::$_instance = null;
				return null;
			}
		}
		
		return CredentialsHandler::$_instance;
	}

	public static function SET_HANDLER($classname){

		CredentialsHandler::$_instance = null;
		CredentialsHandler::$_classname = $classname;
	}

	public static function IS_READY($password = ''){

		return CredentialsHandler::GET_INSTANCE()->isReady($password);
	}

	public static function USER($password = ''){

		return CredentialsHandler::GET_INSTANCE()->user($password);
	}

	public static function PASSWORD($password = ''){

		return CredentialsHandler::GET_INSTANCE()->password($password);
	}

	public static function SERVER(){

		$server = preg_replace('/[^[:print:]]/', '',trim(CredentialsHandler::GET_INSTANCE()->server())); // Clean Invisible Characters

		//return rtrim(CredentialsHandler::GET_INSTANCE()->server(),'/').'/';
		return rtrim($server,'/').'/';
	}

}

?>
