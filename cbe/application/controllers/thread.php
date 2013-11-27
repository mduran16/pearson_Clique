<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thread extends CI_Controller {

	public function index()
	{
		$this->load->model("thread_model");
		/*
		Sample get request and function call
		if($this->input->get("getChatMessages") == true){
			$result = $this->chat_model->getChatMessages($this->input->get("id"));
			$messages = array("messages" => $result);
			$this->load->view("chat_view",$messages);
		}
		*/

		//http://clique.raspi.pw/cbe/index.php/thread?sendInvite=true&senderID=1&recieverID=1&cliqueID=1
		if($this->input->get("sendInvite") == true){
			$cliqueID = '';
			if(gettype($this->input->get("cliqueID")) == "string"){
				$cliqueID = "'" . $this->input->get("cliqueID") . "'";
			}
			else
				$cliqueID = $this->input->get("cliqueID");

			$result = $this->thread_model->sendInvite($this->session->userdata('id'),$this->input->get("recieverID"),$cliqueID);
			$threads = array("threads" => $result);
			$this->load->view("thread_view",$threads);
		}

		//http://clique.raspi.pw/cbe/index.php/thread?acceptInvite=true&messageID=?
		if($this->input->get("acceptInvite") == true){
			$result = $this->thread_model->acceptInvite($this->input->get('messageID'),$this->session->userdata('id'));
			$threads = array("threads" => $result);
			$this->load->view("thread_view",$threads);
		}

		//http://clique.raspi.pw/cbe/index.php/thread?sendMessage=true&senderID=1&recieverID=1&message=hello
		if($this->input->get("sendMessage") == true){
			$result = $this->thread_model->sendMessage($this->session->userdata("id"),$this->input->get("recieverID"),$this->input->get("message"));
			$threads = array("threads" => $result);
			$this->load->view("thread_view",$threads);
		}

		//http://clique.raspi.pw/cbe/index.php/thread?deleteMessage=true&messageID=1
		if($this->input->get("deleteMessage") == true){
			$result = $this->thread_model->deleteMessage($this->input->get("messageID"));
			$threads = array("threads" => $result);
			$this->load->view("thread_view",$threads);
		}

		//http://clique.raspi.pw/cbe/index.php/thread?getMessages=true&userID=1
		if($this->input->get("getMessages") == true){
			$result = $this->thread_model->getMessages($this->input->get("userID"));
			$threads = array("threads" => $result);
			$this->load->view("thread_view",$threads);
		}

		//http://clique.raspi.pw/cbe/index.php/thread?getInvites=true&userID=1
		if($this->input->get("getInvites") == true){
			$result = $this->thread_model->getInvites($this->session->userdata("id"));
			$threads = array("threads" => $result);
			$this->load->view("thread_view",$threads);
		}

		//http://clique.raspi.pw/cbe/index.php/thread?getConversation=true&userID=1&otherID=2
		if($this->input->get("getConversation") == true){
			$result = $this->thread_model->getConversation($this->session->userdata('id'),$this->input->get("otherID"));
			$threads = array("threads" => $result);
			$this->load->view("thread_view",$threads);
		}

		//http://clique.raspi.pw/cbe/index.php/thread?getThreads=true
		if($this->input->get("getThreads") == true){
			$result = $this->thread_model->getThreads($this->session->userdata("id"));
			$threads = array("threads" => $result);
			$this->load->view("thread_view",$threads);
		}

	}


}