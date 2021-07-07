<?php
require_once "../Classes/initialize.php";
!empty($_GET['searchPage']) ? $searchPage = $DB->escapeValue($_GET['searchPage'],true) : $searchPage = 1;
$recordPerPage = 20;
$startFrom = ($searchPage-1)*$recordPerPage;
if (isset($_POST['commentsSearch']) && !(empty($_POST['commentsSearch'])) && isset($_POST['commentsOrderBy']) && !(empty($_POST['commentsOrderBy']))){
    if ($Users->isStandard())
        $commentsResult = $Comments->searchByTitleOrDescriptionOrUsernameOrEmail('comments',$_POST['commentsSearch'],$_POST['commentsOrderBy']," LIMIT {$startFrom},{$recordPerPage}",true,true);
    elseif ($Users->isAdministrator() || $Users->isAdmin())
        $commentsResult = $Comments->searchByTitleOrDescriptionOrUsernameOrEmail('comments',$_POST['commentsSearch'],$_POST['commentsOrderBy']," LIMIT {$startFrom},{$recordPerPage}",true);
    if ($Funcs->checkValue([$commentsResult],false,true) && $DB->numRows($commentsResult) > 0){  ?>
        <div id="comments-main-result">
            <div id="comment_title_result"></div>
            <div id="comment_description_result"></div>
            <div id="comment_publish_mode_result"></div>
            <div class="container">
                <div class="row">
                    <?php
                    while($commentsRow = $DB->fetchArray($commentsResult)):
                        $userResult = $DB->selectById('users',$commentsRow['user_id']);
                        if($userRow = $DB->fetchArray($userResult)):
                            $divid_date_time = $Funcs->divid_date_time_database($commentsRow['create_at']);
                            $clothesResult = $DB->selectById('clothes',$commentsRow['clothes_id']);
                            if ($Clothes = $DB->fetchArray($clothesResult)): ?>
                                <div class="col-12 col-lg-6">
                                    <div class="Comment_BOX">
                                        <div class="Cover_Comment_Product">
                                            <img src=<?= $Funcs->showPic("../style/images/ProductPics/",$Clothes['pic_loc'],'../style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($Clothes['pic_loc']) ?> />
                                        </div>
                                        <div class="Header_Comment">
                                            <div id='panel-rating-comment' class='rating'><?= $Funcs->starByScore($commentsRow['score']) ?></div>
                                            <div class="Cover_Comment">
                                                <a href="editUser.php?id=<?= htmlspecialchars($userRow['id']) ?>"><img src=<?= $Funcs->showPic('../style/images/UsersPics/' , $userRow['pro_pic'],'../style/images/Defaults/default-user.png') ?> alt='' /></a>
                                            </div>
                                        </div>
                                        <div class="Main_InComment">
                                            <div class="top_Main_COMMMENT">
                                                <p><i class="fa fa-id-card"></i> : <?= $commentsRow['id'] ?></p>
                                                <p><i class="fa fa-id-badge"></i> : <?= $userRow['id'] ?></p>
                                                <p><i class="fa fa-envelope"></i> : <?= $userRow['email'] ?></p>
                                            </div>
                                            <a href="editUser.php?id=<?= htmlspecialchars($userRow['id']) ?>"><span style="float: right;color: #007bff"><?= $userRow['username'] ?></span><br /></a>
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
        </div>
        <?php
    }else
        echo "<p class='product-route' style='position: relative;top: 20px;font-size: 20px;float: right;right: 0;'>Error 404 ! Not Found</p>";
}
?>


<!--                <div class="container">-->
<!--                    <a href="more-Product.php" class="float-right mt-3" style="color: red;text-decoration: none"><i class="fa fa-angle-left" style="margin-right: 10px;"></i> More Product</a>-->
<!--                </div>-->
</div>
<?php $Funcs->commentsSearchPagination('comments',$_POST['commentsSearch'],$_POST['commentsOrderBy'],'id',$searchPage,$recordPerPage); ?>
</div>
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