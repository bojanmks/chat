<?php
    function getRequests($id) {
        global $conn;
        $exec = $conn->prepare("SELECT * FROM friends f INNER JOIN users u ON u.user_id = f.user_id1 WHERE user_id2 = ? AND accepted = 0");
        $exec->execute([$id]);
        return $exec->fetchAll();
    }

    function requestExists($sender, $receiver) {
        global $conn;
        $exec = $conn->prepare('SELECT * FROM friends WHERE (user_id1 = ? AND user_id2 = ?) OR (user_id2 = ? AND user_id1 = ?)');
        $exec->execute([$sender, $receiver, $sender, $receiver]);
        return $exec->fetch();
    }

    function addFromRequest($sender, $receiver) {
        try {
            global $conn;
            $conn->beginTransaction();
            $exec = $conn->prepare("UPDATE friends SET accepted = 1 WHERE user_id1 = ? AND user_id2 = ?");
            $exec->execute([$receiver, $sender]);
            $exec = $conn->prepare("INSERT INTO friends(user_id1, user_id2, accepted) VALUES (?, ?, 1)");
            $exec->execute([$sender, $receiver]);
            $conn->commit();
            return true;
        } catch (PDOException $ex) {
            $conn->rollback();
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    function sendRequest($sender, $receiver) {
        try {
            global $conn;
            $exec = $conn->prepare('INSERT INTO friends(user_id1, user_id2) VALUES (?, ?)');
            $result = $exec->execute([$sender, $receiver]);
            return $result;
        } catch (PDOException $ex) {
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    function acceptRequest($id) {
        try {
            global $conn;
            $conn->beginTransaction();
            $exec = $conn->prepare('UPDATE friends SET accepted = 1 WHERE friends_id = ?');
            $exec->execute([$id]);
            $exec = $conn->prepare("SELECT * FROM friends WHERE friends_id = ?");
            $exec->execute([$id]);
            $lastRow = $exec->fetch();
            $exec = $conn->prepare('INSERT INTO friends(user_id1, user_id2, accepted) VALUES (?, ?, 1)');
            $exec->execute([$lastRow->user_id2, $lastRow->user_id1]);
            $conn->commit();
            return true;
        } catch (PDOException $ex) {
            $conn->rollback();
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    function declineRequest($id) {
        try {
            global $conn;
            $exec = $conn->prepare('DELETE FROM friends WHERE friends_id = ?');
            $result = $exec->execute([$id]);
            return $result;
        } catch (PDOException $ex) {
            updateErrorLog($ex->getMessage());
            return false;
        }
    }
?>