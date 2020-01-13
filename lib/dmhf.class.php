<?php
	
class dmhf
{
	// #Release - Debug Mode#
	private $apiBuild = "1.0.58";
	private $apiMode = "Debug	"; //Release - Debug - App
	private $isAPP = false;
	private $apiDebugURL = "http://localhost/dragomon/";
	private $apiAppURL = "http://192.168.0.13/dragomon/";
	private $apiReleaseURL = "http://www.dragomonhunterfan.com/";

	private $apiDebugCDN = "http://res.cloudinary.com/dragomon/image/upload/"; //localhost/dragomon/
	private $apiReleaseCDN = "http://res.cloudinary.com/dragomon/image/upload/";

	private $apiURL;
	private $apiCDN; 

	private $apiPass = "dmhf031120151724";
	private $apiPassString;
	
	public $apiAction;
	public $apiActionID;
	public $apiCategory;
	
	private $apiSearchKeys;
	private $apiSearchID;
	private $apiSearchURL;
	private $apiCurrentURL;
	
	private $fbPageDesc = "No Description Set";
	private $fbPageImage;
	private $userIP;
	private $lang;
	private $apiSearchPageTitle;

	private $ads728x90 = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- DMHF_Adaptable -->
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-client="ca-pub-7257837165893054"
				     data-ad-slot="5189673395"
				     data-ad-format="auto"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>';
	/*private $ads728x90 = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<!-- DMHF_728x90 -->
							<ins class="adsbygoogle"
								style="display:inline-block;width:728px;height:90px"
								data-ad-client="ca-pub-7257837165893054"
								data-ad-slot="3227042190"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>';*/
	private $ads300x600 = '    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- DMHF_300x600 -->
								<ins class="adsbygoogle"
									style="display:inline-block;width:300px;height:600px"
									data-ad-client="ca-pub-7257837165893054"
									data-ad-slot="4703775391"></ins>
								<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script>';
	private $adsInPost = '    <div class="adsInPost"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<!-- DMHF_468x60 -->
								<ins class="adsbygoogle"
									style="display:inline-block;width:468px;height:60px"
									data-ad-client="ca-pub-7257837165893054"
									data-ad-slot="1503179792"></ins>
								<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script></div>';
	private $adsT728x15 = '    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<!-- DMHF-AdUnit1 -->
							<ins class="adsbygoogle"
								style="display:inline-block;width:728px;height:15px"
								data-ad-client="ca-pub-7257837165893054"
								data-ad-slot="7917496594"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>';
	private $adsText01 = '    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<!-- DMHF_Unit2 -->
							<ins class="adsbygoogle"
								style="display:inline-block;width:200px;height:90px"
								data-ad-client="ca-pub-7257837165893054"
								data-ad-slot="3208095391"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>';
	private $adsBlogBox = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- DMHF_BlogPost -->
<ins class="adsbygoogle"
	 style="display:inline-block;width:300px;height:250px"
	 data-ad-client="ca-pub-7257837165893054"
	 data-ad-slot="7184360191"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';
	private $apiTimeStart;
	private $apiTime;
	
	// =======================
	// ==Constructor Inicial==
	// =======================
	public function __construct($from)
	{
		$this->setTime("START");
		$this->userIP = $_SERVER['REMOTE_ADDR'];
		$this->apiMode($this->apiMode);
		$this->apiCurrentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$lang = new lang();
		$this->lang = $lang->getLang();
		if(isset($_GET['act'])) {
			if($_GET['act'] == 4) {
				$type = $this->returnType();
				$this->apiSearchPageTitle = $this->apiSearchCategoryTitle(4, $type);
			}
			if($_GET['act'] == 5) {
				$type = $this->returnType();
				$this->apiSearchPageTitle = $this->apiSearchCategoryTitle(5, $type);
			}
			if($_GET['act'] == 6) {
				$type = $this->returnType();
				$this->apiSearchPageTitle = $this->apiSearchCategoryTitle(6, $type);
			}
			if($_GET['act'] == 8) {
				$type = $this->returnType();
				$this->apiSearchPageTitle = $this->apiSearchCategoryTitle(8, $type);
			}
			if($_GET['act'] == 100) {
				$type = $this->returnPostID();
				$this->apiSearchPageTitle = $this->apiSearchCategoryTitle(100, $type);
			}
			if($_GET['act'] == 500) {
				$this->apiSearchPageTitle = $this->apiSearchCategoryTitle(500, 0);
			}
		}
		if(isset($_GET['cat'])) {
			if($_GET['cat'] == 1) //Items
				{
				if(isset($_GET['id'])) {
					$this->apiSearchPageTitle = $this->returnItemName($_GET['id']);
				}
			}
			if($_GET['cat'] == 2) {
				if(isset($_GET['id'])) {
					$this->apiSearchPageTitle = $this->returnAchievementName($_GET['id']);
				}
			}
			if($_GET['cat'] == 3) { //SET TITLE NAME
				if(isset($_GET['id'])) {
					$this->apiSearchPageTitle = $this->returnTitleName($_GET['id']);
				}
			}
			if($_GET['cat'] == 4) { //SET MAP NAME
				if(isset($_GET['id'])) {
					$this->apiSearchPageTitle = $this->returnMapsName($_GET['id']);
				}
			}
			if($_GET['cat'] == 5) { //SET Quest NAME
				if(isset($_GET['id'])) {
					$this->apiSearchPageTitle = $this->returnQuestName($_GET['id']);
				}
			}
			if($_GET['cat'] == 6) { //SET Biology NAME
				if(isset($_GET['id'])) {
					$this->apiSearchPageTitle = $this->returnBiologyName($_GET['id']);
				}
			}
		}
		if($from == 'app'){
				$this->isAPP = true;
			}else{
				$this->isAPP = false;
		}
	}
	function setTime($rank)
	{
		if($rank == "START") {
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$start = $time;
			$this->apiTimeStart = $start;
		} else {
			$time = microtime();
			$time = explode(' ', $time);
			$time = $time[1] + $time[0];
			$finish = $time;
			$total_time = round(($finish - $this->apiTimeStart), 4);
			$this->apiTime = $total_time;
		}
	}
	function apiMode($str)
	{
		switch($str) {
			case "App":
				$this->apiMode = "Debug";
				$this->apiURL = $this->apiAppURL;
				$this->apiCDN = $this->apiDebugCDN;
				break;
			case "Debug":
				$this->apiMode = "Debug";
				$this->apiURL = $this->apiDebugURL;
				$this->apiCDN = $this->apiDebugCDN;
				break;
			case "Release":
				$this->apiMode = "Release";
				$this->apiURL = $this->apiReleaseURL;
				$this->apiCDN = $this->apiReleaseCDN;
				break;
			default:
				$this->apiMode = "Release";
				$this->apiURL = $this->apiReleaseURL;
				$this->apiCDN = $this->apiDebugCDN;
				break;
		}
	}
	function apiPassword($str)
	{
		$bool = false;
		if($this->apiPass != $str) {
			die("Error: Internal Password Mismatching. <br/> Please Try Again Later...");
		} else {
			$bool = true;
		}
		$this->apiPassString = $str;
		return $bool;
	}
	function pageSetup()
	{
		$this->apiPassword($this->apiPassString);
		foreach($_GET as $key => $value) {
			switch($key) {
				case "act":
					$this->apiAction = $this->getActions($value);
					break;
				case "s":
					// Filtrar s
					$this->apiSearchKeys = trim(strip_tags($value));
					break;
				case "cat":
					if(is_numeric($value)) {
						$this->apiSearchCategory = $value;
					} else {
						$this->apiSearchCategory = 0;
					}
					break;
				case "id":
					$this->apiSearchID = $value;
					break;
				case "in":
					$this->apiSearchURL = $value;
					break;
			}
		}
	}
	// Crear accion
	private function getActions($value)
	{
		$string = "none";
		$this->apiActionID = $value;
		switch($value) {
			case 1:
				$string = "index";
				break;
			case 2:
				$string = "search";
				break;
			case 3:
				$string = "show";
				break;
			case 4:
				$string = "items";
				break;
			case 5:
				$string = "achievements";
				break;
			case 6:
				$string = "titles";
				break;
			case 7:
				$string = "biology";
				break;
			case 8:
				$string = "maps";
				break;
			case 9:
				$string = "quests";
				break;
			case 500:
				$string = "donate";
				break;
			case 100:
				$string = "post";
				break;
			case 101:
				$string = "craft";
				break;
			default:
				$string = "index";
				break;
		}
		return $string;
	}
	
	function stHeader($action)
	{
		if($this->apiMode == "Debug") {
			$cssLink = '<link rel="stylesheet/less" type="text/css" href="' . $this->apiURL . 'lib/css/index.less?dmhf='.time().'" />    <script src="' . $this->apiURL . 'resources/js/less.js" type="text/javascript"></script>';
		} else {
			$cssLink = '<link rel="stylesheet" type="text/css" href="' . $this->apiURL . 'resources/css/index.css?dmhf='.time().'" />';
		}
		echo '<!DOCTYPE html>
				<html lang="en">
					<HEAD>
					<meta name="robots" content="index,follow">
						
						<meta name="description" content="DragomonHunter Official Fansite Community - Databases, Resources and all related to Aeria Games Dragomon Hunter MMORPG."/>
						'.$this->showKeywords($action).'
						<meta name="google-site-verification" content="LclP7L6Nkzmr7AfhjveIXL_U7-qlD2t9GaPlnAmIjCY" />
							
						<meta http-equiv="Content-Language" content="en"/> 
						<meta name="distribution" content="global"/> 
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							
						<!-- Chrome, Firefox OS and Opera -->
						<meta name="theme-color" content="#36002E">
						<!-- Windows Phone -->
						<meta name="msapplication-navbutton-color" content="#36002E">
						<!-- iOS Safari -->
						<meta name="apple-mobile-web-app-status-bar-style" content="#36002E">
							
						<meta name="viewport" content="width=device-width, initial-scale=1.0">
							
						<meta property="og:url"           content="' . $this->apiCurrentURL . '" />
						<meta property="og:type"               content="article" />
						<meta property="og:title"              content="' . $this->apiSearchPageTitle . ' | Dragomon Hunter Fan" />
						<meta property="og:description"        content="' . $this->fbPageDesc . '" />
						<meta property="og:image"              content="' . $this->fbPageImage . '" />
							
						<link href="https://plus.google.com/104295317722747676565" rel="publisher"/>
							
						<link rel="alternate" href="' . $this->apiURL . '" hreflang="en" />    
						<script src="' . $this->apiURL . 'resources/js/ads.js"></script>
						<link rel="icon" href="' . $this->apiURL . 'favicon.ico">
						<link rel="stylesheet" type="text/css" href="' . $this->apiURL . 'resources/css/jquery.qtip.min.css" />
						<link rel="stylesheet" type="text/css" href="' . $this->apiURL . 'resources/css/flatButtons.css" />
						<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500" rel="stylesheet" type="text/css">                        
						<script src="' . $this->apiURL . 'resources/js/jquery.js"></script>
							
						' . $cssLink . '
						';
		switch(strtolower($action)) {
			case "index":
				echo '<title>Dragomon Hunter Fan | Databases & Resources</title>';
				break;
			case "search":
				echo '<title>' . $this->apiSearchKeys . ' | Dragomon Hunter Fan</title> ';
				break;
			case "show":
				echo '<title>' . $this->apiSearchPageTitle . ' | Dragomon Hunter Fan</title> ';
			case "items":
				echo '<title>' . $this->apiSearchPageTitle . ' Database | Dragomon Hunter Fan</title>
			';
				break;
			case "achievements":
				echo '<title>' . $this->apiSearchPageTitle . ' Database | Dragomon Hunter Fan</title> ';
				break;
			case "titles":
				echo '<title>' . $this->apiSearchPageTitle . '  Database | Dragomon Hunter Fan</title> ';
				break;
			case "maps":
				echo '<title>Maps Database | Dragomon Hunter Fan</title> ';
				break;
			case "quests":
				echo '<title>Quests Database | Dragomon Hunter Fan</title> ';
				break;
			case "biology":
				echo '<title>Biology Database | Dragomon Hunter Fan</title> ';
				break;
			case "post":
				echo '<title>' . $this->apiSearchPageTitle . ' | Dragomon Hunter Fan</title> ';
				break;
			case "craft":
				echo '<title>Crafting System Database | Dragomon Hunter Fan</title> ';
				break;
			case "donate":
				echo '<title>Donation\'s Page | Dragomon Hunter Fan</title> ';
				break;
			default:
				echo '<title>Dragomon Hunter Fan | Databases & Resources</title>';
				break;
		}
		echo '</HEAD>';
	}
	function randomItemIMG()
	{
		$myImage = 0;
		$db = $this->connect();
		$stmt3 = $db->prepare("SELECT ItemIndex FROM c_items INNER JOIN t_items ON t_items.ItemID=c_items.ItemID  order by RAND() LIMIT 1");
		$stmt3->execute();
		$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
		$myImage = 0;
		if($row3) {
			if($row3['ItemIndex'] != null) {
				$myImage = $row3['ItemIndex'];
			} else {
				$myImage = "0";
				// die($row3['ItemIndex']);
			}
		} else {
			$myImage = "0";
		}
		return $myImage;
	}
	function stBody($action)
	{
		$itemIMG = $this->randomItemIMG();
		echo '    
			<BODY>
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.5";
					fjs.parentNode.insertBefore(js, fjs);
					}(document, \'script\', \'facebook-jssdk\'));
				</script>
			';
		// Links
		if($this->apiMode == "Debug") {
			$itemsLink = $this->apiURL . 'index.php?act=4';
			$achievementLink = $this->apiURL . 'index.php?act=5';
			$achievementSubLink = $this->apiURL . 'index.php?act=5&type=';
			$titlesLink = $this->apiURL . 'index.php?act=6';
			$titlesSubLink = $this->apiURL . 'index.php?act=6&type=';
			$biologyLink = $this->apiURL . 'index.php?act=7';
			$mapsLink = $this->apiURL . 'index.php?act=8';
			$questsLink = $this->apiURL . 'index.php?act=9';
			$questsSubLink = $this->apiURL . 'index.php?act=9&type=';
			$craftLink = $this->apiURL . 'index.php?act=101';
			$postLink = $this->apiURL . 'index.php?act=100';
			$donateLink = $this->apiURL . 'index.php?act=500';
		} else {
			$itemsLink = $this->apiURL . 'items';
			$achievementLink = $this->apiURL . 'achievements';
			$achievementSubLink = $this->apiURL . 'achievements/type/';
			$titlesLink = $this->apiURL . 'titles';
			$titlesSubLink = $this->apiURL . 'titles/type/';
			$biologyLink = $this->apiURL . 'biology';
			$mapsLink = $this->apiURL . 'maps';
			$questsLink = $this->apiURL . 'quests';
			$questsSubLink = $this->apiURL . 'quests/type/';
			$craftLink = $this->apiURL . 'crafting';
			$postLink = $this->apiURL . 'post';
			$donateLink = $this->apiURL . 'donate';
		}
		echo '<div class="lateralMenu">
									<ul>
										<a href="' . $itemsLink . '" title="<strong>Items</strong> Database"><li><img src="' . $this->apiURL . 'resources/images/itemsicon/' . $itemIMG . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';"></img></li></a>
										<a href="' . $biologyLink . '" title="<strong>Biology</strong> Database"><li><img src="' . $this->apiURL . 'resources/images/ui/dna.png"></img></li></a>
										<a href="' . $questsLink . '" title="<strong>Quests</strong> Database"><li><img src="' . $this->apiURL . 'resources/images/ui/bag.png"></img></li></a>
										<a href="' . $mapsLink . '" title="<strong>Maps</strong> Database"><li><img src="' . $this->apiURL . 'resources/images/ui/locate.png"></img></li></a>
										<a href="' . $titlesLink . '" title="<strong>Titles</strong> Database"><li><img src="' . $this->apiURL . 'resources/images/ui/title.png"></img></li></a>
										<a href="' . $achievementLink . '" title="<strong>Achievements</strong> Database"><li><img src="' . $this->apiURL . 'resources/images/ui/achievements.png"></img></li></a>
										<a href="' . $donateLink . '" title="<strong>Donate</strong>"><li><img src="' . $this->apiURL . 'resources/images/ui/paypal.png"></img></li></a>
									</ul>
				</div>
				<div id="headerFIx">
					
					<div class="wrap">
						<div id="mainLogo"><a href="' . $this->apiURL . '"><img alt="Dragonmon Hunter Fan | Databases & Resources"src="' . $this->apiURL . 'resources/images/logo2.png"></img></a></div>
						<div id="mainMenu">
							<ul>
							<li><a title="Dragomon Hunter Fan Database" href="' . $this->apiURL . '">' . $this->lang['home'] . '</a></li>
							<li><a title="Dragomon Hunter Items Database" href="' . $itemsLink . '">' . $this->lang['items'] . '</a>
								<ul class="dropdown1">
									<li><a href="' . $itemsLink . '">' . $this->lang['showcategory'] . '</a></li>
								</ul>
							</li>';
		$db = $this->connect();
		echo '<li><a title="Dragomon Hunter Mobs/NPC Database" href="' . $biologyLink . '">' . $this->lang['biology'] . '</a></li>';
		$stmt = $db->prepare("SELECT * FROM t_mission_category order by qName ASC");
		$stmt->execute();
		echo '<li><a  title="Dragomon Hunter Quests Database"  href="' . $questsLink . '">' . $this->lang['quests'] . '</a><ul class="dropdown3">';
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo '<li><a href="' . $questsSubLink . $row['qID'] . '">' . $row['qName'] . '</a></li>';
		}
		echo '<li><a class="title black" title="Show All Quests Database" href="' . $questsLink . '"><b>' . $this->lang['showall'] . '</b></a></li>
								</ul>
							</li>';
		echo '<li><a title="Dragomon Hunter Maps Database" href="' . $mapsLink . '">' . $this->lang['maps'] . '</a></li>
							<li><a  title="Dragomon Hunter Titles Database" href="' . $titlesLink . '">' . $this->lang['titles'] . '</a>
								<ul class="dropdown3">';
		$stmt = $db->prepare("SELECT * FROM t_title_category order by tName ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo '<li><a href="' . $titlesSubLink . $row['tID'] . '">' . $row['tName'] . '</a></li>';
		}
		echo '<li><a class="title black" title="Show All Titles Database" href="' . $titlesLink . '"><b>' . $this->lang['showall'] . '</b></a></li>
								</ul>
							</li>
							<li><a title="Dragomon Hunter Achievements Database" href="' . $achievementLink . '">Achievements</a>
								<ul class="dropdown3">';
		$stmt = $db->prepare("SELECT * FROM t_achievement_category order by cName ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			echo '<li><a href="' . $achievementSubLink . $row['cID'] . '">' . $row['cName'] . '</a></li>';
		}
		echo '<li><a class="title black" title="Show All Achievements Database" href="' . $achievementLink . '"><b>' . $this->lang['showall'] . '</b></a></li>
									<div class="clear"></div>
								</ul>
							</li>
								
							<li>
								
								<a href="#">Others</a>
								<ul class="dropDown1">
								<li><a href="' . $postLink . '">Blog Posts</a></li>
								<li><a href="' . $craftLink . '">Crafting System</a></li>
								</ul>
							</li>
								
							<li style="line-height:49px;"><a class="title donate" title="Show us some love supporting the site" href="' . $donateLink . '">Donate</a></li>
								
