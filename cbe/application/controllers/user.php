<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		if($this->input->get("userdata"))
			$this->load->view("user_view");
	}
}