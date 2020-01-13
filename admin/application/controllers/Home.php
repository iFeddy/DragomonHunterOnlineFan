<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		if (!(isset($this->session->uID)))
        { 
            redirect('login');
        }
	}
	
	public function index()
	{
		$this->load->library('configmanager');
		$data = $this->configmanager->getData();
	
		$this->load->view("common/header", $data);
		$this->load->view("menu/default");
		$this->load->view("footer/default", $data);
	}

}
?>