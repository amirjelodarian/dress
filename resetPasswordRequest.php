<?php
require_once "Classes/initialize.php";
if (!empty($_POST['resetPasswordInput']) && !empty($_POST['resetPasswordInputConfirm'])){
    $password = $_POST['resetPasswordInput'];
    $confirmPassword = $_POST['resetPasswordInputConfirm'];
    if ($password == $confirmPassword){
        $checkValue = true;
        if (strlen($password) < 8){
            $checkValue = false;
            echo "رمز بیشتر از 8 رقم باشد";
        }
        if(strlen($password) > 255){
            $checkValue = false;
            echo "رمز کمتر از 255 رقم باشد";
        }
        if ($checkValue == true){
            $password = $DB->escapeValue($password);
            $DB->update('users','password',$password," WHERE email='{$_SESSION['resetPasswordEmail']}'");
            $_SESSION['errorMessage'] = "رمز با موفقیت تغییر کرد = {$password}";
            $Funcs->redirectTo('login.php',true);
        }
    }else
        echo "مغایرت در تکرار رمز";
}
if (!empty($_GET['selfResetPasswordCode'])){
    if ($_SESSION['randomCode'] == $_GET['selfResetPasswordCode']){
        ?>
        <input type="password" name="resetPasswordInput" id="resetPasswordInput" placeholder="رمز جدید">
        <input type="password" name="resetPasswordInputConfirm" id="resetPasswordInputConfirm" placeholder="تکرار رمز جدید">
        <input type="submit" onclick="resetPasswordLastStep(this)" name="submitResetPasswordSuccess" value="تغییر رمز">
        <div class="reset-password-last-e-message"></div>
        <?php
    }else{
        ?><div style="background: #FFBABA;font-family: IRANSansW"><?php
            echo "کد وارد شده اشتباه است"; ?>
          </div><?php
    }
}
if (!empty($_GET['emailOrUsername'])) {
    $emailOrUsername = $DB->escapeValue($_GET['emailOrUsername']);
    if(filter_var($emailOrUsername,FILTER_VALIDATE_EMAIL)){
        $result = $DB->selectAll('email','users'," WHERE email='{$emailOrUsername}'");
        if ($DB->numRows($result) !== 0){
            $code = $Funcs->rnd(['from' => 10000,'to' => 99999]);
            $_SESSION['randomCode'] = $code;
            $_SESSION['resetPasswordEmail'] = $emailOrUsername;
            $Funcs->sendMail($emailOrUsername,$code);
            ?>
            <p>کد ارسال شده به ایمیل را وارد کنید</p>
            <input type="text" id="selfResetPasswordCode" style="padding: 0" name="selfResetPasswordCode" min="5" max="5" required />
            <button class="btn btn-primary" onclick="resetPassword()">تایید</button>
            <div id="messageResetPasswordCode" class="e-message"></div>
            <?php
        }else{
            ?><div class="e-message"><?php
                echo "کاربری با این ایمیل وجود ندارد"; ?>
              </div><?php
        }
    }else{
        $result = $DB->selectAll('email','users'," WHERE username='{$emailOrUsername}'");
        if ($DB->numRows($result) !== 0){
            if ($userEmail = $DB->fetchArray($result)){ $useremail = $userEmail['email']; }
            $code = $Funcs->rnd(['from' => 10000,'to' => 99999]);
            $_SESSION['randomCode'] = $code;
            $_SESSION['resetPasswordEmail'] = $useremail;
            $Funcs->sendMail($useremail,$code);
            ?>
            <p>کد ارسال شده به ایمیل را وارد کنید</p>
            <p><?= $Funcs->hideEmail($useremail) ?></p>
            <input type="text" id="selfResetPasswordCode" style="padding: 0" name="selfResetPasswordCode" min="5" max="5" required />
            <button class="btn btn-primary" onclick="resetPassword()">تایید</button>
            <div id="messageResetPasswordCode" class="e-message"></div>
            <?php
        }else{
            ?><div class="e-message"><?php
                echo "کاربری با این نام وجود ندارد"; ?>
              </div><?php
        }
    }
}
?>