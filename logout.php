<?php
require_once "Classes/initialize.php";
if ($SS->loggedIn())
    $SS->logOut('product.php');
else
    $Funcs->redirectTo('register.php');
?>