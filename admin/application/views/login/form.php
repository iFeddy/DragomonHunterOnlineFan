<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<body>
    <div id="loginBox">
        <div id="loginLogo"><img alt="<?php echo $api['url_title']; ?>" src="<?php echo base_url("resources/img/logo.png"); ?>"></img></div>
		<div class="clear"></div>
        <?php      
			if(!(isset($this->session->uID))){
				$attributes = array('id' => 'logForm');       
				echo form_open('login', $attributes);
				
				echo form_input('username', set_value('username'), 'class="formInput"');
				echo form_label('Username: ', 'username');
				echo '<div class="clear"></div>';

				echo form_password('password', '', 'class="formInput"');
				echo form_label('Password: ', 'password');
				echo '<div class="clear"></div>';
				
				echo form_submit('submit', 'Login', 'class="formSubmit"');
				echo '<a href="#" class="registerButton">Register</a>';
				
				echo form_close();
				echo '<div class="clear"></div>';
				
				echo validation_errors('<div class="form_error">', '</div>');
				if(isset($login['error'])) echo '<div class="form_error">'.$login['error'].'</div>';
			}else{
				echo "<br/>Already Logged In<br/><br/>";
				echo '<a href="'.base_url("logoff").'" class="logoffButton">Logoff</a>';
			}
        ?>
    </div> 