<?php

class BaseViewModelMapper extends BaseModelMapper{

	public function init(BaseViewModel &$model){
		$this->fetch($model);		
	}	
	public function fetch(BaseViewModel &$model){
		
		//if(isset($_COOKIE['authID']) && $this->auth->checkSession($_COOKIE['authID'])) {
		//	$model->loggedin = true;

		$model->menuItems = [
			0 => [
				'linkId' => 'home',
				'linkText' => 'Oversigt',
				'link' => URLHelper::getURL('/AdminHome/'),
				'submenuItems' => [
				  	[
				  		'linkId' => 'exercises',
						'linkText' => 'Øvelser', 
				  		'link' => URLHelper::getURL('/AdminExercise/')
				  	],
				  	[
				  		'linkId' => 'workouts',
						'linkText' => 'Workouts', 
				  		'link' => URLHelper::getURL('/Workout/')
				  	],
				  	[
				  		'linkId' => 'protocols',
						'linkText' => 'Programmer', 
				  		'link' => URLHelper::getURL('/AdminProtocol/displayAll')
				  	]
				  ]	
			],
			1 => [
				'linkId' => 'media',
				'linkText' => 'Mediearkiv',
				'link' => URLHelper::getURL('/Media/')
			],
			2 => [
			  	'submenuItems' => [
				  	[
				  		'linkId' => 'users',
						'linkText' => 'Brugere', 
				  		'link' => site_url() . '/wp-admin/users.php'
				  	],
				  	[
				  		'linkId' => 'settings',
						'linkText' => 'Værktøjer', 
				  		'link' => URLHelper::getURL('/setting')
				  	]
			  	]
			]
		];
		$model->currentMenuItem = "";
		//}
	}
}

?>