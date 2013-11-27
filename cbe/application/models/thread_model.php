<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class thread_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    //sends a message to a user
    //needs the user ID of the sender, user ID of the reciever, and array with message details
    //message = (date, content)
    function sendMessage($senderID,$recieverID,$message){
    	$sql = "INSERT INTO privateMessages(senderID, recipientID, content) VALUES (" .
            $senderID . "," .
            $recieverID . ",'" .
            $message . "')";
        $this->db->query($sql);
    }

    function getMessages($userID){
        $sql = "SELECT privateMessages.*, users.username FROM privateMessages,users WHERE privateMessages.recipientID = " . $userID . " AND privateMessages.isInvite = " . 0 . " AND users.userID = privateMessages.senderID";
       // var_dump($sql);
        $result = $this->db->query($sql);
        $result = $result->result();
        for($i = 0; $i < count($result);$i++){
            $result[$i] = get_object_vars($result[$i]);
        }
        //var_dump($result);
        return $result;
    }

    function getThreads($userID){
        $sql = "SELECT * FROM (SELECT privateMessages.*, users.username FROM privateMessages,users where ((privateMessages.recipientID=".$userID." AND users.userID = privateMessages.senderID) OR (privateMessages.senderID = ".$userID." AND users.userID = privateMessages.recipientID)) AND privateMessages.isInvite = 0 ORDER BY privateMessages.messageDate DESC) as custom GROUP BY username ORDER BY messageDate DESC";
        //echo $sql . "<br/>";
        $result = $this->db->query($sql);
        $result = $result->result();
        if(count($result) > 0){
            for($i = 0; $i < count($result);$i++){
                $result[$i] = get_object_vars($result[$i]);
            }
        }
        //var_dump($result);
        return $result;
    }

    function getConversation($userID,$otherID){
        $sql = "SELECT DISTINCT privateMessages.*, users.username FROM privateMessages, users WHERE 
        (privateMessages.recipientID = " . $userID . " AND privateMessages.senderID = ".$otherID." AND users.userID = ".$otherID.") OR (privateMessages.senderID = ". $userID ." AND privateMessages.recipientID = ".$otherID." AND users.userID = " . $userID.") ORDER BY privateMessages.messageDate DESC LIMIT 0,5" ;
        //var_dump($sql);
        $result = $this->db->query($sql);
        $result = $result->result();
        for($i = 0; $i < count($result);$i++){
            $result[$i] = get_object_vars($result[$i]);
        }
        //var_dump($result);
        return $result;
    }

    function getInvites($userID){
        $sql = "SELECT privateMessages.*, users.username FROM  privateMessages, users WHERE privateMessages.recipientID = " . $userID . " AND privateMessages.isInvite = ". 1 . " AND privateMessages.isRead = ". 0 . " AND users.userID = privateMessages.senderID";
        $result = $this->db->query($sql);
        $result = $result->result();
        for($i = 0; $i < count($result);$i++){
            $result[$i] = get_object_vars($result[$i]);
        }
        return $result;
    }

    //given the id of a message, deletes said message
    function deleteMessage($messageID){
        $sql = "DELETE FROM `privateMessages` WHERE messageID = " . $messageID;
        $this->db->query($sql);
    }

    //gets a full thread given the parent message
    function getMessageThread($parentID){
    	$sql = "INSERT INTO privateMessages(senderID, recipientID, content) VALUES (" .
            $senderID . "," .
            $recieverID . ",'" .
            $message . "')";
        $this->db->query($sql);
    }

    //sends an invite to a clique
    function sendInvite($senderID, $recieverID, $cliqueID){
        $sql = "INSERT INTO privateMessages(senderID, recipientID, content,isInvite) VALUES (" .
            $senderID . "," .
            $recieverID . "," .
            $cliqueID . "," .
            true . ")";
        $this->db->query($sql);
    }


/*
    -new clique is added to clique table
    -new chat room is created with cliqueID
    -both the invited user and the user who sent the invite are added to the new clique (cliqueRelations Table)
*/

    //adds user to the clique and deletes the message
    function acceptInvite($messageID, $userID){
        $inviteData = $this->getMessage($messageID);
        var_dump($inviteData);
        if(is_numeric($inviteData['content'])){
            $this->addUserToClique($userID, 0+$inviteData['content']);
        }
        else{
            $cliqueID = $this->createClique($inviteData['content'], 9005577);
            $this->addUserToClique($inviteData['senderID'],$cliqueID);
            $this->addUserToClique($userID, $cliqueID);
        }
        $this->markMessageRead($messageID);
        
        
    }

    function createClique($cliqueName,$cliqueParent){
        $sql = "INSERT INTO cliques(cliqueName, cliqueParent) VALUES ('" . $cliqueName . "'," . $cliqueParent . ")";
        $this->db->query($sql);

        $sql = "SELECT cliqueID FROM cliques WHERE cliqueName = '" . $cliqueName . "'";
        $result = $this->db->query($sql);
        $row = $result->row_array();

        $this->createChatroom($cliqueName, $row['cliqueID']);

        return $row['cliqueID'];
    }

    function createChatroom($cliqueName, $cliqueID){
        $sql = "INSERT INTO chatRooms (roomParent, roomName) VALUES (" . $cliqueID . ",'".$cliqueName." Study Lounge')";
        $this->db->query($sql);
        return true;
    }

    function addUserToClique($userID, $cliqueID){
        $sql = "INSERT INTO cliqueRelations (cliqueID, userID) VALUES (". $cliqueID .",". $userID .")";
        $this->db->query($sql);
    }

    function getMessage($messageID){
        $sql = "SELECT * FROM privateMessages WHERE messageID = ".$messageID;
        $result = $this->db->query($sql);
        $row = $result->row_array();
        //var_dump($row);
        return $row;
    }

    function getLatestMessages($userID){
        $sql = "SELECT FROM privateMessages";
    }

    function markMessageRead($messageID){
        $sql = "UPDATE privateMessages SET isRead = 1 WHERE messageID = ". $messageID;
        $this->db->query($sql);
    }

}

