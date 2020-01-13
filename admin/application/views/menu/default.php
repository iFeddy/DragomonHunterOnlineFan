<div id="menu">
	<div class="wrap">
		<div id="logo">
			<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url("resources/img/logo.png");?>"></img></a>
		</div>
		<ul id="mainMenu">
			<li><a href="<?php echo base_url(); ?>"><span class="icon_l fat-application_home"></span>Home</a></li>
			<li><a href="#"><span class="icon_l fat-web_template_editor"></span>Website</a>
				<ul class="dropDown1">
					<li><a href="<?php echo base_url('post'); ?>"><span class="icon_l fat-pencil_go"></span>Write New Post</a></li>
					<li><a href="<?php echo base_url('sitemap'); ?>"><span class="icon_l fat-web_layout"></span>Create Sitemap.xml</a></li>
					<li><a href="<?php echo base_url('ads'); ?>"><span class="icon_l fat-table_money"></span>Change Ads</a></li>
					<li><a href="<?php echo base_url('links'); ?>"><span class="icon_l fat-link"></span>Change Sponsored Links</a></li>
				</ul>
			</li>
			<li><a href="<?php echo base_url('database'); ?>"><span class="icon_l fat-database_gear"></span>Database</a>
				<ul class="dropDown1">
					<li><a href="<?php echo base_url('database'); ?>"><span class="icon_l fat-database_mysql_php"></span>Database Information</a></li>
					<li><a href="<?php echo base_url('database/format'); ?>"><span class="icon_l fat-odbs_database"></span>Format INI Tables</a></li>
					<li><a href="<?php echo base_url('database/update'); ?>"><span class="icon_l fat-database_refresh"></span>Update Database</a></li>
				</ul>
			</li>
		</ul>
		<?php if(isset($this->session->uID)){ ?>
		<div id="personalMenu">
			<span id="welcomeMSG">Welcome Back <span class="yellow"><?php echo $this->session->uName; ?></span></span>
			<a href="<?php echo base_url('logoff'); ?>" class="icon_r fat-prohibition_button"></a>
			<a href="#" class="icon_r fat-edit_button"></a>
			<a href="#" class="icon_r fat-user"></a>
		</div>
		<?php } ?>
	</div>
</div>
		