<?
include "../Incluedes/panel-menu.php";

    if (isset($_POST['editProduct'])) {
        $id = $DB->escapeValue($_POST['id'],true);
        if ($Funcs->checkValue([$_POST["title"], $_POST["fabricType"], $_POST["description"], $_POST["size"], $_POST["color"],$_POST["model"],$_POST["type"], $_POST["price"], $_POST["offPrice"],$_POST["count"]], true, true)) {
            if ($_FILES['uploadFile']['size'] == 0 && $_FILES['uploadFile']['name'] == "")
                $Clothes->editProduct([$_POST["title"], $_POST["fabricType"], $_POST["description"], $_POST["size"], $_POST["color"],$_POST["model"],$_POST["type"], $Funcs->EnFa($_POST["price"], false, true), $Funcs->EnFa($_POST["offPrice"], false, true), $Funcs->EnFa($_POST["count"], false, true)],'',$_POST['id']);
            else
                $Clothes->editProduct([$_POST["title"], $_POST["fabricType"], $_POST["description"], $_POST["size"], $_POST["color"],$_POST["model"],$_POST["type"], $Funcs->EnFa($_POST["price"], false, true), $Funcs->EnFa($_POST["offPrice"], false, true), $Funcs->EnFa($_POST["count"], false, true)], "uploadFile",$_POST['id']);
        } else {
            $_SESSION["errorMessage"] .= "برخی از فیلد ها خالیست .";
            $Funcs->redirectTo("editProduct.php?id={$id}");
        }
    }
    if (isset($_GET['deleteProduct'])){
        $deleteProductId = $DB->escapeValue($_GET['deleteProductId'],true);
        $Clothes->deleteProduct($deleteProductId);
    }

    if (isset($_GET['deleteImgProduct']) && isset($_GET['deleteProductId'])){
        $deleteProductImageId = $DB->escapeValue($_GET['deleteProductId'],true);
        $Clothes->deleteProductImg($deleteProductImageId);
    }
    if (isset($_GET['id'])) {
      $id = $DB->escapeValue($_GET['id'],true);

        if (isset($_GET['deleteComment']) && isset($_GET['id'])){
            $id = $DB->escapeValue($_GET['id'],true);
            $deleteCommentId = $DB->escapeValue($_GET['deleteCommentId'],true);
            $Comments->deleteComment($deleteCommentId,'editProduct.php?id='.$id);
        }

    !empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
    $recordPerPage = 36;
    $startFrom = ($page-1)*$recordPerPage;
    ?>
    <div class="main-col">
        <div id="comment_title_result"></div>
        <div id="comment_description_result"></div>
        <div id="comment_publish_mode_result"></div>
        <!--        Start-Man-Pirhan-Product-->
        <div class="container" id="Pirhan2">
            <div class="row ManProduct">
                <? $allResult = $DB->selectById($DB->tableName,$id);
                if ($Funcs->checkValue($allResult,false,true) && $DB->numRows($allResult) > 0) {
                    while ($allRow = $DB->fetchArray($allResult)) { ?>
                      <div class="return"><a href=<?= htmlspecialchars('index.php'). '?clothesType=' ?><?= urlencode($allRow['type']) . '&clothesModel=' . urlencode($allRow['model']) ?> >< بازگشت</a></div>
                        <div class="col-sm-3 col-md-3 col-lg-3"></div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="product product1">
                                <div class="img-Product">
                                    <div class="off">
                                        <p><?= $Funcs->EnFa($Funcs->calcOff($allRow['price'], $allRow['off_price']),true) ?>%</p>
                                    </div>
                                    <div class="del-btn">
                                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                                            <input name="deleteProductId" type="hidden" value='<?= $allRow["id"] ?>' />
                                            <input type="submit" name="deleteProduct" id="deleteProduct" style="width: 100px" value='حذف محصول' /><br />
                                            <input type="submit" name="deleteImgProduct" id="deleteImgProduct" value='حذف عکس' />
                                        </form>
                                    </div>
                                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="post">
                                    <img id="edit-product-img" src=<?= $Funcs->showPic("../style/images/ProductPics/",$allRow['pic_loc'],'../style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($allRow['pic_loc']) ?> />
                                        <input type="hidden" name="id" value="<?= $allRow['id'] ?>" />

                                        <label for="add-product" id="uploadImageIcon"><i class="fa fa-image">+</i></label>
                                        <input type="file" name="uploadFile" id="add-product" class="uploadImageInput" />
                                    <input type='hidden' name='MAX_FILE_SIZE' value='2097152' />

                                </div>
                                <div class="container">
                                    Category
                                        <input type="text" id='type-clothes' class="clothes-type" value="<?= $allRow['type'] ?>" name="type" placeholder="مردانه" autocomplete="off" required />
                                        <ul class="result-list" id="type-result"></ul>
                                    Model
                                        <input type="text" id="model-clothes" class="clothes-type" value="<?= $allRow['model'] ?>" name="model" placeholder="تیشرت" autocomplete="off" required />
                                        <ul class="result-list" id="model-result"></ul>
                                </div>
                                <div class="aboutProduct">
                                    <div class="Price">
                                        <p><input class="limitToNumber" id="editpage-inputs" name="offPrice" placeholder="بعد تخفیف" value="<?= $Funcs->EnFa($allRow['off_price'],true) ?>" /> تومان</p>
                                    </div>
                                    <div class="Mark">
                                        <div class="container">
                                            Title
                                            <input id="editpage-inputs" name="title" class="product-title" value="<?= $allRow['title'] ?>" />
                                        </div>
                                    </div>
                                    <br />
                                </div>
                                <div>
                                    <div class="textProduct">
                                        <div class="container">
                                            <span>قبل تخفیف</span>
                                            <input class="limitToNumber" id="editpage-inputs" name="price" value="<?= $Funcs->EnFa($allRow['price'],true) ?>" />
                                        </div>
                                    </div><br />
                                    <div class="textProduct">
                                        <div class="container">
                                            <span>توضیحات</span>
                                            <textarea id="editpage-textarea" name="description"><?= $allRow['description'] ?></textarea>
                                        </div>
                                    </div><br />
                                    <div class="textProduct">
                                        <div class="container">
                                            <span>رنگ</span>
                                            <input id="editpage-inputs" name="color" value="<?= $allRow['color'] ?>" />
                                        </div>
                                    </div><br />
                                    <div class="textProduct">
                                        <div class="container">
                                            <span>سایز</span>
                                            <input id="editpage-inputs" name="size" value="<?= $allRow['size'] ?>" />
                                        </div>
                                    </div><br />
                                    <div class="textProduct">
                                        <div class="container">
                                            <span>جنس</span>
                                            <input id="editpage-inputs" type="text" name="fabricType" value="<?= $allRow['fabric_type'] ?>" required />
                                        </div>
                                    </div><br />
                                    <div class="textProduct">
                                        <div class="container">
                                            <span>تعداد</span>
                                            <input id="editpage-inputs" type="text" name="count" value="<?= $allRow['count'] ?>" required />
                                        </div>
                                    </div><br />
                                    <input type="submit" id="add-product-submit" name="editProduct" value="ویرایش محصول" />
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
            $commentsResult = $Comments->selectCommentByProductId($id,$startFrom,$recordPerPage);
            while($commentsRow = $DB->fetchArray($commentsResult)):
                $clothesResult = $DB->selectById('clothes',$commentsRow['clothes_id']);
                if ($Clothes = $DB->fetchArray($clothesResult)):
                    $usersResult = $DB->selectById('users',$commentsRow['user_id']);
                    if ($usersRow = $DB->fetchArray($usersResult)):
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
                            <img src=<?= $Funcs->showPic('../style/images/UsersPics/' , $usersRow['pro_pic'],'../style/images/Defaults/default-user.png') ?> alt='' />
                        </div>
                    </div>
                    <div class="Main_InComment">
                        <div class="top_Main_COMMMENT">
                            <p><i class="fa fa-id-card"></i> : <?= $commentsRow['id'] ?></p>
                            <p><i class="fa fa-envelope"></i> : <?= $usersRow['email'] ?></p>
                        </div>
                        <span style="float: right;color: #007bff"><?= $usersRow['username'] ?></span><br />
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

                        <?php $Funcs->clothesCommentPagination('comments','id',$page,$recordPerPage,$id); ?>
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
    <?php
  }
    include "../Incluedes/panel-footer.php"; ?>
