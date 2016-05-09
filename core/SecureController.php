<?php 
abstract class SecureController extends BaseController{

	public function action($actionName, $urlArray){
		
		$this->chkCookie();	
		parent::action($actionName, $urlArray);	

	}
	private function chkCookie(){
		if(!isset($_COOKIE['authID']) ){
			echo URLHelper::getBasePath();
    		header('Location: ' . URLHelper::getBasePath() . '/login');
    		exit();
		}
		if(!$this->auth->checkSession($_COOKIE['authID'])) {
		    header('HTTP/1.0 403 Forbidden');
		    echo "Forbidden";
		    exit();
		}
		
		return true;
	}
}
?>