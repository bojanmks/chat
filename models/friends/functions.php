<?php
    function searchUsers($keyword, $id) {
        global $conn;
        $exec = $conn->prepare("SELECT * FROM users WHERE username LIKE ? AND user_id <> ? ORDER BY username");
        $param = "%" . $keyword . "%";
        $exec->execute([$param, $id]);
        $users = $exec->fetchAll();
        foreach($users as $u) {
            $u->friends = 0;
            $u->alreadySent = 0;
            require_once('../requests/functions.php');
            $request = requestExists($id, $u->user_id);
            if($request) {
                if($request->accepted == 1) {
                    $u->friends = 1;
                } else {
                    if($request->user_id1 == $id) {
                        $u->alreadySent = 1;
                    }
                }
            }
        }
        return $users;
    }

    function getFriends($id) {
        global $conn;
        $exec = $conn->prepare('SELECT * FROM users u INNER JOIN friends f ON f.user_id2 = u.user_id WHERE f.user_id1 = ? AND f.accepted = 1 ORDER BY username');
        $exec->execute([$id]);
        return $exec->fetchAll();
    }

    function removeFriend($user1, $user2) {
        try {
            global $conn;
            $exec = $conn->prepare('DELETE FROM friends WHERE (user_id1 = ? AND user_id2 = ?) OR (user_id2 = ? AND user_id1 = ?)');
            $result = $exec->execute([$user1, $user2, $user1, $user2]);
            return $result;
        } catch (PDOException $ex) {
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    function areFriends($user1, $user2) {
        global $conn;
        $exec = $conn->prepare('SELECT * FROM friends WHERE user_id1 = ? AND user_id2 = ? AND accepted = 1');
        $exec->execute([$user1, $user2]);
        return $exec->fetch();
    }
?>