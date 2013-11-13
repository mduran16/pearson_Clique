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

    function getClique($name){
        $id = $this->db->query("SELECT cliqueID FROM cliques WHERE cliqueName = '" . $name . "'");
        $row = $id->row_array();
        return $row['cliqueID'];
    }

    function getUserCliques($userID,$parent){
        $sql = '';
        if($parent == false)
            $sql = "SELECT cliques.* FROM cliques, cliqueRelations WHERE cliques.cliqueID = cliqueRelations.cliqueID AND cliqueRelations.userID = " . $this->session->userdata("id");
        elseif($this->session->userdata("role") == "PROF" || $this->session->userdata("role") == "TAST")
            $sql = "SELECT cliques.* FROM cliques, cliqueRelations WHERE cliques.cliqueID = cliqueRelations.cliqueID AND cliques.cliqueParent = " . $parent;
        else
            $sql = "SELECT cliques.* FROM cliques, cliqueRelations WHERE cliques.cliqueID = cliqueRelations.cliqueID AND cliqueRelations.userID = " . $this->session->userdata("id") . " AND cliques.cliqueParent = " . $parent;
        
        $cliques = $this->db->query($sql);
        $cliques = $cliques->result();

        for($i = 0; $i < count($cliques); $i++){
            $cliques[$i] = get_object_vars($cliques[$i]);
        }
        return $cliques;
    }

    function getCourseCliques($parent){
        $sql = "SELECT cliques.* FROM cliques, cliqueRelations WHERE cliques.cliqueID = cliqueRelations.cliqueID AND cliques.cliqueParent = " . $parent;
        
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

    function addUserToClique($cliqueID, $userID){
        $addUser = "INSERT INTO cliqueRelations (cliqueID, userID) VALUES (". $cliqueID . ",". $userID .")";
        $query = $this->db->query($addUser);
    }



    function getCliqueUsers($cliqueID){
        $sql = '';
        $sql = "SELECT users.* FROM users, cliqueRelations WHERE users.userID = cliqueRelations.userID AND cliqueRelations.cliqueID = " . $cliqueID;
        
        $cliques = $this->db->query($sql);
        $cliques = $cliques->result();

        for($i = 0; $i < count($cliques); $i++){
            $cliques[$i] = get_object_vars($cliques[$i]);
        }
        //var_dump($cliques);
        return $cliques;
    }

 
}