<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

	public function index()
	{
		$this->load->model("courses_model");
		$courses = $this->session->userdata("courses");
		$courses = $courses["courses"];

		if($this->input->get("id") && $this->input->get("classmates") == true){
			$roster = array("roster" => $this->courses_model->getCourseRoster($this->input->get("id")));
			$this->load->view("courses_view",$roster);
		}

		elseif(!$this->session->userdata("coursedata")){
			for($i = 0; $i < count($courses); $i++){
				$courses[$i] = get_object_vars($courses[$i]);
				$courses[$i]["links"] = get_object_vars($courses[$i]["links"][0]);
				$details = $this->courses_model->getCourseData($courses[$i]["links"]["href"]);
				$id = $details["id"];
				$courses[$i][$id]["details"] = $this->courses_model->getCourseData($courses[$i]["links"]["href"]);
				$courses[$i][$id]["instructor"] = $this->courses_model->getInstructorData($courses[$i]["links"]["href"]);
				$courses[$i][$id]["ta"] = $this->courses_model->getTAData($courses[$i]["links"]["href"]);
				unset($courses[$i]["links"]);
			}
			$this->session->set_userdata("coursedata",$courses);
			
		}
		$this->load->view("courses_view");

	
	}
}