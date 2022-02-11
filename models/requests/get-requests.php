<?php
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        session_start();
        require_once('../../config/connection.php');
        require_once('functions.php');

        if(!isset($_SESSION['user'])) {
            http_response_code(400);
            echo('You need to be logged in.');
            exit();
        }

        $id = $_SESSION['user']->user_id;

        $requests = getRequests($id);

        http_response_code(200);
        echo(json_encode($requests));
    } else {
        http_response_code(400);
    }
?>