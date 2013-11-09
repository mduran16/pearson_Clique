<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		$this->load->model("auth_model");

		if($this->session->userdata("logged_in") == false){

			if($this->input->post("username") != false && $this->input->post("password") != false){

				$result = $this->auth_model->authenticate($this->input->post("username"),$this->input->post("password"));

				if($result[0] != false){
					$auth = get_object_vars($result[0]);
					$this->session->set_userdata("logged_in",true);
					$this->session->set_userdata("refresh_token", $auth['refresh_token']);
					$this->session->set_userdata("access_token", $auth['access_token']);
					$this->session->set_userdata("expires_in", $auth['expires_in']);
				

					$userdata = get_object_vars($result[1]);

					$this->session->set_userdata("id",$userdata["id"]);
					$this->session->set_userdata("userName", $userdata["userName"]);
					$this->session->set_userdata("firstName", $userdata["firstName"]);
					$this->session->set_userdata("emailAddress",$userdata["emailAddress"]);
					$this->session->set_userdata("clientString", $userdata["clientString"]);

					$this->session->set_userdata("courses",$result[2]);
				}
			}	
		}
		if($this->input->get('logout'))
			$this->session->sess_destroy();
		
		$this->load->view('auth');

	
	}
}