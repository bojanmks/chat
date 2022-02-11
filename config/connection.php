<?php
    require_once('config.php');
    try {
        $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    } catch (PDOException $ex) {
        echo("Connection error: " . $ex->getMessage());
    }

    function executeQuery($query) {
        global $conn;
        return $conn->query($query)->fetchAll();
    }

    function updateErrorLog($message) {
        $file = fopen(ERROR_LOG, 'a');
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $dateAndTime = date('d-m-Y h:i:s');
        $text = $ipAddress . SEPARATOR . $dateAndTime . SEPARATOR . $message . "\n";
        fwrite($file, $text);
        fclose($file);
    }
?>