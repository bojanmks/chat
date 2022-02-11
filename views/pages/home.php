<?php
    redirectToLogin();
    $user = $_SESSION['user'];
?>
<div id="userBar" class="d-flex justify-content-between align-items-center">
    <div id="userImageAndName" class="d-flex align-items-center">
        <div id="userImage" class="d-flex align-items-center me-2">
            <img src="assets/img/<?= $user->image ?>" alt="<?= $user->username ?>" class="img-fluid d-block"/>
        </div>
        <label class="font-medium"><?= $user->username ?></label>
    </div>
    <div id="userButtons">
        <a href="index.php?page=edit" class="btn btn-primary font-xs">Edit</a>
        <a href="models/users/logout.php" class="btn btn-primary font-xs">Log out</a>
    </div>
</div>
<hr/>
<div id="friendsSection">
    <label class="font-medium mb-1">Friends:</label>
    <ul id="friendsList" class="p-0 m-0">
    </ul>
</div>
<hr/>
<a href="index.php?page=add-friends" class="font-xs btn btn-primary">Add friends</a>
<?php
    require_once('models/requests/functions.php');
    $requests = getRequests($user->user_id);
?>
<a href="index.php?page=requests" class="btn font-small">Requests (<?= count($requests); ?>)</a>