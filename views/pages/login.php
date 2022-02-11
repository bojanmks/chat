<?php
    redirectToHome();
?>
<h1 class="font-large text-center">Login</h1>
<form action="models/users/login.php" method="POST" id="loginForm" class='font-small'>
    <div class="mb-2">
        <label for="tbUsername">Username:</label>
        <input type="text" name="username" id="tbUsername" class="form-control font-small login-field" maxlength="30" autocomplete="off"/>
    </div>
    <div class="mb-3">
        <label for="tbPassword">Password:</label>
        <input type="password" name="password" id="tbPassword" class="form-control font-small login-field"/>
    </div>
    <input type="submit" value="Log in" name="btnLogin" class='d-block mx-auto btn btn-primary font-small'/>
</form>
<a href="index.php?page=register" class="font-small">
    Don't have an account?
    <br/>
    Register instead.
</a>
<?php
    displayMessages();
?>