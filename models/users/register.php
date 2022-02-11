<?php
    if(isset($_POST['btnRegister'])) {
        session_start();

        require_once('../../config/connection.php');
        require_once('functions.php');

        $username = $_POST['username'];
        $password = $_POST['password'];

        $errors = [];

        if(strlen($username) < 3 || strlen($username) > 30) {
            $errors[] = "Your username needs to be between 3 and 30 characters long; ";
        }

        if(strlen($password) < 3) {
            $errors[] = "Your password needs to be at least 3 characters long; ";
        }

        if(getUser('username', $username)) {
            $errors[] = "That username is taken; ";
        }

        if(!count($errors)) {
            if(registerUser($username, $password)) {
                $_SESSION['messages'] = ["Account successfully created."];
                http_response_code(200);
            } else {
                http_response_code(500);
                $_SESSION['errors'] = ["We encountered an error."];
            }
        } else {
            http_response_code(400);
            $_SESSION['errors'] = $errors;
        }

        header('Location: ../../index.php?page=register');
        exit();
    } else {
        http_response_code(400);
    }
?>