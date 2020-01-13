	<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		<div id="content">
			<div class="inlineBox">
				<h1><span class='icon fleft fat-database_green'></span> Items</h1>
				<div class="updateItems">
					<table class="sorteableTable">
						<thead>
						<tr><th style="width: 33%;"><span class='icon_l fat-database'></span>Database</th><th style="width: 33%;"><span class='icon_l fat-database_error'></span>Rows</th><th style="width: 33%;"><span class='icon_l fat-database_add'></span>Updates</th></tr>
						</thead>
						<tbody>
						<tr><td>c_items</td><td><?php echo $this->dmhf_tables->rows("c_items"); ?></td><td><?php echo $this->dmhf_tables->newRows("c_item"); ?></td></tr>
						<tr><td>t_items</td><td><?php echo $this->dmhf_tables->rows("t_items"); ?></td><td><?php echo $this->dmhf_tables->newRows("t_item"); ?></td></td></tr>
						<tr><td>t_items_effect</td><td><?php echo $this->dmhf_tables->rows("t_items_effect"); ?></td><td><?php echo $this->dmhf_tables->newRows("t_enchant"); ?></td></td></tr>
						<tr><td>c_combine</td><td><?php echo $this->dmhf_tables->rows("c_combine"); ?></td><td><?php echo $this->dmhf_tables->newRows("c_combine"); ?></td></td></tr>
						<tr><td>t_combine</td><td><?php echo $this->dmhf_tables->rows("t_combine"); ?></td><td><?php echo $this->dmhf_tables->newRows("t_combine"); ?></td></td></tr>
						</tbody>
					</table>
				<button class="update_button" data="items" id="button">Update</button>
				<div id="status_items" class="update_status">
				</div>
				</div>
			</div>
			<div class="inlineBox">
				<h1><span class='icon fleft fat-database_green'></span>Biology</h1>
				<div class="updateItems">
				<table class="sorteableTable">
						<thead>
						<tr><th style="width: 33%;"><span class='icon_l fat-database'></span>Database</th><th style="width: 33%;"><span class='icon_l fat-database_error'></span>Rows</th><th style="width: 33%;"><span class='icon_l fat-database_add'></span>Updates</th></tr>
						</thead>
						<tbody>
						<tr><td>c_biology</td><td><?php echo $this->dmhf_tables->rows("c_biology"); ?></td><td><?php echo $this->dmhf_tables->newRows("c_biology"); ?></td></tr>
						<tr><td>t_biology</td><td><?php echo $this->dmhf_tables->rows("t_biology"); ?></td><td><?php echo $this->dmhf_tables->newRows("t_biology"); ?></td></td></tr>
						</tbody>
					</table>
					<button class="update_button" data="biology" id="button">Update</button>
				<div id="status_biology" class="update_status">
				</div>
				</div>
			</div>

			<div class="inlineBox">
				<h1><span class='icon fleft fat-database_green'></span>Quests</h1>
				<div class="updateItems">
				<table class="sorteableTable">
						<thead>
						<tr><th style="width: 33%;"><span class='icon_l fat-database'></span>Database</th><th style="width: 33%;"><span class='icon_l fat-database_error'></span>Rows</th><th style="width: 33%;"><span class='icon_l fat-database_add'></span>Updates</th></tr>
						</thead>
						<tbody>
						<tr><td>c_mission</td><td><?php echo $this->dmhf_tables->rows("c_mission"); ?></td><td><?php echo $this->dmhf_tables->newRows("c_mission"); ?></td></tr>
						<tr><td>t_mission</td><td><?php echo $this->dmhf_tables->rows("t_mission"); ?></td><td><?php echo $this->dmhf_tables->newRows("t_mission"); ?></td></td></tr>
						</tbody>
					</table>
					<button class="update_button" data="quests" id="button">Update</button>
				<div id="status_quests" class="update_status">
				</div>
				</div>
			</div>

			<div class="inlineBox">
				<h1><span class='icon fleft fat-database_green'></span>Achievements</h1>
				<div class="updateItems">
				<table class="sorteableTable">
						<thead>
						<tr><th style="width: 33%;"><span class='icon_l fat-database'></span>Database</th><th style="width: 33%;"><span class='icon_l fat-database_error'></span>Rows</th><th style="width: 33%;"><span class='icon_l fat-database_add'></span>Updates</th></tr>
						</thead>
						<tbody>
						<tr><td>c_achievement</td><td><?php echo $this->dmhf_tables->rows("c_achievement"); ?></td><td><?php echo $this->dmhf_tables->newRows("c_achievement"); ?></td></tr>
						<tr><td>t_achievement</td><td><?php echo $this->dmhf_tables->rows("t_achievement"); ?></td><td><?php echo $this->dmhf_tables->newRows("t_achievement"); ?></td></td></tr>
						</tbody>
					</table>
					<button class="update_button" data="achievements" id="button">Update</button>
				<div id="status_achievements" class="update_status">
				</div>
				</div>
			</div>
			
				<div class="inlineBox">
				<h1><span class='icon fleft fat-database_green'></span>Titles</h1>
				<div class="updateItems">
				<table class="sorteableTable">
						<thead>
						<tr><th style="width: 33%;"><span class='icon_l fat-database'></span>Database</th><th style="width: 33%;"><span class='icon_l fat-database_error'></span>Rows</th><th style="width: 33%;"><span class='icon_l fat-database_add'></span>Updates</th></tr>
						</thead>
						<tbody>
						<tr><td>c_title</td><td><?php echo $this->dmhf_tables->rows("c_title"); ?></td><td><?php echo $this->dmhf_tables->newRows("c_title"); ?></td></tr>
						<tr><td>t_title</td><td><?php echo $this->dmhf_tables->rows("t_title"); ?></td><td><?php echo $this->dmhf_tables->newRows("t_title"); ?></td></td></tr>
						</tbody>
					</table>
					<button class="update_button" data="titles" id="button">Update</button>
				<div id="status_titles" class="update_status">
				</div>
				</div>
			</div>
			
			
			<div class="clear"></div>
		</div>
		<script src="<?php echo base_url("resources/js/database.update.js");?>" type="text/javascript"></script>