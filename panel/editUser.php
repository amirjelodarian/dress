<?php
include "../Incluedes/panel-menu.php";
if(!($Users->isAdministrator() || $Users->isAdmin()))
  $Funcs->redirectTo('profile.php');
if (isset($_POST['editUser'])) {
    $id = $DB->escapeValue($_POST['id'],true);
    if ($_FILES['uploadFile']['size'] == 0 && $_FILES['uploadFile']['name'] == "")
        if ($users->user_mode == "administrator") 
            $Users->editPanelUser([$_POST["first_name"], $_POST["last_name"], $_POST["tell"], $_POST["address"],$_POST['user_mode']],'',$_POST['id']);
        else
            $Users->editPanelUser([$_POST["first_name"], $_POST["last_name"], $_POST["tell"], $_POST["address"]],'',$_POST['id']);

    else{
      if ($users->user_mode == "administrator")
          $Users->editPanelUser([$_POST["first_name"], $_POST["last_name"], $_POST["tell"], $_POST["address"],$_POST['user_mode']], "uploadFile",$_POST['id']);
      else
          $Users->editPanelUser([$_POST["first_name"], $_POST["last_name"], $_POST["tell"], $_POST["address"]], "uploadFile",$_POST['id']);
    }
}
if (isset($_GET['deletePanelUser'])){
    $deletePanelUserId = $DB->escapeValue($_GET['deletePanelUserId'],true);
    $Users->deletePanelUser($deletePanelUserId);
}