							</ul>
								
								
								
							<a href="https://www.facebook.com/dragomonhunterfan/" id="fbicon"></a>
								
								
				</div>
								<a href="#" id="respButton"></a>
								<a href="#" id="respSearch"></a>
								<a href="#" id="respUp"></a>
								
					</div>
					<div class="clear"></div>
					</div>
				</div>
				<div class="respSearchMenu">
					<form action="' . $this->apiURL . 'search.php" method="POST">
									<center><input id="respSearchBox" type="search" name="s" placeholder="Enter Keywords..." required></input>
									<input type="submit" style="width: 90%" class="peter-river-flat-button" value="Search"></input></center>
					<br/></form>
				</div>
				<div class="respMenu">
									<ul>
										<a href="' . $itemsLink . '" title="<strong>Items</strong> Database"><li>Items</li></a>
										<a href="' . $biologyLink . '" title="<strong>Biology</strong> Database"><li>Biology</li></a>
										<a href="#" class="respSubTouch01" title="<strong>Quests</strong> Database"><li>Quests</li></a>';

										echo '<div class="respSub" id="respQuest">';
										$stmt = $db->prepare("SELECT * FROM t_mission_category order by qName ASC");
										$stmt->execute();
			
											while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
											echo '<a href="' . $questsSubLink . $row['qID'] . '"><li>' . $row['qName'] . '</li></a>';
										}
										echo '<a class="title black" title="Show All Quests Database" href="' . $questsLink . '"><li><b>' . $this->lang['showall'] . '</b></li></a>';
		
										echo '</div>';

										echo '<a href="' . $mapsLink . '" title="<strong>Maps</strong> Database"><li>Maps</li></a>
										<a href="#" class="respSubTouch02" title="<strong>Titles</strong> Database"><li>Titles</li></a>';

										echo '<div class="respSub" id="respTitle">';	
										$stmt = $db->prepare("SELECT * FROM t_title_category order by tName ASC");
										$stmt->execute();
										while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
											echo '<a href="' . $titlesSubLink . $row['tID'] . '"><li>' . $row['tName'] . '</li></a>';
										}
										echo '<a class="title black" title="Show All Titles Database" href="' . $titlesLink . '"><li><b>' . $this->lang['showall'] . '</b></li></a>';
											
										echo '</div>';

										echo '<a href="#" class="respSubTouch03" title="<strong>Achievements</strong> Database"><li>Achievements</li></a>';

										echo '<div class="respSub" id="respAchie">';									
										$stmt = $db->prepare("SELECT * FROM t_achievement_category order by cName ASC");
										$stmt->execute();
											while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												echo '<a href="' . $achievementSubLink . $row['cID'] . '"><li>' . $row['cName'] . '</li></a>';
											}
											echo '<a class="title black" title="Show All Achievements Database" href="' . $achievementLink . '"><li><b>' . $this->lang['showall'] . '</b></li></a>';
										echo '</div>';

										echo '<a href="' . $donateLink . '" title="<strong>Donate</strong>"><li>Donate</li></a>
									</ul>
				</div>
				<div style="width: 325px;
							margin: 0 auto;
							background-color: rgb(177, 204, 120);
							border-bottom-left-radius: 5px;
							border-bottom-right-radius: 5px;
							font-weight: 600;
							color: rgb(89, 99, 96);
							padding-left: 25px;
							padding-right: 25px;
							padding-top: 10px;
							padding-bottom: 10px;
							border: 1px solid rgb(193, 210, 159);">
							<strong>Dragomon Hunter</strong> server is going down on 29th June! 
							</div>				
				<div class="clear"></div>									
				';

			if(!($this->isAPP)){
				echo'<div id="ads728x90">
						' . $this->ads728x90 . '
					</div>';
			}	

			echo '<div class="clear"></div>
				';
		if($action == "donate") {
			die($this->donatePage());
		}
		echo '<div class="wrap">
							
					<div id="newsTicket"><span id="warningIcon"></span>
					If you like content of website, please share!
					</div>';
					if(!($this->isAPP)){
						//	echo '<div id="gplayAPP"><center><a href="#" id="downloadAPP"><span id="gplayIcon"></span></a></center></div>';
					}
					echo '<div id="content">
						<div id="contRight" ';
						if($this->isAPP){
							echo 'style="display:none;" ';
						}
						echo '>
							<div id="searchAll">
								<h1><span id="searchIcon"></span>Search Dragomon Database</h1>
								Search <strong>Items</strong>, <strong>Biology</strong>, <strong>Achievements</strong>, <strong>Maps</strong>, <strong>Quests</strong> or <strong>Titles</strong> on <strong>DragomonHunter</strong> Fan Database:
								<form action="' . $this->apiURL . 'search.php" method="POST">
									<input id="searchBox" type="search" name="s" placeholder="Enter Keywords..." required></input>
									<input type="submit" class="peter-river-flat-button" value="Search"></input>
								</form>
							</div>';
							if(!($this->isAPP)){
							echo '<div id="ads300x600">
								' . $this->ads300x600 . '
							</div>';
							}
							echo '<div id="faceBox" style="display:none">
								<div class="fb-page" data-href="https://www.facebook.com/Dragomon-Hunter-Fan-1487800321549504" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"></div>
							</div>
						</div>
						<div id="contLeft">';
							if(!($this->isAPP)){
								echo '<div class="adsT728x15">' . $this->adsT728x15 . '</div>';
							}
							
							echo '<div id="welcomeBanner">
								<img alt="DragomonHunter Databases & Resources" src="' . $this->apiURL . 'resources/images/banner.jpg"></img>
							</div>';
							
							$this->navigateMenu();
													
		switch($action) {
			case "index":
				$this->echoBodyDefault();
				break;
			case "search":
				echo '<div id="searchingFor"><h1><span id="searchIcon2"></span>Searching for "<span class="lightblue">' . $this->apiSearchKeys . '</span>"</h1>';
				$page = $this->checkPage();
				$this->searchTable($page, $this->apiSearchKeys);
				echo '</div>';
				break;
			case "items":
				$this->echoBodyCategory(4);
				break;
			case "achievements":
				$this->echoBodyCategory(5);
				break;
			case "post":
				$this->echoBodyCategory(100);
				break;
			case "show":
				$this->showPage($this->apiSearchCategory, $this->apiSearchID, $this->apiSearchURL);
				break;
			case "craft":
				$this->returnSiteConstruction("Crafting System");
				break;
			case "biology":
				$this->echoBodyCategory(7);
				break;
			case "maps":
				// Muestra Mapas
				$this->echoBodyCategory(8);
				break;
			case "quests":
				$this->echoBodyCategory(9);
				break;
			case "titles":
				$this->echoBodyCategory(6);
				break;
			case "donate":
				echo "hola";
				break;
			default:
				$this->echoBodyDefault();
				break;
		}
		$this->echoFooter();
	}
	private function echoFooter()
	{
		if(!($this->isAPP)){
		echo '<div id="adsTextBlock"><div class="adsText01">' . $this->adsText01 . '</div><div class="adstext02">' . $this->adsText01 . '</div><div class="clear"></div></div>';
		}
		echo '<div class="clear"></div>';
		echo '<div id="discus">
								<div id="disqus_thread"></div>
								<script>
									/**
									*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
									*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
									*/
									/*
									var disqus_config = function () {
										this.page.url = PAGE_URL;  
										this.page.identifier = PAGE_IDENTIFIER; 
									};
									*/
									(function() {  
										var d = document, s = d.createElement(\'script\');
											
										s.src = \'//dragomonhunterfan.disqus.com/embed.js\';
											
										s.setAttribute(\'data-timestamp\', +new Date());
										(d.head || d.body).appendChild(s);
									})();
								</script>
								<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
						
					<a class="upbt" title="Go to Top" href="#"></i></a>
				</div>        
				';
		$this->setTime("END");
		echo '<div id="footer">
					<div class="wrap">
					<div id="leftFooter"><div id="footItems"><h3>Most Viewed Items</h3>';
		$this->showMostViewItems(6);
		echo '
						</div>
					</div>
					<div id="appsCustom" style="margin-bottom: 10px;margin-top: 10px;"><h3>Ads</h3><center>'.$this->adsBlogBox.'</center></div>
					<div id="rightFooter">
						<h3>Sponsored Links</h3>
						<ul>
							<li><a href="http://tecnologia21.com/hotmail" target="_blank">Hotmail</a></li>
							<li><a href="http://tecnologia21.com/gmail" target="_blank">Gmail</a></li>
							<li><a href="mailto:admin@dragomonhunterfan.com?subject=DragomonHunterFan:%20Get%20Sponsored%20Link">Get your link here!</a></li>
							<li><a href="mailto:admin@dragomonhunterfan.com?subject=DragomonHunterFan:%20Get%20Sponsored%20Link">Get your link here!</a></li>
							<li><a href="mailto:admin@dragomonhunterfan.com?subject=DragomonHunterFan:%20Get%20Sponsored%20Link">Get your link here!</a></li>
							<li><a href="mailto:admin@dragomonhunterfan.com?subject=DragomonHunterFan:%20Get%20Sponsored%20Link">Get your link here!</a></li>
						</ul>
						</div>
						<div class="clear"></div>
						Copyright &#169; 2015-2016 <a href="' . $this->apiURL . '">DragomonHunterFan.com</a>.<br/>
						Dragomon Hunter &#169; 2016 Aeria Games Europe GmbH. All other elements &#169; 2016 X-LEGEND Entertainment Corp. <br/>All other trademarks and copyrights are the property of their respective owners. All rights reserved.<br/>

						<span id="timeAPI">Page Generated in ' . $this->apiTime . ' Seconds. Build <span id="buildBox">'.$this->apiBuild.'</span></span>
					</div>
				</div>';

		if(!(isset($_COOKIE['_gotmsg']))) {
			echo '<div id="overlay">
					<div id="killMsg">
						<div id="top-not"></div>
						<div id="not">
							<h1>Disable Adblock</h1>
							Please help <b>DragomonHunterFan</b>\'s website by disabling AdBlock. Donation and Advertisements found in this site are to support the Server Costs.
							<br/>Follow this steps to disable it:<br/>
							<br/>1) Click on AdBlock Options</br></br>
							2) Disable on <a href="http://www.dragomonhunterfan.com/">www.dragomonhunterfan.com</a><br/><br/>
							<img src="' . $this->apiURL . 'resources/images/ui/allowdragomonhunter.png"></img><br/><br/>
							This will only disable it on our site, other sites wont be affected.<br/><br/>
							<input style="width: 100%;height: 45px;font-size:13px;" type="submit" class="midnight-blue-flat-button" id="killBlock" value="Got It!"></input>
						</div>
					</div>
				</div>';
		}
		echo '<script>
				(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');
					
				ga(\'create\', \'UA-69728217-1\', \'auto\');
				ga(\'send\', \'pageview\');
					
				</script>    
				<script id="dsq-count-scr" src="//dragomonhunterfan.disqus.com/count.js" async></script>
				<script type="text/javascript" src="' . $this->apiURL . 'resources/js/jquery.qtip.min.js"></script>
				<script type="text/javascript" src="' . $this->apiURL . 'lib/js/dmhf.js?dmhf='.time().'"></script>
				</BODY>
		</HTML>
	';
	}
	private function echoBodyDefault()
	{
		$db = $this->connect();
		// Links
		if($this->apiMode == "Debug") {
			$itemsLink = $this->apiURL . 'index.php?act=4';
			$achievementLink = $this->apiURL . 'index.php?act=5';
			$titlesLink = $this->apiURL . 'index.php?act=6';
			$mapsLink = $this->apiURL . 'index.php?act=8';
		} else {
			$itemsLink = $this->apiURL . 'items';
			$achievementLink = $this->apiURL . 'achievements';
			$titlesLink = $this->apiURL . 'titles';
			$mapsLink = $this->apiURL . 'maps';
		}
		echo '<div id="welcome" style="display:none;">
								<h1><span id="welcomeIcon"></span>Welcome to Dragomon Hunter Fan</h1>
								Welcome to official fansite for MMORPG <strong>DragomonHunter</strong> from AeriaGames, you can find <strong>databases</strong> & <strong>Resources</strong>. So far we have the following <strong>Databases</strong>:
									<ul>
										<a href="' . $itemsLink . '"><li><strong>Items Database</strong></li></a>
										<a href="' . $achievementLink . '"><li><strong>Achievements Database</strong></li></a>
										<a href="' . $titlesLink . '"><li><strong>Titles Database</strong></li></a>
										<a href="' . $mapsLink . '"><li><strong>Maps Database</strong></li></a>
									</ul>';
									if(!($this->isAPP)){
									echo $this->adsInPost;
									}
									
							echo '</div>';
							
							$stmt = $db->prepare("SELECT * FROM dmhf_posts order by pIndex DESC LIMIT 7");
							$stmt->execute();
							$vuelta = 0;
							
							echo '<div id="news">
								<h1><span id="newsIcon"></span>Dragomon Hunter Fan News</h1>
								Lastest news about <strong>Dragomon Hunter Fan</strong> Website and <strong>Dragomon Hunter\'s Official Servers</strong>';
								
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								if($this->apiMode == "Debug") {
									$pLink = $this->apiURL . '?act=100&pid=' . $row['pIndex'] . '&pbl=' . $row['pLink'];
								} else {
									$pLink = 'post/' . $row['pIndex'] . '/' . $row['pLink'];
								}
																	
								$rgb = $this->rand_color();
								$rgb2 = $this->rand_color();

								if($vuelta == 0){
									echo'<div class="newBox mainBox"><a href="' . $pLink . '">
									<div class="newImageCTN">
										<h1>' . $row['pTitle'] . '</h1>
										<img class="newImage" alt="' . $row['pTitle'] . '"  title= "' . $row['pTitle'] . '" src="' . $row['pImage'] . '"></img>
										<div id="newLay">' . substr($row['pDesc'], 0, 180) . '...</div>
								</a></div></div>';
								}else{
									echo'<div class="newBox relatedBox" style="border: 1px solid '.$rgb.';background-color: '.$rgb2.'"><a href="' . $pLink . '">
									<div class="newImageCTN">
										<h1>' . $row['pTitle'] . '</h1>
										<img class="newImage" alt="' . $row['pTitle'] . '"  title= "' . $row['pTitle'] . '" src="' . $row['pImage'] . '"></img>
									</div>
								</a></div>';
								}
								$vuelta++;
							}
							
							echo'<div class="clear"></div></div>	';
	
		echo '<div id="dbVersion">
								<h1><span id="dbIcon"></span>Databases & Resources Version</h1>
								<table>
									<tr class="firstRow">
										<td>Database Name</td>
										<td>Last Modified</td>
									</tr>
									<tr>
										<td>Items</td>
										<td>01/09/2017 23:23</td>
									</tr>
									<tr>
										<td>Achievements</td>
										<td>13/04/2017 19:04</td>
									</tr>
										<tr>
										<td>Titles</td>
										<td>13/04/2017 19:05</td>
										</tr>
										<tr>
										<td>Maps</td>
										<td>08/25/2016 19:45</td>
										</tr>
										<tr>
										<td>Quests</td>
										<td>13/04/2017 19:06</td>
									</tr>
									<tr>
										<td>Biology</td>
										<td>08/25/2016 19:45</td>
									</tr>
									<tr>
										<td class="lastRow" colspan="2">Aeria\'s DragomonHunter PackVer: 20161028163645</td>
									</tr>
								</table>
							</div>
							';
	}
	private function echoBodyCategory($type)
	{
		switch($type) {
			// Items
			case 4:
				if(!(isset($_GET['type']))) {
					$this->showItemCategory("All", 0);
				} else {
					if(is_numeric($_GET['type'])) {
						$page = $this->checkPage();
						$this->showItemCategory($_GET['type'], $page);
					} else {
						$this->showItemCategory("All", 0);
					}
				}
				break;
			// Achievements
			case 5:
				$page = $this->checkPage();
				if(!(isset($_GET['type']))) {
					$this->showAchievementList("All", $page);
				} else {
					if(is_numeric($_GET['type'])) {
						$this->showAchievementList($_GET['type'], $page);
					} else {
						$this->showAchievementList("All", $page);
					}
				}
				break;
			// Titles
			case 6:
				$page = $this->checkPage();
				if(!(isset($_GET['type']))) {
					$this->showTitleList("All", $page);
				} else {
					if(is_numeric($_GET['type'])) {
						$this->showTitleList($_GET['type'], $page);
					} else {
						$this->showTitleList("All", $page);
					}
				}
				break;
			case 7:
				$page = $this->checkPage();
				if(!(isset($_GET['type']))) {
					$this->showBiologyList("All", $page);
				} else {
					if(is_numeric($_GET['type'])) {
						$this->showBiologyList($_GET['type'], $page);
					} else {
						$this->showBiologyList("All", $page);
					}
				}
				break;
			// Mapas (Sacar Type porque no hay o si???)
			case 8:
				$page = $this->checkPage();
				if(!(isset($_GET['type']))) {
					$this->showMapsList("All", $page);
				} else {
					if(is_numeric($_GET['type'])) {
						$this->showMapsList($_GET['type'], $page);
					} else {
						$this->showMapsList("All", $page);
					}
				}
				break;
			case 9:
				$page = $this->checkPage();
				if(!(isset($_GET['type']))) {
					$this->showQuestList("All", $page);
				} else {
					if(is_numeric($_GET['type'])) {
						$this->showQuestList($_GET['type'], $page);
					} else {
						$this->showQuestList("All", $page);
					}
				}
				break;
			// Posts
			case 100:
				if(!(isset($_GET['pid']))) {
					$this->showPost(0);
				} else {
					if(is_numeric($_GET['pid'])) {
						$this->showPost($_GET['pid']);
					} else {
						$this->showPost(0);
					}
				}
				break;
			case 101:
				if(!(isset($_GET['type']))) {
					$this->showPost(0);
				} else {
					if(is_numeric($_GET['type'])) {
						$this->showPost($_GET['type']);
					} else {
						$this->showPost(0);
					}
				}
				break;
		}
	}
	private function checkPage()
	{
		if(isset($_GET['page'])) {
			if(is_numeric($_GET['page'])) {
				$page = $_GET['page'];
			} else {
				$page = 1;
			}
		} else {
			$page = 1;
		}
		return $page;
	}
	private function showMapsList($action, $currentPage)
	{
		if(!(is_numeric($action))) {
			$limitPage = 40;
			$db = $this->connect();
			// Cantidad de registros
			$stmt = $db->prepare("SELECT DISTINCT tName FROM t_node as a INNER JOIN c_node as b on a.tID = b.cID");
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			echo '<div id="categoryList"><div Class="categoryIndex">Maps (' . $cantResultados . ')</div>
			<div id="achievementList">';
			$stmt = $db->prepare("SELECT a.tName, a.tID, a.tURL FROM t_node as a INNER JOIN c_node as b on a.tID = b.cID group by a.tName order by a.tID ASC LIMIT ? , ?");
			$stmt->bindParam(1, $min, PDO::PARAM_INT);
			$stmt->bindParam(2, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=4&id=" . $row['tID'] . "&in=" . $row['tURL'];
					} else {
						$achievementLink = $this->apiURL . "maps/" . $row['tID'] . "/" . $row['tURL'];
					}
					$mapName = $row['tName'];
					$mapLevel = 0;
					if(preg_match('#^Lv#', $mapName) === 1) {
						$mapSubName = substr($mapName, 5);
						$mapLevel = substr($mapName, 2);
						$mapLevel = substr($mapLevel, 0, strpos($mapLevel, "."));
						$mapName = $mapSubName;
					}
					if($mapLevel > 0) {
						$hasLevel = '<div class="achievementAP title" style="background-color: rgb(0, 138, 255);" title="Map Level Limit">Lvl ' . $mapLevel . '</div>';
					} else {
						$hasLevel = '';
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="locationKey"></span><div class="mapName">' . ucfirst($mapName) . '</div>' . $hasLevel . '<div class="clear"></div></a>';
					if($a == 20) {
						if(!($this->isAPP)){
							echo $this->adsInPost;
						}
					}
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=8&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=8&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=8&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=8&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "maps/page/" . $prevPage;
					$ppLink = $this->apiURL . "maps/page/" . $firstPage;
					$psLink = $this->apiURL . "maps/page/" . $nextPage;
					$pfLink = $this->apiURL . "maps/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 5;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 2;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 2;
				}
				if($currentPage > $Pages - 2) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=8&page=" . $i;
					} else {
						$iLink = $this->apiURL . "maps/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div>';
			}
			echo '</div>
			</div>';
		}
	}
	private function showTitleList($action, $currentPage)
	{
		if(is_numeric($action)) {
			$limitPage = 40;
			$db = $this->connect();
			$stmt = $db->prepare("SELECT a.tID, a.tCat, b.tName FROM t_title as a INNER JOIN t_title_category as b on a.tCat = b.tName where b.tID = ?");
			$stmt->bindParam(1, $action, PDO::PARAM_INT);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			echo '<div id="categoryList"><div Class="categoryIndex">Titles (' . $cantResultados . ')</div>
			<div id="achievementList">';
			$stmt = $db->prepare("SELECT
			a.tID,
			a.tName,
			a.tCat,
			c.tID,
			b.*,
			a.tURL
			FROM
			t_title AS a
			INNER JOIN c_title AS b ON a.tID = b.tID
			INNER JOIN t_title_category AS c ON a.tCat = c.tName WHERE c.tID = ? LIMIT ? , ?");
			$stmt->bindParam(1, $action, PDO::PARAM_INT);
			$stmt->bindParam(2, $min, PDO::PARAM_INT);
			$stmt->bindParam(3, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=3&id=" . $row['tID'] . "&in=" . $row['tURL'];
					} else {
						$achievementLink = $this->apiURL . "titles/" . $row['tID'] . "/" . $row['tURL'];
					}
					$stat = "-";
					if($row['HP'] > 0) {
						$stat = "+ " . $row['HP'] . " HP";
					}
					if($row['SP'] > 0) {
						$stat = "+ " . $row['SP'] . " SP";
					}
					if($row['ATK'] > 0) {
						$stat = "+ " . $row['ATK'] . " ATK";
					}
					if($row['PEN'] > 0) {
						$stat = "+ " . $row['PEN'] . " PEN";
					}
					if($row['DEF'] > 0) {
						$stat = "+ " . $row['DEF'] . " DEF";
					}
					if($row['CRIT'] > 0) {
						$stat = "+ " . $row['CRIT'] . " CRIT";
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="arrowKey"></span><div class="achievementName"><span class="iGrade-' . $row['tGrade'] . '">' . $row['tName'] . '</span></div><div class="achievementCat"><b>' . $row['tCat'] . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
					if($a == 20) {
						if(!($this->isAPP)){
						echo $this->adsInPost;
						}
					}
				}
			} else {
				// Buscar si esta solamente en la db ingles
				$stmt = $db->prepare("SELECT
			a.tID,
			a.tName,
			a.tCat,
			c.tID as catID,
				
			a.tURL
			FROM
			t_title AS a
			INNER JOIN t_title_category AS c ON a.tCat = c.tName WHERE c.tID = ? LIMIT ? , ?");
				$stmt->bindParam(1, $action, PDO::PARAM_INT);
				$stmt->bindParam(2, $min, PDO::PARAM_INT);
				$stmt->bindParam(3, $limitPage, PDO::PARAM_INT);
				$stmt->execute();
				$cant = $stmt->rowCount();
				if($cant != 0) {
					$a = 0;
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$a++;
						if($this->apiMode == "Debug") {
							$achievementLink = $this->apiURL . "index.php?act=3&cat=3&id=" . $row['tID'] . "&in=" . $row['tURL'];
						} else {
							$achievementLink = $this->apiURL . "titles/" . $row['tID'] . "/" . $row['tURL'];
						}
						$stat = "-";
						echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="arrowKey"></span><div class="achievementName"><span class="iGrade-0">' . $row['tName'] . '</span></div><div class="achievementCat"><b>' . $row['tCat'] . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
						if($a == 20) {
							if(!($this->isAPP)){
							echo $this->adsInPost;
							}
						}
					}
				} else {
					echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>' . $this->adsInPost;
				}
			}
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=6&type=" . $action . "&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=6&type=" . $action . "&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=6&type=" . $action . "&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=6&type=" . $action . "&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "titles/type/" . $action . "/page/" . $prevPage;
					$ppLink = $this->apiURL . "titles/type/" . $action . "/page/" . $firstPage;
					$psLink = $this->apiURL . "titles/type/" . $action . "/page/" . $nextPage;
					$pfLink = $this->apiURL . "titles/type/" . $action . "/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 5;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 2;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 2;
				}
				if($currentPage > $Pages - 2) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=6&type=" . $action . "&page=" . $i;
					} else {
						$iLink = $this->apiURL . "titles/type/" . $action . "/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div>';
			}
			echo '</div>
			</div>';
		} else {
			$limitPage = 40;
			$db = $this->connect();
			// Cantidad de registros
			$stmt = $db->prepare("SELECT * FROM t_title");
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			echo '<div id="categoryList"><div Class="categoryIndex">Titles (' . $cantResultados . ')</div>
			<div id="achievementList">';
			$stmt = $db->prepare("SELECT
				a.tID,
				a.tName,
				a.tCat,
				c.tID,
				b.*,
				a.tURL
				FROM
				t_title AS a
				INNER JOIN c_title AS b ON a.tID = b.tID
				INNER JOIN t_title_category AS c ON a.tCat = c.tName LIMIT ? , ?");
			$stmt->bindParam(1, $min, PDO::PARAM_INT);
			$stmt->bindParam(2, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=3&id=" . $row['tID'] . "&in=" . $row['tURL'];
					} else {
						$achievementLink = $this->apiURL . "titles/" . $row['tID'] . "/" . $row['tURL'];
					}
					$stat = "-";
					if($row['HP'] > 0) {
						$stat = "+ " . $row['HP'] . " HP";
					}
					if($row['SP'] > 0) {
						$stat = "+ " . $row['SP'] . " SP";
					}
					if($row['ATK'] > 0) {
						$stat = "+ " . $row['ATK'] . " ATK";
					}
					if($row['PEN'] > 0) {
						$stat = "+ " . $row['PEN'] . " PEN";
					}
					if($row['DEF'] > 0) {
						$stat = "+ " . $row['DEF'] . " DEF";
					}
					if($row['CRIT'] > 0) {
						$stat = "+ " . $row['CRIT'] . " CRIT";
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="arrowKey"></span><div class="achievementName"><span class="iGrade-' . $row['tGrade'] . '">' . $row['tName'] . '</span></div><div class="achievementCat"><b>' . $row['tCat'] . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
					if($a == 20) {
						if(!($this->isAPP)){
							echo $this->adsInPost;
						}
					}
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=6&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=6&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=6&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=6&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "titles/page/" . $prevPage;
					$ppLink = $this->apiURL . "titles/page/" . $firstPage;
					$psLink = $this->apiURL . "titles/page/" . $nextPage;
					$pfLink = $this->apiURL . "titles/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 5;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 2;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 2;
				}
				if($currentPage > $Pages - 2) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=6&page=" . $i;
					} else {
						$iLink = $this->apiURL . "titles/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div>';
			}
			echo '</div>
			</div>';
		}
	}
	private function showQuestList($action, $currentPage)
	{
		if(is_numeric($action)) {
			$limitPage = 40;
			$db = $this->connect();
			// Cantidad de registros
			$stmt = $db->prepare("SELECT a.qID, a.qName, a.qChapter, a.qURL from t_mission as a
														INNER JOIN t_mission_category as b on a.qChapter = b.qName
														WHERE b.qID = ?");
			$stmt->bindParam(1, $action, PDO::PARAM_INT);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			echo '<div id="categoryList"><div Class="categoryIndex">Quests (' . $cantResultados . ')</div>
			<div id="achievementList">';
			$stmt = $db->prepare("SELECT a.qID, a.qName, a.qChapter, a.qURL from t_mission as a
														INNER JOIN t_mission_category as b on a.qChapter = b.qName
														WHERE b.qID = ?
														ORDER BY a.qID ASC LIMIT ? , ?");
			$stmt->bindParam(1, $action, PDO::PARAM_INT);
			$stmt->bindParam(2, $min, PDO::PARAM_INT);
			$stmt->bindParam(3, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=5&id=" . $row['qID'] . "&in=" . $row['qURL'];
					} else {
						$achievementLink = $this->apiURL . "quests/" . $row['qID'] . "/" . $row['qURL'];
					}
					$questName = $row['qName'];
					$stat = "-";
					$questLevel = 0;
					if(preg_match('#^Lv#', $questName) === 1) {
						$mapSubName = substr($questName, 5);
						$questLevel = substr($questName, 2);
						$stat = "Lvl. " . substr($questLevel, 0, strpos($questLevel, "."));
						$questName = $mapSubName;
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="bagKey"></span><div class="achievementName"><span class="iGrade-0">' . $questName . '</span></div><div class="achievementCat"><b>' . $row['qChapter'] . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
					if($a == 20) {
						if(!($this->isAPP)){
							echo $this->adsInPost;
						}
					}
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "quests/type/" . $action . "/page/" . $prevPage;
					$ppLink = $this->apiURL . "quests/type/" . $action . "/page/" . $firstPage;
					$psLink = $this->apiURL . "quests/type/" . $action . "/page/" . $nextPage;
					$pfLink = $this->apiURL . "quests/type/" . $action . "/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 5;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 2;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 2;
				}
				if($currentPage > $Pages - 2) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $i;
					} else {
						$iLink = $this->apiURL . "quests/type/" . $action . "/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div>';
			}
			echo '</div>
			</div>';
		} else {
			$limitPage = 40;
			$db = $this->connect();
			// Cantidad de registros
			$stmt = $db->prepare("SELECT * FROM t_mission");
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			echo '<div id="categoryList"><div Class="categoryIndex">Quests (' . $cantResultados . ')</div>
			<div id="achievementList">';
			$stmt = $db->prepare("SELECT * from t_mission order by qID ASC LIMIT ? , ?");
			$stmt->bindParam(1, $min, PDO::PARAM_INT);
			$stmt->bindParam(2, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=5&id=" . $row['qID'] . "&in=" . $row['qURL'];
					} else {
						$achievementLink = $this->apiURL . "quests/" . $row['qID'] . "/" . $row['qURL'];
					}
					$questName = $row['qName'];
					$stat = "-";
					$questLevel = 0;
					if(preg_match('#^Lv#', $questName) === 1) {
						$mapSubName = substr($questName, 5);
						$questLevel = substr($questName, 2);
						$stat = "Lvl. " . substr($questLevel, 0, strpos($questLevel, "."));
						$questName = $mapSubName;
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="bagKey"></span><div class="achievementName"><span class="iGrade-0">' . $questName . '</span></div><div class="achievementCat"><b>' . $row['qChapter'] . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
					if($a == 20) {
						if(!($this->isAPP)){
							echo $this->adsInPost;
						}
					}
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=9&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=9&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=9&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=9&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "quests/page/" . $prevPage;
					$ppLink = $this->apiURL . "quests/page/" . $firstPage;
					$psLink = $this->apiURL . "quests/page/" . $nextPage;
					$pfLink = $this->apiURL . "quests/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 5;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 2;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 2;
				}
				if($currentPage > $Pages - 2) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=9&page=" . $i;
					} else {
						$iLink = $this->apiURL . "quests/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div>';
			}
			echo '</div>
			</div>';
		}
	}
	private function showBiologyList($action, $currentPage)
	{
		if(is_numeric($action)) {
			$limitPage = 40;
			$db = $this->connect();
			// Cantidad de registros
			$stmt = $db->prepare("SELECT a.qID, a.qName, a.qChapter, a.qURL from t_mission as a
														INNER JOIN t_mission_category as b on a.qChapter = b.qName
														WHERE b.qID = ?");
			$stmt->bindParam(1, $action, PDO::PARAM_INT);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			echo '<div id="categoryList"><div Class="categoryIndex">Quests (' . $cantResultados . ')</div>
			<div id="achievementList">';
			$stmt = $db->prepare("SELECT a.qID, a.qName, a.qChapter, a.qURL from t_mission as a
														INNER JOIN t_mission_category as b on a.qChapter = b.qName
														WHERE b.qID = ?
														ORDER BY a.qID ASC LIMIT ? , ?");
			$stmt->bindParam(1, $action, PDO::PARAM_INT);
			$stmt->bindParam(2, $min, PDO::PARAM_INT);
			$stmt->bindParam(3, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=5&id=" . $row['qID'] . "&in=" . $row['qURL'];
					} else {
						$achievementLink = $this->apiURL . "quests/" . $row['qID'] . "/" . $row['qURL'];
					}
					$questName = $row['qName'];
					$stat = "-";
					$questLevel = 0;
					if(preg_match('#^Lv#', $questName) === 1) {
						$mapSubName = substr($questName, 5);
						$questLevel = substr($questName, 2);
						$stat = "Lvl. " . substr($questLevel, 0, strpos($questLevel, "."));
						$questName = $mapSubName;
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="bagKey"></span><div class="achievementName"><span class="iGrade-0">' . $questName . '</span></div><div class="achievementCat"><b>' . $row['qChapter'] . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
					if($a == 20) {
						if(!($this->isAPP)){
							echo $this->adsInPost;
						}
					}
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "quests/type/" . $action . "/page/" . $prevPage;
					$ppLink = $this->apiURL . "quests/type/" . $action . "/page/" . $firstPage;
					$psLink = $this->apiURL . "quests/type/" . $action . "/page/" . $nextPage;
					$pfLink = $this->apiURL . "quests/type/" . $action . "/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 5;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 2;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 2;
				}
				if($currentPage > $Pages - 2) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=9&type=" . $action . "&page=" . $i;
					} else {
						$iLink = $this->apiURL . "quests/type/" . $action . "/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div>';
			}
			echo '</div>
			</div>';
		} else {
			$limitPage = 40;
			$db = $this->connect();
			// Cantidad de registros
			$stmt = $db->prepare("SELECT * FROM t_biology");
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			echo '<div id="categoryList"><div Class="categoryIndex">Biology (' . $cantResultados . ')</div>
			<div id="achievementList">';
			$stmt = $db->prepare("SELECT * from t_biology order by mID ASC LIMIT ? , ?");
			$stmt->bindParam(1, $min, PDO::PARAM_INT);
			$stmt->bindParam(2, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=6&id=" . $row['mID'] . "&in=" . $row['mURL'];
					} else {
						$achievementLink = $this->apiURL . "biology/" . $row['mID'] . "/" . $row['mURL'];
					}
					$mobName = $row['mName'];
					$stat = "-";
					if($row['mPart'] != "") {
						$stat = $row['mPart'];
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="bagKey"></span><div class="achievementName"><b>' . $mobName . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
					if($a == 20) {
						if(!($this->isAPP)){
							echo $this->adsInPost;
						}
					}
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>' . $this->adsInPost;
			}
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=7&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=7&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=7&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=79&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "biology/page/" . $prevPage;
					$ppLink = $this->apiURL . "biology/page/" . $firstPage;
					$psLink = $this->apiURL . "biology/page/" . $nextPage;
					$pfLink = $this->apiURL . "biology/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 5;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 2;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 2;
				}
				if($currentPage > $Pages - 2) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=7&page=" . $i;
					} else {
						$iLink = $this->apiURL . "biology/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div>';
			}
			echo '</div>
			</div>';
		}
	}
	private function showAchievementList($action, $currentPage)
	{
		if(is_numeric($action)) {
			$limitPage = 40;
			$db = $this->connect();
			$stmt = $db->prepare("SELECT a.aID, a.aName, a.aCat,b.cID, a.aURL FROM t_achievement as a INNER JOIN t_achievement_category as b on a.aCat = b.cName where b.cID = ?");
			$stmt->bindParam(1, $action, PDO::PARAM_INT);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			echo '<div id="categoryList"><div Class="categoryIndex">Achievements (' . $cantResultados . ')</div>
		<div id="achievementList">';
			$stmt = $db->prepare("SELECT
															a.aID,
															a.aName,
															a.aCat,
															c.cID,
															IFNULL(b.aAP, 0) as aAP,
															a.aURL
														FROM
															t_achievement AS a
														LEFT JOIN c_achievement as b ON a.aID = b.aID
														INNER JOIN t_achievement_category AS c ON a.aCat = c.cName WHERE c.cID = ? LIMIT ? , ?");
			$stmt->bindParam(1, $action, PDO::PARAM_INT);
			$stmt->bindParam(2, $min, PDO::PARAM_INT);
			$stmt->bindParam(3, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=2&id=" . $row['aID'] . "&in=" . $row['aURL'];
					} else {
						$achievementLink = $this->apiURL . "achievements/" . $row['aID'] . "/" . $row['aURL'];
					}
					if($row['aAP'] > 0) {
						$hasAP = '<div class="achievementAP title" title="Achievement Points">+ ' . $row['aAP'] . ' AP</div>';
					} else {
						$hasAP = '<div class="achievementAP title" title="Achievement Points">-</div>';
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="starKey"></span><div class="achievementName">' . $row['aName'] . '</div><div class="achievementCat"><b>' . $row['aCat'] . '</b></div>' . $hasAP . '<div class="clear"></div></a>';
					if($a == 20) {
						if(!($this->isAPP)){
							echo $this->adsInPost;
						}
					}
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=5&type=" . $action . "&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=5&type=" . $action . "&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=5&type=" . $action . "&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=5&type=" . $action . "&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "achievements/type/" . $action . "/page/" . $prevPage;
					$ppLink = $this->apiURL . "achievements/type/" . $action . "/page/" . $firstPage;
					$psLink = $this->apiURL . "achievements/type/" . $action . "/page/" . $nextPage;
					$pfLink = $this->apiURL . "achievements/type/" . $action . "/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 5;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 2;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 2;
				}
				if($currentPage > $Pages - 2) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=5&type=" . $action . "&page=" . $i;
					} else {
						$iLink = $this->apiURL . "achievements/type/" . $action . "/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div>';
			}
			echo '</div>
		</div>';
		} else {
			$limitPage = 40;
			$db = $this->connect();
			$stmt = $db->prepare("SELECT a.aID, a.aName, a.aCat,b.cID, a.aURL FROM t_achievement as a INNER JOIN t_achievement_category as b on a.aCat = b.cName");
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			echo '<div id="categoryList"><div Class="categoryIndex">Achievements (' . $cantResultados . ')</div>
		<div id="achievementList">';
			$stmt = $db->prepare("SELECT
															a.aID,
															a.aName,
															a.aCat,
															c.cID,
															b.aAP,
															a.aURL
														FROM
															t_achievement AS a
														INNER JOIN c_achievement as b ON a.aID = b.aID
														INNER JOIN t_achievement_category AS c ON a.aCat = c.cName LIMIT ? , ?");
			$stmt->bindParam(1, $min, PDO::PARAM_INT);
			$stmt->bindParam(2, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=2&id=" . $row['aID'] . "&in=" . $row['aURL'];
					} else {
						$achievementLink = $this->apiURL . "achievements/" . $row['aID'] . "/" . $row['aURL'];
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="starKey"></span><div class="achievementName">' . $row['aName'] . '</div><div class="achievementCat"><b>' . $row['aCat'] . '</b></div><div class="achievementAP title" title="Achievement Points">+ ' . $row['aAP'] . ' AP</div><div class="clear"></div></a>';
					if($a == 20) {
						if(!($this->isAPP)){
							echo $this->adsInPost;
						}
					}
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=5&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=5&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=5&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=5&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "achievements/page/" . $prevPage;
					$ppLink = $this->apiURL . "achievements/page/" . $firstPage;
					$psLink = $this->apiURL . "achievements/page/" . $nextPage;
					$pfLink = $this->apiURL . "achievements/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 5;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 2;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 2;
				}
				if($currentPage > $Pages - 2) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=5&page=" . $i;
					} else {
						$iLink = $this->apiURL . "achievements/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div>';
			}
			echo '</div>
		</div>';
		}
	}

	private function showItemCategory($action, $currentPage)
	{
		if(is_numeric($action)) {
			
			$this->printFilterMenu("items");

			if(isset($_SESSION['iFilteredQ1'])){
				if($_SESSION['iFilteredCat'] == $_GET['type']){
					$queryC = $_SESSION['iFilteredQ2'];
					$queryT = $_SESSION['iFilteredQ1'];
				}else{
					$queryC = 'SELECT c_items.ItemID, c_items.ItemIndex, c_items.ItemGrade, c_items.ItemLevel, t_items.ItemName, t_items.ItemDesc,  t_items.ItemURL FROM c_items INNER JOIN t_items ON t_items.ItemID=c_items.ItemID WHERE c_items.ItemType = ? LIMIT ? , ? ';
					$queryT = 'SELECT c_items.ItemID FROM c_items INNER JOIN t_items ON t_items.ItemID=c_items.ItemID WHERE c_items.ItemType = ?';
				}
			}else{
				$queryC = 'SELECT c_items.ItemID, c_items.ItemIndex, c_items.ItemGrade, c_items.ItemLevel, t_items.ItemName, t_items.ItemDesc,  t_items.ItemURL FROM c_items INNER JOIN t_items ON t_items.ItemID=c_items.ItemID WHERE c_items.ItemType = ? LIMIT ? , ? ';
				$queryT = 'SELECT c_items.ItemID FROM c_items INNER JOIN t_items ON t_items.ItemID=c_items.ItemID WHERE c_items.ItemType = ?';
			}

			$db = $this->connect();
			$catName = $this->returnCategoryName($action);
			$limitPage = 39;
			$stmtS = $db->prepare($queryT);
			$stmtS->bindParam(1, $action, PDO::PARAM_INT);
			$stmtS->execute();
			$cantResultados = $stmtS->rowCount();
			$Pages = ceil($cantResultados / $limitPage);
			if($currentPage > $Pages) {
				$currentPage = $Pages;
			}
			$prevPage = $currentPage - 1;
			$nextPage = $currentPage + 1;
			$min = ($currentPage * $limitPage) - $limitPage;
			$max = $currentPage * $limitPage;
			if($min < 0) {
				$min = 0;
			}
			$stmt = $db->prepare($queryC);
			$stmt->bindParam(1, $action, PDO::PARAM_INT);
			$stmt->bindParam(2, $min, PDO::PARAM_INT);
			$stmt->bindParam(3, $limitPage, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			$this->apiCategory = $catName;
			echo '<div id="categoryList"><div Class="categoryIndex">' . $this->apiCategory . ' (' . $cantResultados . ')</div>';
			echo '<div class="itemSearchBoxes">';
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$linktoURL = $this->apiURL . 'index.php?act=3&cat=1&id=' . $row['ItemID'] . '&in=' . $row['ItemURL'];
					} else {
						$linktoURL = $this->apiURL . 'items/' . $row['ItemID'] . '/' . $row['ItemURL'];
					}
					if($row['ItemLevel'] > 0) {
						$hasLevel = '<div class="itemLevelSearch">Lvl ' . $row['ItemLevel'] . '</div>';
					} else {
						$hasLevel = "";
					}
					echo '<a class="title iGrade-' . (int) $row['ItemGrade'] . '" href="' . $linktoURL . '" title="' . $row['ItemName'] . '" alt="' . $row['ItemName'] . '">' . $hasLevel . '<img src="' . $this->apiURL . 'resources/images/itemsicon/' . $row['ItemIndex'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img><div class="clear"></div>' . $row['ItemName'] . '</a>';
					if($a == 18) {
						echo '<div class="clear"></div>';
						if(!($this->isAPP)){
							echo $this->adsInPost;
						}
					}
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
			echo '<div class="clear"></div></div>';
			if($cant != 0) {
				// Primera Pagina y Anterior
				$firstPage = 1;
				if($this->apiMode == "Debug") {
					$ppLink = $this->apiURL . "index.php?act=4&type=" . $action . "&page=" . $firstPage;
					$paLink = $this->apiURL . "index.php?act=4&type=" . $action . "&page=" . $prevPage;
					$psLink = $this->apiURL . "index.php?act=4&type=" . $action . "&page=" . $nextPage;
					$pfLink = $this->apiURL . "index.php?act=4&type=" . $action . "&page=" . $Pages;
				} else {
					$paLink = $this->apiURL . "items/type/" . $action . "/page/" . $prevPage;
					$ppLink = $this->apiURL . "items/type/" . $action . "/page/" . $firstPage;
					$psLink = $this->apiURL . "items/type/" . $action . "/page/" . $nextPage;
					$pfLink = $this->apiURL . "items/type/" . $action . "/page/" . $Pages;
				}
				if($currentPage == 1) {
					$primerPagina = '<a class="pagInactive"><<</a>';
					$anteriorPagina = '<a class="pagInactive"><</a>';
				} else {
					$primerPagina = '<a title="First Page" href="' . $ppLink . '" class="pagActive title"><<</a>';
					$anteriorPagina = '<a title="Previous Page" href="' . $paLink . '" class="pagActive title"><</a>';
				}
				echo '<div id="paginationSearch">' . $primerPagina . '' . $anteriorPagina . '';
				$cantBoxes = 7;
				$mitadBoxes = ceil($cantBoxes / 2);
				if($currentPage > $mitadBoxes) {
					$iStart = $currentPage - 3;
				} else {
					$iStart = 1;
				}
				if($currentPage < $mitadBoxes) {
					$iEnd = $cantBoxes;
				} else {
					$iEnd = $currentPage + 3;
				}
				if($currentPage > $Pages - 3) {
					$iEnd = $Pages;
				}
				if($iStart > $Pages - $cantBoxes) {
					// $iStart = $Pages - $cantBoxes +1;
				}
				for($i = $iStart; $i <= $iEnd; $i++) {
					if($this->apiMode == "Debug") {
						$iLink = $this->apiURL . "index.php?act=4&type=" . $action . "&page=" . $i;
					} else {
						$iLink = $this->apiURL . "items/type/" . $action . "/page/" . $i;
					}
					if($i == $currentPage) {
						echo '<a class="pagCurrent" href="' . $iLink . '">' . $i . '</a>';
					} else {
						echo '<a class="pagActive" href="' . $iLink . '">' . $i . '</a>';
					}
				}
				// Ultima Pagina y Siguiente
				if($currentPage == $Pages) {
					$finalPagina = '<a class="pagInactive">>></a>';
					$siguientePagina = '<a class="pagInactive">></a>';
				} else {
					$finalPagina = '<a title="Last Page" class="pagActive title" href="' . $pfLink . '">>></a>';
					$siguientePagina = '<a title="Next Page" class="pagActive title" href="' . $psLink . '">></a>';
				}
				echo $siguientePagina . '' . $finalPagina . '</div></div>';
			}
		} else {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT DISTINCT catIndex FROM t_items_category ");
			$stmt->execute();
			echo '<div id="categoryList">';
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo '<div Class="categoryIndex">' . $row['catIndex'] . '</div>';
				echo '<div class="itemCategoryBoxes">';
				$stmt2 = $db->prepare("SELECT * FROM t_items_category where catIndex = ? order by catName ASC");
				$stmt2->bindParam(1, $row['catIndex'], PDO::PARAM_STR);
				$stmt2->execute();
				while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
					$stmt3 = $db->prepare("SELECT ItemIndex FROM c_items INNER JOIN t_items ON t_items.ItemID=c_items.ItemID  where c_items.ItemType = ? order by RAND() LIMIT 1");
					$stmt3->bindParam(1, $row2['catID'], PDO::PARAM_STR);
					$stmt3->execute();
					$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
					$myImage = 0;
					if($row3) {
						if($row3['ItemIndex'] != null) {
							$myImage = $row3['ItemIndex'];
						} else {
							$myImage = "0";
							// die($row3['ItemIndex']);
						}
					} else {
						$myImage = "0";
					}
					if($this->apiMode == "Debug") {
						$myLink = $this->apiURL . "index.php?act=4&type=" . $row2['catID'] . "";
					} else {
						$myLink = $this->apiURL . "items/type/" . $row2['catID'] . "";
					}
					echo '<a href="' . $myLink . '"><img src="' . $this->apiURL . 'resources/images/itemsicon/' . $myImage . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img><div class="clear"></div>' . $row2['catName'] . '</a>';
				}
				echo '<div class="clear"></div>
							</div>';
			}
			echo '</div>';
		}
	}
	// Muestra las Busquedas
	private function searchTable($currentPage, $key)
	{
		if(isset($_GET['f'])) {
			echo 'buscar en categoria f todos los items';
		} else {
			echo '<div id="searchNew"><div id="escapingBallG"><div id="escapingBall_1" class="escapingBallG" style="background-color: rgb(106, 183, 240);"></div></div><div style="margin-top: -65px;text-align: center;font-size: 20px;background-color: rgba(42, 39, 39, 0.83);padding-top: 20px;padding-bottom: 15px;border-radius: 5px;border: 1px solid rgb(116, 101, 216);"><br/>Searching in 
		<div id="CONF_URL" style="display:none;">' . $this->apiURL . '</div>
		<div id="CONF_KEYS" style="display:none;">' . $this->apiSearchKeys . '</div>
		<div id="SDBTABLES">Items</div>
		Database. Please Wait</div>    
		</div>
		<div id="SDBRESULT" style="display:none">
			
		</div>    
		';
		}
	}
	public function searchAjax($cat, $key)
	{
		if($cat == 4) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT c_items.ItemID, c_items.ItemGrade, c_items.ItemIndex,c_items.ItemLevel, t_items.ItemName, t_items.ItemDesc,  t_items.ItemURL FROM t_items INNER JOIN c_items ON c_items.ItemID=t_items.ItemID WHERE t_items.ItemName LIKE CONCAT('%', ?, '%')");
			$stmt->bindParam(1, $key, PDO::PARAM_STR);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$stmt = $db->prepare("SELECT c_items.ItemID, c_items.ItemGrade, c_items.ItemIndex,c_items.ItemLevel, t_items.ItemName, t_items.ItemDesc,  t_items.ItemURL FROM t_items INNER JOIN c_items ON c_items.ItemID=t_items.ItemID WHERE t_items.ItemName LIKE CONCAT('%', ?, '%') LIMIT 9");
			$stmt->bindParam(1, $key, PDO::PARAM_STR);
			$stmt->execute();
			echo '<div Class="categoryIndex">Items (' . $cantResultados . ')</div>';
			echo '<div class="itemSearchBoxes">';
			if($cantResultados != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$linktoURL = $this->apiURL . 'index.php?act=3&cat=1&id=' . $row['ItemID'] . '&in=' . $row['ItemURL'];
					} else {
						$linktoURL = $this->apiURL . 'items/' . $row['ItemID'] . '/' . $row['ItemURL'];
					}
					if($row['ItemLevel'] > 0) {
						$hasLevel = '<div class="itemLevelSearch">Lvl ' . $row['ItemLevel'] . '</div>';
					} else {
						$hasLevel = "";
					}
					echo '<a class="iGrade-' . (int) $row['ItemGrade'] . '"href="' . $linktoURL . '" class="title" title="' . $row['ItemName'] . '" alt="' . $row['ItemName'] . '">' . $hasLevel . '<img src="' . $this->apiURL . 'resources/images/itemsicon/' . $row['ItemIndex'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img><div class="clear"></div>' . $row['ItemName'] . '</a>';
				}
			} else {
				echo '<div id="errorSet">Nothing found on Items Database<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
			echo '<div class="clear"></div></div>';
			if($cantResultados > 9) {
				$thisURL = htmlspecialchars($_SERVER["PHP_SELF"]);
				echo '<form action="' . $thisURL . '?k=' . $key . '&c=' . $cat . '" method="post">
							<input type="hidden" name="sAll" value="' . $cat . '">';
				echo '<input type="submit" class="sShowAll" href="#" value="Show all Results in Items"></input></form>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
		}
		if($cat == 8) {
			// Mapas
			$db = $this->connect();
			$stmt = $db->prepare("SELECT a.tName, a.tID, a.tURL FROM t_node as a INNER JOIN c_node as b on a.tID = b.cID where a.tName LIKE CONCAT('%', ?, '%')");
			$stmt->bindParam(1, $key, PDO::PARAM_STR);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			echo '<div Class="categoryIndex">Maps (' . $cantResultados . ')</div>
				<div id="achievementList">';
			$stmt = $db->prepare("SELECT a.tName, a.tID, a.tURL FROM t_node as a INNER JOIN c_node as b on a.tID = b.cID where a.tName LIKE CONCAT('%', ?, '%') LIMIT 5");
			$stmt->bindParam(1, $key, PDO::PARAM_INT);
			$stmt->execute();
			if($cantResultados != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=4&id=" . $row['tID'] . "&in=" . $row['tURL'];
					} else {
						$achievementLink = $this->apiURL . "maps/" . $row['tID'] . "/" . $row['tURL'];
					}
					$mapName = $row['tName'];
					$mapLevel = 0;
					if(preg_match('#^Lv#', $mapName) === 1) {
						$mapSubName = substr($mapName, 5);
						$mapLevel = substr($mapName, 2);
						$mapLevel = substr($mapLevel, 0, strpos($mapLevel, "."));
						$mapName = $mapSubName;
					}
					if($mapLevel > 0) {
						$hasLevel = '<div class="achievementAP title" style="background-color: rgb(0, 138, 255);" title="Map Level Limit">Lvl ' . $mapLevel . '</div>';
					} else {
						$hasLevel = '';
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="locationKey"></span><div class="mapName">' . ucfirst($mapName) . '</div>' . $hasLevel . '<div class="clear"></div></a>';
				}
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			} else {
				echo '<div id="errorSet">Nothing found on Maps database<br/>Please Try Again Later.</div>';
			}
			if($cantResultados > 5) {
				echo '<a class="sShowAll" href="#">Show all Results in Maps</a>';
			}
		}
		if($cat == 5) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT a.aID, a.aName, a.aCat,b.cID, a.aURL FROM t_achievement as a INNER JOIN t_achievement_category as b on a.aCat = b.cName where a.aName LIKE CONCAT('%', ?,'%')");
			$stmt->bindParam(1, $key, PDO::PARAM_INT);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			echo '<div Class="categoryIndex">Achievements (' . $cantResultados . ')</div>
				<div id="achievementList">';
			$stmt = $db->prepare("SELECT
																a.aID,
																a.aName,
																a.aCat,
																c.cID,
																IFNULL(b.aAP, 0) as aAP,
																a.aURL
															FROM
																t_achievement AS a
															LEFT JOIN c_achievement as b ON a.aID = b.aID
															INNER JOIN t_achievement_category AS c ON a.aCat = c.cName WHERE a.aName LIKE CONCAT('%', ?,'%') LIMIT 5");
			$stmt->bindParam(1, $key, PDO::PARAM_INT);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=2&id=" . $row['aID'] . "&in=" . $row['aURL'];
					} else {
						$achievementLink = $this->apiURL . "achievements/" . $row['aID'] . "/" . $row['aURL'];
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="starKey"></span><div class="achievementName">' . ucfirst($row['aName']) . '</div><div class="achievementCat"><b>' . $row['aCat'] . '</b></div><div class="achievementAP title" title="Achievement Points">+ ' . $row['aAP'] . ' AP</div><div class="clear"></div></a>';
				}
				if($cantResultados > 5) {
					echo '<a class="sShowAll" href="#">Show all Results in Achievement</a>';
				}
			} else {
				echo '<div id="errorSet">Nothing Found on Achievements Database<br/>Please Try Again Later.</div>';
			}
		}
		if($cat == 6) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT a.tID, a.tCat, b.tName FROM t_title as a INNER JOIN t_title_category as b on a.tCat = b.tName WHERE a.tName LIKE CONCAT('%', ?,'%') or a.tDesc LIKE CONCAT('%', ?,'%')");
			$stmt->bindParam(1, $key, PDO::PARAM_STR);
			$stmt->bindParam(2, $key, PDO::PARAM_STR);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			echo '<div Class="categoryIndex">Titles (' . $cantResultados . ')</div>
			<div id="achievementList">';
			$stmt = $db->prepare("SELECT
			a.tID,
			a.tName,
			a.tCat,
			c.tID,
			b.*,
			a.tURL
			FROM
			t_title AS a
			INNER JOIN c_title AS b ON a.tID = b.tID
			INNER JOIN t_title_category AS c ON a.tCat = c.tName WHERE a.tName LIKE CONCAT('%', ?,'%') or a.tDesc LIKE CONCAT('%', ?,'%') LIMIT 5");
			$stmt->bindParam(1, $key, PDO::PARAM_INT);
			$stmt->bindParam(1, $key, PDO::PARAM_STR);
			$stmt->bindParam(2, $key, PDO::PARAM_STR);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=3&id=" . $row['tID'] . "&in=" . $row['tURL'];
					} else {
						$achievementLink = $this->apiURL . "titles/" . $row['tID'] . "/" . $row['tURL'];
					}
					$stat = "-";
					if($row['HP'] > 0) {
						$stat = "+ " . $row['HP'] . " HP";
					}
					if($row['SP'] > 0) {
						$stat = "+ " . $row['SP'] . " SP";
					}
					if($row['ATK'] > 0) {
						$stat = "+ " . $row['ATK'] . " ATK";
					}
					if($row['PEN'] > 0) {
						$stat = "+ " . $row['PEN'] . " PEN";
					}
					if($row['DEF'] > 0) {
						$stat = "+ " . $row['DEF'] . " DEF";
					}
					if($row['CRIT'] > 0) {
						$stat = "+ " . $row['CRIT'] . " CRIT";
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="arrowKey"></span><div class="achievementName"><span class="iGrade-' . $row['tGrade'] . '">' . $row['tName'] . '</span></div><div class="achievementCat"><b>' . $row['tCat'] . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
				}
				if($cantResultados > 5) {
					echo '<a class="sShowAll" href="#">Show all Results in Titles</a>';
				}
			} else {
				echo '<div id="errorSet">Nothing Found on Titles Database<br/>Please Try Again Later.</div>';
			}
		}
		if($cat == 7) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT * FROM t_biology where mName LIKE CONCAT('%', ?,'%')");
			$stmt->bindParam(1, $key, PDO::PARAM_STR);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			echo '<div Class="categoryIndex">Biology (' . $cantResultados . ')</div>
			<div id="achievementList">';
			$stmt = $db->prepare("SELECT * FROM t_biology where mName LIKE CONCAT('%', ?,'%') order by mID ASC LIMIT 5");
			$stmt->bindParam(1, $key, PDO::PARAM_STR);
			$stmt->execute();
			$cant = $stmt->rowCount();
			if($cant != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=6&id=" . $row['mID'] . "&in=" . $row['mURL'];
					} else {
						$achievementLink = $this->apiURL . "biology/" . $row['mID'] . "/" . $row['mURL'];
					}
					$mobName = $row['mName'];
					$stat = "-";
					if($row['mPart'] != "") {
						$stat = $row['mPart'];
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="bagKey"></span><div class="achievementName"><b>' . $mobName . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
				}
				if($cantResultados > 5) {
					echo '<a class="sShowAll" href="#">Show all Results in Biology</a>';
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
		}
		if($cat == 9) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT a.qID, a.qName, a.qChapter, a.qDesc, a.qURL from t_mission as a
				
														WHERE a.qName LIKE CONCAT('%', ?,'%') OR a.qDesc LIKE CONCAT('%', ?,'%')");
			$stmt->bindParam(1, $key, PDO::PARAM_STR);
			$stmt->bindParam(2, $key, PDO::PARAM_STR);
			$stmt->execute();
			$cantResultados = $stmt->rowCount();
			$stmt = $db->prepare("SELECT a.qID, a.qName, a.qChapter, a.qDesc, a.qURL from t_mission as a                                                        
														WHERE a.qName LIKE CONCAT('%', ?,'%') OR a.qDesc LIKE CONCAT('%', ?,'%') LIMIT 5");
			$stmt->bindParam(1, $key, PDO::PARAM_STR);
			$stmt->bindParam(2, $key, PDO::PARAM_STR);
			$stmt->execute();
			echo '<div Class="categoryIndex">Quests (' . $cantResultados . ')</div>
			<div id="achievementList">';
			if($cantResultados != 0) {
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					if($this->apiMode == "Debug") {
						$achievementLink = $this->apiURL . "index.php?act=3&cat=5&id=" . $row['qID'] . "&in=" . $row['qURL'];
					} else {
						$achievementLink = $this->apiURL . "quests/" . $row['qID'] . "/" . $row['qURL'];
					}
					$questName = $row['qName'];
					$stat = "-";
					$questLevel = 0;
					if(preg_match('#^Lv#', $questName) === 1) {
						$mapSubName = substr($questName, 5);
						$questLevel = substr($questName, 2);
						$stat = "Lvl. " . substr($questLevel, 0, strpos($questLevel, "."));
						$questName = $mapSubName;
					}
					echo '<a class="achievementItem" href="' . $achievementLink . '"><span class="bagKey"></span><div class="achievementName"><span class="iGrade-0">' . $questName . '</span></div><div class="achievementCat"><b>' . $row['qChapter'] . '</b></div><div class="achievementAP title" title="Achievement Points">' . $stat . '</div><div class="clear"></div></a>';
				}
				if($cantResultados > 5) {
					echo '<a class="sShowAll" href="#">Show all Results in Quests</a>';
				}
			} else {
				echo '<div id="errorSet">Error! Category Not Found<br/>Please Try Again Later.</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
			}
		}
	}
	// Inicio Blog Posts
	private function showPost($id)
	{
		if($id > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT * FROM dmhf_posts where pIndex = ? or pLink = ? order by pDate DESC LIMIT 1");
			$stmt->bindParam(1, $id, PDO::PARAM_STR);
			$stmt->bindParam(2, $_GET['pbl'], PDO::PARAM_STR);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo '<div id="showPage">';
				echo '<div id="showPageTitle">
				<h1 style="font-size: 18px;">
				<img alt="Dragomon Hunter\'s News" src="' . $this->apiURL . 'resources/' . $row['pIcon'] . '" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
					' . $row['pTitle'] . '
				</h1>
				</div>';
				echo '<div id="ShowPostInfo"><div id="ShowPostBy">Posted By: <span style="font-size:11px;" class="yellow">' . $row['pUser'] . '</span></div>
				<div id="ShowPostDate">Posted On: <span style="font-size:11px;" class="yellow">' . $row['pDate'] . '</span></div></div><div class="clear"></div>';
				echo '<div id="showPostIMG"><img alt="' . $row['pTitle'] . '" title="' . $row['pTitle'] . '" src="' . $row['pImage'] . '"></img></div>';
				echo '<div id="showPageDesc">
						<div class="adsInPostBlock">';
						if(!($this->isAPP)){
							echo $this->adsBlogBox;
						}
						echo '</div>
						<div id="randPost"><h3>Related Posts:</h3>
							<table>';
							$stmt2 = $db->prepare("SELECT * FROM dmhf_posts order by rand() LIMIT 3");
							$stmt2->execute();						
							while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
									if($this->apiMode == "Debug") {
										$pLink = $this->apiURL . '?act=100&pid=' . $row2['pIndex'] . '&pbl=' . $row2['pLink'];
									} else {
										$pLink = 'post/' . $row2['pIndex'] . '/' . $row2['pLink'];
									}
								echo '<tr><td><a href="'.$pLink.'" title="'.$row2['pTitle'].'">&#215; '.$row2['pTitle'].'</a></td></tr>';
							}
							echo '</table>
						</div>
						<div id="postDesc">' . $row['pDesc'] . '</div>
						<div class="clear"></div>
						</div>';
				$this->socialShare(0, $row['pTitle']);
				echo "</div>";
			}
		} else {
			// Muestra todos
			$db = $this->connect();
			$stmt = $db->prepare("SELECT * FROM dmhf_posts order by pDate DESC LIMIT 3");
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo '<div id="showPage">';
				echo '<div id="showPageTitle">
				<h1 style="font-size: 18px;"><img alt="Dragomon Hunter Databases News" src="' . $this->apiURL . 'resources/' . $row['pIcon'] . '" 
				onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
				' . $row['pTitle'] . '
				</h1></div>';
				if($this->apiMode == "Debug") {
					$pLink = $this->apiURL . '?act=100&pid=' . $row['pIndex'] . '&pbl=' . $row['pLink'];
				} else {
					$pLink = 'post/' . $row['pIndex'] . '/' . $row['pLink'];
				}
				echo '<div id="ShowPostInfo"><div id="ShowPostBy">Posted By: <span style="font-size:11px;" class="yellow">' . $row['pUser'] . '</span></div>
				<div id="ShowPostDate">Posted On: <span style="font-size:11px;" class="yellow">' . $row['pDate'] . '</span></div></div><div class="clear"></div>';
				echo '<div id="showPageDesc">' . substr($row['pDesc'], 0, 180) . '...
				<div class="clear"></div>
				<a href="' . $pLink . '" id="readMorePost"><div id="readIcon"></div> Read More</a>
				<div class="clear"></div>';
				echo "</div>";
			}
			echo "</div>";
		}
	}
	// Muestra el Item/Mob/Quest ETC
	
	function showPage($cat, $id, $name)
	{
		$db = $this->connect();
		// if categoria = 1 //Items
		if($cat == 1) {
			$stmt = $db->prepare("SELECT
									i.ItemID,
									i.ItemName,
									i.ItemDesc,
									i.ItemURL,
									iv.iViews as ItemView,
									ic.ItemIndex,
									ic.ItemLevel,
									ic.ItemEffectID,
									ic.ItemType,
									ic.ItemGrade,
									ic.ItemCost,
									ic.HP,
									ic.SP,
									ic.ATK,
									ic.PEN,
									ic.DEF,
									ic.CRIT,
									ic.CRITDMG,
									ic.HPREGEN,
									ic.ATKSPD,
									ic.ItemDurability,
									ic.ItemHunterLevel,
									c.catIndex,
									c.catName,
									ig.*
								FROM
									t_items AS i
								INNER JOIN c_items AS ic ON ic.ItemID = i.ItemID
								INNER JOIN t_items_category AS c ON ic.ItemType = c.catID
								INNER JOIN t_items_grade AS ig ON IFNULL(ic.ItemGrade, 1) = ig.igID
								INNER JOIN t_items_views AS iv ON iv.iID = i.ItemID
								WHERE
									i.ItemID = ? LIMIT 1");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $name, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			echo '<div id="showPage">';
			if($row) {
				// Stats
				$HP = $row['HP'];
				$SP = $row['SP'];
				$ATK = $row['ATK'];
				$PEN = $row['PEN'];
				$DEF = $row['DEF'];
				$CRIT = $row['CRIT'];
				$CRITDMG = $row['CRITDMG'];
				$HPREGEN = $row['HPREGEN'];
				$ATKSPD = $row['ATKSPD'];
				$iLevel = $row['ItemLevel'];
				if($iLevel == "") {
					$iLevel = "-";
				}
				$iDurability = $row['ItemDurability'];
				if($iDurability != ""){
					$iDurability = "Durability: ".$iDurability."/".$iDurability."<br/>";
				}
				$iHunterLevel = $row['ItemHunterLevel'];
				if($iHunterLevel != ""){
					$iHunterLevel = "Hunter Level Requirement: ".$iHunterLevel."<br/>";
				}
				$iCost = (int) $row['ItemCost'];
				if($iCost > 999 && $iCost < 999999) {
					$resto = ($iCost % 1000);
					$entero = intval($iCost / 1000);
					$iCost = $entero . '<img class="title" title="Gold" src="' . $this->apiURL . 'resources/images/ui/g.png"></img>' . $resto . '<img class="title" title="Silver" src="' . $this->apiURL . 'resources/images/ui/s.png"></img>';
				} else if($iCost > 0 && $iCost < 999) {
					$iCost = $iCost . '<img class="title" title="Silver" src="' . $this->apiURL . 'resources/images/ui/s.png"></img>';
				} else {
					$iCost = "-";
				}
				if($this->apiMode == "Debug") {
					$catLink = $this->apiURL . "index.php?act=4&type=" . $row['ItemType'];
				} else {
					$catLink = $this->apiURL . "items/type/" . $row['ItemType'];
				}
				echo '<div id="showPageTitle"><h1 class="iGrade-' . (int) $row['ItemGrade'] . '"><img src="' . $this->apiURL . 'resources/images/itemsicon/' . $row['ItemIndex'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>' . $row['ItemName'] . '</h1></div>';
				if($row['ItemLevel'] > 0) {
					echo '<div id="ShowItemLevel">Level ' . $row['ItemLevel'] . '</div>';
				}

				$total = $HP + $SP + $ATK + $PEN + $DEF + $CRIT + $CRITDMG + $HPREGEN + $ATKSPD;
				//Item Extra Info
				echo '<div id="itemExtra">'.$iDurability.$iHunterLevel;
				if($total > 0){
					echo 'Status:  <select id="statusJQ">
									<option value="100" selected>100%</option>';
						for($s = 101; $s <= 135; $s++){
							echo '<option value="'.$s.'">'.$s.'%</option>';
						}				
					echo '</select>'; 
					}
				echo '</div>';

				if($total > 0) {
					// Mostrar Panel de Stats
					echo '<div id="showPageStats">
					<table>
						<tr><td colspan="2" class="firstRowStats">Base Stats:</td></tr>';
					if($HP > 0) {
						echo '<tr title="Increases the Health Points"><td style="width:50%;" class="tcenter" >HP</td><td class="tcenter yellow">+<span id="iHP">' . $HP . '</span></td></tr>';
					}
					if($SP > 0) {
						echo '<tr title="Increases the Special Points"><td style="width:50%;" class="tcenter">SP</td><td class="tcenter yellow">+<span id="iSP">' . $SP . '</span></td></tr>';
					}
					if($ATK > 0) {
						echo '<tr title="Increases Damage"><td style="width:50%;" class="tcenter">Attack: </td><td class="tcenter yellow">+<span id="iATK">' . $ATK . '</span></td></tr>';
					}
					if($PEN > 0) {
						echo '<tr title="Increases Hit Chance"><td style="width:50%;" class="tcenter">Penetration: </td><td class="tcenter yellow">+<span id="iPEN">' . $PEN . '</span></td></tr>';
					}
					if($DEF > 0) {
						echo '<tr title="Increases Chance to Deflect Damage"><td style="width:50%;" class="tcenter">Defense: </td><td class="tcenter yellow">+<span id="iDEF">' . $DEF . '</span></td></tr>';
					}
					if($CRIT > 0) {
						echo '<tr title="Increases Chance of Critical Hit"><td style="width:50%;" class="tcenter">Critical: </td><td class="tcenter yellow">+<span id="iCRIT">' . $CRIT . '</span></td></tr>';
					}
					if($CRITDMG > 0) {
						echo '<tr title="Increases Chance of Bonus Damage"><td style="width:50%;" class="tcenter">Critical Damage: </td><td class="tcenter yellow">+<span id="iCRITDMG">' . $CRITDMG . '</span></td></tr>';
					}
					if($HPREGEN > 0) {
						echo '<tr title="Increases The Regeneration Time of Health Points"><td style="width:50%;" class="tcenter">HP Regeneration: </td><td class="tcenter yellow">+' . $HPREGEN . '</td></tr>';
					}
					if($ATKSPD > 0) {
						echo '<tr title="Increases the Attack Speed"><td style="width:50%;" class="tcenter">Attack Speed:</td><td class="tcenter yellow">+' . $ATKSPD . '</td></tr>';
					}
					echo '</table>
				</div>';
				}

				$iViews = $row['ItemView'] + 1;

				echo '<div id="showPageDesc">' . $this->filterDesc($row['ItemDesc']) . '</div>
			<div id="showTableItems">
				<table>
					<tr title="The Identification Number in Database">
						<td>
							<img src="https://cdn3.iconfinder.com/data/icons/fugue/icon/sort-number.png"></img>ID:
						</td>
						<td>
							' . $row['ItemID'] . '
						</td>    
					</tr>
					<tr title="The Index Name of Item">
						<td>
							<img src="https://cdn2.iconfinder.com/data/icons/crystalproject/Open-Office-Icons/stock_navigator-insert-index-16.png"></img>Index:
						</td>
						<td>
							' . $row['ItemIndex'] . '
						</td>    
					</tr>
					<tr title="The Name Label of the Item">
						<td>
							<img src="https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/Yellow_tag.png"></img>Name:
						</td>
						<td>
							<strong>' . $row['ItemName'] . '</strong>
						</td>    
					</tr>
					<tr title="The Item Rarity">
						<td>
							<img src="https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678064-star-16.png"></img>Grade:
						</td>
						<td>
							<a href="#" class="iGrade-' . (int) $row['ItemGrade'] . '">' . $row['igName'] . '</a>
						</td>    
					</tr>
					<tr title="Category Name">
						<td>
							<img src="https://cdn2.iconfinder.com/data/icons/crystalproject/Open-Office-Icons/stock_3d-all-attributes-16.png"></img>Type:
						</td>
						<td>
							<a class="white" href="' . $catLink . '">' . $row['catName'] . '</a>
						</td>    
					</tr>
					<tr title="Category Group">
						<td>
							<img src="https://cdn2.iconfinder.com/data/icons/fatcow/16x16/category_item.png"></img>Group:
						</td>
						<td>
							' . $row['catIndex'] . '
						</td>    
					</tr>
					<tr title="Level Required">
						<td>
							<img src="https://cdn2.iconfinder.com/data/icons/aspneticons_v1.0_Nov2006/level_up_16x16.gif"></img>Level:
						</td>
						<td>
							<strong>' . $iLevel . '</strong>
						</td>    
					</tr>
					<tr title="Price on NPC">
						<td>
							<img src="https://cdn3.iconfinder.com/data/icons/fatcow/16/coins.png"></img>Price:
						</td>
						<td>
							' . $iCost . '
						</td>    
					</tr>
					<tr title="Total Views">
						<td>
							<img src="https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/View.png"></img>Views:
						</td>
						<td>
							' . $iViews . '
						</td>    
					</tr>
				</table>
			</div>
			';
			}
			if(!($this->isAPP)){
				echo $this->adsInPost;
			}
			if($row['ItemEffectID'] > 0) {
				$stmtEffect = $db->prepare("SELECT * FROM t_items_effect where EffectID = ?");
				$stmtEffect->bindParam(1, $row['ItemEffectID'], PDO::PARAM_INT);
				$stmtEffect->execute();
				$rowEffect = $stmtEffect->fetch(PDO::FETCH_ASSOC);
				if($rowEffect) {
					$EffectName = $rowEffect['EffectName'];
					$EffectDesc = $rowEffect['EffectDesc'];
					if($EffectName == "" || $EffectName == 'Placeholder') {
						$EffectName = 'Effect Name Not Set';
					}
					if($EffectDesc == "-") {
						$EffectDesc = 'No Description Available';
					}
					echo '<div id="showPageDesc">
					<b>Item Effect:</b> 
				<div class="effectName">
					' . $EffectName . '
				</div>
				<div class="effectDesc">
					' . $EffectDesc . '
				</div></div>';
				}
			}
			$this->showCraftTable($row['ItemID'], 0);
			// Add View
			$stmtView = $db->prepare("UPDATE t_items_views SET iViews = iViews + 1 WHERE iID = ?");
			$stmtView->bindParam(1, $row['ItemID'], PDO::PARAM_INT);
			$stmtView->execute();
			$this->socialShare($row['ItemGrade'], $row['ItemName']);
			echo '</div>';
		}
		if($cat == 2) {
			// Poner aca la vista de Achievements
			$stmt = $db->prepare("SELECT
										a.*, c.cID,
										b.aAP,
										IF(b.aTitle = \"-\", 0, b.aTitle) as aTitle,
										d.*
									FROM
										t_achievement AS a
									INNER JOIN c_achievement AS b ON a.aID = b.aID
									INNER JOIN t_achievement_category AS c ON a.aCat = c.cName
									INNER JOIN t_title AS d ON b.aTitle = d.tID
									WHERE
										a.aID = ? or a.aURL = ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $name, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row) {
				$cant = 0;
				if($row['aAP'] > 0) {
					$ap = '<div id="AchievementAP"><b>+' . $row['aAP'] . '</b><br/>Achievement Points</div>';
					$cant++;
				} else {
					$ap = "";
				}
				if($row['aTitle'] > 0) {
					if($this->apiMode == "Debug") {
						$titleLink = $this->apiURL . 'index.php?act=3&cat=3&id=' . $row['tID'] . '&in=' . $row['tURL'];
					} else {
						$titleLink = $this->apiURL . 'titles/' . $row['tID'] . '/' . $row['tURL'];
					}
					$at = '<a href="' . $titleLink . '" class="title yellow" id="AchievementTitle"><img src="' . $this->apiURL . 'resources/images/ui/titles.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img><br/>' . $row['tName'] . '</a>';
					$cant++;
				} else {
					$at = "";
				}
				if($cant == 1) {
					$cssFix = "width: 48%;margin: 0px auto;";
				} else {
					$cssFix = "";
				}
				echo '<div id="showPage">';
				echo '<div id="showPageTitle"><h1><img alt="Achievements Database" src="' . $this->apiURL . 'resources/images/ui/achievements.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>' . $row['aName'] . '</h1></div>';
				echo '<div id="ShowItemLevel">' . $row['aCat'] . '</div>';
				echo '<div id="showPageDesc">' . $row['aDesc'] . '</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
				if($cant > 0) {
					echo '<div id="showAchievementReward"><h2><div class="crownKey"></div>Rewards:</h2>
				<div style="' . $cssFix . '">
				' . $ap . '
				' . $at;
					echo '<div class="clear"></div></div></div>';
				}
				$this->socialShare(0, "Achievement: " . $row['aName']);
				echo "</div>";
			} else {
				// do same as above but without chinese db
				$stmt = $db->prepare("SELECT a.*
															FROM
																t_achievement AS a
														WHERE
															a.aID = ? or a.aURL = ?");
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->bindParam(2, $name, PDO::PARAM_STR);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if($row) {
					echo '<div id="showPage">';
					echo '<div id="showPageTitle"><h1><img alt="Achievements Database" src="' . $this->apiURL . 'resources/images/ui/achievements.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>' . $row['aName'] . '</h1></div>';
					echo '<div id="ShowItemLevel">' . $row['aCat'] . '</div>';
					echo '<div id="showPageDesc">' . $row['aDesc'] . '</div>
					<div class="warningAchievement">
						Warning! Rewards were\'nt found on Chinese database or we are updating them. Please try again later!
					</div>';
					if(!($this->isAPP)){
						echo $this->adsInPost;
					}
					echo '<div class="clear">
						
				</div>';
					$this->socialShare(0, "Achievement: " . $row['aName']);
					echo "</div>";
				}
			}
		}
		if($cat == 3) {
			$stmt = $db->prepare("SELECT
				a.tID,
				a.tName,
				a.tCat,
				a.tDesc,
				a.tObj,
				c.tID as catID,
				b.*,
				a.tURL
				FROM
				t_title AS a
				INNER JOIN c_title AS b ON a.tID = b.tID
				INNER JOIN t_title_category AS c ON a.tCat = c.tName WHERE
			a.tID = ? or a.tURL = ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $name, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row) {
				$cant = 0;
				// Stats
				$HP = $row['HP'];
				$SP = $row['SP'];
				$ATK = $row['ATK'];
				$PEN = $row['PEN'];
				$DEF = $row['DEF'];
				$CRIT = $row['CRIT'];
				$ActLevel = $row['tStatActivateLevel'];
				$total = $HP + $SP + $ATK + $PEN + $DEF + $CRIT + $ActLevel;
				echo '<div id="showPage">';
				echo '<div id="showPageTitle"><h1 class="iGrade-' . $row['tGrade'] . '"><img alt="Titles Database" src="' . $this->apiURL . 'resources/images/ui/titles.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>' . $row['tName'] . '</h1></div>';
				if($total > 0) {
					// Mostrar Panel de Stats
					echo '<div id="showPageStats">
					<table>
					<tr><td colspan="2" class="firstRowStats">Information:</td></tr>';
					if($HP > 0) {
						echo '<tr><td style="width:50%;" class="tcenter">HP</td><td class="tcenter yellow">+' . number_format($HP, 0) . '</td></tr>';
					}
					if($SP > 0) {
						echo '<tr><td style="width:50%;" class="tcenter">SP</td><td class="tcenter yellow">+' . number_format($SP, 0) . '</td></tr>';
					}
					if($ATK > 0) {
						echo '<tr><td style="width:50%;" class="tcenter">Attack: </td><td class="tcenter yellow">+' . number_format($ATK, 0) . '</td></tr>';
					}
					if($PEN > 0) {
						echo '<tr><td style="width:50%;" class="tcenter">Penetration: </td><td class="tcenter yellow">+' . number_format($PEN, 0) . '</td></tr>';
					}
					if($DEF > 0) {
						echo '<tr><td style="width:50%;" class="tcenter">Defense: </td><td class="tcenter yellow">+' . number_format($DEF, 0) . '</td></tr>';
					}
					if($CRIT > 0) {
						echo '<tr><td style="width:50%;" class="tcenter">Critical: </td><td class="tcenter yellow">+' . number_format($CRIT, 0) . '</td></tr>';
					}
					if($ActLevel > 0) {
						echo '<tr><td style="width:50%;" class="tcenter">Activation Level: </td><td class="tcenter yellow">Lvl. ' . number_format($ActLevel, 0) . '</td></tr>';
					}
					echo '</table>
					</div>';
				}
				echo '<div id="ShowItemLevel">' . $row['tCat'] . '</div>';
				echo '<div id="showPageDesc">' . $this->filterDesc($row['tDesc']) . '</div>';
				echo '<div id="showTitlesObjetives"><h3>Objetives:</h3> ' . $row['tObj'] . '</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}

				if($row['tRewardID'] > 0) {
					if($row['tRewardID'] == 5) {
						echo '<div id="showTitlesObjetives"><h3>Points Needed:</h3><ul><li> ' . $row['tRewardPoints'] . ' Falcon Influence Points.</li></ul></div>';
					}
				}
				$this->socialShare(0, "Title: " . $row['tName']);
				echo '</div>';
			} else {
				// buscar en la DB inglesa solamente
				$stmt = $db->prepare("SELECT
				a.tID,
				a.tName,
				a.tCat,
				a.tDesc,
				a.tObj,
				c.tID as catID,
				a.tURL
				FROM
				t_title AS a
				INNER JOIN t_title_category AS c ON a.tCat = c.tName WHERE
			a.tID = ? or a.tURL = ?");
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->bindParam(2, $name, PDO::PARAM_STR);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if($row) {
					$cant = 0;
					// Stats
					$total = 0;
					echo '<div id="showPage">';
					echo '<div id="showPageTitle"><h1 class="iGrade-0"><img alt="Titles Database" src="' . $this->apiURL . 'resources/images/ui/titles.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>' . $row['tName'] . '</h1></div>';
					echo '<div id="ShowItemLevel">' . $row['tCat'] . '</div>';
					echo '<div id="showPageDesc">' . $this->filterDesc($row['tDesc']) . '</div>';
					echo '<div id="showTitlesObjetives"><h3>Objetives:</h3> ' . $row['tObj'] . '</div>';
					if(!($this->isAPP)){
						echo $this->adsInPost;
					}
					echo '<div class="warningAchievement">Warning! Rewards were\'nt found on Chinese database or we are updating them. Please try again later!</div>';
					$this->socialShare(0, "Title: " . $row['tName']);
					echo '</div>';
				}
			}
		}
		// ShowMapasPage
		if($cat == 4) {
			$stmt = $db->prepare("SELECT a.*, b.* FROM t_node as a INNER JOIN c_node as b on a.tID = b.cID where a.tID = ? OR a.tName = ? LIMIT 1");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $name, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$mapDescription = $row['tDesc'];
			if(strlen($mapDescription) == 0) {
				$mapDescription = "No description set";
			}
			if($row) {
				$cantZones = 0;
				for($i = 1; $i <= 7; $i++) {
					if(strlen($row['zone0' . $i]) > 0) {
						$cantZones++;
					}
				}
				$Level = $row['minLevel'];
				$minLevel = $Level - $row['rateLevel'];
				$maxLevel = $Level + $row['rateLevel'];
				if($row['cMapLoading'] != "") {
					$backImg = '<img class="mapLoading" src="' . $this->apiCDN . 'resources/images/loadingframe/' . $row['cMapLoading'] . '.jpg" onError="this.onerror=null;this.src=\'' . $this->apiCDN . 'resources/images/loadingframe/loading_0.jpg\';" ></img>';
				} else {
					$backImg = '<img class="mapLoading" src="' . $this->apiCDN . 'resources/images/loadingframe/loading_0.jpg"></img>';
				}
				echo '<div id="showPage">
				<div id="mapName"><h1>' . $row['tName'] . '</h1></div>
				' . $backImg . '
				<div id="loadingframe"></div>';
				if($Level > 0) {
					echo '<div id="showRateLevel">Recommended Level: <span class="yellow">' . $Level . '</span> | Lowest Level: <span class="yellow">' . $minLevel . '</span> |     Highest Level: <span class="yellow">' . $maxLevel . '</span></div>';
				}
				echo '<div id="showPageDesc">' . $mapDescription . '</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
				if($row['cMapPreview'] != "") {
					$mapPreview = '<div id="mapPreview"><h2><div class="previewIcon"></div>Map Preview:</h2><center>
					<img src="' . $this->apiCDN . 'resources/images/map/' . $row['cMapPreview'] . '.jpg" onerror="imgError(this);"></img></center></div>';
				} else {
					$mapPreview = "";
				}
				echo $mapPreview;
				if($cantZones > 0) {
					echo '<div id="showMapsLocation"><h2><div class="locationZone"></div>Map Zones</h2>';
					$ZXY = 26; //unk26
					for($i = 1; $i <= $cantZones; $i++) {
						if(strlen($row['zone0' . $i]) > 0) {
							$pos = $row['unk' . $ZXY];
							$pos = explode(';', $pos);
							echo '<h3><div class="locationKey" style="margin-top: 5px;margin-left: 15px;margin-right: 10px;"></div>' . $row['zone0' . $i] . '<div id="posxy">X: ' . $pos[0] . ' Y: ' . $pos[1] . '</div></h3> ';
						}
						$ZXY = $ZXY + 2;
					}
					echo '</div>';
				}
				if($row['cMapMini'] != "") {
					$mapPreview = '<div id="mapMini"><h2><div class="miniMapIcon"></div>MiniMap:</h2><center>
					<img src="' . $this->apiCDN . 'resources/images/map/' . $row['cMapMini'] . '.png" onerror="imgError(this);"></img></center></div>';
				} else {
					$mapPreview = "";
				}
				echo $mapPreview;
				$this->socialShare(0, $row['tName']);
				echo '</div>';
			}
		}
		if($cat == 5) {
			$stmt = $db->prepare("SELECT * FROM t_mission where qID = ? or qURL = ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $name, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row) {
				echo '<div id="showPage">';
				echo '<div id="showPageTitle"><h1 class="iGrade-0">
			<img alt="Quests Database" src="' . $this->apiURL . 'resources/images/ui/quests.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
			' . $row['qName'] . '</h1></div>';
				echo '<div id="ShowItemLevel">' . $row['qChapter'] . '</div>';
				echo '<div id="showPageDesc">' . $this->filterDesc($row['qDesc']) . '</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
				$this->socialShare(0, "Quest: " . $row['qName']);
				echo '</div>';
			} else {
				// buscar en la DB inglesa solamente
				$stmt = $db->prepare("SELECT * FROM t_mission where qID = ? or qURL = ?");
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->bindParam(2, $name, PDO::PARAM_STR);
				$stmt->execute();
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if($row) {
					$cant = 0;
					// Stats
					$total = 0;
				}
			}
		}
		if($cat == 6) {
			$stmt = $db->prepare("SELECT * FROM t_biology where mID = ? or mURL = ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->bindParam(2, $name, PDO::PARAM_STR);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row) {
				if($row['mPart'] == "") {
					$part = '-';
				} else {
					$part = $row['mPart'];
				}
				echo '<div id="showPage">';
				echo '<div id="showPageTitle"><h1 class="iGrade-0">
			<img alt="Biology Database" src="' . $this->apiURL . 'resources/images/ui/quests.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
			' . $row['mName'] . '</h1></div>';
				echo '<div id="ShowItemLevel">' . $part . '</div>';
				// echo '<div id="showPageDesc">'.$this->filterDesc($row['mDesc']).'</div>';
				if(!($this->isAPP)){
					echo $this->adsInPost;
				}
				$this->socialShare(0, "Biology: " . $row['mName']);
				echo '</div>';
			} else {
				echo "error in db";
			}
		} else {
		}
	}
	public function showCraftTable($itemID, $page)
	{
		$db = $this->connect();
		$stmtCraft = $db->prepare("SELECT DISTINCT a.CraftID, a.CraftGrade, b.cName, a.ItemPrimary, a.ItemOut, a.ItemOutCant,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemOut) AS ItemOutIndex,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemOut) AS ItemOutGrade,
(SELECT ItemName FROM t_items where ItemID = a.ItemOut) AS ItemOutName,
(SELECT ItemURL FROM t_items where ItemID = a.ItemOut) AS ItemOutUrl,
a.ItemNeed01,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed01) AS ItemNeed01Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed01) AS ItemNeed01Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed01) AS ItemNeed01Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed01) AS ItemNeed01Url,
a.ItemCant01, a.ItemNeed02,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed02) AS ItemNeed02Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed02) AS ItemNeed02Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed02) AS ItemNeed02Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed02) AS ItemNeed02Url,
a.ItemCant02, a.ItemNeed03,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed03) AS ItemNeed03Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed03) AS ItemNeed03Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed03) AS ItemNeed03Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed03) AS ItemNeed03Url,
a.ItemCant03, a.ItemNeed04,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed04) AS ItemNeed04Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed04) AS ItemNeed04Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed04) AS ItemNeed04Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed04) AS ItemNeed04Url,
a.ItemCant04
FROM c_combine as a
INNER JOIN t_combine as b on a.CraftID = b.cID
	
