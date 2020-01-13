<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->library('configmanager');
		$data = $this->configmanager->getData();
		$data['api']['version'] = $data['login']['version'];

		if(strlen($this->input->get('from')) > 0)
		{
			$this->session->login_redirect = $this->input->get('from');
		}

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->model('dmhf_users');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[15]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');

		if ($this->form_validation->run() == FALSE)
        {
			$this->load->view("login/header", $data);
			$this->load->view("login/form", $data);
			$this->load->view("footer/default", $data);
		}
		else
        {
			if($this->_checkDatabase()){
				$this->load->view("login/header", $data);
				$this->load->view("login/form_success", $data);
				$this->load->view("footer/default", $data);
			}else{
				$data['login']['error'] = 'Invalid Username or Password';
				$this->load->view("login/header", $data);
				$this->load->view("login/form", $data);
				$this->load->view("footer/default", $data);
			}
        }

	}

	function _checkDatabase(){

			$uName = $this->input->post('username');
			$uPass = $this->input->post('password');

			$result = $this->dmhf_users->login($uName, $uPass);

			if ($result == TRUE) {
				foreach($result as $row)
				{
					$this->session->uID = $row->uID;
					$this->session->uName = $row->uName;
					$this->session->uEmail = $row->uEmail;
					$this->session->uAuth = $row->uAuth;
					$this->session->uPoints = $row->uPoints;
					$this->session->uVerified = $row->uVerified;
				}	
				return true;
			}else{
				return false;
			}
	}
}
?>