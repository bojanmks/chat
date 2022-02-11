<?php
    function redirectToLogin($prefix = '') {
        if(!isset($_SESSION['user'])) {
            header("Location: {$prefix}index.php?page=login");
            exit();
        }
    }

    function redirectToHome($prefix = '') {
        if(isset($_SESSION['user'])) {
            header("Location: {$prefix}index.php?page=home");
            exit();
        }
    }

    function displayMessages() {
        $html = '';

        if(isset($_SESSION['messages'])) {
            $html .= "<div class='alert alert-success text-center mt-2' role='alert'>";
            foreach($_SESSION['messages'] as $m) {
                $html .= $m . "</br>";
            }
            $html .= "</div>";
            unset($_SESSION['messages']);
        }

        if(isset($_SESSION['errors'])) {
            $html .= "<div class='alert alert-warning text-center mt-2' role='alert'>";
            foreach($_SESSION['errors'] as $e) {
                $html .= $e . "</br>";
            }
            $html .= "</div>";
            unset($_SESSION['errors']);
        }

        echo($html);
    }
?>