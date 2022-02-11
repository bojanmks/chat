<?php
    function getUser($column, $value) {
        global $conn;
        $exec = $conn->prepare("SELECT user_id, username, password, image, u.role_id, role_name FROM users u INNER JOIN roles r ON u.role_id = r.role_id WHERE $column = ?");
        $exec->execute([$value]);
        return $exec->fetch();
    }

    function registerUser($username, $password) {
        $encPass = md5($password);
        try {
            global $conn;
            $exec = $conn->prepare("INSERT INTO users(username, password) VALUES (?, ?)");
            $result = $exec->execute([$username, $encPass]);
            return $result;
        } catch (PDOException $ex) {
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    // edit user

    function updateUsername($id, $username) {
        try {
            global $conn;
            $exec = $conn->prepare("UPDATE users SET username = ? WHERE user_id = ?");
            $result = $exec->execute([$username, $id]);
            return $result;
        } catch (PDOException $ex) {
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    function updatePassword($id, $password) {
        $encPass = md5($password);
        try {
            global $conn;
            $exec = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $result = $exec->execute([$encPass, $id]);
            return $result;
        } catch (PDOException $ex) {
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    function updateImage($id, $imageName) {
        try {
            global $conn;
            $exec = $conn->prepare("UPDATE users SET image = ? WHERE user_id = ?");
            $result = $exec->execute([$imageName, $id]);
            return $result;
        } catch (PDOException $ex) {
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    function reloadSession() {
        if(isset($_SESSION['user'])) {
            $id = $_SESSION['user']->user_id;
            $user = getUser('user_id', $id);
            $_SESSION['user'] = $user;
        }
    }

    function deleteAccount($id) {
        try {
            global $conn;
            $conn->beginTransaction();

            $exec = $conn->prepare('DELETE FROM messages WHERE sender_id = ? OR receiver_id = ?');
            $exec->execute([$id, $id]);

            $exec = $conn->prepare('DELETE FROM friends WHERE user_id1 = ? OR user_id2 = ?');
            $exec->execute([$id, $id]);

            $exec = $conn->prepare('DELETE FROM users WHERE user_id = ?');
            $exec->execute([$id]);

            $conn->commit();
            unset($_SESSION['user']);

            return true;
        } catch(PDOException $ex) {
            $conn->rollback();
            updateErrorLog($ex->getMessage());
            return false;
        }
    }

    // still alive
    function clearFile() {
        $text = "";
        $file = file(STILL_ALIVE_LOG);
        foreach($file as $f) {
            $f = trim($f);
            $values = explode(SEPARATOR, $f);
            $time = intval($values[1]);
            if(time() - $time < 60 * 10) {
                $text .= $f . "\n";
            }
        }
        $fileToWrite = fopen(STILL_ALIVE_LOG, 'w');
        fwrite($fileToWrite, $text);
        fclose($fileToWrite);
    }
?>