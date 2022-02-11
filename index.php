<?php
    session_start();
    require_once('config/connection.php');
    require_once('models/functions.php');

    require_once('views/fixed/head.php');
?>
<div id="main" class="d-flex align-items-center justify-content-center">
    <div id="container" class="p-3 rounded shadow">
        <?php
            if(isset($_GET['page'])) {
                switch($_GET['page']) {
                    case 'home':
                        require_once('views/pages/home.php');
                        break;
                    case 'edit':
                        require_once('views/pages/edit.php');
                        break;
                    case 'add-friends':
                        require_once('views/pages/add-friends.php');
                        break;
                    case 'requests':
                        require_once('views/pages/requests.php');
                        break;
                    case 'messages':
                        require_once('views/pages/messages.php');
                        break;
                    case 'login':
                        require_once('views/pages/login.php');
                        break;
                    case 'register':
                        require_once('views/pages/register.php');
                        break;
                    default:
                        require_once('views/pages/home.php');
                }
            } else {
                require_once('views/pages/home.php');
            }
        ?>
    </div>
</div>
<?php
    require_once('views/fixed/scripts.php');
?>