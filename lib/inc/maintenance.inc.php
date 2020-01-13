<?php
	echo '<html>
		<head>
			<title>Dragomon Hunter Fan | Maintenance</title>
			<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500" rel="stylesheet" type="text/css">
			<link rel="icon" href="http://www.dragomonhunterfan.com/favicon.ico">
			<style>
				*{
					margin: 0;
					font-size: 14px;
					font-weight: 300;
					font-family: Ubuntu, sans-serif
				}
				html{
					background: url("https://s14.postimg.org/9cxeu61hd/image.jpg") 50% 0 no-repeat #36002e;
					background-size: 98%
				}
				#maintPanel{
					background-color: #33043280;
					color: white;
					padding: 15px;
					margin-top: 50px;
					font-size: 26px;
				}
				#retryPanel{
					width: 640px;
					background-color: #1D292CE6;
					padding: 20px;
					border-radius: 5px;
					border: 1px solid #5D5E63;
					margin-top:40px;
				}
				#retryButton{
					padding: 10px;
					background-color: #9ba9f8;
					display: block;
					width: 140px;
					border: 1px solid #6D7DD8;
					margin-top: 15px;
					border-radius: 5px;
					color: white;
					text-decoration: none;
				}
				#retryButton:hover{
					background-color: #6879db;
				}
			</style>
		</head>
		<body>
		<center>
		<div id="maintPanel">
			Sorry, we are updating website. Please try again in a few minutes.
		</div>
			<div id="retryPanel"><img src="https://cdn2.iconfinder.com/data/icons/the-shine-of-small-things/128/shining_mix_wrench-256.png"></img>
			<a id="retryButton" href="http://www.dragomonhunterfan.com/">Retry Again</a></div>
		</center>
		</body>
	</html>';
?>