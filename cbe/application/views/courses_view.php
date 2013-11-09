<?php

ob_start();

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	header("location: http://clique.raspi.pw/");
}

else{

	if($this->session->userdata("logged_in") == true)
	{
		$userdata = array("courses" => $this->session->userdata("coursedata"),
			);
		echo json_encode($userdata);
	}
	else
		echo json_encode(array("logged_in" => false));
}		


die();


