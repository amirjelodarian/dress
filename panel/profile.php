<?php include "../Incluedes/panel-menu.php"; ?>
    <!--            Start-for-dashboard-->
<?php
use \Validate\Validate;
use \Functions\Functions;
!empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
$recordPerPage = 36;
$startFrom = ($page-1)*$recordPerPage;
if (isset($_GET['deleteComment'])){
    $deleteCommentId = $DB->escapeValue($_GET['deleteCommentId'],true);
    $Comments->deleteComment($deleteCommentId,'editUser.php');
}
?>
<div class="main-col">
    <div id="comment_title_result"></div>
    <div id="comment_description_result"></div>
    <div id="comment_publish_mode_result"></div>
    <div class="account-status">
        <br />
        <h1><?= $users->username ?></h1>
        <?php
            switch ($users->account_status){
                case "verified":
                    ?><img src="../style/images/SitePics/verified.png" alt="Verified" />
                    <div id="for-dashboard">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                            <label for="edit-profile-panel" id="edit-profile-panel-icon"><img id="user-profile-pic" src=<?= $Funcs->showPic('../style/images/UsersPics/' , $users->pro_pic,'../style/images/Defaults/default-user.png') ?> alt="" /><span class="add-picture">+</span></label>
                            <input type="file" name="uploadProFile" id="edit-profile-panel" />
                            <input type='hidden' name='MAX_FILE_SIZE' value='2097152' />
                            <div class="input-for-dashboard">
                                <input type="text" id="edit-profile-inputs" class="panel-username" name="username" value="<?= $users->username ?>" placeholder="تغییر نام کاربری"><br /><br />
                                <input type="text" id="edit-profile-inputs" class="panel-username" name="first_name" value="<?= $users->first_name ?>" placeholder="نام"><br /><br />
                                <input type="text" id="edit-profile-inputs" class="panel-username" name="last_name" value="<?= $users->last_name ?>" placeholder="نام خانوادگی"><hr />
                                <input type="text" id="edit-profile-inputs" class="panel-username" name="tell" minlength="8" maxlength="11" value="<?= $users->tell ?>" placeholder="شماره تلفن"><hr />
                                <textarea type="text"  class="panel-address" cols="25" rows="4" minlength="3" maxlength="1000" name="address" placeholder="آدرس"><?= $users->address ?></textarea><br />
                                <img id="captcha" style="width: 80px;margin-top: 17px;height: 30px" src=<?= $Funcs->showCaptcha() ?> /><input id="captcha-input" name="captcha" placeholder="کد مقابل را وارد کنید"  min="5" max="5" required /><br />
                                <div id='username-panel-message'></div>
                                <input type="submit" name="userInfoSubmit" id="edit-profile-submit" value="ثبت تغییرات">
                            </div>
                        </form>
                        <?php
                        if(isset($_POST['userInfoSubmit'])){
                            Validate::validate([
                                $_POST['username'] => 'required|min:3|max:255',
                                $_POST['first_name'] => 'required|min:3|max:255',
                                $_POST['last_name'] => 'required|min:3|max:255',
                                $_POST['tell'] => 'required|min:8|max:11|tell',
                                $_POST['address'] => 'required|min:3|max:1000'
                            ],[
                                $_POST['captcha'] => $_SESSION['randomCode']
                            ]);
                            if (Validate::$errors == ""){
                                if(Validate::fileUploadEmpty('uploadProFile'))
                                    $users->editUser([$_POST['username'], $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['tell']], $_POST['username']);
                                else
                                    $users->editUser([$_POST['username'], $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['tell']], $_POST['username'],'uploadProFile');

                            }
                            if (Validate::showErrors()){
                                echo "<div class='e-message'>";
                                foreach (Validate::showErrors() as $error)
                                    echo "<p>{$error}</p>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="changePassword">
                        <p class="changePasswordBtn"><span class="bottom-icon">⌄</span> تغییر کلمه عبور</p>
                        <div id="for-dashboard" class="changePasswordInside">
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                                <input type="password" name="password" id="edit-profile-inputs" placeholder="رمز جدید">
                                <input type="password" name="confirmPassword" id="edit-profile-inputs" placeholder="تکرار رمز جدید"><br />
                                <img id="captcha" style="width: 80px;margin-top: 17px;height: 30px" src=<?= $Funcs->showCaptcha() ?> /><input id="captcha-input" name="captcha" placeholder="کد مقابل را وارد کنید"  min="5" max="5" required /><br />
                                <input type="submit" name="userChangePasswordSubmit" id="edit-profile-submit" value="تایید">
                            </form>
                            <?php
                            if(isset($_POST['userChangePasswordSubmit'])){
                                Validate::validate([
                                    $_POST['password'] => 'required|min:8|max:255',
                                    $_POST['confirmPassword'] => 'required|min:8|max:255'
                                ],[
                                    $_POST['password'] => $_POST['confirmPassword'],
                                    $_POST['captcha'] => $_SESSION['randomCode']
                                ]);
                                if (Validate::$errors == ""){
                                    $DB->update('users', 'password', $Funcs->encrypt_decrypt('encrypt',$_POST['password']), "WHERE id = {$users->id}");
                                    $_SESSION['errorMessage'] .= "رمز با موفقیت تغییر کرد = {$_POST['password']}";
                                    $Funcs->redirectTo('profile.php');
                                }
                                if (Validate::showErrors()){
                                    echo "<div class='e-message'>";
                                    foreach (Validate::showErrors() as $error)
                                        echo "<p>{$error}</p>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    break;
                case "not_verified":
                    ?><img src="../style/images/SitePics/not-verified.png" alt="Verified" /><br />
                    <span class="text-panel">برای تایید حساب کاربری روی دکمه زیر کلیک کنید تا کد تایید به ایمیل شما ارسال شود</span>
                    <br /><br />
                    <input name="email" id="email-verify-panel" value="<?= $users->email ?>" />
                    <input type="submit" class="btn btn-dark" name="sendEmailVerifyPanel" id="send-email-verify-panel" value="ارسال کد">
                    <div class="single-product-message" id="verify-message"></div>
                    <div class="loader-outside">
                        <div class="loader"></div>
                    </div>
                    <?php
                    break;
            }
        ?>
        <br />
        <hr />
    </div>
    <div class="container">
        <div class="row">
            <?php
            $commentsResult = $Comments->selectCommentByUserId($Users->id,$startFrom,$recordPerPage);
            while($commentsRow = $DB->fetchArray($commentsResult)):
                $clothesResult = $DB->selectById('clothes',$commentsRow['clothes_id']);
                if ($Clothes = $DB->fetchArray($clothesResult)):
                     $allResult = $DB->selectById('users',$Users->id);
                        if ($userRow = $DB->fetchArray($allResult)):
                    $divid_date_time = $Funcs->divid_date_time_database($commentsRow['create_at']);
                    ?>

                    <div class="col-12 col-lg-6">
                        <div class="Comment_BOX">
                            <div class="Cover_Comment_Product">
                                <img src=<?= $Funcs->showPic("../style/images/ProductPics/",$Clothes['pic_loc'],'../style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($Clothes['pic_loc']) ?> />
                            </div>
                            <div class="Header_Comment">
                                <div id='panel-rating-comment' class='rating'><?= $Funcs->starByScore($commentsRow['score']) ?></div>
                                <div class="Cover_Comment">
                                    <img src=<?= $Funcs->showPic('../style/images/UsersPics/' , $userRow['pro_pic'],'../style/images/Defaults/default-user.png') ?> alt='' />
                                </div>
                            </div>
                            <div class="Main_InComment">
                                <div class="top_Main_COMMMENT">
                                    <p><i class="fa fa-id-card"></i> : <?= $commentsRow['id'] ?></p>
                                    <p><i class="fa fa-envelope"></i> : <?= $userRow['email'] ?></p>
                                </div>
                                <span style="float: right;color: #007bff"><?= $userRow['username'] ?></span><br />
                                <div class="Bottom_Main_COMMMENT">
                                    <p><i class="fa">موضوع</i> : <span id="<?= $commentsRow['id'] ?>" class='comment-title'><?= $commentsRow['title'] ?></span></p>
                                    <p><i class="fa">نظر</i> : <span id="<?= $commentsRow['id'] ?>" class='comment-description'><?= nl2br($commentsRow['description']) ?></span></p>
                                    <?php if($Users->isAdministrator() || $Users->isAdmin()): ?>
                                        <select name="comment_publish_mode" class="comment-publish-mode">
                                            <option value="publish_<?= $commentsRow['id'] ?>" <?= $Funcs->ifEqual('published',$commentsRow['publish_mode'],'selected') ?>>Publish</option>
                                            <option value="unpublish_<?= $commentsRow['id'] ?>" <?= $Funcs->ifEqual('unpublished',$commentsRow['publish_mode'],'selected') ?>>UnPublish</option>
                                        </select><br />
                                    <?php endif; ?>
                                    <small id='panel-date-comment'><?= $Funcs->EnFa($Funcs->dateTimeToJalaliDate($divid_date_time[1],'/',true),true) ?></small>
                                    <small class='icon-clock-8' id='panel-time-comment'><?= $Funcs->EnFa($divid_date_time[0],true) ?></small>
                                    <div class='comment-panel-btns col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                        <a href='../singleProduct.php?id=<?= $commentsRow["clothes_id"] ?>'>
                                            <p id='see-room-btn' class='submit_edit'>بازدید اتاق</p>
                                        </a>
                                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" style="display: inline-block">
                                            <input name="deleteCommentId" type="hidden" value='<?= $commentsRow["id"] ?>' />
                                            <input name="id" value='<?= $id ?>' type="hidden" />
                                            <input type="submit" name="deleteComment" id="AreYouSure" class="delete-comment-panel-btn" value='حذف' />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    endif;
                endif;
            endwhile;
            ?>
        </div>
    </div>

    <?php $Funcs->userCommentPagination('comments','id',$page,$recordPerPage,$Users->id); ?>
    <div class="col-sm-3 col-md-3 col-lg-3"></div>
    <script>
        <?php if($Users->isAdministrator() || $Users->isAdmin()): ?>
        $(document).ready(function(){
            $("#comment_publish_mode_result").hide();
            $("#comment_title_result").hide();
            $("#comment_description_result").hide();
            $('.comment-publish-mode').click(function (){
                var commentPublishModeValue = this.value;
                $.ajax({
                    url: "editCommentsRequests.php",
                    method: "post",
                    dataType: "text",
                    // beforeSend: function() {
                    //     $('.loader-outside').fadeIn(500);
                    // },
                    data: {commentPublishModeValue: commentPublishModeValue},
                    success:function (data) {
                        $("#comment_publish_mode_result").show();
                        $("#comment_publish_mode_result").html(data);
                    }
                });
            });
        });
        $(function () {
            //Loop through all Labels with class 'editable'.
            $('.comment-title').click(function (){
                $(".comment-title").each(function () {
                    //Reference the Label.
                    var label = $(this);
                    //Add a TextBox next to the Label.
                    label.after("<input type = 'text' style = 'display:none;direction: rtl' />");

                    //Reference the TextBox.
                    var textbox = $(this).next();

                    //Set the name attribute of the TextBox.
                    textbox[0].name = this.id.replace("lbl", "txt");

                    //Assign the value of Label to TextBox.
                    textbox.val(label.html());

                    //When Label is clicked, hide Label and show TextBox.
                    label.click(function () {
                        $(this).hide();
                        $(this).next().show();
                    });

                    //When focus is lost from TextBox, hide TextBox and show Label.
                    textbox.focusout(function () {
                        $(this).hide();
                        $(this).prev().html($(this).val());
                        $(this).prev().show();
                        var commentTitleId = this.name;
                        var commentTitleValue = this.value;
                        $.ajax({
                            url: "editCommentsRequests.php",
                            method: "post",
                            dataType: "text",
                            // beforeSend: function() {
                            //     $('.loader-outside').fadeIn(500);
                            // },
                            data: {commentTitleId: commentTitleId,commentTitleValue: commentTitleValue},
                            success:function (data) {
                                $("#comment_title_result").show();
                                $("#comment_title_result").html(data);
                            }
                        });
                    });
                });

            });

            $('.comment-description').click(function (){
                $(".comment-description").each(function () {
                    //Reference the Label.
                    var label = $(this);
                    //Add a TextBox next to the Label.
                    label.after("<textarea type = 'text' style = 'display:none;direction: rtl'></textarea>");

                    //Reference the TextBox.
                    var textbox = $(this).next();

                    //Set the name attribute of the TextBox.
                    textbox[0].name = this.id.replace("lbl", "txt");

                    //Assign the value of Label to TextBox.
                    textbox.val(label.html());

                    //When Label is clicked, hide Label and show TextBox.
                    label.click(function () {
                        $(this).hide();
                        $(this).next().show();
                    });

                    //When focus is lost from TextBox, hide TextBox and show Label.
                    textbox.focusout(function () {
                        $(this).hide();
                        $(this).prev().html($(this).val());
                        $(this).prev().show();
                        var commentDescriptionId = this.name;
                        var commentDescriptionValue = this.value;
                        $.ajax({
                            url: "editCommentsRequests.php",
                            method: "post",
                            dataType: "text",
                            // beforeSend: function() {
                            //     $('.loader-outside').fadeIn(500);
                            // },
                            data: {commentDescriptionId: commentDescriptionId,commentDescriptionValue: commentDescriptionValue},
                            success:function (data) {
                                $("#comment_description_result").show();
                                $("#comment_description_result").html(data);
                            }
                        });
                    });
                });

            });

        });
        <?php endif; ?>
    </script>
</div>
    <!--            End-for-dashboard-->
<?php include "../Incluedes/panel-footer.php"; ?>
