<?php
class lang{
	
	function __construct(){

	}
	
	public function getLang(){
		/**
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		if($lang == "es"){
			include('lang/spanish.php');	
		}else{
			include('lang/english.php');
		}
		**/
		
		include('lang/english.php');
		
		return $lang;
	}
}
?>