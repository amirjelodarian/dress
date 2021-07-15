<?php
require_once "../Classes/initialize.php";
!empty($_GET['searchPage']) ? $searchPage = $DB->escapeValue($_GET['searchPage'],true) : $searchPage = 1;
$recordPerPage = 36;
$startFrom = ($searchPage-1)*$recordPerPage;
if (isset($_POST['clothesSearch']) && !(empty($_POST['clothesSearch'])) && isset($_POST['clothesOrderBy']) && !(empty($_POST['clothesOrderBy']))){
$allResult = $Clothes->searchByTitleOrPrice('clothes',$_POST['clothesSearch'],$_POST['clothesOrderBy']," LIMIT {$startFrom},{$recordPerPage}",true);
if ($Funcs->checkValue([$allResult],false,true) && $DB->numRows($allResult) > 0) { ?>
    <div class="row ManProduct">
    <?php while ($allRow = $DB->fetchArray($allResult)) { ?>
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <div class="product product1">
                <div class="img-Product">
                    <?php $offer = $Funcs->calcOff($allRow['price'], $allRow['off_price']);
                    if ($offer !== (float)0): ?>
                        <div class="off">
                            <p><?= $Funcs->EnFa($offer,true) ?>%</p>
                        </div>
                    <?php endif; ?>
                    <div class="del-btn">
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                            <input name="deleteProductId" type="hidden" value='<?= $allRow["id"] ?>' />
                            <input type="submit" name="deleteProduct" id="deleteProduct" class="AreYouSure" value='حذف' /><br />
                        </form>
                    </div>
                    <div class="edit-btn">
                        <a href='editProduct.php?id=<?= $allRow["id"] ?>'>ویرایش</a>
                    </div>
                    <a href='../singleProduct.php?id=<?= $allRow["id"] ?>'><img src=<?= $Funcs->showPic("../style/images/ProductPics/",$allRow['pic_loc'],'../style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($allRow['pic_loc']) ?> /></a>
                </div>
                <div class="aboutProduct">
                    <?= $allRow["id"] ?>
                    <div class="Price">
                        <p><?= $Funcs->EnFa($Funcs->insertSeperator($allRow['off_price']),true) ?> تومان</p>
                    </div>
                    <div class="Mark">
                        <div class="container">
                            <h2 class="product-title"><?= $allRow['title'] ?></h2>
                            <i class="fa fa-angle-down" onclick="slideToggle('.div1')"></i>
                        </div>
                    </div>
                </div>
                <div class="div1">
                    <div class="textProduct">
                        <div class="container">
                            <span>قبل تخفیف</span>
                            <p><?= $Funcs->EnFa($allRow['price'],true) ?> تومان </p>
                        </div>
                    </div>
                    <div class="textProduct">
                        <div class="container">
                            <span>جنس</span>
                            <p><?= $allRow['fabric_type'] ?></p>
                        </div>
                    </div>
                    <div class="textProduct">
                        <div class="container">
                            <span>رنگ</span>
                            <p><?= $allRow['color'] ?></p>
                        </div>
                    </div>
                    <div class="textProduct">
                        <div class="container">
                            <span>سایز</span>
                            <p><?= $allRow['size'] ?></p>
                        </div>
                    </div>
                    <div class="textProduct">
                        <div class="container">
                            <span>توضیحات</span>
                            <p><?= $allRow['description'] ?></p>
                        </div>
                    </div>
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
        <?php
    }
}else
    echo "<p class='product-route' style='position: relative;top: 20px;font-size: 20px;float: right;right: 0;'>Error 404 ! Not Found</p>";
?>


<!--                <div class="container">-->
<!--                    <a href="more-Product.php" class="float-right mt-3" style="color: red;text-decoration: none"><i class="fa fa-angle-left" style="margin-right: 10px;"></i> More Product</a>-->
<!--                </div>-->
</div>
<?php $Funcs->clothesSearchPagination('clothes',$_POST['clothesSearch'],$_POST['clothesOrderBy'],'id',$searchPage,$recordPerPage); ?>
</div>
<?php } ?>