<?php

class BaseViewModelMapper extends BaseModelMapper{

	public function init(BaseViewModel &$model){
		$this->fetch($model);		
	}	
	public function fetch(BaseViewModel &$model){
		
		if(isset($_COOKIE['authID']) && $this->auth->checkSession($_COOKIE['authID'])) {
			$model->loggedin = true;

			$model->menuItems = [
						0 => [
						  'linkText' => 'Forside',
						  'link' => '/AdminHome/',
						  'submenuItems' => [
						  	[
						  		'linkText' => 'Øvelser', 
						  		'link' => '/AdminExercise/'
						  	],
						  	[
						  		'linkText' => 'Workouts', 
						  		'link' => '/AdminWorkout/'
						  	],
						  	[
						  		'linkText' => 'Programmer', 
						  		'link' => '/AdminProtocol/displayAll'
						  	]
						  ]	
						],
						1 => [
						  'linkText' => 'Mediearkiv',
						  'link' => '/Media/'
						],
						2 => [
						  'submenuItems' => [
						  	[
						  		'linkText' => 'Brugere', 
						  		'link' => '/AdminUser/'
						  	],
						  	[
						  		'linkText' => 'Værktøjer', 
						  		'link' => '/setting'
						  	]
						  ]
						]
			];
			$model->currentMenuItem = "";
		}
	}
}

?>