<?php
session_start();
	include ('../classManager.php');
	
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
	if(isset($_GET['id'])){
		$dmhf->showCraftTable($_GET['id'], 1);
	}else{
		echo 'Error ItemID Not Set';
	}
?>