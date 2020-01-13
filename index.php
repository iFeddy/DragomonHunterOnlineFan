<?php 
    session_start();
    include('lib/classManager.php');

    $from = "desktop";

	if(isset($_GET['from'])) {
		if($_GET['from'] == 'app'){
			$from = "app";
            $_SESSION['from'] = "app";
		}else{
           	$from = "desktop";
            $_SESSION['from'] = "desktop";  
        }
	}
    if(isset($_SESSION['from'])){
        if($_SESSION['from'] == 'app'){
			$from = "app";
            $_SESSION['from'] = "app";
		}else{
           	$from = "desktop";
            $_SESSION['from'] = "desktop"; 
        }
    }

    $dmhf = new dmhf($from);
    $dmhf->apiPassword("dmhf031120151724");
        
    //$isMante = $dmhf->checkMante();
    $isMante = false;  
    
    if(!($isMante)){
        $dmhf->pageSetup();
        $sth_act = $dmhf->apiAction;
        $dmhf->stHeader($sth_act);	
        $dmhf->stBody($sth_act);	
        }else{
            $dmhf->Mantenimiento();
        }
?>