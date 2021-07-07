<?php
require_once "Classes/initialize.php";
$Funcs->pageTitle = "فراموشی رمز";
include "Incluedes/header.php";
use \Validate\Validate;
if ($SS->loggedIn()) $Funcs->redirectTo('product.php');
?>

<div class="login-box" id="auth">

    <!--Start-Forgot-Password-->
    <div class="forgot-box" id="forgot">
        <i class="fa fa-lock"></i><br><br>
        <h5>رمز عبور خود را فراموش کردید ؟</h5>
        <p>نام کاربری یا ایمیل خود را وارد کنید</p>
        <label for="imail2"><i class="fa fa-envelope"></i></label>
        <input type="text" placeholder="ایمیل یا نام کاربری" name="emailOrUsername" id="emailOrUsername">
        <input type="submit" id="reset-password-btn" value="ارسال کد به ایمیل">
        <div id="reset-password-message"></div>
        <div class="loader-outside">
            <div class="loader"></div>
        </div>
        <br>
    </div>

    <!--End-Forgot-Password-->
</div>
<script type="text/javascript" src="style/js/app.js"></script>
</body>
</html>