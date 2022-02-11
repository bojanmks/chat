<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        session_start();

        require_once('../../config/connection.php');
        require_once('functions.php');
        require_once('../functions.php');

        redirectToLogin('../../');

        $file = $_FILES['file'];
        $id = $_SESSION['user']->user_id;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        $errors = [];

        if(!in_array($file['type'], $allowedTypes)) {
            $errors[] = "Allowed file types are: jpg/jpeg, png, gif; ";
        }

        if(!count($errors)) {
            // checks if the username is taken
            list($width, $height) = getimagesize($file['tmp_name']);

            $newWidth = 300;
            $newHeight = $height * ($newWidth / $width);

            switch($file['type']) {
                case 'image/jpeg':
                    $image = imagecreatefromjpeg($file['tmp_name']);
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($file['tmp_name']);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($file['tmp_name']);
                    break;
            }

            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            $imageName = time() . '.jpg';
            imagejpeg($newImage, '../../assets/img/' . $imageName);

            // updates the username
            if(updateImage($id, $imageName)) {
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

        echo(json_encode('Image successfully updated.'));
        exit();
    } else {
        http_response_code(400);
    }
?>