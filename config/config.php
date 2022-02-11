<?php
    // absolute path
    define('ABSOLUTE_PATH', $_SERVER['DOCUMENT_ROOT'] . "/");

    // files
    define('ENV_FILE', ABSOLUTE_PATH . 'config/.env');
    define('ERROR_LOG', ABSOLUTE_PATH . 'data/error.log');
    define('STILL_ALIVE_LOG', ABSOLUTE_PATH . 'data/still_alive.txt');
    define('SEPARATOR', "\t");

    // db
    define('SERVER', env('SERVER'));
    define('DATABASE', env('DATABASE'));
    define('USERNAME', env('USERNAME'));
    define('PASSWORD', env('PASSWORD'));
    
    function env($keyword) {
        $file = file(ENV_FILE);
        foreach($file as $line) {
            $line = trim($line);
            $lineContent = explode('=', $line);
            if($lineContent[0] == $keyword) {
                return $lineContent[1];
            }
        }
    }
?>