if (isset($_GET['deleteImgPanelUser']) && isset($_GET['deletePanelUserId'])){
    $deleteImgPanelUser = $DB->escapeValue($_GET['deletePanelUserId'],true);
    $Users->deleteImgPanelUser($deleteImgPanelUser);
}
!empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
$recordPerPage = 36;
$startFrom = ($page-1)*$recordPerPage;
if (isset($_GET['id'])) {
  $id = $DB->escapeValue($_GET['id'],true);

    if (isset($_GET['deleteComment']) && isset($_GET['id'])){
        $id = $DB->escapeValue($_GET['id'],true);
        $deleteCommentId = $DB->escapeValue($_GET['deleteCommentId'],true);
        $Comments->deleteComment($deleteCommentId,'editUser.php?id='.$id);
    }
  ?>
<div class="main-col">
    <div id="comment_title_result"></div>
    <div id="comment_description_result"></div>
    <div id="comment_publish_mode_result"></div>
    <!--        Start-Man-Pirhan-Product-->
    <div class="container" id="Pirhan2">
        <div class="row ManProduct">
            <? $allResult = $DB->selectById('users',$id);
            if ($Funcs->checkValue($allResult,false,true) && $DB->numRows($allResult) > 0) {
                if ($allRow = $DB->fetchArray($allResult)) {
                  if ($allRow['user_mode'] == "administrator" && $users->id !== $allRow['id']) {
                    echo "Access Denied";
                    die();
                  }
                  ?>
                  <div class="return"><a href="usersList.php">< بازگشت</a></div>
                    <div class="col-sm-3 col-md-3 col-lg-3"></div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="product product1" id="user-edit-form">
                            <div class="img-Product">
                              <?php
                              switch ($allRow['account_status']){
                                  case "verified": ?>
                                      <img style="width: 15px;height: 15px" src="../style/images/SitePics/verified.png" alt="Verified" /><?php
                                      break;
                                  case "not_verified": ?>
                                      <img style="width: 15px;height: 15px" src="../style/images/SitePics/not-verified.png" alt="Verified" /><?php
                                      break;
                              }
                              ?>
                                <div class="del-btn">
                                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                                        <input name="deletePanelUserId" type="hidden" value='<?= $allRow["id"] ?>' />
                                        <input type="submit" name="deletePanelUser" id="deleteProduct" style="width: 100px" value='حذف کاربر' /><br />
                                        <input type="submit" name="deleteImgPanelUser" id="deleteImgProduct" value='حذف عکس' />
                                    </form>
                                </div>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="post">
                                <img id="edit-product-img" src=<?= $Funcs->showPic("../style/images/UsersPics/",$allRow['pro_pic'],'../style/images/Defaults/default-user.png'); ?> alt=<?= stripslashes($allRow['pro_pic']) ?> />
                                    <input type="hidden" name="id" value="<?= $allRow['id'] ?>" />
                                    <label for="add-product" id="uploadImageIcon"><i class="fa fa-image">+</i></label>
                                    <input type="file" name="uploadFile" id="add-product" class="uploadImageInput" />
                                <input type='hidden' name='MAX_FILE_SIZE' value='2097152' />
                            </div>
                            <div>
                                <div class="textProduct">
                                  <div class="container">
                                      <select name="user_mode">
                                        <?php if ($Users->isAdministrator()): ?>
                                          <option value="administrator" <?= $Funcs->returnSomeThingByEqualTwoVal($allRow['user_mode'],'administrator','selected') ?>>مدیر</option>
                                        <?php endif; ?>
                                        <option value="admin" <?= $Funcs->returnSomeThingByEqualTwoVal($allRow['user_mode'],'admin','selected') ?>>ادمین</option>
                                        <option value="standard" <?= $Funcs->returnSomeThingByEqualTwoVal($allRow['user_mode'],'standard','selected') ?>>استاندارد</option>
                                      </select>
                                      <span>سطح دسترسی</span>
                                  </div>
                                  <div class="container">
                                      <br /><span>نام</span>
                                      <input id="editpage-inputs" name="first_name" placeholder="نام" value="<?= $allRow['first_name'] ?>" />
                                  </div><br />
                                  <div class="container">
                                      <span>نام خانوادگی</span>
                                      <input id="editpage-inputs" name="last_name" placeholder="نام خانوادگی" value="<?= $allRow['last_name'] ?>" />
                                  </div><br />
                                  <div class="container">
                                      <span>شماره تلفن</span>
                                      <input class="limitToNumber" id="editpage-inputs" name="tell" placeholder="شماره تلفن" value="<?= $allRow['tell'] ?>" />
                                  </div><br />
                                  <div class="container">
                                      <span>آدرس</span>
                                      <textarea name="address" placeholder="آدرس"><?= $allRow['address'] ?></textarea>
                                  </div><br />
                                </div>
                                <br />
                                <input type="submit" class="submit-edit-user" id="add-product-submit" name="editUser" value="ویرایش" />
                                </form>
                                <!--                            <div class="submit">-->
                                <!--                                <div class="container">-->
                                <!--                                    <form action="">-->
                                <!--                                        <input type="submit" value="ثبت سفارش">-->
                                <!--                                    </form>-->
                                <!--                                </div>-->
                                <!--                            </div>-->
                                <br>
                            </div>
                        </div>
                    </div>
         <div class="container">
            <div class="row">
         <?php
            $commentsResult = $Comments->selectCommentByUserId($id,$startFrom,$recordPerPage);
            while($commentsRow = $DB->fetchArray($commentsResult)):
                $clothesResult = $DB->selectById('clothes',$commentsRow['clothes_id']);
                if ($Clothes = $DB->fetchArray($clothesResult)):
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
                            <img src=<?= $Funcs->showPic('../style/images/UsersPics/' , $allRow['pro_pic'],'../style/images/Defaults/default-user.png') ?> alt='' />
                        </div>
                    </div>
                    <div class="Main_InComment">
                        <div class="top_Main_COMMMENT">
                            <p><i class="fa fa-id-card"></i> : <?= $commentsRow['id'] ?></p>
                            <p><i class="fa fa-envelope"></i> : <?= $allRow['email'] ?></p>
                        </div>
                        <span style="float: right;color: #007bff"><?= $allRow['username'] ?></span><br />
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
                endwhile;
            ?>
        </div>
    </div>

                        <?php $Funcs->userCommentPagination('comments','id',$page,$recordPerPage,$id); ?>
                    <div class="col-sm-3 col-md-3 col-lg-3"></div>
                    <?
                }
            }else
                echo "<p class='product-route' style='position: relative;top: 20px;font-size: 20px;float: right;right: 0;'>Error 404 ! Not Found</p>";
            ?>

            <!--                <div class="container">-->
            <!--                    <a href="more-Product.php" class="float-right mt-3" style="color: red;text-decoration: none"><i class="fa fa-angle-left" style="margin-right: 10px;"></i> More Product</a>-->
            <!--                </div>-->
        </div>
    </div>
    <!--        End-Man-Pirhan-Product-->


    <!--        Start-Man-T-shrt-Product-->

    <!--        End-Man-womanZhakat-Product-->
    <!--End-For-womMan-->

</div>
    <?php if($Users->isAdministrator() || $Users->isAdmin()): ?>
    <script>
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
<?php
}
 include "../Incluedes/panel-footer.php"; ?>
