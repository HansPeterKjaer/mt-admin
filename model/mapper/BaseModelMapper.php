<?php

abstract class BaseModelMapper {
	protected $dbhandle;
	protected $auth;

	public function __construct($dbhandle, $auth) {
		$this->dbhandle = $dbhandle;
		$this->auth = $auth;
	}
}

?>