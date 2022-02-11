<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();
        require_once('../../config/connection.php');
        require_once('functions.php');
        require_once('../users/functions.php');

        if(!isset($_SESSION['user'])) {
            http_response_code(400);
            echo("You need to be logged in.");
            exit();
        }

        $receiverId = $_POST['id'];
        $senderId = $_SESSION['user']->user_id;

        $receiverExists = getUser('user_id', $receiverId);
        if($receiverExists) {
            $request = requestExists($senderId, $receiverId);
            if($request) {
                if($request->accepted == 1) {
                    http_response_code(400);
                    echo('Already friends with user.');
                } else {
                    if($request->user_id1 == $senderId) {
                        http_response_code(400);
                        echo('Request already sent.');
                    } else if($request->user_id2 == $senderId) {
                        if(addFromRequest($senderId, $receiverId)) {
                            http_response_code(200);
                            header('Content-type: application/json');
                            echo(json_encode("Friends"));
                        } else {
                            http_response_code(500);
                            echo('We encountered an error.');
                        }
                    }
                }
            } else {
                if(sendRequest($senderId, $receiverId)) {
                    http_response_code(200);
                    header('Content-type: application/json');
                    echo(json_encode("Request sent"));
                } else {
                    http_response_code(500);
                    echo("We encountered an error.");
                }
            }
        } else {
            http_response_code(400);
            echo("User doesn't exist.");
        }
    } else {
        http_response_code(400);
    }
?>