<?php
require_once "../Classes/initialize.php";
$Funcs->pageTitle = "سبد خرید";
include "../Incluedes/panel-menu.php";
!empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
!empty($_GET['id']) ? $id = $DB->escapeValue($_GET['id'],true) : $id = 1;
$recordPerPage = 10;
$startFrom = ($page-1)*$recordPerPage;
if($SS->loggedIn()): ?>



    <div class="main-col" style="overflow-x: scroll">
        <div class="col-12 text-center">
            <p class="number-order-panel"><?= $id ?></p>
            <p class="word-order-panel">شماره سفارش</p>
        </div>
        <div class="container">
            <?php if($SS->loggedIn()): ?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                    <table class="table panel-table">
                        <thead>
                        <tr>
                            <th>قیمت واحد</th>
                            <th></th>
                            <th>تعداد</th>
                            <th>نام محصول</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $arrSize = sizeof($cart->calculateCart($id)['count']);
                        if(sizeof($cart->calculateCart($id)['price']) == $arrSize && sizeof($cart->calculateCart($id)['title']) == $arrSize):
                            for ($countPrice = 0 ; $countPrice < sizeof($cart->calculateCart($id)['count']) ; $countPrice++): ?>
                                <tr class="cart-table">
                                <td><?= $Funcs->insertSeperator($cart->calculateCart($id)['price'][$countPrice]) ?><span> تومان </span></td>
                                <td>x</td>
                                <td><?= $cart->calculateCart($id)['count'][$countPrice] ?></td>
                                <td><?= $cart->calculateCart($id)['title'][$countPrice] ?></td>
                                </tr><?php
                            endfor;
                        else:
                            echo "Something Wrong !";
                        endif; ?>
                        </tbody>
                    </table>
                    <hr />
                    <div class="sum-product-word" style="height: 32px!important;border-radius: 3.4px;">
                        <span class="sum-product">جمع کل : </span>
                        <span class="sum-product sum-product-price"><?= $Funcs->insertSeperator($cart->calculateCart($id)['sum']) ?> تومان </span>
                    </div>
                </div>
                <?php
                $userCartResult = $cart->showCartByUserId($startFrom,$recordPerPage,$id);
                while($userCartRow = $DB->fetchArray($userCartResult)):
                    $userClothesResult = $DB->selectById('clothes',$userCartRow['clothes_id']);
                    if ($userClothesRow = $DB->fetchArray($userClothesResult)): ?>
                    <?php $offer = $Funcs->calcOff($userClothesRow['price'], $userClothesRow['off_price']); ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 customize-col-lg-3-order" style="font-family: IRANSansU" id="cart-<?= $userCartRow['clothes_id'] ?>">
                            <div class="around-single-cart">
                                <div class="orders" id="orders1">
                                    <div class="L-order text-right">
                                        <div class="container"><br>
                                            <div class="product product1">
                                                <div class="img-Product" id="product-img">
                                                <?php if ($offer !== (float)0): ?>
                                                    <div class="off">
                                                        <p><?= $Funcs->EnFa($offer,true) ?>%</p>
                                                    </div>
                                                <?php endif; ?>
                                                    <img src=<?= $Funcs->showPic("../style/images/ProductPics/",$userClothesRow['pic_loc'],'../style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($userClothesRow['pic_loc']) ?> />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="R-order text-right">
                                    <div class="container">
                                        <h5><?= $userClothesRow['title'] ?></h5>
                                        <p>قیمت نهایی : <span style="font-family: IRANSansB;color: #017BFF"><?= $Funcs->insertSeperator($userClothesRow['off_price']) ?> تومان </span></p>
                                        <?php if ($offer !== (float)0): ?>
                                            <p class="before-off"> تومان <span><?= $Funcs->EnFa($Funcs->insertSeperator($userClothesRow['price']),true) ?></span></p><br />
                                        <?php endif; ?>
                                        <p>رنگ : <span><?= $userClothesRow['color'] ?></span></p>

                                        <div class="btns d-flex float-right">
                                            <input name='productId' id="product-id-<?= $userCartRow['clothes_id'] ?>" type="hidden" value="<?= $userCartRow['clothes_id'] ?>" />
                                        </div>
                                        <div class="S_Description" style="text-align: right;float: right">
                                            <p class="text-warning count-product-order"><?= $userCartRow['count'] ?> عدد</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                endwhile;
                ?>
            </div>
            <?php $Funcs->cartPagination('cart','user_id',$page,$recordPerPage,$id); ?>
        </div>
        <?php endif; ?>
        </div>
    </div>

    <script type="text/javascript" src="style/js/app.js"></script>
    <script>
        // $(document).ready(function (){
        //
        //
        //     $('.trash1').click(function () {
        //         $('#orders1').hide();
        //     });
        // });

    </script>
<?php include "../Incluedes/panel-footer.php"; ?>
<?php else: $Funcs->redirectTo('../product.php'); ?>
<?php endif; ?>
