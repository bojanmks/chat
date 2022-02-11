<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
        require_once('../../config/connection.php');
        require_once('functions.php');

        if(!isset($_SESSION['user'])) {
            http_response_code(400);
            echo('You need to be logged in.');
            exit();
        }

        $id = $_POST['id'];

        if(declineRequest($id)) {
            http_response_code(200);
            echo(json_encode('Success.'));
        } else {
            http_response_code(400);
            echo('We encountered an error.');
        }
    }
?>