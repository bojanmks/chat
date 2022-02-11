<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        session_start();
        require_once('../../config/connection.php');
        require_once('functions.php');

        if(!isset($_SESSION['user'])) {
            http_response_code(400);
            echo('You need to be logged in.');
        }

        $id = $_SESSION['user']->user_id;
        $userId = $_POST['userId'];

        if(removeFriend($id, $userId)) {
            http_response_code(200);
            echo(json_encode('Friend removed.'));
        } else {
            http_response_code(500);
            echo('We encountered an error.');
        }
    } else {
        http_response_code(400);
    }
?>