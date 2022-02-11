<?php
    redirectToLogin();
    if(!isset($_GET['user'])) {
        header("Location: index.php?page=home");
        exit();
    } else {
        require_once('models/friends/functions.php');
        $userId = $_SESSION['user']->user_id;
        $friendId = $_GET['user'];
        if(!areFriends($userId, $friendId)) {
            header("Location: index.php?page=home");
            exit();
        }

        require_once('models/users/functions.php');
        $friend = getUser('user_id', $friendId);
    }
?>
<a href="index.php?page=home" class="font-large">
    <i class="fas fa-arrow-left"></i>
</a>
<hr/>
<span class="d-flex align-items-center mb-2">
    <span id="userImage" class="me-2">
        <img src="assets/img/<?= $friend->image ?>" alt="<?= $friend->username ?>" class="img-fluid d-block"/>
    </span>
    <label class="font-medium"><?= $friend->username ?></label>
</span>
<div id="messagesContainer" class="rounded p-3">
</div>
<form id="sendMessageForm" class="mt-2">
    <div class="row w-100 m-0">
        <div class="col-11 p-0">
            <textarea id="tbMessage" class="form-control beige-border font-small" maxlength="500"></textarea>
        </div>
        <div class="col-1 p-0 d-flex align-items-center">
            <a href="#" id="btnSendMessage" class="btn p-0 w-100 h-100 d-flex align-items-center justify-content-center"><i class="fa fa-paper-plane font-small" aria-hidden="true"></i></a>
        </div>
    </div>
</form>