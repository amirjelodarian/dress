<?php include "../Incluedes/panel-menu.php"; ?>
<?php
!empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
$recordPerPage = 20;
$startFrom = ($page-1)*$recordPerPage;
!empty($_GET['delivery']) ? $delivery = $DB->escapeValue($_GET['delivery']) : $delivery = 'delivery';

if (!empty($_GET['orderBy']) && !empty($_GET['keyword'])) $searchMode = true;
else $searchMode = false;

if ($searchMode){
    !empty($_GET['searchPage']) ? $searchPage = $DB->escapeValue($_GET['searchPage'],true) : $searchPage = 1;
    $searchRecordPerPage = 20;
    $searchStartFrom = ($searchPage-1)*$searchRecordPerPage;
    if (!empty($_GET['keyword']) && !empty($_GET['orderBy'])) {
        $checkoutsResult = $checkout->allCheckoutSearchByUserId($_GET['keyword'],$searchStartFrom,$searchRecordPerPage);
    }
}else{
        $checkoutsResult = $checkout->allCheckoutByUserId($delivery,$startFrom,$recordPerPage);
}

?>
<div class="main-col">
    <div class="col-12 text-right">
        <h1 class="panel-title">سفارشات</h1>
    </div>
    <div class="panel-search">
        <input type="text" name="checkoutsSearch" id="checkouts-search" class="panel-search-bar m-2"  placeholder="شماره سفارش" />
        <i class="icon-search"></i>
        <select hidden name="checkoutsOrderBy" id="checkouts-order-by" class="order-by">
            <option value="checkout_id">شماره سفارش</option>
        </select>
    </div>
    <div class="loader-outside">
        <div class="loader"></div>
    </div>
    <div id="checkouts-search-result"></div>
    <div id="checkouts-main-result">
        <a class="btn btn-custome" id="btn-publish-mode" href="<?= $_SERVER['PHP_SELF'] ?>?delivery=delivery">تحویل شده ها</a>
        <a class="btn btn-danger" id="btn-publish-mode" href="<?= $_SERVER['PHP_SELF'] ?>?delivery=not_delivery">تحویل نشده ها</a>
        <?php
        if (!$searchMode){
            switch ($delivery){
                case 'delivery':
                        $deliveryCount = $DB->count('checkout','id'," WHERE user_id = {$Users->id} AND delivery_at != 0");
                    ?><h3 style="color: #017BFF;font-family: IRANSansB">(<?= $deliveryCount ?>)تحویل شده ها</h3><?php
                    break;
                case 'not_delivery':
                        $notDeliveryCount = $DB->count('checkout','id'," WHERE user_id = {$Users->id} AND delivery_at = 0");
                    ?><h3 style="color: #dc3545;font-family: IRANSansB">(<?= $notDeliveryCount ?>)تحویل نشده ها</h3><?php
                    break;
                default:
                    return null;
                    exit;
                    break;
            }
        } ?>
        <div class="container">
            <div class="row">
                <?php
                if (!$searchMode)
                    $checkoutsResult = $checkout->allCheckoutByUserId($delivery, $startFrom, $recordPerPage);

                while($checkoutsRow = $DB->fetchArray($checkoutsResult)):
                        $divid_date_time = $Funcs->divid_date_time_database($checkoutsRow['create_at']);
                        $clothesResult = $DB->selectAll('pic_loc as pic_loc','clothes',"WHERE id IN ({$checkoutsRow['clothes_id']})"); ?>
                            <div class="col-12 col-lg-6">
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
        <?php
        if ($searchMode)
            $Funcs->checkoutsSearchPagination('checkout', $_GET['keyword'], $_GET['orderBy'], 'id', $searchPage, $recordPerPage);
        else
            $Funcs->checkoutsPagination('checkout','id',$page,$recordPerPage,$delivery); ?>
    </div>
</div>
<script>
    $('#checkouts-search').keyup(function () {
        var checkoutsSearch = $("#checkouts-search").val();
        var checkoutsOrderBy = $('#checkouts-order-by').val();
        if (checkoutsSearch != '' && checkoutsOrderBy != ''){
            $('#checkouts-search-result').html('');
            $.ajax({
                url: "checkoutsSearchRequests.php",
                method: "post",
                dataType: "text",
                beforeSend: function() {
                    $('.loader-outside').show();
                },
                data: {checkoutsSearch: checkoutsSearch,checkoutsOrderBy: checkoutsOrderBy},
                success:function (data) {
                    $('#checkouts-main-result,.loader-outside').hide();
                    $('#checkouts-search-result').show();
                    $("#checkouts-search-result").html(data);
                    if (data == "" || data == null){
                        $('#checkouts-main-result').show();
                    }
                }
            });
        }else{
            $('#checkouts-main-result').show();
            $('#checkouts-search-result').hide();
        }
    });
</script>


<?php include "../Incluedes/panel-footer.php"; ?>
