<?php
include "../Incluedes/panel-menu.php";
if (isset($_GET['deleteProduct'])){
    $id = $DB->escapeValue($_GET['deleteProductId'],true);
    $Clothes->deleteProduct($id);
}
if (!empty($_GET['orderBy']) && !empty($_GET['keyword'])) $searchMode = true;
else $searchMode = false;

if(!empty($_GET['clothesType']) && !empty($_GET['clothesModel']) && !$searchMode) {
    $clothesType = $DB->escapeValue($_GET['clothesType']);
    $clothesModel = $DB->escapeValue($_GET['clothesModel']);
    !empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'], true) : $page = 1;
    $recordPerPage = 36;
    $startFrom = ($page - 1) * $recordPerPage;
    $allResult = $Clothes->selectByTypeAndModel($DB->tableName, $clothesType, $clothesModel, true, " LIMIT {$startFrom},{$recordPerPage}");
}elseif ($searchMode){
    !empty($_GET['searchPage']) ? $searchPage = $DB->escapeValue($_GET['searchPage'],true) : $searchPage = 1;
    $searchRecordPerPage = 36;
    $searchStartFrom = ($searchPage-1)*$searchRecordPerPage;
    if (!empty($_GET['keyword']) && !empty($_GET['orderBy'])) {
        $allResult = $Clothes->searchByTitleOrPrice('clothes', $_GET['keyword'], $_GET['orderBy'], " LIMIT {$searchStartFrom},{$searchRecordPerPage}",true);
    }
}else
    $Funcs->redirectTo('profile.php');
?>
    <div class="main-col">
        <div class="panel-search">
            <input type="text" name="clothesSearch" id="clothes-search" class="panel-search-bar"  placeholder="Search" />
            <select name="clothesOrderBy" id="clothes-order-by" class="order-by">
                <option value="clothes_title">مدل</option>
                <option value="clothes_price">قیمت</option>
                <option value="clothes_id">Id</option>
            </select>
        </div>
        <!--        Start-Man-Pirhan-Product-->
        <div class="container" id="Pirhan2">
            <div class="row">
                <div class="loader-outside">
                    <div class="loader"></div>
                </div>
                <?php if(!$searchMode): ?>
                <div class="col-12 text-right">
                    <p class="product-route" style="position: relative;top: 20px;font-size: 20px"><?= stripslashes($clothesType) . " - " . stripslashes($clothesModel) ?></p>
                </div>
                <?php endif; ?>
            </div>
            <div id="clothes-search-result"></div>
            <div class="row ManProduct" id="clothes-main-result">
                <?php
                if ($Funcs->checkValue(array($allResult),false,true) && $DB->numRows($allResult) > 0) {
                    while ($allRow = $DB->fetchArray($allResult)) { ?>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <div class="product product1">
                                <div class="img-Product">
                                    <div class="off">
                                        <p><?= $Funcs->EnFa($Funcs->calcOff($allRow['price'], $allRow['off_price']),true) ?>%</p>
                                    </div>
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
                                        <p><?= $Funcs->EnFa($allRow['off_price'],true) ?> تومان</p>
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
                <br />
                <?php
                if ($searchMode){
                    $Funcs->clothesSearchPagination('clothes', $_GET['keyword'], $_GET['orderBy'], 'id', $searchPage, $searchRecordPerPage,true);
                }else
                    $Funcs->clothesPagination($DB->tableName,$clothesType,$clothesModel,'id',$page,$recordPerPage); ?>
            </div>
        </div>
        <!--        End-Man-Pirhan-Product-->


        <!--        Start-Man-T-shrt-Product-->

        <!--        End-Man-womanZhakat-Product-->
        <!--End-For-womMan-->

    </div>

    <?php include "../Incluedes/panel-footer.php"; ?>
