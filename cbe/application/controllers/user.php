<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{	

		$this->load->model('user_model');
		//http://clique.raspi.pw/cbe/index.php/user?userdata=true&userID=?
		if($this->input->get("userdata") == true){
			$result = $this->user_model->getUserdata($this->input->get('userID'));
			$data = array("data" => $result);
			$this->load->view("user_view",$data);
		}
		$this->load->view("user_view");
	}
}