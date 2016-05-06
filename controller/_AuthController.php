<?php

class _AuthController extends SecureController {
	protected function registerAction(){
		$viewmodel = null;
		#$this->returnPureView("loginView",$viewmodel);
	}
	protected function logoutAction(){
		$this->auth->logout($_COOKIE['authID']);
		setcookie('authID', '', time() - 3600, '/');

		header('Location: ' . URLHelper::getURL('auth/logout'));
	}	
}
?>