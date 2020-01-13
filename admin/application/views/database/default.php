	<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		<div id="content">
		<h1 style="margin-bottom:10px;"><span class="icon_l fat-database_mysql_php" style="margin-top: -1px;margin-right: 5px;"></span> Database Information</h1>
		<table>
				<tr><td style="width: 10%;">Total Tables</td><td><?php echo $this->dmhf_info->totalTables(); ?></td></tr>		
				<tr><td style="width: 10%;">Total Rows</td><td><?php echo $this->dmhf_info->totalRows(); ?></td></tr>
				<tr><td style="width: 10%;">Total Size</td><td><?php echo $this->dmhf_info->totalSize(); ?> MB</td></tr>
		</table>
		
				<a href="<?php echo base_url('database/format'); ?>" class="buttonDB"><span class="icon_l fat-odbs_database" style="margin-right: -20px;"></span>Format INI Tables</a>
				<a href="<?php echo base_url('database/update'); ?>" class="buttonDB"><span class="icon_l fat-database_refresh" style="margin-right: -20px;"></span>Update Database</a>
				
			<div class="clear"></div>
		</div>
		<script src="<?php echo base_url("resources/js/database.update.js");?>" type="text/javascript"></script>