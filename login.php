<?php
require_once "Classes/initialize.php";
$Funcs->pageTitle = "ورود به سیستم";
include "Incluedes/header.php";
use \Validate\Validate;
if ($SS->loggedIn()) $Funcs->redirectTo('product.php');

if (!empty($_GET['from']))
    $_SESSION['redirect'] = $_GET['from']; 
elseif(!empty($_SESSION['redirect']))
    $redirect = $_SESSION['redirect'];
else
    $redirect = 'product.php';
?>

<div class="login-box" id="auth">
    <div id="header-for-login">
        <div class="L-login active" id="login2">
            <p>ورود</p>
        </div>
    </div>
    <div id="main-for-login" class="text-center">
        <label for="profile" class="profile"><i class="fa fa-user"></i></label>
        <div class="input-box-for-login">
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method='POST'>
                <label for="user">
                    <i class="fa fa-user"></i>
                </label>
                <input type="text" placeholder="ایمیل یا نام کاربری" id="user" name="usernameOrEmail" required />
                <label for="pass">
                    <i class="fa fa-lock"></i>
                </label>
                <input type="password" placeholder="رمز عبور" id="pass" name="password" required /><hr />
                <img id="captcha" src=<?= $Funcs->showCaptcha() ?> /><input id="captcha-input" name="captcha" placeholder="کد مقابل را وارد کنید"  min="5" max="5" required /><br />
                <input type="submit" name="loginSubmit" class="login-btn" value="ورود">
            </form><br />
        </div>
        <a href="resetPassword.php" class="text-center forget-password">فراموشی رمز عبور</a>
        <div class="TextLink">
            <a href="register.php">حساب کاربری ندارید ؟ <span style="font-weight:bold;">ثبت نام کنید</span></a>
        </div>
        <?php
        if (isset($_POST['loginSubmit'])){
            Validate::validate([
                $_POST['usernameOrEmail'] => 'required|min:3|max:255',
                $_POST['password'] => 'required|min:8|max:255',
            ],[
                $_POST['captcha'] => $_SESSION['randomCode']
            ]);
            if (Validate::showErrors()){
                echo "<div class='e-message'>";
                foreach (Validate::showErrors() as $error)
                    echo "<p>{$error}</p>";
                echo "</div>";
            }
            if (Validate::$errors == ""){
                echo "<div class='e-message'><p>";
                $Users->selectByUsernameOrEmailAndPassword($_POST['usernameOrEmail'],$Funcs->encrypt_decrypt('encrypt',$_POST['password']),$redirect);
                echo "</p></div>";
            }


        }
        ?>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="style/js/app.js"></script>