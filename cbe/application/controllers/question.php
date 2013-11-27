<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends CI_Controller {

	public function index()
	{
		/*
		Sample get request and function call
		if($this->input->get("getChatMessages") == true){
			$result = $this->chat_model->getChatMessages($this->input->get("id"));
			$messages = array("messages" => $result);
			$this->load->view("chat_view",$messages);
		}
		*/
		$this->load->model("questions_model");

		//http://clique.raspi.pw/cbe/index.php/question?askQuestion=true&userID=1&cliqueID=1&title=yes&content=hello
		if($this->input->get("askQuestion") == true){
			$result = $this->questions_model->askQuestion($this->input->get("userID"),$this->input->get("cliqueID"), $this->input->get("title"), $this->input->get("content"));
			$questions = array("questions" => $result);
			$this->load->view("questions_view",$questions);
		}

		//http://clique.raspi.pw/cbe/index.php/question?deleteQuestion=true&questionID=1
		if($this->input->get("deleteQuestion") == true){
			$result = $this->questions_model->deleteQuestion($this->input->get("questionID"));
			$questions = array("questions" => $result);
			$this->load->view("questions_view",$questions);
		}

		//http://clique.raspi.pw/cbe/index.php/question?answerQuestion=true&userID=1&questionID=1&content=yes
		if($this->input->get("answerQuestion") == true){
			$result = $this->questions_model->answerQuestion($this->input->get("userID"),$this->input->get("questionID"),$this->input->get("content"));
			$questions = array("questions" => $result);
			$this->load->view("questions_view",$questions);
		}

		//http://clique.raspi.pw/cbe/index.php/question?getQuestions=true&cliqueID=?
		if($this->input->get("getQuestions") == true){
			$result = $this->questions_model->getQuestions($this->input->get("cliqueID"));
			$questions = array("questions" => $result);
			$this->load->view("questions_view",$questions);
		}

		//http://clique.raspi.pw/cbe/index.php/question?getQuestionThread=true&questionID=?
		if($this->input->get("getQuestionThread") == true){
			$result = $this->questions_model->getQuestionThread($this->input->get("questionID"));
			$questions = array("questions" => $result);
			$this->load->view("questions_view",$questions);
		}



		$this->load->view("questions_view");
	}


}