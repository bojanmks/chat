<?php

?><?php
    if(isset($_POST['btnLogin'])) {
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

        if(!count($errors)) {
            $user = getUser('username', $username);
            $encPass = md5($password);

            if($user->password == $encPass) {
                $_SESSION['user'] = $user;
                http_response_code(200);
            } else {
                $_SESSION['errors'] = ["Invalid credentials; "];
                http_response_code(400);
            }
        } else {
            http_response_code(400);
            $_SESSION['errors'] = $errors;
        }

        header('Location: ../../index.php?page=login');
        exit();
    } else {
        http_response_code(400);
    }
?>