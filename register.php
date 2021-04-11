<?php
require_once "Classes/initialize.php";
$Funcs->pageTitle = "ثبت نام";
include "Incluedes/header.php";
use \Validate\Validate;
use \Sessions\Sessions;
use \Functions\Functions;
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
            <p>ثبت نام</p>
        </div>
    </div>
    <div class="Sign-Up text-center">
            <label for="profile2" class="profile"><i class="fa fa-user"></i></label><br/>
            <label id="add-pic-text-register" for="profile2">عکس پروفایل +</label>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="uploadProFile" id="profile2">
            <input type='hidden' name='MAX_FILE_SIZE' value='2097152' />
            <div id='username-message'></div>
            <label for="username"><i class="fa fa-user"></i></label>
            <input type="text" name="username" placeholder="نام کاربری" id="username" autocomplete="off" required />
            <div id='email-message'></div>
            <label for="ٍEmail"><i class="fa fa-envelope"></i></label>
            <input type="text" name="email" placeholder="ایمیل" id="email" required />
            <label for="password"><i class="fa fa-lock"></i></label>
            <input type="password" name="password" placeholder="رمز عبور" id="password" required />
            <label for="confirm"><i class="fa fa-key"></i></label>
            <input type="password" name="confirmPassword" placeholder="تکرار رمز عبور" id="confirm" required /><hr />

            <img id="captcha" src=<?= $Funcs->showCaptcha() ?> /><input id="captcha-input" name="captcha" placeholder="کد مقابل را وارد کنید"  min="5" max="5" required />

<!--            <div class="remember">-->
<!--                <label for="remember">شرایط و قوانین سایت را مطالعه کرده و قیول دارم .</label>-->
<!--                <input type="checkbox" id="remember">-->
<!--            </div>-->
            <input type="submit" name="registerSubmit" value="ثبت نام">
        </form>
        <div class="TextLink">
            <a href="login.php">حساب کاربری دارید ؟ <span style="font-weight:bold;">وارد شوید</span></a>
        </div>
        <?php
        if (isset($_POST['registerSubmit'])){
            Validate::validate([
                $_POST['username'] => 'required|min:3|max:255|unique:users:username',
                $_POST['email'] => 'required|email|max:255|unique:users:email',
                $_POST['password'] => 'required|min:8|max:255',
                $_POST['confirmPassword'] => 'required|min:8|max:255'
            ],[
                $_POST['password'] => $_POST['confirmPassword'],
                $_POST['captcha'] => $_SESSION['randomCode']
            ]);
            if (Validate::showErrors()){
                echo "<div class='e-message'>";
                    foreach (Validate::showErrors() as $error)
                        echo "<p>{$error}</p>";
                echo "</div>";
            }
            if (Validate::$errors == ""){
                if(Validate::fileUploadEmpty('uploadProFile'))
                    $Users->addUser([$_POST['username'],$_POST['password'],$_POST['email'],$Funcs::nowDataTime(),$Funcs::nowDataTime()],'',$_POST['username'],$_POST['email'],$_POST['password'],$redirect);
                else
                    $Users->addUser([$_POST['username'],$_POST['password'],$_POST['email'],$Funcs::nowDataTime(),$Funcs::nowDataTime()],'uploadProFile',$_POST['username'],$_POST['email'],$_POST['password'],$redirect);
            }


        }
        ?>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="style/js/app.js"></script>