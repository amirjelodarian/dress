<?php
include "Classes/initialize.php";
    $DB->tableName = 'clothes';

    // ---------------------------------------------------------------------------
    // product section live ajax select option
    if (!empty($_POST['userMenu'])){
        $userMenu = $DB->escapeValue($Funcs->urlValue($_POST['userMenu'],false));
        $subMenuResult = $Clothes->selectPanelSubMenu('model', $DB->tableName, $userMenu,true);
        echo '<option value="*">*</option>';
        if ($Funcs->checkValue(array($subMenuResult),false,true) && ($DB->numRows($subMenuResult) > 0)) {
            while ($subMenu = $DB->fetchArray($subMenuResult))
                echo "<option value=" . $Funcs->urlValue($subMenu['model'], true) . ">" . ($subMenu['model']) . "</option>";
        }
    }

    // ---------------------------------------------------------------------------



    // product section product themselves product show limit 4
    if (!empty($_GET['userMenu']) || !empty($_GET['userSubMenu'])){
        $userMenu = $DB->escapeValue($Funcs->urlValue($_GET['userMenu'],false));
        $userSubMenu = $DB->escapeValue($Funcs->urlValue($_GET['userSubMenu'],false)); ?>
        <p class="product-route" style="position: relative;top: 10px;padding: 20px;font-size: 20px;text-align: center;text-align: -moz-center;text-align: -webkit-center"><?= stripslashes($userSubMenu) . " - " . stripslashes($userMenu) ?></p>
        <div class="row ManProduct" id="All-Product-Result">
                <?
                    $allResult = $Clothes->selectByTypeAndModelSearch($DB->tableName,$userMenu,$userSubMenu,'ORDER BY id DESC LIMIT 4');
                if ($Funcs->checkValue(array($allResult),false,true) && $DB->numRows($allResult) > 0) {
                    while ($allRow = $DB->fetchArray($allResult)) { ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="product product1">
                                <div class="img-Product" id="product-img">
                                    <div class="off">
                                        <p><?= $Funcs->EnFa($Funcs->calcOff($allRow['price'], $allRow['off_price']),true) ?>%</p>
                                    </div>
                                    <img src=<?= $Funcs->showPic("style/images/ProductPics/",$allRow['pic_loc'],'style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($allRow['pic_loc']) ?> />
                                    <a  href=singleProduct.php?id=<?= $allRow['id'] ?> id="more-details" class="more-details">...جزئیات بیشتر</a>
                                </div>
                                <input name="deleteProductId" type="hidden" value='<?= $allRow["id"] ?>' />
                                <div class="Mark">
                                    <div class="container d-flex justify-content-between">
                                        <p>
                                            <?php if ($allRow['count'] !== "0"): ?>
                                                <?= $Funcs->EnFa($Funcs->insertSeperator($allRow['off_price']),true) ?> تومان
                                            <? else: ?>
                                        <p style="color: #DB3445;margin-top: 8px;">ناموجود</p>
                                        <?php endif; ?>
                                        </p>
                                        <h5 style="font-size: 13px;padding: 5px;position: relative;top: 8px;"><?= $allRow['title'] ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?
                    } ?>
                    <div class="container">
                        <i><a class="float-right mt-3" style="color: red;text-decoration: none" href=<?= htmlspecialchars('moreProduct.php'). '?Type=' ?><?= urlencode($userMenu) . '&Model=' . urlencode($userSubMenu) ?> > ... محصولات بیشتر</a><br />
                    </div>
                    <?php
                }else
                    echo "<p class='product-route' style='position: relative;top: 10px;left:20px;font-size: 20px;'>Not Found !</p>";
                ?>


        <!--                <div class="container">-->
        <!--                    <a href="more-Product.php" class="float-right mt-3" style="color: red;text-decoration: none"><i class="fa fa-angle-left" style="margin-right: 10px;"></i> More Product</a>-->
        <!--                </div>-->
        </div>
        <?php
        // ------------------------------------------------------------------------------------------
    }
?>