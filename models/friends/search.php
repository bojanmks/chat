<?php
    session_start();

    require_once('../../config/connection.php');
    require_once('functions.php');
    require_once('../functions.php');

    redirectToLogin('../../');

    $keyword = $_GET['keyword'];
    $id = $_SESSION['user']->user_id;

    $users = searchUsers($keyword, $id);

    http_response_code(200);
    echo(json_encode($users));
?>