<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

	public function index()
	{
		$this->load->model("courses_model");
		$courses = $this->session->userdata("courses");
		$courses = $courses["courses"];
		if(!$this->session->userdata("coursedata")){
			for($i = 0; $i < count($courses); $i++){
				$courses[$i] = get_object_vars($courses[$i]);
				$courses[$i]["links"] = get_object_vars($courses[$i]["links"][0]);
				$courses[$i]["details"] = $this->courses_model->getCourseData($courses[$i]["links"]["href"]);
				$courses[$i]["instructor"] = $this->courses_model->getInstructorData($courses[$i]["links"]["href"]);
				$courses[$i]["ta"] = $this->courses_model->getTAData($courses[$i]["links"]["href"]);
			}
			$this->session->set_userdata("coursedata",$courses);
		}

		//var_dump($courses);
		$this->load->view("courses_view");

	
	}
}