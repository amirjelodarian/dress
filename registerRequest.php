<?php
include "Classes/initialize.php";
    if (!empty($_GET['username'])){
        $username = $DB->escapeValue($_GET['username']);
        $uniqueResult = $DB->selectAll('username','users'," WHERE username='{$username}'");
        if ($DB->numRows($uniqueResult) !== 0)
            echo " از قبل وجود دارد {$username} کاربر";
    } else if (!empty($_GET['email'])){
        $email = $DB->escapeValue($_GET['email']);
        $uniqueResult = $DB->selectAll('email','users'," WHERE email='{$email}'");
        if ($DB->numRows($uniqueResult) !== 0)
            echo " قبلا ثبت شده {$email} ایمیل";
    }else
        $Funcs->redirectTo('register.php');

?>