WHERE a.ItemOut = ? OR a.ItemNeed01 = ? OR a.ItemNeed02 = ? OR a.ItemNeed03 = ? OR a.ItemNeed04 = ?
ORDER BY a.CraftID ASC
");
		$stmtCraft->bindParam(1, $itemID, PDO::PARAM_INT);
		$stmtCraft->bindParam(2, $itemID, PDO::PARAM_INT);
		$stmtCraft->bindParam(3, $itemID, PDO::PARAM_INT);
		$stmtCraft->bindParam(4, $itemID, PDO::PARAM_INT);
		$stmtCraft->bindParam(5, $itemID, PDO::PARAM_INT);
		$stmtCraft->execute();
		$cantResultados = $stmtCraft->rowCount();
		if($itemID > 0) {
			if($page == 0) {
				$stmtCraft = $db->prepare("SELECT DISTINCT a.CraftID, a.CraftGrade, b.cName, a.ItemPrimary, a.ItemOut, a.ItemOutCant,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemOut) AS ItemOutIndex,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemOut) AS ItemOutGrade,
(SELECT ItemName FROM t_items where ItemID = a.ItemOut) AS ItemOutName,
(SELECT ItemURL FROM t_items where ItemID = a.ItemOut) AS ItemOutUrl,
a.ItemNeed01,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed01) AS ItemNeed01Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed01) AS ItemNeed01Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed01) AS ItemNeed01Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed01) AS ItemNeed01Url,
a.ItemCant01, a.ItemNeed02,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed02) AS ItemNeed02Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed02) AS ItemNeed02Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed02) AS ItemNeed02Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed02) AS ItemNeed02Url,
a.ItemCant02, a.ItemNeed03,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed03) AS ItemNeed03Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed03) AS ItemNeed03Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed03) AS ItemNeed03Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed03) AS ItemNeed03Url,
a.ItemCant03, a.ItemNeed04,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed04) AS ItemNeed04Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed04) AS ItemNeed04Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed04) AS ItemNeed04Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed04) AS ItemNeed04Url,
a.ItemCant04
FROM c_combine as a
INNER JOIN t_combine as b on a.CraftID = b.cID
	
