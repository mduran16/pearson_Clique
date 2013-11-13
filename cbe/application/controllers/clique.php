<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clique extends CI_Controller {

	public function index()
	{
		$this->load->model("clique_model");
		if($this->input->get("addClique") == true){
			$result = $this->clique_model->addClique($this->input->get('name'),$this->input->get("parent"));
		}
		elseif($this->input->get("getClique") == true){
			$result = $this->clique_model->getClique($this->input->get('name'));
		}
		elseif($this->input->get("getUserCliques") == true){
			$result = $this->clique_model->getUserCliques($this->session->userdata("id"),$this->input->get("parent"));
			$userCliques = array("cliques" => $result);
			$this->load->view('clique_view',$userCliques);
		}
		elseif($this->input->get("addUserClique") == true){
			$result = $this->clique_model->addUserToClique($this->input->get("cliqueID"),$this->session->userdata("id"));
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

		$this->load->view('clique_view');
	}
}