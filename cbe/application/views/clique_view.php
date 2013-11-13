<?php
/*
ob_start();

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	header("location: http://clique.raspi.pw/");
}

else{
*/
	if($this->session->userdata("logged_in") == true)
	{
		if(isset($cliques)){
			echo json_encode($cliques);
		}
	}
	else
		echo json_encode(array("logged_in" => false));
//}		


die();


