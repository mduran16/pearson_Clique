<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clique extends CI_Controller {

	public function __construct(){
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
	}

	public function index()
	{

		$this->load->model("clique_model");

		if($this->input->get("addClique") == true){
			$result = $this->clique_model->addClique($this->input->get('name'),$this->input->get("parent"));
		}
		//http://clique.raspi.pw/cbe/index.php/clique?getClique=true&cliqueID=?
		elseif($this->input->get("getClique") == true){
			$result = $this->clique_model->getClique($this->input->get('cliqueID'));
			$userCliques = array("cliques" => $result);
			$this->load->view('clique_view',$userCliques);
		}

		elseif($this->input->get("getUserCliques") == true){
			$result = $this->clique_model->getUserCliques($this->session->userdata("id"),$this->input->get("parent"));
			$userCliques = array("cliques" => $result);
			$this->load->view('clique_view',$userCliques);
		}

		elseif($this->input->get("addUserClique") == true){
			if($this->input->get("instructor") == true)
				$result = $this->clique_model->addUserToClique($this->input->get("cliqueID"),$this->session->userdata("id"),$this->input->get("instructor"));
			else
				$result = $this->clique_model->addUserToClique($this->input->get("cliqueID"),$this->session->userdata("id"),false);
			$this->load->view('clique_view');
		}

		elseif($this->input->get("getCourseCliques") == true){
			$result = $this->clique_model->getCourseCliques($this->input->get("parent"));
			$userCliques = array("cliques" => $result);
			$this->load->view('clique_view',$userCliques);
		}

		elseif($this->input->get("getCliqueUsers") == true){
			$result = $this->clique_model->getCliqueUsers($this->input->get("id"));
			$userCliques = array("cliques" => $result);
			$this->load->view('clique_view',$userCliques);
		}

		//http://clique.raspi.pw/cbe/index.php/clique?hangouturl=true&url=?&cliqueID=?
		elseif($this->input->get("hangouturl") == true){
			$result = $this->clique_model->addHangoutURL($this->input->get("cliqueID"),$this->input->get("url"));
			$userCliques = array("cliques" => $result);
			$this->load->view('clique_view',$userCliques);
		}

		//http://clique.raspi.pw/cbe/index.php/clique?gethangouturl=true&cliqueID=?
		elseif($this->input->get("gethangouturl") == true){
			$result = $this->clique_model->getHangoutURL($this->input->get("cliqueID"));
			$userCliques = array("cliques" => $result);
			$this->load->view('clique_view',$userCliques);
		}


		$this->load->view('clique_view');
	}
}