<?php
session_start();
	include('lib/classManager.php');
	$from = "desktop";

	if(isset($_GET['from'])) {
		if($_GET['from'] == 'app'){
			$from = "app";
            $_SESSION['from'] = "app";
		}
	}
    if(isset($_SESSION['from'])){
        if($_SESSION['from'] == 'app'){
			$from = "app";
            $_SESSION['from'] = "app";
		}
    }

    $dmhf = new dmhf($from);
	$dmhf->apiPassword("dmhf031120151724");
	
	$result = preg_replace("/[^a-zA-Z0-9 ]+/", " ", $_POST['s']);
	$s = urlencode($result);
	
	$url = $dmhf->newSearch($s);
	header("Location: ".$url);
?>