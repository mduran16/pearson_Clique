<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function index()
	{
		$this->load->model("chat_model");
		
		if($this->input->get("getChatMessages") == true){
			$result = $this->chat_model->getChatMessages($this->input->get("id"));
			$messages = array("messages" => $result);
			$this->load->view("chat_view",$messages);
		}
		//http://clique.raspi.pw/cbe/index.php/chat?addMessage=true&chatID=?&message=?
		if($this->input->get("addMessage") == true){
			$result = $this->chat_model->addMessage($this->input->get("chatID"),$this->session->userdata("id"),$this->input->get("message"));
			$messages = array("messages" => '');
			$this->load->view("chat_view",$messages);
		}

		if($this->input->get("configureChat") == true){
			$result = $this->chat_model->configureChat($this->input->get("id"));
			$messages = array("messages" => $result);
			$this->load->view("chat_view",$messages);
		}

		//http://clique.raspi.pw/cbe/index.php/chat?getLatestMessages=true&chatID=1&latestID=11
		if($this->input->get("getLatestMessages") == true){
			$result = $this->chat_model->getLatestMessages($this->input->get("chatID"),$this->input->get("latestID"));
			$messages = array("messages" => $result);
			$this->load->view("chat_view",$messages);
		}

		/*
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
		*/
		$this->load->view('chat_view');
	}
}