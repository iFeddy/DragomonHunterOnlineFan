<?php
				$db = $this->connect();
				$stmt = $db->prepare("SELECT * FROM dmhf_donator order by dID ASC");
				$stmt->execute();	
				$cantResultados = $stmt->rowCount();
			if($cantResultados == 0){
				$tableShow = 'style="float: none; margin: 20px auto;"';
			}else{
				$tableShow = '';
			}
				
			echo '<div id="donatePage"><h1>Donation\'s Page</h1>
				<span id="hearticon"></span>DragomonHunterFan gives more than 45,655 unique rows from the game\'s database. You can always help us improve and update database, pay server bills and domain bills by making a small donation.
				If you find this website helpful, please consider supporting <strong>DragomonHunterFan</strong> with Donations.
			</div>
			<div class="wrap">';
			if(isset($_GET['tkn'])){
				echo '<div id="donationInfo"><h1>Hola</h1>
				<form>
					
				</form>
				</div>';
						
			}else{
				echo '<div id="donatePanel" '.$tableShow.'>
					<h2><span id="donicon"></span>Donation Menu:</h2>
					<center>
					<h2> Paypal | Credit Card </h2>
					If you want to donate to our website please use the following link to checkout:<br/><br/>
					
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="877BGW7HWHB9U">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="amount" value="25.00">
					<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_donate_pp_142x27.png" border="0" name="submit" alt="PayPal - Donation">
					</form>


					<br/>
					After donation is done, you will recive a link in order to complete information about you (Optional)		<br/><br/>
					
					<h2> SMS | Others</h2>
					If your cell phone company allows you, you can send a SMS to donate on dragomonhunterfan.com<br/><br/>
					
					 <form name="pg_frm" method="post" action="https://www.paygol.com/pay" >
					   <input type="hidden" name="pg_serviceid" value="358194">
					   <input type="hidden" name="pg_currency" value="USD">
					   <input type="hidden" name="pg_name" value="DragomonHunterFan">
					   <input type="hidden" name="pg_custom" value="">
					   <input type="hidden" name="pg_price" value="5">
					   <input type="hidden" name="pg_return_url" value="http://www.dragomonhunterfan.com/donate">
					   <input type="hidden" name="pg_cancel_url" value="http://www.dragomonhunterfan.com/donate">
					   <input type="image" name="pg_button" src="https://www.paygol.com/webapps/buttons/en/white.png" border="0" alt="Make payments with PayGol: the easiest way!" title="Make payments with PayGol: the easiest way!" >    
					</form> 
					
					</center>		
				</div>
				';
				if($cantResultados > 0){
				echo '<div id="donateChart">
					<h2><span id="don2icon"></span>Donators List:</h2>
					<table id="donateTable">
						<tr class="tName">
							<td style="width:40px;font-weight: bold;">#</td><td style="width:115px;font-weight: bold;">Name</td><td style="width:115px;font-weight: bold;">Guild Name</td><td style="width:70px;font-weight: bold;">Server</td>
						</tr>
						';
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						echo'<tr class="border_bottom">
							<td>'.$row['dID'].'</td><td>'.$row['dName'].'</td><td>'.$row['dGuild'].'</td><td>'.$row['dServer'].'</td>
						</tr>					<tr class="border_bottom">
						';	
						}					
					echo '
					<tr class="tName">
							<td colspan=4 style="height:20px;font-weight: bold;">(*) List only shows Paypal Donations</td>
						</tr>
					</table>
				</div>
				
				<div class="clear"></div>
				';
				}
			}
			$this->echoFooter();
			
			
?>