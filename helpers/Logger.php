<?php

class Logger {
	private $dev = true;
	private $msg = '';
	private static $_instance;

 	private function __construct($dev){
 		if ($dev == false) error_reporting(0);
 		$this->dev = $dev; 
 	}
 	public static function initLogger($dev){
		
 		if(!isset(self::$_instance)) {
            self::$_instance = new Logger($dev);
        }
        return self::$_instance;
 	}
 	public static function log($output){
		$msg = "";
		if(is_array($output))
			$msg = var_export($output, true) . '\n\n';
		else
			$msg .= $output. '\n\n';

 		if(self::$_instance->dev)
 			echo $msg;
 		else
 			self::$_instance->msg .= $msg; 
 	}
 	public static function consoleLog(){
 		echo '<script>console.log(' . json_encode(self::$_instance->msg) . ');</script>';
 	}
}

?>