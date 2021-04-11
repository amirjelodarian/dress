<?php
require_once "Classes/initialize.php";
$Funcs->pageTitle = "تمام محصولات";
include "Incluedes/header.php";
$DB->tableName = 'clothes';
?>

<!--End-for-bars-->
<!--    For-header-->
<!--Start-Main-->

<main>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="aboutSite">
                    <h4>Site Name</h4>
                </div>
            </div>
        </div>
<!--        Start-owl-->
        <div class="container">
            <div class="owl-box">
                <div class="slider">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="style/images/SitePics/slider4.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="style/images/SitePics/slider2.jpg" class="d-block w-100" alt="..." title="E-ConnectُS اندو موتور">
                            </div>
                            <div class="carousel-item">
                                <img src="style/images/SitePics/slider3..jpg" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
            </div>
        </div>
<!--        End-owl-->

        <div class="row">
            <div class="col-12">
                <div class="aboutSelect">
                    <h6>جنسیت را مشخص کنید .</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="Select-box">

                    <select name="userMenu" id="userMenu" class="Select">
                        <option value="*">*</option>
                        <?php
                        $menuResult = $Clothes->selectPanelMenu('type',$DB->tableName,true);
                        if ($Funcs->checkValue(array($menuResult),false,true) && $DB->numRows($menuResult) > 0) {
                            $menuArr = [];
                            array_push($menuArr,'*');
                            while ($menu = $DB->fetchArray($menuResult)):
                                array_push($menuArr,$menu['type']);
                                ?><option value=<?= $Funcs->urlValue($menu['type'],true) ?>><?= $menu['type'] ?></option><?php
                            endwhile;
                        }
                        ?>
                        <!--                        <option value="baby">بچگانه</option>-->
                    </select>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-12">
                    <div class="aboutSelect">
                        <h6>مدل را مشخص کنید .</h6>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="Select-box" id="Man">
                    <select name="userSubMenu" id="userSubMenu" class="Select">
                        <option value="*">*</option>
                        <?php
                        $subMenuResult = $Clothes->selectPanelSubMenu('model',$DB->tableName,$menuArr[0],true);
                        if ($Funcs->checkValue(array($subMenuResult),false,true) && ($DB->numRows($subMenuResult) > 0)) {
                            while ($subMenu = $DB->fetchArray($subMenuResult))
                                ?><option value=<?= $Funcs->urlValue($subMenu['model'],true) ?>><?= $subMenu['model'] ?></option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>
        </div>
            <div  id="All-Product-Result">
                <div class="loader-outside">
                    <div class="loader"></div>
                </div>
            </div>
        <!--        End-Man-List-->
<!--Start-for-man-->
<!--            Edit-for-amir!-->
            <? $allModels = $Clothes->selectPanelMenu('model',$DB->tableName,true);
            if ($Funcs->checkValue(array($allModels),false,true) && $DB->numRows($allModels) > 0) {
                while ($allModel = $DB->fetchArray($allModels)):
            ?>
            <div id="All-Product">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-right">
                            <p style="position: relative;top: 20px;font-size: 20px;font-weight:bold;"><?= $allModel['model']?></p>
                        </div>
                    </div>
                    <div class="row ManProduct">
                        <? $allResults = $Clothes->selectByModel($DB->tableName,$allModel['model'],' LIMIT 4',true);
                        while ($allResult = $DB->fetchArray($allResults)):  ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="product product1">
                                <div class="img-Product" id="product-img">
                                    <div class="off">
                                        <p><?= $Funcs->EnFa($Funcs->calcOff($allResult['price'], $allResult['off_price']),true) ?>%</p>
<!--                                        <b>--><?//= $allResult['type'] ?><!--</b>-->
<!--                                        <p id="product-color">--><?//= $allResult['color'] ?><!--</p>-->
                                    </div>
                                    <img src=<?= $Funcs->showPic("style/images/ProductPics/",$allResult['pic_loc'],'style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($allResult['pic_loc']) ?> />
                                    <a  href=singleProduct.php?id=<?= $allResult['id'] ?> id="more-details" class="more-details">...جزئیات بیشتر</a>
                                </div>
                                <input name="deleteProductId" type="hidden" value='<?= $allResult["id"] ?>' />
                                    <div class="Mark">
                                        <div class="container d-flex justify-content-between">
                                            <p style="font-size: 13px;padding: 5px;position: relative;top: 6px;"><?= $allResult['off_price'] ?> تومان</p>
                                            <h5 style="font-size: 13px;padding: 5px;position: relative;top: 8px;"><?= $allResult['title'] ?></h5>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <?php $Type = $allResult['type']; endwhile;  ?>
                        <div class="container">
                            <i><a class="float-right mt-3" style="color: red;text-decoration: none" href=<?= htmlspecialchars('moreProduct.php'). '?Type=' ?><?= urlencode($Type) . '&Model=' . urlencode($allModel['model']) ?> > ... محصولات بیشتر</a><br />
                        </div>
                    </div>
                </div>
                <?php
                   endwhile;
                } ?>
            <!--        End-Man-Pirhan-Product-->
        </div>
    </div>
    <!--        End-Man-womanZhakat-Product-->
    <!--End-For-womMan-->
</div>

</div>

</main>
<br><br><br>
<!--End-Main-->

<!--End-footer-->
<?php include "Incluedes/footer.php"; ?>