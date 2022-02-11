<?php
    if(isset($_POST['btnSave'])) {
        session_start();

        require_once('../../config/connection.php');
        require_once('functions.php');
        require_once('../functions.php');

        redirectToLogin('../../');

        $password = $_POST['password'];
        $id = $_SESSION['user']->user_id;

        $errors = [];

        if(strlen($password) < 3) {
            $errors[] = "Your password needs to be at least 3 characters long; ";
        }

        if(!count($errors)) {
            // updates the password
            if(updatePassword($id, $password)) {
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