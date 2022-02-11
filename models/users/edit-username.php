<?php
    if(isset($_POST['btnSave'])) {
        session_start();
        
        require_once('../../config/connection.php');
        require_once('functions.php');
        require_once('../functions.php');

        redirectToLogin('../../');

        $username = $_POST['username'];
        $id = $_SESSION['user']->user_id;

        $errors = [];

        if(strlen($username) < 3 || strlen($username) > 30) {
            $errors[] = "Your username needs to be between 3 and 30 characters long; ";
        }

        if(!count($errors)) {
            // checks if the username is taken
            $user = getUser('username', $username);

            if($user) {
                if($user->user_id != $id) {
                    http_response_code(400);
                    $_SESSION['errors'] = ['That username is taken.'];
                    header('Location: ../../index.php?page=edit');
                    exit();
                }
            }

            // updates the username
            if(updateUsername($id, $username)) {
                http_response_code(200);
                reloadSession();
            } else {
                http_response_code(500);
                $_SESSION['errors'] = ['We encountered an error.'];
            }
        } else {
            http_response_code(400);
            $_SESSION['errors'] = $errors;
        }

        header('Location: ../../index.php?page=edit');
        exit();
    } else {
        http_response_code(400);
    }
?>