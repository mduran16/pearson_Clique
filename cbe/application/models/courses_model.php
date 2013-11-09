<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Courses_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getInstructorData($link){
        $instructoredata = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link . "/instructors");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Authorization: Access_Token access_token=" . $this->session->userdata("access_token")));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
         
        $api_response = curl_exec($ch);

        $curlError = curl_error($ch);
         
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
         
        if($curlError){
         
            $instructordata = false; 
         
        } else if(intval($http_code / 100) >=4){

            $instructordata =  false;
         
        } else {
            $instructordata = json_decode($api_response);
            $instructordata = get_object_vars($instructordata);

            $instructordata = $instructordata["instructors"][0];
            $instructordata = get_object_vars($instructordata);
            
            $instructordata = array(
                "id" => $instructordata["id"],
                "firstName" => $instructordata["firstName"],
                "lastName" => $instructordata["lastName"],
                "emailAddress" => $instructordata["emailAddress"]
                );
            //var_dump($instructordata);
        }

        return $instructordata;
    }

    

    function getTAData($link){
        $tadata = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link . "/teachingAssistants");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Authorization: Access_Token access_token=" . $this->session->userdata("access_token")));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
         
        $api_response = curl_exec($ch);

        $curlError = curl_error($ch);
         
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
         
        if($curlError){
         
            $tadata = false; 
         
        } else if(intval($http_code / 100) >=4){

            $tadata =  false;
         
        } else {
            $tadata = json_decode($api_response);
            $tadata = get_object_vars($tadata);

            $tadata = $tadata["teachingAssistants"][0];
            $tadata = get_object_vars($tadata);
            $tadata = array(
                "id" => $tadata["id"],
                "firstName" => $tadata["firstName"],
                "lastName" => $tadata["lastName"],
                "emailAddress" => $tadata["emailAddress"],

                );
            //var_dump($tadata);
        }

        return $tadata;
    }


    function getCourseData($link){
        $coursedata = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Authorization: Access_Token access_token=" . $this->session->userdata("access_token")));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
         
        $api_response = curl_exec($ch);

        $curlError = curl_error($ch);
         
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
         
        if($curlError){
         
            $coursedata = false; 
         
        } else if(intval($http_code / 100) >=4){

            $coursedata =  false;
         
        } else {
            $coursedata = json_decode($api_response);
            $coursedata = get_object_vars($coursedata);

            $coursedata = $coursedata["courses"][0];
            $coursedata = get_object_vars($coursedata);

            $coursedata = array(
                "id" => $coursedata["id"],
                "displayCourseCode" => $coursedata["displayCourseCode"],
                "title" => $coursedata["title"],

            );
            //var_dump($coursedata);
        }

        return $coursedata;
    }

}
?>