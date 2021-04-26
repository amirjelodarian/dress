<?php include "../Incluedes/panel-menu.php"; ?>
<?php
!empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
$recordPerPage = 20;
$startFrom = ($page-1)*$recordPerPage;
!empty($_GET['publish_mode']) ? $publish_mode = $DB->escapeValue($_GET['publish_mode']) : $publish_mode = 'published';

if (isset($_GET['deleteComment'])){
    $id = $DB->escapeValue($_GET['deleteCommentId'],true);
    $Comments->deleteComment($id);
}
if (!empty($_GET['orderBy']) && !empty($_GET['keyword'])) $searchMode = true;
else $searchMode = false;

if ($searchMode){
    !empty($_GET['searchPage']) ? $searchPage = $DB->escapeValue($_GET['searchPage'],true) : $searchPage = 1;
    $searchRecordPerPage = 20;
    $searchStartFrom = ($searchPage-1)*$searchRecordPerPage;
    if (!empty($_GET['keyword']) && !empty($_GET['orderBy'])) {
        if ($Users->isStandard())
            $commentsResult = $Comments->searchByTitleOrDescriptionOrUsernameOrEmail('comments',$_GET['keyword'],$_GET['orderBy']," LIMIT {$startFrom},{$recordPerPage}",true,true);
        elseif ($Users->isAdministrator() || $Users->isAdmin())
            $commentsResult = $Comments->searchByTitleOrDescriptionOrUsernameOrEmail('comments',$_GET['keyword'],$_GET['orderBy']," LIMIT {$startFrom},{$recordPerPage}",true);
    }
}else{
    if ($Users->isStandard())
        $commentsResult = $Comments->selectCommentStandardUser($publish_mode,$startFrom,$recordPerPage);
    elseif ($Users->isAdministrator() || $Users->isAdmin())
        $commentsResult = $Comments->allComments($publish_mode,$startFrom,$recordPerPage);
}

?>
<div class="main-col">
    <div class="panel-search">
        <input type="text" name="commentsSearch" id="comments-search" class="panel-search-bar"  placeholder="Search" />
        <select name="commentsOrderBy" id="comments-order-by" class="order-by">
            <option value="comment_title">موضوع</option>
            <option value="comment_description">نظر</option>
            <option value="comment_username">نام کاربری</option>
            <option value="comment_user_id">آیدی کاربر</option>
            <option value="comment_email">ایمیل</option>
            <option value="comment_id">Id</option>
        </select>
    </div>
    <div class="loader-outside">
        <div class="loader"></div>
    </div>
    <div id="comments-search-result"></div>
    <div id="comments-main-result">
        <div id="comment_title_result"></div>
        <div id="comment_description_result"></div>
        <div id="comment_publish_mode_result"></div>
    <a class="btn btn-success" id="btn-publish-mode" href="<?= $_SERVER['PHP_SELF'] ?>?publish_mode=published">منتشر شده ها</a>
    <a class="btn btn-danger" id="btn-publish-mode" href="<?= $_SERVER['PHP_SELF'] ?>?publish_mode=unpublished">منتشر نشده ها</a>
    <?php
    if (!$searchMode){
        switch ($publish_mode){
        case 'published':
            if ($Users->isStandard())
                $publishedCount = $DB->count('comments','id'," WHERE user_id = {$Users->id} AND publish_mode='published'");
            elseif ($Users->isAdministrator() || $Users->isAdmin())
                $publishedCount = $DB->count('comments','id'," WHERE publish_mode='published'");

            ?><h3 style="color: #28a745;font-family: IRANSansB">(<?= $publishedCount ?>)منتشر شده ها</h3><?php
            break;
        case 'unpublished':
            if ($Users->isStandard())
                $unPublishedCount = $DB->count('comments','id'," WHERE user_id = {$Users->id} AND publish_mode='unpublished'");
            elseif ($Users->isAdministrator() || $Users->isAdmin())
                $unPublishedCount = $DB->count('comments','id'," WHERE publish_mode='unpublished'");
            ?><h3 style="color: #dc3545;font-family: IRANSansB">(<?= $unPublishedCount ?>)منتشر نشده ها</h3><?php
            break;
        default:
            return null;
            break;
    }
    } ?>
    <div class="container">
        <div class="row">
            <?php
            if (!$searchMode) {
                if ($Users->isStandard())
                    $commentsResult = $Comments->selectCommentStandardUser($publish_mode, $startFrom, $recordPerPage);
                elseif ($Users->isAdministrator() || $Users->isAdmin())
                    $commentsResult = $Comments->allComments($publish_mode, $startFrom, $recordPerPage);
            }
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
        <?php
        if ($searchMode)
            $Funcs->commentsSearchPagination('comments', $_GET['keyword'], $_GET['orderBy'], 'id', $searchPage, $recordPerPage);
        else
            $Funcs->commentPagination('comments','id',$page,$recordPerPage,$publish_mode); ?>
    </div>
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


<?php include "../Incluedes/panel-footer.php"; ?>