WHERE a.ItemOut = ? OR a.ItemNeed01 = ? OR a.ItemNeed02 = ? OR a.ItemNeed03 = ? OR a.ItemNeed04 = ?
ORDER BY a.CraftID ASC LIMIT 3
");
				$stmtCraft->bindParam(1, $itemID, PDO::PARAM_INT);
				$stmtCraft->bindParam(2, $itemID, PDO::PARAM_INT);
				$stmtCraft->bindParam(3, $itemID, PDO::PARAM_INT);
				$stmtCraft->bindParam(4, $itemID, PDO::PARAM_INT);
				$stmtCraft->bindParam(5, $itemID, PDO::PARAM_INT);
				$stmtCraft->execute();
				while($rowCraft = $stmtCraft->fetch(PDO::FETCH_ASSOC)) {
					$craftName = $rowCraft['cName'];
					if($craftName == "") {
						$craftName = "-";
					}
					$itemID01 = $rowCraft['ItemNeed01'];
					$itemID02 = $rowCraft['ItemNeed02'];
					$itemID03 = $rowCraft['ItemNeed03'];
					$itemID04 = $rowCraft['ItemNeed04'];
					$itemPrimary = $rowCraft['ItemPrimary'];
					$cantNeeded = 0;
					if($itemID01 > 0) {
						$cantNeeded++;
					}
					if($itemID02 > 0) {
						$cantNeeded++;
					}
					if($itemID03 > 0) {
						$cantNeeded++;
					}
					if($itemID04 > 0) {
						$cantNeeded++;
					}
					$width = 100;
					switch($cantNeeded) {
						case 1:
							$width = 27;
							break;
						case 2:
							$width = 51;
							break;
						case 3:
							$width = 74;
							break;
						case 4:
							$width = 98;
							break;
					}
					if($this->apiMode == "Debug") {
						$itemOutLink = $this->apiURL . "index.php?act=3&cat=1&id=" . $rowCraft['ItemOut'] . "&in=" . $rowCraft['ItemOutUrl'];
					} else {
						$itemOutLink = $this->apiURL . "items/" . $rowCraft['ItemOut'] . "/" . $rowCraft['ItemOutUrl'];
					}
					echo '<div id="craftInfo">
					Crafting Information:<div class="clear"></div>';
					echo '<a href="' . $itemOutLink . '" class="itemOut">
						<img src="' . $this->apiURL . 'resources/images/itemsicon/' . $rowCraft['ItemOutIndex'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
						<span class="iGrade-' . (int) $rowCraft['ItemOutGrade'] . '">' . $rowCraft['ItemOutName'] . '</span>
						<div class="craftGrade-' . $rowCraft['CraftGrade'] . '"></div>
						<div class="craftName">' . $craftName . '</div>
						<div class="clear"></div>
						</a>                    
						<div class="arrow_box width' . $width . '">
						<div class="neededBox">';
					for($i = 1; $i <= $cantNeeded; $i++) {
						if($this->apiMode == "Debug") {
							$itemNeededLink = $this->apiURL . "index.php?act=3&cat=1&id=" . $rowCraft['ItemNeed0' . $i . ''] . "&in=" . $rowCraft['ItemNeed0' . $i . 'Url'];
						} else {
							$itemNeededLink = $this->apiURL . "items/" . $rowCraft['ItemNeed0' . $i . ''] . "/" . $rowCraft['ItemNeed0' . $i . 'Url'];
						}
						echo '<a class="neededItems" href="' . $itemNeededLink . '">';
						if($itemPrimary == $rowCraft['ItemNeed0' . $i . '']) {
							echo '<div class="primaryItem">Primary</div>';
						}
						echo '<img src="' . $this->apiURL . 'resources/images/itemsicon/' . $rowCraft['ItemNeed0' . $i . 'Index'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
									<div class="clear"></div>
									<span class="iGrade-' . (int) $rowCraft['ItemNeed0' . $i . 'Grade'] . '">' . $rowCraft['ItemNeed0' . $i . 'Name'] . '</span>
									<div class="clear"></div>
									<div class="craftAmount">x' . $rowCraft['ItemCant0' . $i . ''] . '</div>
								</a>';
					}
					echo '<div class="clear"></div>
							</div>                            
						</div>                
				</div>';
				}
				$leftResultados = $cantResultados - 3;
				if($cantResultados > 3) {
					echo '<div id="ajaxCraft"><div id="escapingBallG">
	<div id="escapingBall_1" class="escapingBallG"></div>
</div></div>
					<div class="showAllCrafting alizarin-flat-button" id="showCraftfrItem" dmhf_pg=1 dmhf_id="' . $itemID . '">Show All Results For Crafting (+' . $leftResultados . ')</div>';
				} //FIN
			} else {
				$stmtCraft = $db->prepare("SELECT DISTINCT a.CraftID, a.CraftGrade, b.cName, a.ItemPrimary, a.ItemOut, a.ItemOutCant,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemOut) AS ItemOutIndex,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemOut) AS ItemOutGrade,
(SELECT ItemName FROM t_items where ItemID = a.ItemOut) AS ItemOutName,
(SELECT ItemURL FROM t_items where ItemID = a.ItemOut) AS ItemOutUrl,
a.ItemNeed01,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed01) AS ItemNeed01Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed01) AS ItemNeed01Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed01) AS ItemNeed01Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed01) AS ItemNeed01Url,
a.ItemCant01, a.ItemNeed02,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed02) AS ItemNeed02Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed02) AS ItemNeed02Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed02) AS ItemNeed02Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed02) AS ItemNeed02Url,
a.ItemCant02, a.ItemNeed03,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed03) AS ItemNeed03Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed03) AS ItemNeed03Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed03) AS ItemNeed03Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed03) AS ItemNeed03Url,
a.ItemCant03, a.ItemNeed04,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed04) AS ItemNeed04Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed04) AS ItemNeed04Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed04) AS ItemNeed04Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed04) AS ItemNeed04Url,
a.ItemCant04
FROM c_combine as a
INNER JOIN t_combine as b on a.CraftID = b.cID
	
