<?php

class UsersViewModelMapper extends BaseViewModelMapper{

	public function fetch(BaseViewModel &$model){
		$users = $this->auth->getAllUsers();
		foreach ($users as $data) {
			$user = new UserModel();
			$user->id = $data["id"];
			$user->username = $data["username"];
			$user->email = $data["email"];
			$model->users[] = $user;
		}
		parent::fetch($model);
	}
}

?>