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
$maxDelay = 100000;
$minDelay = 0;

if (isset($_GET['k']))
{
	$Keys = $_GET['k'];
}
else
{
	die("Error: Keys Not Set");
}

if (isset($_GET['c']))
{
	$Category = $_GET['c'];
}
else
{
	die("Error: Category Not Set");
}

// POST UPDATE

if (isset($_POST['sAll']))
{
	header('Location: ' . $_SERVER['HTTP_REFERER'] . '&f=' . $Category);
}

if ($Category == 4)
{
	$rand = rand($minDelay, $maxDelay);
	usleep($rand);
	$dmhf->searchAjax($Category, $Keys);
}
else
if ($Category == 6)
{
	$rand = rand($minDelay, $maxDelay);
	usleep($rand);
	$dmhf->searchAjax($Category, $Keys);
}
else
if ($Category == 5)
{
	$rand = rand($minDelay, $maxDelay);
	usleep($rand);
	$dmhf->searchAjax($Category, $Keys);
}
else
if ($Category == 7)
{
	$rand = rand($minDelay, $maxDelay);
	usleep($rand);
	$dmhf->searchAjax($Category, $Keys);
}
else
if ($Category == 9)
{
	$rand = rand($minDelay, $maxDelay);
	usleep($rand);
	$dmhf->searchAjax($Category, $Keys);
}
else
if ($Category == 8)
{
	$rand = rand($minDelay, $maxDelay);
	usleep($rand);
	$dmhf->searchAjax($Category, $Keys);
}



?>
