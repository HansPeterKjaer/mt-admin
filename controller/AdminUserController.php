<?php

class AdminUserController extends SecureController {
	protected function indexAction($status = false){
		$viewmodel = $this->modelFactory->buildObject('UsersViewModel');
		$mapper = $this->modelFactory->buildMapper('UsersViewModelMapper');
		$mapper->fetch($viewmodel);

		$this->view->output("user/index", $viewmodel);
	}
	
	protected function createUserAction(){
		$viewmodel = $this->modelFactory->buildObject('UsersViewModel');
		$mapper = $this->modelFactory->buildMapper('UsersViewModelMapper');
		$mapper->init($viewmodel);

		$this->view->output("user/createUser", $viewmodel);
	}

	protected function addUserAction($brugernavn, $email, $password, $password2, $role){

		if(!preg_match('/^\w{4,11}$/', $brugernavn)){
			$this->view->outputJSON(array('msg'=>'Brugernavnet skal være mellem 4 og 11 tegn', 'status'=>false, 'input'=>'#brugernavn'));
			return;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$this->view->outputJSON(array('msg'=>'Ugyldig Emailadresse', 'status'=>false, 'input'=>'#email'));
			return;
		}
		if(!preg_match('/^\w{4,11}$/', $password)){
			$this->view->outputJSON(array('msg'=>'Password skal være mellem 4 og 14 tegn', 'status'=>false, 'input'=>'#password'));
			return;
		}
		if($password !== $password2){
			$this->view->outputJSON(array('msg'=>'Password er ikke ens', 'status'=>false, 'input'=>'#password2'));
			return;
		}
		
		$this->view->outputJSON($this->auth->addUser($email, $brugernavn, $password));
		return;
	}

	protected function deleteUserAction($brugernavn, $email){
		if( $this->auth->deleteUser($brugernavn, $email)){
			header("Location: {URLHelper::getBasePath();}/adminUser/index?status=delete");
		}
		// Note should be json???
		header("Location: {URLHelper::getBasePath();}/adminUser/index?status=err");
	}
	protected function updateUserAction($brugernavn, $email, $password){

	
	}
}

?>