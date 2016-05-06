<?php

class LoginController extends BaseController {
	public function indexAction(){
		$viewmodel = $this->modelFactory->buildObject('BaseViewModel');

		$this->view->output('loginView', $viewmodel, 'shared/emptyTemplate');
	}
	public function loginAction($user, $pw, $login){
		$viewmodel = null;
		$status = $this->auth->login($user,$pw);
		if($status['error'] == 0) {
		    setcookie('authID', $status['hash'], $status['expire'], '/');
		    header('Location: ' . URLHelper::getURL('/adminHome'));
		} else {
		    header('Location: ' . URLHelper::getURL('/login'));
		}
	}
	protected function logoutAction(){
		$this->auth->logout($_COOKIE['authID']);
		setcookie('authID', '', time() - 3600, '/');

		$this->view->output('logoutView', $viewmodel, 'shared/emptyTemplate');
	}	
}

?>