WHERE a.ItemOut = ? OR a.ItemNeed01 = ? OR a.ItemNeed02 = ? OR a.ItemNeed03 = ? OR a.ItemNeed04 = ?
ORDER BY a.CraftID ASC LIMIT 5,1000
");
				$stmtCraft->bindParam(1, $itemID, PDO::PARAM_INT);
				$stmtCraft->bindParam(2, $itemID, PDO::PARAM_INT);
				$stmtCraft->bindParam(3, $itemID, PDO::PARAM_INT);
				$stmtCraft->bindParam(4, $itemID, PDO::PARAM_INT);
				$stmtCraft->bindParam(5, $itemID, PDO::PARAM_INT);
				$stmtCraft->execute();
				while($rowCraft = $stmtCraft->fetch(PDO::FETCH_ASSOC)) {
					$craftName = $rowCraft['cName'];
					if($craftName == "") {
						$craftName = "-";
					}
					$itemID01 = $rowCraft['ItemNeed01'];
					$itemID02 = $rowCraft['ItemNeed02'];
					$itemID03 = $rowCraft['ItemNeed03'];
					$itemID04 = $rowCraft['ItemNeed04'];
					$itemPrimary = $rowCraft['ItemPrimary'];
					$cantNeeded = 0;
					if($itemID01 > 0) {
						$cantNeeded++;
					}
					if($itemID02 > 0) {
						$cantNeeded++;
					}
					if($itemID03 > 0) {
						$cantNeeded++;
					}
					if($itemID04 > 0) {
						$cantNeeded++;
					}
					$width = 100;
					switch($cantNeeded) {
						case 1:
							$width = 27;
							break;
						case 2:
							$width = 51;
							break;
						case 3:
							$width = 74;
							break;
						case 4:
							$width = 98;
							break;
					}
					if($this->apiMode == "Debug") {
						$itemOutLink = $this->apiURL . "index.php?act=3&cat=1&id=" . $rowCraft['ItemOut'] . "&in=" . $rowCraft['ItemOutUrl'];
					} else {
						$itemOutLink = $this->apiURL . "items/" . $rowCraft['ItemOut'] . "/" . $rowCraft['ItemOutUrl'];
					}
					echo '<div id="craftInfo">
					Crafting Information:<div class="clear"></div>';
					echo '<a href="' . $itemOutLink . '" class="itemOut">
						<img src="' . $this->apiURL . 'resources/images/itemsicon/' . $rowCraft['ItemOutIndex'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
						<span class="iGrade-' . (int) $rowCraft['ItemOutGrade'] . '">' . $rowCraft['ItemOutName'] . '</span>
						<div class="craftGrade-' . $rowCraft['CraftGrade'] . '"></div>
						<div class="craftName">' . $craftName . '</div>
						</a>                    
						<div class="arrow_box width' . $width . '">
						<div class="neededBox">';
					for($i = 1; $i <= $cantNeeded; $i++) {
						if($this->apiMode == "Debug") {
							$itemNeededLink = $this->apiURL . "index.php?act=3&cat=1&id=" . $rowCraft['ItemNeed0' . $i . ''] . "&in=" . $rowCraft['ItemNeed0' . $i . 'Url'];
						} else {
							$itemNeededLink = $this->apiURL . "items/" . $rowCraft['ItemNeed0' . $i . ''] . "/" . $rowCraft['ItemNeed0' . $i . 'Url'];
						}
						echo '<a class="neededItems" href="' . $itemNeededLink . '">';
						if($itemPrimary == $rowCraft['ItemNeed0' . $i . '']) {
							echo '<div class="primaryItem">Primary</div>';
						}
						echo '<img src="' . $this->apiURL . 'resources/images/itemsicon/' . $rowCraft['ItemNeed0' . $i . 'Index'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
									<div class="clear"></div>
									<span class="iGrade-' . (int) $rowCraft['ItemNeed0' . $i . 'Grade'] . '">' . $rowCraft['ItemNeed0' . $i . 'Name'] . '</span>
									<div class="clear"></div>
									<div class="craftAmount">x' . $rowCraft['ItemCant0' . $i . ''] . '</div>
								</a>';
					}
					echo '<div class="clear"></div>
							</div>
						</div>
							
				</div>';
				} //FIN
			}
		} else {
			$stmtCraft = $db->prepare("SELECT DISTINCT a.CraftID, a.CraftGrade, b.cName, a.ItemPrimary, a.ItemOut, a.ItemOutCant,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemOut) AS ItemOutIndex,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemOut) AS ItemOutGrade,
(SELECT ItemName FROM t_items where ItemID = a.ItemOut) AS ItemOutName,
(SELECT ItemURL FROM t_items where ItemID = a.ItemOut) AS ItemOutUrl,
a.ItemNeed01,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed01) AS ItemNeed01Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed01) AS ItemNeed01Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed01) AS ItemNeed01Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed01) AS ItemNeed01Url,
a.ItemCant01, a.ItemNeed02,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed02) AS ItemNeed02Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed02) AS ItemNeed02Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed02) AS ItemNeed02Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed02) AS ItemNeed02Url,
a.ItemCant02, a.ItemNeed03,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed03) AS ItemNeed03Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed03) AS ItemNeed03Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed03) AS ItemNeed03Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed03) AS ItemNeed03Url,
a.ItemCant03, a.ItemNeed04,
(SELECT ItemIndex FROM c_items where ItemID = a.ItemNeed04) AS ItemNeed04Index,
(SELECT ItemName FROM t_items where ItemID = a.ItemNeed04) AS ItemNeed04Name,
(SELECT ItemGrade FROM c_items where ItemID = a.ItemNeed04) AS ItemNeed04Grade,
(SELECT ItemURL FROM t_items where ItemID = a.ItemNeed04) AS ItemNeed04Url,
a.ItemCant04
FROM c_combine as a
INNER JOIN t_combine as b on a.CraftID = b.cID
ORDER BY a.CraftID ASC
");
			$stmtCraft->bindParam(1, $itemID, PDO::PARAM_INT);
			$stmtCraft->bindParam(2, $itemID, PDO::PARAM_INT);
			$stmtCraft->bindParam(3, $itemID, PDO::PARAM_INT);
			$stmtCraft->bindParam(4, $itemID, PDO::PARAM_INT);
			$stmtCraft->bindParam(5, $itemID, PDO::PARAM_INT);
			$stmtCraft->execute();
			while($rowCraft = $stmtCraft->fetch(PDO::FETCH_ASSOC)) {
				$craftName = $rowCraft['cName'];
				if($craftName == "") {
					$craftName = "-";
				}
				$itemID01 = $rowCraft['ItemNeed01'];
				$itemID02 = $rowCraft['ItemNeed02'];
				$itemID03 = $rowCraft['ItemNeed03'];
				$itemID04 = $rowCraft['ItemNeed04'];
				$itemPrimary = $rowCraft['ItemPrimary'];
				$cantNeeded = 0;
				if($itemID01 > 0) {
					$cantNeeded++;
				}
				if($itemID02 > 0) {
					$cantNeeded++;
				}
				if($itemID03 > 0) {
					$cantNeeded++;
				}
				if($itemID04 > 0) {
					$cantNeeded++;
				}
				$width = 100;
				switch($cantNeeded) {
					case 1:
						$width = 25;
						break;
					case 2:
						$width = 49;
						break;
					case 3:
						$width = 72;
						break;
					case 4:
						$width = 95;
						break;
				}
				if($this->apiMode == "Debug") {
					$itemOutLink = $this->apiURL . "index.php?act=3&cat=1&id=" . $rowCraft['ItemOut'] . "&in=" . $rowCraft['ItemOutUrl'];
				} else {
					$itemOutLink = $this->apiURL . "items/" . $rowCraft['ItemOut'] . "/" . $rowCraft['ItemOutUrl'];
				}
				echo '<div id="craftInfo">
					Crafting Information:<div class="clear"></div>';
				echo '<a href="' . $itemOutLink . '" class="itemOut">
						<img src="' . $this->apiURL . 'resources/images/itemsicon/' . $rowCraft['ItemOutIndex'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
						<span class="iGrade-' . (int) $rowCraft['ItemOutGrade'] . '">' . $rowCraft['ItemOutName'] . '</span>
						<div class="craftGrade-' . $rowCraft['CraftGrade'] . '"></div>
						<div class="craftName">' . $craftName . '</div>
						</a>                    
						<div class="arrow_box width' . $width . '">
						<div class="neededBox">';
				for($i = 1; $i <= $cantNeeded; $i++) {
					if($this->apiMode == "Debug") {
						$itemNeededLink = $this->apiURL . "index.php?act=3&cat=1&id=" . $rowCraft['ItemNeed0' . $i . ''] . "&in=" . $rowCraft['ItemNeed0' . $i . 'Url'];
					} else {
						$itemNeededLink = $this->apiURL . "items/" . $rowCraft['ItemNeed0' . $i . ''] . "/" . $rowCraft['ItemNeed0' . $i . 'Url'];
					}
					echo '<a class="neededItems" href="' . $itemNeededLink . '">';
					if($itemPrimary == $rowCraft['ItemNeed0' . $i . '']) {
						echo '<div class="primaryItem">Primary</div>';
					}
					echo '<img src="' . $this->apiURL . 'resources/images/itemsicon/' . $rowCraft['ItemNeed0' . $i . 'Index'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>
									<div class="clear"></div>
									<span class="iGrade-' . (int) $rowCraft['ItemNeed0' . $i . 'Grade'] . '">' . $rowCraft['ItemNeed0' . $i . 'Name'] . '</span>
									<div class="clear"></div>
									<div class="craftAmount">x' . $rowCraft['ItemCant0' . $i . ''] . '</div>
								</a>';
				}
				echo '<div class="clear"></div>
							</div>
						</div>
							
				</div>';
			}
		}
	}
	private function socialShare($grade, $name)
	{
		echo '<div id="Sharers">
		<h3>Share <span class="iGrade-' . (int) $grade . '">[' . $name . ']</span></h3>
			
			<div style="margin-right: 10px;margin-left: 10px;" class="fb-share-button" 
				data-href="' . $this->apiCurrentURL . '" 
				data-layout="button">
			</div>
				
			<a href="https://twitter.com/share" class="twitter-share-button"{count} data-count="vertical" data-size="default"></a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>
				
			<a class="gshare" href="https://plus.google.com/share?url={' . $this->apiCurrentURL . '}" onclick="javascript:window.open(this.href,
				\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"><img
				src="https://www.gstatic.com/images/icons/gplus-16.png" alt="Share on Google+"/>Share</a>
			</div>';
	}
	
	/**
		Funcion que Filtra la Descripcion $n$
	**/
	public function filterDesc($string)
	{
		//$this->itemCode7
		$spans = 0;
		preg_match_all("/[$]+[\d+]+[$]/", $string, $filtro);

		// Buscar el Filtro $7$ y que nos tendria que reemplazar con <span id="7"> y sumar 1 a spans
		foreach($filtro[0] as $key => $value) {
			$spans++;
			$value = preg_replace("/[$]/", "", $value);
			$htmlSpan = "<br/><span id='itemcode".$value."'>";

			$string = preg_replace("/[$]+[".$value."]+[$]/", $htmlSpan, $string);
		}

		for($i = 0; $i < $spans; $i++){
			$string .= "</span>";
		}

		if($string == "" || $string == "-") {
			$string = "No description available.";
		}
		//fix $n$ al principio
		if($this->startsWith($string, "<br/>")){
			$string = substr($string, 5);
		}
		return $string;
	}

	public function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}


	public function prettyURL($what)
	{
		$db = $this->connect();
		switch(strtolower($what)) {
			case "items":
				$stmt = $db->prepare("SELECT ItemName FROM t_items order by itemID ASC");
				$stmt->execute();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$string = $this->createPrettyLink($row['ItemName']);
					echo $string . '<br/>';
				}
				break;
			case "achievements":
				$stmt = $db->prepare("SELECT aName FROM t_achievement order by aID ASC");
				$stmt->execute();
				$a = 0;
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$a++;
					$string = $this->createPrettyLink($row['aName']);
					echo $string . '<br/>';
				}
				echo $a;
				break;
			case "titles":
				$stmt = $db->prepare("SELECT tName FROM t_title order by tID ASC");
				$stmt->execute();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$string = $this->createPrettyLink($row['tName']);
					echo $string . '<br/>';
				}
				break;
			case "maps":
				$stmt = $db->prepare("SELECT tName FROM t_node order by tID ASC");
				$stmt->execute();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$string = $this->createPrettyLink($row['tName']);
					echo $string . '<br/>';
				}
				break;
			case "biology":
				$stmt = $db->prepare("SELECT mName FROM t_biology order by mID ASC");
				$stmt->execute();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$name = $this->createPrettyLink($row['mName']);
					$string = $rank . "-" . $name;
					echo rtrim($string, "-") . '<br/>';
				}
				break;
			case "quests":
				$stmt = $db->prepare("SELECT qName FROM t_mission order by qID ASC");
				$stmt->execute();
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$questName = $row['qName'];
					if(preg_match('#^Lv#', $questName) === 1) {
						$qSubName = substr($questName, 5);
						$string = $this->createPrettyLink(trim($qSubName));
					}
					echo $string . '<br/>';
				}
				break;
		}
	}
	private function createPrettyLink($string)
	{
		$result = preg_replace("/[^a-zA-Z0-9 ]+/", "", $string);
		$result2 = preg_replace("/[ ]+/", "-", strtolower($result));
		$result3 = rtrim($result2, '-');
		return $result3;
	}
	public function addDefaultImage($what)
	{
		$db = $this->connect();
		switch(strtolower($what)) {
			case "items":
				$stmt = $db->prepare("UPDATE c_items SET ItemIndex = '0' where ItemIndex = ''");
				$stmt->execute();
				$cantResultados = $stmtS->rowCount();
				echo "Arreglados " . $cantResultados . " Items";
				break;
		}
	}
	public function doSitemap($id)
	{
		$myfile = fopen("../sitemap.xml", "w") or die("Error Creating SiteMap");
		$start = '<?xml version="1.0" encoding="UTF-8"?>
		<urlset xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		';
		$url = "http://www.dragomonhunterfan.com/";
		fwrite($myfile, $start);
		$i = 0;
		$db = $this->connect();
		// Pages
		$main = '
			<url>
				<loc>' . $url . '</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>
				
			<url>
				<loc>' . $url . 'items</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>            
			<url>
				<loc>' . $url . 'achievements</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>
			<url>
				<loc>' . $url . 'maps</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>
			<url>
				<loc>' . $url . 'biology</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>
			<url>
				<loc>' . $url . 'quests</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>
			<url>
				<loc>' . $url . 'donate</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>
			<url>
				<loc>' . $url . 'post</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>
				
			';
		fwrite($myfile, $main);
		// Items
		$stmt = $db->prepare("SELECT * FROM t_items where ItemName NOT LIKE '%placeholder%' order by itemID ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			$main = '
			<url>
				<loc>' . $url . 'items/' . $row['ItemID'] . '/' . $row['ItemURL'] . '</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>
			';
			fwrite($myfile, $main);
		}
		// Achievements
		$stmt = $db->prepare("SELECT * FROM t_achievement where aName NOT LIKE '%placeholder%' order by aID ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			$main = '
			<url>
				<loc>' . $url . 'achievements/' . $row['aID'] . '/' . $row['aURL'] . '</loc>
				<changefreq>weekly</changefreq>
				<priority>0.5</priority>
			</url>
			';
			fwrite($myfile, $main);
		}
		// TITLES
		$stmt = $db->prepare("SELECT * FROM t_title where tName NOT LIKE '%placeholder%' order by tID ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			$main = '
			<url>
			<loc>' . $url . 'titles/' . $row['tID'] . '/' . $row['tURL'] . '</loc>
			<changefreq>weekly</changefreq>
			<priority>0.5</priority>
			</url>
			';
			fwrite($myfile, $main);
		} //FIN TITLES
		// MAPAS
		$stmt = $db->prepare("SELECT * FROM t_node where tName NOT LIKE '%placeholder%' order by tID ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			$main = '
			<url>
			<loc>' . $url . 'maps/' . $row['tID'] . '/' . $row['tURL'] . '</loc>
			<changefreq>weekly</changefreq>
			<priority>0.5</priority>
			</url>
			';
			fwrite($myfile, $main);
		}
		// FIN Mapas
		// Biology
		$stmt = $db->prepare("SELECT * FROM t_biology where mName NOT LIKE '%placeholder%' order by mID ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			$main = '
			<url>
			<loc>' . $url . 'biology/' . $row['mID'] . '/' . $row['mURL'] . '</loc>
			<changefreq>weekly</changefreq>
			<priority>0.5</priority>
			</url>
			';
			fwrite($myfile, $main);
		}
		// FIN Biology
		// Quests
		$stmt = $db->prepare("SELECT * FROM t_mission where qName NOT LIKE '%placeholder%' order by qID ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			$main = '
			<url>
			<loc>' . $url . 'quests/' . $row['qID'] . '/' . $row['qURL'] . '</loc>
			<changefreq>weekly</changefreq>
			<priority>0.5</priority>
			</url>
			';
			fwrite($myfile, $main);
		}
		// FIN Quests
		// Blog Posts
		$stmt = $db->prepare("SELECT * FROM dmhf_posts order by pIndex ASC");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$i++;
			$main = '
			<url>
			<loc>' . $url . 'post/' . $row['pIndex'] . '/' . $row['pLink'] . '</loc>
			<changefreq>weekly</changefreq>
			<priority>0.5</priority>
			</url>
			';
			fwrite($myfile, $main);
		}
		// FIN BlogPosts
		$end = '
		</urlset>';
		fwrite($myfile, $end);
		echo $i . " Links added to Sitemap.xml";
		fclose($myfile);
	}
	private function returnItemName($id)
	{
		$string = "Error";
		$db = $this->connect();
		$stmt = $db->prepare("SELECT a.ItemName, b.ItemIndex, a.ItemDesc FROM t_items as a INNER JOIN c_items as b on a.ItemID = b.ItemID where a.ItemID = ? LIMIT 1");
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$string = $row['ItemName'];
			$this->fbPageDesc = $row['ItemDesc'];
			$this->fbPageImage = $this->apiURL . 'resources/images/itemsicon/' . $row['ItemIndex'] . '.png';
		}
		if($string == "Error") {
			$this->returnError(1);
		}
		return $string;
	}
	public function newSearch($s)
	{
		$db = $this->connect();
		$stmt = $db->prepare("INSERT INTO `dmhf_search` (`sKeys`) VALUES (?)");
		$stmt->bindParam(1, $s, PDO::PARAM_STR);
		$stmt->execute();
		$url = $this->apiURL;
		if($this->apiMode == "Debug") {
			$url = $url . 'index.php?act=2&s=' . $s;
		} else {
			$url = $url . 'search/' . $s;
		}
		return $url;
	}
	private function connect()
	{
		if($this->apiMode == "Debug") {
			$mysql_host = 'localhost';
			$mysql_user = 'root';
			$mysql_pass = '';
			$mysql_db = 'dmhf';
		} else {
			$mysql_host = 'www.dragomonhunterfan.com';
			$mysql_user = 'dragomon_root';
			$mysql_pass = 'IcMpncgad+s.';
			$mysql_db = 'dragomon_dmhf';
		}
		try {
			$db = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $mysql_db . ';charset=utf8', '' . $mysql_user . '', '' . $mysql_pass . '');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
		catch(PDOException $ex) {
			die("Invalid DataBase: (" . $ex . ")");
		}
		return $db;
	}
	// Funcion que busca el Titulo de las paginas $Category = Tipo(4 items 5 achievements), el $type es la subcategoria en caso de que se encuentre
	private function apiSearchCategoryTitle($category, $type)
	{
		$string = "Error";
		switch($category) {
			// Items
			case 4:
				$string = $this->returnCategoryName($type);
				break;
			// Achievements
			case 5:
				$string = $this->returnCategoryAchievementName($type);
				break;
			// Titles
			case 6:
				$string = $this->returnCategoryTitleName($type);
				break;
			case 8:
				$string = $this->returnMapsName($type);
				break;
			case 500:
				$string = "Donate";
				break;
			case 100:
				$string = $this->returnPostName($type);
				break;
		}
		return $string;
	}
	private function returnPostName($id)
	{
		$string = "Error";
		if($id > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT pTitle FROM dmhf_posts where pIndex = ? LIMIT 1");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$string = $row['pTitle'];
			}
		} else {
			$string = "Blog Posts";
		}
		if($string == "Error") {
			$this->returnError(0);
		}
		return $string;
	}
	private function returnCategoryName($catID)
	{
		$string = "Error";
		if($catID > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT catName FROM t_items_category where catID = ? LIMIT 1");
			$stmt->bindParam(1, $catID, PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$string = $row['catName'];
			}
		} else {
			$string = "Item";
		}
		if($string == "Error") {
			$this->returnError(0);
		}
		return $string;
	}
	private function returnCategoryTitleName($aID)
	{
		$string = "Error";
		if($aID > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT tName FROM t_title_category where tID = ? LIMIT 1");
			$stmt->bindParam(1, $aID, PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$string = $row['tName'];
			}
		} else {
			$string = "Titles";
		}
		if($string == "Error") {
			$this->returnError(0);
		}
		return $string;
	}
	private function returnMapsName($id)
	{
		$string = "Error";
		if($id > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT tName FROM t_node where tID = ? LIMIT 1");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$string = $row['tName'];
			}
		} else {
			$string = "Maps List";
		}
		if($string == "Error") {
			$this->returnError(0);
		}
		return $string;
	}
	private function returnQuestName($id)
	{
		$string = "Error";
		if($id > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT qName FROM t_mission where qID = ? LIMIT 1");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$string = $row['qName'];
			}
		} else {
			$string = "Quests List";
		}
		if($string == "Error") {
			$this->returnError(0);
		}
		return $string;
	}
	private function returnBiologyName($id)
	{
		$string = "Error";
		if($id > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT mName FROM t_biology where mID = ? LIMIT 1");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$string = $row['mName'];
			}
		} else {
			$string = "Biology List";
		}
		if($string == "Error") {
			$this->returnError(0);
		}
		return $string;
	}
	// Devuelve el nombre de las categorias de achievement que existen
	private function returnCategoryAchievementName($aID)
	{
		$string = "Error";
		if($aID > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT cName FROM t_achievement_category where cID = ? LIMIT 1");
			$stmt->bindParam(1, $aID, PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$string = $row['cName'];
			}
		} else {
			$string = "Achievements";
		}
		if($string == "Error") {
			$this->returnError(0);
		}
		return $string;
	}
	private function returnTitleName($aID)
	{
		$string = "Error";
		if($aID > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT tName FROM t_title where tID = ? LIMIT 1");
			$stmt->bindParam(1, $aID, PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$string = "Title: " . $row['tName'];
			}
		} else {
			$string = "Titles";
		}
		if($string == "Error") {
			$this->returnError(0);
		}
		return $string;
	}
	private function returnAchievementName($aID)
	{
		$string = "Error";
		if($aID > 0) {
			$db = $this->connect();
			$stmt = $db->prepare("SELECT aName FROM t_achievement where aID = ? LIMIT 1");
			$stmt->bindParam(1, $aID, PDO::PARAM_INT);
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$string = "Achievement: " . $row['aName'];
			}
		} else {
			$string = "Achievements";
		}
		if($string == "Error") {
			$this->returnError(0);
		}
		return $string;
	}
	// Devuelve error al index.php?err=xxxx
	function returnError($num)
	{
		switch($num) {
			case 0:
				$errNo = 404;
				$err = "no-category";
				break;
			case 1:
				$errNo = 404;
				$err = "no-found-item";
				break;
			case 2:
				$errNo = 0;
				$err = "2";
				break;
			case 3:
				$errNo = 0;
				$err = "3";
				break;
			case 403:
				$errNo = 403;
				$err = "HTTP-403-Forbidden";
				break;
		}
		header('Location: ' . $this->apiURL . 'index.php?err=' . $errNo . '&type=' . $err . '');
	}
	// Devolver el type de la url del navegador
	private function returnType()
	{
		$type = 0;
		if(isset($_GET['type'])) {
			if(is_numeric($_GET['type'])) {
				$type = $_GET['type'];
			} else {
				$type = 0;
			}
		} else {
			$type = 0;
		}
		return $type;
	}
	private function returnPostID()
	{
		$type = 0;
		if(isset($_GET['pid'])) {
			if(is_numeric($_GET['pid'])) {
				$type = $_GET['pid'];
			} else {
				$type = 0;
			}
		} else {
			$type = 0;
		}
		return $type;
	}
	public function checkCookies()
	{
		// HASHED IP
		$dmhf_id = md5($this->userIP);
		$number_of_days = 30;
		$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;
		setcookie("dmhf_id", $dmhf_id, $date_of_expiry, "/");
	}
	public function returnSiteConstruction($string)
	{
		echo '<div id="errorSet">' . $string . ' Section is under development!<br/>Please Try Again Later.</div>';
		if(!($this->isAPP)){
			echo $this->adsInPost;
		}
	}
	private function showMostViewItems($cant)
	{
		$db = $this->connect();
		$stmt = $db->prepare("SELECT
								c_items.ItemID,
								c_items.ItemIndex,
								c_items.ItemGrade,
								c_items.ItemLevel,
								t_items.ItemName,
								t_items.ItemDesc,
								t_items.ItemURL
							FROM
								c_items
							INNER JOIN t_items ON t_items.ItemID = c_items.ItemID
							INNER JOIN t_items_views ON t_items_views.iID = t_items.ItemID
							ORDER BY
								t_items_views.iViews DESC
							LIMIT ?");
		$stmt->bindParam(1, $cant, PDO::PARAM_INT);
		$stmt->execute();
		$cant = $stmt->rowCount();
		echo "<ul>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			if($this->apiMode == "Debug") {
				$linktoURL = $this->apiURL . 'index.php?act=3&cat=1&id=' . $row['ItemID'] . '&in=' . $row['ItemURL'];
			} else {
				$linktoURL = $this->apiURL . 'items/' . $row['ItemID'] . '/' . $row['ItemURL'];
			}
			echo '<li><a href="' . $linktoURL . '"><img alt="' . $row['ItemName'] . '"src="' . $this->apiURL . 'resources/images/itemsicon/' . $row['ItemIndex'] . '.png" onError="this.onerror=null;this.src=\'' . $this->apiURL . 'resources/images/itemsicon/0.png\';" ></img>' . $row['ItemName'] . '<div>View</div></a></li>';
		}
		echo "</ul>";
	}
	private function donatePage()
	{
		include('inc/donate.inc.php');
	}
	public function checkMante(){
		$filename = "css/index.css";
		if (file_exists($filename)) {
			return false;
			}
		return true;
	}
	public function Mantenimiento(){
		include("inc/maintenance.inc.php");
		return;
	}
	
	private function navigateMenu(){
		echo '<div id="navigateMenu"><span id="homeIcon"></span>
			<a href="'.$this->apiURL.'">Home</a>';
					
		if(isset($_GET['act'])){
			if($_GET['act'] != 3){
				//Primer Link despues del Home
				if($this->apiMode == "Debug") {
					$mLink = $this->apiURL.'index.php?act='.$this->apiActionID;
				} else {
					$mLink = $this->apiURL.$this->apiAction;
				}
		
				echo ' > <a href="'.$mLink.'">'.ucfirst($this->apiAction).'</a>';
				
				
				if($_GET['act'] == 4){
						if(isset($_GET['type'])){
							if($this->apiMode == "Debug") {
								$sLink = $this->apiURL.'index.php?act='.$this->apiActionID.'&type='.$_GET['type'];
							} else {
								$sLink = $this->apiURL.$this->apiAction."/type/".$_GET['type'];
							}
				
						echo ' > <a href="'.$sLink.'">'.$this->apiSearchCategoryTitle(4, $_GET['type']).'</a>';
					}
				}
			}else{
				if(isset($_GET['cat'])){
					$catInfo = $this->getCategoryInfo($_GET['cat']);
					if($this->apiMode == "Debug") {
						
						$sLink = $this->apiURL.'index.php?act='.$catInfo['id'];
					} else {
						$sLink = $this->apiURL.$catInfo['name'];
					}
					echo ' > <a href="'.$sLink.'">'.ucfirst($catInfo['name']).'</a>';
					if($_GET['cat'] == 1){
						$types = $this->getItemTypes($_GET['id']);
						if($this->apiMode == "Debug") {
								$cLink = $this->apiURL.'index.php?act='.$catInfo['id'].'&type='.$types['id'];
							} else {
								$cLink = $this->apiURL.$catInfo['name']."/type/".$types['id'];
						   }
						echo ' > <a href="'.$cLink.'">'.$types['name'].'</a>';
					}
				}
			}
		}
		
		echo '</div>';
	}
	private function getItemTypes($id){
		$type[] = array();
		$db = $this->connect();
		$stmt = $db->prepare("SELECT
								i.*, 
								ic.ItemIndex,
								ic.ItemLevel,
								ic.ItemEffectID,
								ic.ItemType,
								ic.ItemGrade,
								ic.ItemCost,
								ic.HP,
								ic.SP,
								ic.ATK,
								ic.PEN,
								ic.DEF,
								ic.CRIT,
								ic.CRITDMG,
								ic.HPREGEN,
								ic.ATKSPD,
								c.catIndex,
								c.catName,
								ig.*
							FROM
								t_items AS i
							INNER JOIN c_items AS ic ON ic.ItemID = i.ItemID
							INNER JOIN t_items_category AS c ON ic.ItemType = c.catID
							INNER JOIN t_items_grade AS ig ON IFNULL(ic.ItemGrade, 1) = ig.igID
							WHERE
								i.ItemID = ?");
			$stmt->bindParam(1, $id, PDO::PARAM_INT);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			if($row) {
				$type['id'] = $row['ItemType'];
				$type['name'] = $row['catName'];
			}
		return $type;
	}
	private function getCategoryInfo($cat){
		$string = array();
			
		switch($cat){
			case 1:
				$string['id'] = 4;
				$string['name'] = "items";
			break;
			case 2:
				$string['id'] = 5;
				$string['name'] = "achievements";
			break;
			case 3:
				$string['id'] = 6;
				$string['name'] = "titles";
			break;
			case 4:
				$string['id'] = 8;
				$string['name'] = "maps";
			break;
			case 5:
				$string['id'] = 9;
				$string['name'] = "quests";
			break;
			case 6:
				$string['id'] = 7;
				$string['name'] = "biology";
			break;
		}
		return $string;
	}
	private function printFilterMenu($type){
		if($type == "items"){

			echo '<div id="catFilter"><div class="categoryIndex showFilter">';
			
			if(isset($_SESSION['iFilteredCat'])){
				if($_SESSION['iFilteredCat'] == $_GET['type']){
					echo '<span id="filterOnIcon" title="Filter On"></span> Filtered By '.$_SESSION['iFilteredBy'];
					//Grade
					($_SESSION['iFilteredGrade01'] == true) ? $isChecked01 = "checked" : $isChecked01 = "";
					($_SESSION['iFilteredGrade02'] == true) ? $isChecked02 = "checked" : $isChecked02 = "";
					($_SESSION['iFilteredGrade03'] == true) ? $isChecked03 = "checked" : $isChecked03 = "";
					($_SESSION['iFilteredGrade04'] == true) ? $isChecked04 = "checked" : $isChecked04 = "";
					($_SESSION['iFilteredGrade05'] == true) ? $isChecked05 = "checked" : $isChecked05 = "";
					($_SESSION['iFilteredGrade06'] == true) ? $isChecked06 = "checked" : $isChecked06 = "";
					//Filtered
					($_SESSION['isFilteredSort01'] == true) ? $isFiltered01 = "checked" : $isFiltered01 = "";
					($_SESSION['isFilteredSort02'] == true) ? $isFiltered02 = "checked" : $isFiltered02 = "";
					($_SESSION['isFilteredSort03'] == true) ? $isFiltered03 = "checked" : $isFiltered03 = "";
					($_SESSION['isFilteredSort04'] == true) ? $isFiltered04 = "checked" : $isFiltered04 = "";
					($_SESSION['isFilteredSort05'] == true) ? $isFiltered05 = "checked" : $isFiltered05 = "";
					($_SESSION['isFilteredSort06'] == true) ? $isFiltered06 = "checked" : $isFiltered06 = "";
					($_SESSION['isFilteredSort07'] == true) ? $isFiltered07 = "checked" : $isFiltered07 = "";
					($_SESSION['isFilteredSort08'] == true) ? $isFiltered08 = "checked" : $isFiltered08 = "";
					($_SESSION['isFilteredSort09'] == true) ? $isFiltered09 = "checked" : $isFiltered09 = "";
					//Order
					$isOrderASC = "";
					$isOrderDESC = "";
					($_SESSION['iFilteredOrder'] == "ASC") ? $isOrderASC = "checked" : $isOrderDESC = "checked";
				}
				else{
					echo '<span id="filterOffIcon" title="Filter Off"></span> Filter';
					$isChecked01 = "checked";
					$isChecked02 = "checked";
					$isChecked03 = "checked";
					$isChecked04 = "checked";
					$isChecked05 = "checked";
					$isChecked06 = "checked";
					//filtered
					$isFiltered01 = "checked";
					$isFiltered02 = "";
					$isFiltered03 = "";
					$isFiltered04 = "";
					$isFiltered05 = "";
					$isFiltered06 = "";
					$isFiltered07 = "";
					$isFiltered08 = "";
					$isFiltered09 = "";
					//order
					$isOrderASC = "checked";
					$isOrderDESC = "";
				}
			}else{
				echo '<span id="filterOffIcon" title="Filter Off"></span> Filter';
				$isChecked01 = "checked";
					$isChecked02 = "checked";
					$isChecked03 = "checked";
					$isChecked04 = "checked";
					$isChecked05 = "checked";
					$isChecked06 = "checked";
					//filtered
					$isFiltered01 = "checked";
					$isFiltered02 = "";
					$isFiltered03 = "";
					$isFiltered04 = "";
					$isFiltered05 = "";
					$isFiltered06 = "";
					$isFiltered07 = "";
					$isFiltered08 = "";
					$isFiltered09 = "";
					//order
					$isOrderASC = "checked";
					$isOrderDESC = "";
			}
			echo '<span id="downfilterIcon"></span></div>
			<form class="filterItems" action="' . $this->apiURL . 'lib/form/filter.php" method="POST">
			<div id="filterForm">
				<h2>Grade:</h2><br/>
				<input type="checkbox" name="grade1" '.$isChecked01.'><span class="iGrade-1"> Common</span><br/>
				<input type="checkbox" name="grade2" '.$isChecked02.'><span class="iGrade-2"> Special</span><br/>
				<input type="checkbox" name="grade3" '.$isChecked03.'><span class="iGrade-3"> Rare</span><br/>
				<input type="checkbox" name="grade4" '.$isChecked04.'><span class="iGrade-4"> Epic</span><br/>
				<input type="checkbox" name="grade5" '.$isChecked05.'><span class="iGrade-5"> Elite</span><br/>
				<input type="checkbox" name="grade6" '.$isChecked06.'><span class="iGrade-6"> Legendary</span><br/>
			</div>
			<div id="filterForm">
				<h2>Filter:</h2><br/>
				<input type="radio" name="sortedby" value="ID" '.$isFiltered01.'> ID<br/>
				<input type="radio" name="sortedby" value="Level" '.$isFiltered02.'> Level<br/>
				<input type="radio" name="sortedby" value="HP" '.$isFiltered03.'> HP<br/>
				<input type="radio" name="sortedby" value="SP" '.$isFiltered04.'> SP<br/>
				<input type="radio" name="sortedby" value="Attack" '.$isFiltered05.'> Attack<br/>
				<input type="radio" name="sortedby" value="Penetration" '.$isFiltered06.'> Penetration<br/>
				<input type="radio" name="sortedby" value="Defense" '.$isFiltered07.'> Defense<br/>
				<input type="radio" name="sortedby" value="Critical" '.$isFiltered08.'> Critical<br/>
				<input type="radio" name="sortedby" value="Price" '.$isFiltered09.'> Price<br/>
			</div>
			<div id="filterForm">
				<h2>Order:</h2><br/>
				<input type="radio" name="order" value="ASC" '.$isOrderASC.'> Ascending<br/>
  				<input type="radio" name="order" value="DESC" '.$isOrderDESC.'> Descending<br/>
			</div>
				<center>
				<input type="hidden" name="iCat" value="'.$_GET['type'].'"/>
				<input type="submit" style="margin-top:10px;width: 90%" class="peter-river-flat-button" value="Apply"></input>
				</center>
				</form>
			</div>';
		}
	}
	private function rand_color() {
    	return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
	}

	private function showKeywords($action){
		echo '<meta name="keywords" content="DragomonHunter database,
		Dragomon Hunter databases,items, 
		maps, quests, biology, mobs, fansite, 
		DragomonHunter Official Fansite, Fan, Official"/>';
	}
}
?>