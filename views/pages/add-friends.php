<?php
    redirectToLogin();
?>
<a href="index.php?page=home" class="font-large">
    <i class="fas fa-arrow-left"></i>
</a>
<hr/>
<form>
    <div class="row w-100 m-0">
        <div class="col-9 p-0 m-0">
            <input type="text" id="tbAddFriend" class="form-control rounded-0 rounded-start beige-border font-small" placeholder="Username"/>
        </div>
        <div class="col-3 p-0 m-0">
            <a href="#!" class="btn btn-primary d-block h-100 rounded-0 rounded-end disabled font-small"><i class="fas fa-search"></i></a>
        </div>
    </div>
</form>
<hr/>
<ul id="searchList" class="p-0">
</ul>
<?php
    displayMessages();
?>