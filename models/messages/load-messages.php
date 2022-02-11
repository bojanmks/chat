<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
        require_once('../../config/connection.php');
        require_once('functions.php');

        $receiverId = $_POST['receiver'];

        if(!isset($_SESSION['user'])) {
            echo('You need to be logged in.');
            http_response_code(400);
            exit();
        }

        $senderId = $_SESSION['user']->user_id;

        require_once('../friends/functions.php');
        if(!areFriends($senderId, $receiverId)) {
            http_response_code(400);
            exit();
        }

        $messages = getMessages($senderId, $receiverId);

        http_response_code(200);
        echo(json_encode($messages));
    } else {
        http_response_code(400);
    }
?>