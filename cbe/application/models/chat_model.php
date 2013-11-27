<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chat_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getChatMessages($id){
        $getMessages = "SELECT chatMessages.*,users.username FROM chatMessages, users WHERE chatRoomID = " . $id . " AND users.userID = chatMessages.userID ORDER BY chatMessages.date DESC LIMIT 0,20";
        $messages = $this->db->query($getMessages);
        $messages = $messages->result();

        for($i = 0; $i < count($messages); $i++){
            $messages[$i] = get_object_vars($messages[$i]);
        }
        return $messages;
    
    }

    function addMessage($parentID,$userID, $message){
        $addMessage = "INSERT INTO chatMessages(chatRoomID,userID,message) VALUES (" . $parentID . ",'" . $userID . "','" . $message . "')";
        $addMessage = $this->db->query($addMessage);
        //var_dump($addMessage);
    }

    function deleteMessage(){
        return true;
    }


    function configureChat($parentID){
        $sql = "SELECT * FROM chatRooms WHERE roomParent = " . $parentID;
        $result = $this->db->query($sql);
        $row = $result->row_array();
        return $row;
    }

    function getLatestMessages($chatID, $latestID){
        $sql = "SELECT chatMessages.*, users.username FROM chatMessages, users WHERE chatMessages.chatRoomID = " . $chatID . " AND chatMessages.message_id >" .  $latestID . " AND users.userID = chatMessages.userID";
        $messages = $this->db->query($sql);
        $messages = $messages->result();
        for($i = 0; $i < count($messages); $i++){
            $messages[$i] = get_object_vars($messages[$i]);
        }
        return $messages;
    }

}