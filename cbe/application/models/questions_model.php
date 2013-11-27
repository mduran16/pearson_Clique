<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class questions_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    //adds a question from a user to a clique given the userid, cliqueid, and content
    //content = (date, question)
    function askQuestion($userID, $cliqueID, $title, $content){
        //INSERT INTO `questions`(`questionID`, `questionName`, `authorID`, `questionDate`, `questionContent`, `cliqueID`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
        $sql = "INSERT INTO questions (questionName, authorID, questionContent, cliqueID) VALUES ('" . $title . "'," .
            $userID . ",'" . $content . "'," . $cliqueID . ")";
        $this->db->query($sql);
    }

    //given the id of a question, deletes it
    function deleteQuestion($questionID){
        $sql = "DELETE FROM `questions` WHERE questionID = " . $questionID;
        $this->db->query($sql);
    }

    //adds answer to a question
    //content = (date, content)
    function answerQuestion($userID,$questionID,$content){
    	$sql = "INSERT INTO questions (authorID, questionContent, questionParent) VALUES (". $userID .",'". $content ."',". $questionID .")";
        $this->db->query($sql);
    }

    //returns an array of all questions asked in a certain clique
    function getQuestions($cliqueID){
    	$sql = "SELECT questions.*, users.username from questions,users where cliqueID = " . $cliqueID . " AND questions.questionParent = 0 AND users.userID = questions.authorID";
        $result = $this->db->query($sql);
        $result = $result->result();
        for($i = 0; $i < count($result);$i++){
            $result[$i] = get_object_vars($result[$i]);
        }
        //var_dump($result);
        return $result;
    }

    function getQuestionThread($questionID){
        $sql = "SELECT questions.*, users.username FROM questions, users where (questions.questionID = " . $questionID . " OR questions.questionParent = " . $questionID . ") AND users.userID = questions.authorID";
        $result = $this->db->query($sql);
        $result = $result->result();
        for($i = 0; $i < count($result);$i++){
            $result[$i] = get_object_vars($result[$i]);
        }

        return $result;
    }
}