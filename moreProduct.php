<?php
require_once "Classes/initialize.php";
$Funcs->pageTitle = "محصولات بیشتر...";
include "Incluedes/header.php";
    $DB->tableName = 'clothes';
    if(!empty($_GET['Type']) && !empty($_GET['Model'])){
        $Type = $DB->escapeValue($_GET['Type']); $Model = $DB->escapeValue($_GET['Model']);
        !empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
        $recordPerPage = 36;
        $startFrom = ($page-1)*$recordPerPage;

        if (isset($_GET['priceFilter']) && !empty($_GET['priceFilter']))
            $allResult = $Clothes->doPriceFilter($Type,$Model,$startFrom,$recordPerPage,$_GET['priceFilter']);
        else
            $allResult = $Clothes->selectByTypeAndModelSearch($DB->tableName,$Type,$Model," ORDER BY id DESC LIMIT {$startFrom},{$recordPerPage}");

        if (isset($_GET['priceRangeFilter']) && !empty($_GET['priceRangeFilter']))
            $allResult = $Clothes->doPriceFilterBetween($Type,$Model,$startFrom,$recordPerPage,$_GET['priceRangeFilter']);
    ?>
<!--End-for-bars-->
<!--    For-header-->
<main style="background-color: #FFFFFF!important;">
   <div class="container-fluid">
       <div class="row">
           <div class="col-12">
               <div class="filters text-right">
                   <div class="filter">
                       <h6>فیلتر <i class="fa fa-angle-down"></i></h6>
                   </div>
                   <div class="about-filter">
                       <div class="filter-1" style="margin-top: 55px">
                           <a href=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?Type={$Type}&Model={$Model}&priceFilter=cheapest"; ?> class="mt-1">ارزان ترین قیمت</a>
                       </div>
                       <div class="filter-1" style="border-bottom: 0">
                           <a href=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?Type={$Type}&Model={$Model}&priceFilter=theMostExpensive"; ?> class="mt-1">گران ترین قیمت</a>
                       </div>
                       <div class="filter-1" style="border-top: 1px solid #eeeeee">
                           <p>قیمت مورد نظر</p>
                           <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                               <input type="text" id="priceRange" name="priceRangeFilter" value="" /><br />
                               <input name="Type" type="hidden" value="<?= $Type ?>" />
                               <input name="Model" type="hidden" value="<?= $Model ?>" />
                               <input type="submit" value="اعمال فیلتر" id="do-filter-btn" />
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="more-panel">
           <div class="L-desktop-more">
               <div class="inside-L-desktop">
                   <p class="product-route" style="position: relative;top: 10px;padding: 20px;font-size: 20px;text-align: center;text-align: -moz-center;text-align: -webkit-center"><?= stripslashes($Model) . " - " . stripslashes($Type) ?></p>
                    <div class="row">
        <?
        if ($Funcs->checkValue(array($allResult),false,true) && $DB->numRows($allResult) > 0) {
            while ($allRow = $DB->fetchArray($allResult)) { ?>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
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
                                    <p style="font-size: 13px;padding: 5px;position: relative;top: 6px;"><?= $allRow['off_price'] ?> تومان</p>
                                    <h5 style="font-size: 13px;padding: 5px;position: relative;top: 8px;"><?= $allRow['title'] ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                <?
            }
        }else
            echo "<p class='product-route' style='position: relative;top: 20px;font-size: 20px;float: right;right: 0;'>Error 404 ! Not Found</p>";
        ?>

                </div>

               </div>
               <?php $Funcs->clothesPagination($DB->tableName,$Type,$Model,'id',$page,$recordPerPage); ?>
           </div>

           <div class="R-desktop-more" id="r-desk">
                   <div id="more-cheapset" class="search-filter">
                       <div class="container">
                           <br>
                           <a href=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?Type={$Type}&Model={$Model}&priceFilter=cheapest"; ?> class="mt-1">ارزان ترین قیمت</a>
                       </div>
                   </div>
                   <div id="the-most-expensive" class="search-filter">
                       <div class="container">
                           <br>
                           <a href=<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?Type={$Type}&Model={$Model}&priceFilter=theMostExpensive"; ?> class="mt-1">گران ترین قیمت</a>
                       </div>
                   </div>
                   <br /><hr />
               <div id="more-price" class="search-filter">
                   <div class="container">
                       <p class="mt-3">قیمت مورد نظر </p>
                       <form method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <input type="text" id="priceRange2" name="priceRangeFilter" value="" /><br />
                            <input name="Type" type="hidden" value="<?= $Type ?>" />
                            <input name="Model" type="hidden" value="<?= $Model ?>" />
                            <input type="submit" value="اعمال فیلتر" id="do-filter-btn" />
                       </form>
                       <br />
                   </div>
               </div>
           </div>
       </div>
   </div>
</main>
<br><br>
<!--End-footer-->
<?php
        include "Incluedes/footer.php";
    }else
    $Funcs->redirectTo('product.php');
    ?>