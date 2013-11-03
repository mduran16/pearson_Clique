<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function authenticate($username, $password){
    	$data = array(
    		"username" => $username,
    		"password" => $password,
    		"auth" => array(
    			"logged_in" => false,

    			),
    		);
    	return $data;
    }
}
?>