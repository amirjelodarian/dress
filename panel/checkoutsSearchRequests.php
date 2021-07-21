<?php
require_once "../Classes/initialize.php";
!empty($_GET['searchPage']) ? $searchPage = $DB->escapeValue($_GET['searchPage'],true) : $searchPage = 1;
$recordPerPage = 20;
$startFrom = ($searchPage-1)*$recordPerPage;
if (isset($_POST['checkoutsSearch']) && !(empty($_POST['checkoutsSearch'])) && isset($_POST['checkoutsOrderBy']) && !(empty($_POST['checkoutsOrderBy']))){
    $checkoutsResult = $checkout->allCheckoutSearchByUserId($_POST['checkoutsSearch'],$startFrom, $recordPerPage);
    if ($Funcs->checkValue([$checkoutsResult],false,true) && $DB->numRows($checkoutsResult) > 0){  ?>
        <div id="checkouts-main-result">
            <div class="container">
                <div class="row">
                    <?php
                    while($checkoutsRow = $DB->fetchArray($checkoutsResult)):
                        $delivery = $checkoutsRow['delivery_at'];
                        $divid_date_time = $Funcs->divid_date_time_database($checkoutsRow['create_at']);
                        $clothesResult = $DB->selectAll('pic_loc as pic_loc','clothes',"WHERE id IN ({$checkoutsRow['clothes_id']})"); ?>
                        <div class="col-12 col-lg-6">
                            <?php
                                if ($delivery == "0"){ ?>
                                    <h5 style="color: #dc3545;font-family: IRANSansB">تحویل نشده</h5><?php
                                }else{ ?>
                                    <h5 style="color: #017BFF;font-family: IRANSansB">تحویل شده</h5><?php
                                }?>
                            <div class="Comment_BOX">
                                <?php while ($Clothes = $DB->fetchArray($clothesResult)): ?>
                                    <div class="Cover_Comment_Product cover_checkout">
                                        <img src=<?= $Funcs->showPic("../style/images/ProductPics/",$Clothes['pic_loc'],'../style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($Clothes['pic_loc']) ?> />
                                    </div>
                                <?php endwhile; ?>
                                <div class="Main_InComment">
                                    <div class="Bottom_Main_COMMMENT">
                                        <p><i class="fa">شماره سفارش</i> : <span id="<?= $checkoutsRow['id'] ?>" class='comment-title'><?= $checkoutsRow['id'] ?></span></p>
                                        <p><i class="fa">شماره تماس</i> : <span id="<?= $checkoutsRow['id'] ?>" class='comment-title'><?= $checkoutsRow['tell'] ?></span></p>
                                        <p><i class="fa">آدرس</i> : <span id="<?= $checkoutsRow['id'] ?>" class='comment-description'><?= nl2br($checkoutsRow['address']) ?></span></p>
                                        <small id='panel-date-comment'><?= $Funcs->EnFa($Funcs->dateTimeToJalaliDate($divid_date_time[1],'/',true),true) ?></small>
                                        <small class='icon-clock-8' id='panel-time-comment'><?= $Funcs->EnFa($divid_date_time[0],true) ?></small>
                                        <div class='comment-panel-btns col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                                            <a href='singleCheckout.php?id=<?= $checkoutsRow["id"] ?>'>
                                                <p id='see-room-btn' class='checkout-details'>جز‌‌ییات</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php $Funcs->checkoutsSearchPagination('checkout', $_POST['checkoutsSearch'], $_POST['checkoutsOrderBy'], 'id', $searchPage, $recordPerPage); ?>
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
</div>