<?php
    redirectToLogin();
    $user = $_SESSION['user'];
?>
<a href="index.php?page=home" class="font-large">
    <i class="fas fa-arrow-left"></i>
</a>
<hr/>
<div id="userInfo" class="d-flex flex-column align-items-center justify-content-center">
    <form action="#">
        <input type="file" name="image" id="fileImage" class="d-none"/>
    </form>
    <label for="fileImage" class="mb-3">
        <div id="userImageBig" class="overflow-hidden d-flex align-items-center position-relative">
            <img src="assets/img/<?= $user->image ?>" alt="<?= $user->username ?>" class="img-fluid d-block"/>
            <div class="cover d-flex align-items-center justify-content-center">
                <p class="font-small m-0">Update image</p>
            </div>
        </div>
    </label>
    <div id="username" class="align-items-center justify-content-center mb-1">
        <label class="me-2 font-large"><?= $user->username ?></label>
        <a href="#" id="btnEditUsername" class="font-small"><i class="fas fa-edit"></i></a>
    </div>
    <div id="editUsername" class="mb-2">
        <form action="models/users/edit-username.php" method="POST">
            <div class="row">
                <div class="col-8 p-0 m-0">
                    <input type="text" name="username" id="tbEditUsername" class="form-control font-small text-center rounded-0 rounded-start beige-border" value="<?= $user->username ?>" maxlength="30" autocomplete="off"/>
                </div>
                <div class="col-4 p-0 m-0">
                    <input type="submit" value="Save username" name="btnSave" class="btn btn-primary font-xs h-100 rounded-0 rounded-end"/>
                </div>
            </div>
        </form>
    </div>
    <a href="#" id="btnEditPassword" class="font-medium">Update password</a>
    <div id="editPassword" class="mt-2">
        <form action="models/users/edit-password.php" method="POST">
            <div class="row">
                <div class="col-8 p-0 m-0">
                    <input type="password" name="password" id="tbEditPassword" class="form-control font-small text-center rounded-0 rounded-start beige-border"/>
                </div>
                <div class="col-4 p-0 m-0">
                    <input type="submit" value="Save password" name="btnSave" class="btn btn-primary font-xs h-100 rounded-0 rounded-end"/>
                </div>
            </div>
        </form>
    </div>
    <a href="models/users/delete-account.php" id="btnDeleteAccount" class="font-small mt-4">Delete account</a>
</div>
<?php
    displayMessages();
?>