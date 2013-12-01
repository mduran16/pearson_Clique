<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getUserdata($userID){
    	$userdata = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://m-api.ecollege.com/users/" . $userID);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Authorization: Access_Token access_token=" . $this->session->userdata("access_token")));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
         
        $api_response = curl_exec($ch);

        $curlError = curl_error($ch);
         
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //var_dump($api_response);
        if($curlError){
         
            $userdata = false; 
         
        } else if(intval($http_code / 100) >=4){

            $userdata =  false;
         
        } else {
            $userdata = json_decode($api_response);
            $userdata = get_object_vars($userdata);
            $userdata = $userdata["users"][0];
            $userdata = get_object_vars($userdata);
        }

        return $userdata;
    }

}