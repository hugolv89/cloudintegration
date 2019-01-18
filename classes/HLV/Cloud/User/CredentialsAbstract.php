<?php

namespace HLV\Cloud\User;

abstract class CredentialsAbstract{

	abstract public function isReady($password);

	abstract public function user($password);

	abstract public function password($password);

	abstract public function server();

}

?>
