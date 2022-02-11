<?php
    session_start();
    require_once('../../config/connection.php');
    require_once('functions.php');
    require_once('../functions.php');

    redirectToLogin();

    $userId = $_SESSION['user']->user_id;

    if(deleteAccount($userId)) {
        http_response_code(200);
        $_SESSION['messages'] = ['Account successfully deleted.'];
        header('Location: ../../index.php?page=login');
    } else {
        http_response_code(500);
        $_SESSION['errors'] = ["We encountered an error."];
        header('Location: ../../index.php?page=edit');
    }
?>