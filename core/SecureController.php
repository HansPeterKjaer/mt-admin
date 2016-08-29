<?php 
abstract class SecureController extends BaseController{

	public function action($actionName, $urlArray){
		require_once($_SERVER['DOCUMENT_ROOT'] . constant('APP_BLOGROOT') . '/wp-blog-header.php');

		if ( is_user_logged_in() ) {
		    parent::action($actionName, $urlArray);	
		} else {
		    header('Location: ' . constant('APP_BLOGROOT') . '/wp-login.php');
		}
		//$this->chkCookie();	
		//parent::action($actionName, $urlArray);	

	}
	/*private function chkCookie(){
		if(!isset($_COOKIE['authID']) ){
    		header('Location: ' . URLHelper::getBasePath() . '/login');
    		exit();
		}
		if(!$this->auth->checkSession($_COOKIE['authID'])) {
		    header('HTTP/1.0 403 Forbidden');
		    echo "Forbidden";
		    exit();
		}
		
		return true;
	}*/
}
?>