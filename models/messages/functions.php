<?php
    function sendMessage($sender, $receiver, $message) {
        try {
            global $conn;
            $exec = $conn->prepare('INSERT INTO messages(sender_id, receiver_id, messageContent) VALUES (?, ?, ?)');
            $result = $exec->execute([$sender, $receiver, $message]);
            return $result;
        } catch(PDOException $ex) {
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    function getMessages($senderId, $receiverId) {
        global $conn;
        $exec = $conn->prepare('SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY message_id');
        $exec->execute([$senderId, $receiverId, $receiverId, $senderId]);
        return $exec->fetchAll();
    }

    function messagesRead($sender, $receiver) {
        try {
            global $conn;
            $exec = $conn->prepare('UPDATE messages SET isRead = 1 WHERE sender_id = ? AND receiver_id = ?');
            $result = $exec->execute([$sender, $receiver]);
            return $result;
        } catch(PDOException $ex) {
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    function getUnreadMessages($receiver, $sender) {
        global $conn;
        $exec = $conn->prepare('SELECT * FROM messages WHERE sender_id = ? AND receiver_id = ? AND isRead = 0');
        $exec->execute([$sender, $receiver]);
        return $exec->fetchAll();
    }
?>