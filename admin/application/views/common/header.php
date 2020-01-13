<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo $api['url_title']; ?></title>
		<link rel="icon" href="<?php echo base_url();?>favicon.ico">
	
<?php if(ENVIRONMENT == "Debug"){ ?>
		<link rel="stylesheet/less" type="text/css" href="<?php echo base_url("resources/less/index.less");?>" />
		<script src="<?php echo base_url("resources/js/less.js");?>" type="text/javascript"></script>
<?php } else {?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url("resources/css/index.css");?>">
<?php }?>
		<script src="<?php echo base_url("resources/js/jquery.min.js");?>" type="text/javascript"></script>
		<script src="<?php echo base_url("resources/js/tablesorter.js");?>" type="text/javascript"></script> 
	</head>
	<body>
	