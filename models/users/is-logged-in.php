<?php
    session_start();

    if(isset($_SESSION['user'])) {
        http_response_code(200);
        echo(json_encode('User is logged in.'));
    } else {
        http_response_code(400);
        echo("User isn't logged in");
    }
?>