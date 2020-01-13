<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<body>
    <?php 
        $redirectTo = base_url("");
        if(strlen($this->session->login_redirect) > 0){
            $redirectTo = $this->session->login_redirect;
        }
    $this->output->set_header('refresh:3; url='.$redirectTo); ?>
    <div id="loginBox">
        <div id="loginLogo"><img alt="<?php echo $api['url_title']; ?>" src="<?php echo base_url("resources/img/logo.png"); ?>"></img></div>
            <br/>
            <br/>
            <div class="loginSuccess">Login Success!<br/>
            Thank you for logging in, <span class="yellow"><?php echo set_value('username'); ?></span></div>
  
    </div> 