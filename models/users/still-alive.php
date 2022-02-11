<?php
    session_start();
    if(isset($_SESSION['user'])) {
        require_once('../../config/connection.php');
        require_once('functions.php');

        clearFile();

        $id = $_SESSION['user']->user_id;
        $file = fopen(STILL_ALIVE_LOG, 'a');
        $text = $id . SEPARATOR . time() . "\n";
        fwrite($file, $text);
        fclose($file);
    }
?>