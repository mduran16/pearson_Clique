<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function authenticate($username, $password){

        $response = array();
        $userdata = array();
        $application_id     = $this->config->item('appid');; 
        $client_string      = $this->config->item('client');; 
        $username           = $username; 
        $password           = $password; 
         
        $post_request = 'grant_type=password'
                        .'&client_id='.$application_id
                        .'&username='.$client_string.'\\'.$username
                        .'&password='.$password; 
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://m-api.ecollege.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_request);
         
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
         
         
        $api_response = curl_exec($ch); 
         
        $curlError = curl_error($ch);
         
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
         
        if($curlError){
         
            return false; 
         
        } else if(intval($http_code / 100) >=4){

            return false;
         
        } else {

            $response = json_decode($api_response);

            $temp = get_object_vars($response);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://m-api.ecollege.com/me');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Authorization: Access_Token access_token=" . $temp["access_token"]));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
             
            $api_response = curl_exec($ch);

            $curlError = curl_error($ch);
             
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
             
            if($curlError){
             
                $userdata = false; 
             
            } else if(intval($http_code / 100) >=4){

                $userdata =  false;
             
            } else {

                $userdata = json_decode($api_response);
                $userdata = get_object_vars($userdata);
                $userdata = $userdata["me"];
            }


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://m-api.ecollege.com/me/courses');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Authorization: Access_Token access_token=" . $temp["access_token"]));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
             
            $api_response = curl_exec($ch);

            $curlError = curl_error($ch);
             
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
             
            if($curlError){
             
                $userdata = false; 
             
            } else if(intval($http_code / 100) >=4){

                $userdata =  false;
             
            } else {

                $coursedata = json_decode($api_response);
                $coursedata = get_object_vars($coursedata);
                //var_dump($coursedata);
            }


            $return = array($response,$userdata,$coursedata);
            return $return;
        }

    }

    function isUserInDB($userID){
        $sql = "SELECT * FROM users WHERE userID = " . $userID;
        $result = $this->db->query($sql);
        if($result->num_rows() == 0)
            return false;
        else
            return true;
    }

    function addUserToDB($userID,$username){
        $sql = "INSERT INTO users(userID,username) VALUES (".$userID.",'".$username."')";
        $result = $this->db->query($sql);  
    }

    function getNewAccessToken(){
        return true;
    }
}
?>