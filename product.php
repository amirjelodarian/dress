<?php
    require_once "Classes/initialize.php";
    $Funcs->pageTitle = "تمام محصولات";
    include "Incluedes/header.php";
    $DB->tableName = 'clothes';
?>

<!--End-for-bars-->
<!--    For-header-->
<!--Start-Main-->

<main class="product-main">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="aboutSite">
                    <h4>محصولات</h4>
                </div>
            </div>
        </div>
<!--        Start-owl-->
        <div class="container">
            <div class="owl-box">
                <div class="slider">
                    <div class="swiper-container">

                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="style/images/SitePics/slider1.jpg" alt="404" class="img-fluid" />
                            </div>
                            <div class="swiper-slide">
                                <img src="style/images/SitePics/slider2.jpg" alt="404" class="img-fluid" />
                            </div>
                            <div class="swiper-slide">
                                <img src="style/images/SitePics/slider4.jpg" alt="404" class="img-fluid" />
                            </div>
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
        </div>
<!--        End-owl-->
        <div class="row">
            <div class="col-12">
                <div class="aboutSelect">
                    <h6>دسته را مشخص کنید .</h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="Select-box">

                    <select name="userMenu" id="userMenu" class="Select">
                        <option value="*">انتخاب کنید -</option>
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
                        <h6>زیر دسته را مشخص کنید .</h6>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="Select-box" id="Man">
                    <select name="userSubMenu" id="userSubMenu" class="Select">
                        <option value="*">انتخاب کنید -</option>
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
            <?php $allModels = $Clothes->selectPanelMenu('model',$DB->tableName,true);
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
                        <?php $allResults = $Clothes->selectByModel($DB->tableName,$allModel['model'],' LIMIT 4',true);
                        while ($allResult = $DB->fetchArray($allResults)):  ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="product product1">
                                <div class="img-Product" id="product-img">
                                    <?php $offer = $Funcs->calcOff($allResult['price'], $allResult['off_price']);
                                    if ($offer !== (float)0): ?>
                                        <div class="off">
                                            <p><?= $Funcs->EnFa($offer,true) ?>%</p>
                                        </div>
                                    <?php endif; ?>
                                    <img src=<?= $Funcs->showPic("style/images/ProductPics/",$allResult['pic_loc'],'style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($allResult['pic_loc']) ?> />
                                    <a href=singleProduct.php?id=<?= $allResult['id'] ?> id="more-details" class="more-details">...جزئیات بیشتر</a>
                                </div>
                                <input name="deleteProductId" type="hidden" value='<?= $allResult["id"] ?>' />
                                    <div class="Mark">
                                        <div class="container d-flex justify-content-between">
                                            <p>
                                                <?php if ($allResult['count'] !== "0"): ?>
                                                    <?= $Funcs->EnFa($Funcs->insertSeperator($allResult['off_price']),true) ?> تومان
                                                <? else: ?>
                                                    <p style="color: #DB3445;margin-top: 8px;">ناموجود</p>
                                                <?php endif; ?>
                                            </p>
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
<script>
    var swiper = new Swiper('.swiper-container', {
        autoplay:true,
        pagination: {
            el: '.swiper-pagination',
            type: 'progressbar',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        scrollbar: {
            el: '.swiper-scrollbar',
            hide: true,
        },
        loop: true,
        speed: 500,
        cssMode: true,
    });

</script>
<br><br><br>
<!--End-Main-->
<!--End-footer-->
<?php include "Incluedes/footer.php"; ?>