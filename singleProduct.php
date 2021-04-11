<?php
require_once "Classes/initialize.php";
isset($_GET['id']) && !(empty($_GET['id'])) ? $id = $DB->escapeValue($_GET['id'],true) : $Funcs->redirectTo('product.php');
$DB->tableName = 'clothes';

!empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
    $recordPerPage = 50;
    $startFrom = ($page-1)*$recordPerPage;
    
$allResult = $DB->selectById($DB->tableName,$id);
if ($DB->numRows($allResult) !== 0){
    if ($allRow = $DB->fetchArray($allResult)):
        $Funcs->pageTitle = $allRow['title'];
        include "Incluedes/header.php";
?>
<main style="background-color: #FFFFFF;">
    <div class="Address">
        <div class="container">
            <p><?= $allRow['type'] ?><i class="fa fa-angle-left newAngle"></i><?= $allRow['model'] ?></p>
        </div>
    </div>

    <div class="container">

        <div class="SingleBox">

            <div class="Single R_single">
                <img src=<?= $Funcs->showPic("style/images/ProductPics/",$allRow['pic_loc'],'style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($allRow['pic_loc']) ?> />
            </div>
            <div class="Single L_single">
                <h4><?= $allRow['title'] ?></h4><br>
                <a href="#">افزودن به سبد خرید</a>
                <div class="Sin_boxes">
                    <div class="sin L_Sin" style="border-left: 0!important;">
                        <h6>رنگ</h6>
                        <h6><b><?= $allRow['color'] ?></b></h6>
                    </div>
                    <div class="sin C_Sin">
                        <h6>جنس</h6>
                        <h6><b><?= $allRow['fabric_type'] ?></b></h6>
                    </div>
                    <div class="sin R_Sin">
                        <h6>قیمت قبل تخفیف</h6>
                        <h6><b><?= $allRow['price'] ?></b></h6>
                    </div>
                </div>
                <div class="row_single">
                    <div class="rows R_row">
                        <h6><b><?= $allRow['off_price'] ?> تومان</b></h6>
                    </div>
                    <div class="rows L_row">
                        <h6>قیمت </h6>
                    </div>
                </div>
                <div class="S_Description">
                    <p><?= $allRow['description'] ?></p>
                </div>

            </div>

        </div>
            <div class="row">
                <div class="col-12">
                    <div class="Comments">
                        <h5>شما هم می‌توانید در مورد این کالا نظر بدهید.</h5><br>
                        <div class="single-product-message" id="verify-message">
                            <?php if(!$SS->loggedIn()){ ?>
                            برای ثبت نظر بایستی به حساب کاربری خود وارد شوید یا حسابی بسازید
                            <ul>
                                <li><a href='login.php?from=singleProduct.php?id=<?= $allRow['id'] ?>'>ورود</a></li>
                                <li><a href='register.php?from=singleProduct.php?id=<?= $allRow['id'] ?>'>ثبت نام</a></li>
                            </ul>
                            <?php } ?>
                        </div>
                        <div class="loader-outside">
                            <div class="loader"></div>
                        </div>
                         <div class="form-group row">
                            <label  for="comment-title">عنوان نظر</label>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <input type="text" class="form-control" id="comment-title" name="title" placeholder="عنوان نظر" />
                            </div>
                          </div>
                          <div class="form-group row">
                            <label  for="comment-title">شرح نظر</label>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <textarea name="description" class="form-control" id="comment-description" name="description" placeholder="شرح نظر"></textarea>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label  for="comment-title">امتیاز</label>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                <select id="comment-score" name="score">
                                    <option value="">امتیاز</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                          </div>
                        <input name='productId' id="product-id" type="hidden" value="<?= $allRow['id'] ?>" />
                        <button id="comment-submit" class="btn btn-primary" name="comment-submit">افزودن نظر</button>
                        <hr />
                        تعداد نظرات
                        <?= $DB->count('comments','id',"WHERE clothes_id='{$id}' AND publish_mode='published'"); ?>
                        
                        <?php 
                            $commentsResult = $Comments->commentsByProductId($allRow['id'],$startFrom,$recordPerPage);
                            while($commentsRow = $DB->fetchArray($commentsResult)):
                                $userResult = $DB->selectById('users',$commentsRow['user_id']);
                                if($userRow = $DB->fetchArray($userResult)):
                                    ?>
                                    <div class="Comment">
                                        <img class="profile-icon" id="user-profile-pic" alt="404" src=<?= $Funcs->showPic('style/images/UsersPics/' , $userRow['pro_pic'],'style/images/Defaults/default-user.png') ?> />
                                        <div class="R_Comment">
                                            <p><?= $userRow['username'] ?></p><?php $Funcs->starByScore($commentsRow['score']) ?>
                                            <p class="Comment_time">در تاریخ <?= $Funcs->dateTimeToJalaliDate($commentsRow['create_at'],'/',true) ?></p>
                                        </div>
                                        <div class="L_Comment">
                                            <h4><?= $commentsRow['title'] ?></h4>
                                            <p><?= htmlspecialchars($commentsRow['description']) ?></p>
                                        </div>
                                    </div>
                                    <?php
                                endif;
                            endwhile;
                        ?>
                    </div>
                </div>
            </div>
    </div>
</main>

<?php
    endif;
        include "Incluedes/footer.php";
}else
    $Funcs->redirectTo('product.php');
    ?>