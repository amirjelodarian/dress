<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $Funcs->pageTitle ?></title>
    <link rel="stylesheet" href="../style/css/style.css">
    <link rel="stylesheet" href="../style/bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script type="text/javascript" src="../style/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../style/jquery/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../style/js/app.js"></script>
    <script type="text/javascript" src="../style/jquery/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="../style/fontawesome/fontawesome-free-5.14.0-web/css/all.min.css">
</head>
<?php
require_once "../Classes/initialize.php";
if (!empty($_GET['code'])) {
    if ($_GET['code'] == $_SESSION['randomCode']) {
        $DB->update('users', 'account_status', 'verified', " WHERE id={$_SESSION['userId']}");
        $_SESSION['errorMessage'] = "حساب شما با موفقیت تایید شد";
        $Funcs->redirectTo('profile.php',true);
    }else{
        echo "کد وارد شده اشتباه است";
    }
}
if (isset($_GET['sendEmailVerifyPanel']) && !empty($_GET['email'])){
    $users->fillUserAttribute($_SESSION['userId']);
    $email = $DB->escapeValue($_GET['email']);
    $uniqueResult = $DB->selectAll('email','users'," WHERE email='{$email}'");
    if ($DB->numRows($uniqueResult) !== 0){
        if ($userEmailRow = $DB->fetchArray($uniqueResult))
            $allUsersEmail = $userEmailRow['email'];
    }else
        $allUsersEmail = false;

    switch ($email){
        case $users->email:
            $_SESSION['randomCode'] = $Funcs->rnd(['from' => 10000, 'to' => 99999]);
            $Funcs->sendMail($users->email, $_SESSION['randomCode']);
            ?>
            <hr />
            <input type="text" id="selfCode" name="code" min="5" max="5" required />
            <button class="btn btn-primary" id="submitCode" name="submitCode">تایید</button>
            <div id="code-message"></div>
            <?php
            break;

        case $email !== $users->email && $allUsersEmail == false:
            $DB->update('users', 'email', $email," WHERE id={$_SESSION['userId']}");
            $_SESSION['randomCode'] = $Funcs->rnd(['from' => 10000, 'to' => 99999]);
            $Funcs->sendMail($email, $_SESSION['randomCode']);
            ?>
            <hr />
            <input type="text" id="selfCode" name="code" min="5" max="5" required />
            <button class="btn btn-primary" id="submitCode" name="submitCode">تایید</button>
            <div id="code-message"></div>
            <?php
            break;

        case $email !== $users->email && $email == $allUsersEmail:
                echo " قبلا ثبت شده و برای کاربر دیگری است {$email} ایمیل";
            break;
    }
}
?>
