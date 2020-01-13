	<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		<div id="content">
		<table class="sorteableTable">
			<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Directory</th>
				<th>Craeted</th>
				<th>Size</th>
				<th>Status</th>
			</tr>
			</thead>
			<tbody>
		<?php 
		$i = 0;
		foreach (glob('db/*') as $fullname) {
				date_default_timezone_set('America/Argentina/Buenos_Aires');
				$filename = basename(strtolower($fullname));
				if (preg_match('#^t_|^c_#i', $filename) === 1) {
					echo "<tr><td>$i</td><td>$filename</td><td>$fullname</td><td>".date("F d Y H:i:s",fileatime($fullname))."</td><td>".filesize_formatted($fullname)."</td><td class='status' id='$filename'></td></tr>";
					$i++;
				}
		}
		
			function filesize_formatted($path)
			{
				$size = filesize($path);
				$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
				$power = $size > 0 ? floor(log($size, 1024)) : 0;
				return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
			}
			//<span class="icon_l fat-tick_button"></span>
		?>
		</tbody>
		</table>

		<button id="button" class="formatSubmit"><span id="formatButtonTxT">Start Formatting</span></button>
		</div>
		
		<script src="<?php echo base_url("resources/js/database.format.js");?>" type="text/javascript"></script>