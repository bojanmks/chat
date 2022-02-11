<?php
    redirectToHome();
?>
<h1 class="font-large text-center">Register</h1>
<form action="models/users/register.php" method="POST" id="registerForm" class='font-small'>
    <div class="mb-2">
        <label for="tbUsername">Username:</label>
        <input type="text" name="username" id="tbUsername" class="form-control font-small login-field" maxlength="30" autocomplete="off"/>
    </div>
    <div class="mb-3">
        <label for="tbPassword">Password:</label>
        <input type="password" name="password" id="tbPassword" class="form-control font-small login-field"/>
    </div>
    <input type="submit" value="Register" name="btnRegister" class='d-block mx-auto btn btn-primary font-small'/>
</form>
<a href="index.php?page=login" class="font-small">
    Already have an account?
    <br/>
    Log in instead.
</a>
<?php
    displayMessages();
?>