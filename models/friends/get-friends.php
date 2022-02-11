<?php
    session_start();
    require_once('../../config/connection.php');
    require_once('functions.php');

    if(!isset($_SESSION['user'])) {
        http_response_code(400);
        echo('You need to be logged in.');
        exit();
    }

    $id = $_SESSION['user']->user_id;

    $friends = getFriends($id);

    foreach($friends as $f) {
        $userId = $f->user_id;
        $alive = 0;
        $file = file(STILL_ALIVE_LOG);
        foreach($file as $row) {
            $row = trim($row);
            $values = explode(SEPARATOR, $row);
            $fileUserId = $values[0];
            $time = intval($values[1]);
            if($fileUserId == $userId && time() - $time <= 10) {
                $alive = 1;
                break;
            }
        }
        $f->online = $alive;

        // unread messages
        require_once('../messages/functions.php');
        $f->unreadMessages = count(getUnreadMessages($id, $userId));
    }

    http_response_code(200);
    echo(json_encode($friends));
?>