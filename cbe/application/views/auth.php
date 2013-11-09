<?php

ob_start();

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	header("location: http://clique.raspi.pw/");
}

else{

	if($this->session->userdata("logged_in") == true)
	{
		$userdata = array("logged_in" => $this->session->userdata("logged_in"),
			"refresh_token" => $this->session->userdata("refresh_token"),
			"access_token" => $this->session->userdata("access_token"),
			"expires_in" =>$this->session->userdata("expires_in"),
			"id" => $this->session->userdata("id"),
			"userName" => $this->session->userdata("userName"),
			"firstName" =>$this->session->userdata("firstName"),
			"lastName" => $this->session->userdata("lastName"),
			"emailAddress" => $this->session->userdata("emailAddress"),
			"clientString" =>$this->session->userdata("clientString"),
			"courses" => $this->session->userdata("courses"),
			);
		echo json_encode($userdata);
	}
	else
		echo json_encode(array("logged_in" => false));
}		


die();


