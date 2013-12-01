<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clique_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function addClique($name, $parent){
        $addClique = "INSERT INTO cliques(cliqueName, cliqueParent) VALUES ('" . $name . "'," . $parent . ")";
        $query = $this->db->query($addClique);
        $this->addUserToClique($this->getClique($name),$this->session->userdata("id"));
    }

    function getClique($id){
        $id = $this->db->query("SELECT * FROM cliques WHERE cliqueID = " . $id);
        $row = $id->row_array();
        return $row;
    }

    function getUserCliques($userID,$parent){
        $sql = '';
        //var_dump($this->session->userdata("role"));
        if($parent == false)
            $sql = "SELECT cliques.* FROM cliques, cliqueRelations WHERE cliques.cliqueID = cliqueRelations.cliqueID AND cliqueRelations.userID = " . $this->session->userdata("id");
        //elseif($this->session->userdata("role") == "PROF" || $this->session->userdata("role") == "TAST")
          //  $sql = "SELECT cliques.* FROM cliques, cliqueRelations WHERE cliques.cliqueID = cliqueRelations.cliqueID AND cliques.cliqueParent = " . $parent;
        else
            $sql = "SELECT cliques.* FROM cliques, cliqueRelations WHERE cliques.cliqueID = cliqueRelations.cliqueID AND cliqueRelations.userID = " . $this->session->userdata("id") . " AND cliques.cliqueParent = " . $parent;
        //echo ($sql);
        $cliques = $this->db->query($sql);
        $cliques = $cliques->result();
        for($i = 0; $i < count($cliques); $i++){
            $cliques[$i] = get_object_vars($cliques[$i]);
        }
        return $cliques;
    }

    function getCourseCliques($parent){
        $sql = "SELECT cliques.* FROM cliques, cliqueRelations WHERE cliques.cliqueID = cliqueRelations.cliqueID AND cliques.cliqueParent = " . $parent . " GROUP BY cliques.cliqueID";
        
        $cliques = $this->db->query($sql);
        $cliques = $cliques->result();

        for($i = 0; $i < count($cliques); $i++){
            $cliques[$i] = get_object_vars($cliques[$i]);
        }
        return $cliques;
    }

    function getUserClique($userID, $cliqueName){
        echo "test";
    }

    function addUserToClique($cliqueID, $userID,$instructor){
        $sql = "SELECT * FROM cliqueRelations WHERE cliqueID = " . $cliqueID . " AND userID = " . $userID;
        $result = $this->db->query($sql);
        $cliques = $result->result();

        if(count($cliques) == 0)
        {
            if($instructor = false)
                $addUser = "INSERT INTO cliqueRelations (cliqueID, userID) VALUES (". $cliqueID . ",". $userID .")";
            else
                $addUser = "INSERT INTO cliqueRelations (cliqueID, userID, isInstructor) VALUES (". $cliqueID . ",". $userID .",1)";
            $query = $this->db->query($addUser);

        }
    }



    function getCliqueUsers($cliqueID){
        $sql = '';
        $sql = "SELECT users.* FROM users, cliqueRelations WHERE cliqueRelations.isInstructor = 0 AND users.userID = cliqueRelations.userID AND cliqueRelations.cliqueID = " . $cliqueID;
        
        $cliques = $this->db->query($sql);
        $cliques = $cliques->result();

        for($i = 0; $i < count($cliques); $i++){
            $cliques[$i] = get_object_vars($cliques[$i]);
        }
        //var_dump($cliques);
        return $cliques;
    }


    function addHangoutURL($cliqueID,$url){
        $sql = "UPDATE cliques SET hangoutURL = '" . urlencode($url) . "' WHERE cliqueID = " . $cliqueID;
        $this->db->query($sql);
    }

    function getHangoutURL($cliqueID){
        $sql = "SELECT cliques.hangoutURL FROM cliques WHERE cliques.cliqueID = " . $cliqueID; 
        $result = $this->db->query($sql);

        $row = $result->row_array();
        return $row['hangoutURL'];
    }

 
}