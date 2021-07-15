<?php
require_once "Classes/initialize.php";
$Funcs->pageTitle = "سبد خرید";
include "Incluedes/header.php";
!empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
$recordPerPage = 50;
$startFrom = ($page-1)*$recordPerPage;
?>



    <main id="order-main">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if($SS->loggedIn()): ?>
                        <a href="#"><i class="fa fa-shopping-cart"></i><span id="cartOrderCount"><?=  $cart->cartOrderCount() ?></span></a>
                    <?php else: ?>
                        <div class="single-product-message" id="verify-message">
                            برای ثبت نظر بایستی به حساب کاربری خود وارد شوید یا حسابی بسازید
                            <ul>
                                <li><a href='login.php?from=singleProduct.php?id=<?= $allRow['id'] ?>'>ورود</a></li>
                                <li><a href='register.php?from=singleProduct.php?id=<?= $allRow['id'] ?>'>ثبت نام</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
                <!--Start-order-1-->
                <?php
                $userCartResult = $cart->showCartByUserId($startFrom,$recordPerPage);
                while($userCartRow = $DB->fetchArray($userCartResult)):
                    $userClothesResult = $DB->selectById('clothes',$userCartRow['clothes_id']);
                    if ($userClothesRow = $DB->fetchArray($userClothesResult)):
                        ?>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-4 pt-5" id="cart-<?= $userCartRow['clothes_id'] ?>">
                            <div class="orders" id="orders1">
                                <div class="L-order text-right">
                                    <div class="container"><br>
                                        <img src=<?= $Funcs->showPic("style/images/ProductPics/",$userClothesRow['pic_loc'],'style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($userClothesRow['pic_loc']) ?> />
                                    </div>
                                </div>
                                <br>
                                <div class="R-order text-right">
                                    <div class="container">
                                        <h5><?= $userClothesRow['title'] ?></h5>
                                        <p>قیمت نهایی : <?= $userClothesRow['off_price'] ?></p>
                                        <p>رنگ : <span><?= $userClothesRow['color'] ?></span></p>

                                        <div class="btns d-flex float-right">
                                            <div class="number-increase-decrease">
                                                <div class="value-button-decrease" id="decrease-<?= $userCartRow['clothes_id'] ?>" onclick="decreaseValue(<?= $userCartRow['clothes_id'] ?>,<?= $userClothesRow['count'] ?>);reloadCartOrderCount();" value="Decrease Value">-</div>
                                                <input value="<?= $userCartRow['count'] ?>" id="number-<?= $userCartRow['clothes_id'] ?>" class="add-to-cart-value add-to-cart-value-<?= $userCartRow['clothes_id'] ?>" name="addToCartValue" value="1" min="1" max=<?= $userClothesRow['count'] ?> />
                                                <div class="value-button-increase" id="increase-<?= $userCartRow['clothes_id'] ?>" onclick="increaseValue(<?= $userCartRow['clothes_id'] ?>,<?= $userClothesRow['count'] ?>);reloadCartOrderCount();" value="Increase Value">+</div>
                                            </div>
                                            <input name='productId' id="product-id-<?= $userCartRow['clothes_id'] ?>" type="hidden" value="<?= $userCartRow['clothes_id'] ?>" />
                                        </div>
                                        <div id="add-to-cart-result-<?= $userCartRow['clothes_id'] ?>" class="add-cart-message">
                                            <div class="loader-outside">
                                                <div class="loader" style="max-width: 20px;max-height: 20px"></div>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function (){
                                                $('#decrease-<?= $userCartRow['clothes_id'] ?>,#increase-<?= $userCartRow['clothes_id'] ?>').click(function (){
                                                    var product_id = $('#product-id-<?= $userCartRow['clothes_id'] ?>').val();
                                                    var add_to_cart_value = $('.add-to-cart-value-<?= $userCartRow['clothes_id'] ?>').val();
                                                    if (product_id != ''){
                                                        $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").html('');
                                                        $.ajax({
                                                            url: "ordersRequest.php",
                                                            method: "post",
                                                            dataType: "text",
                                                            data: {productId: product_id,addToCartValue: add_to_cart_value},
                                                            success:function (data) {
                                                                $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").show();
                                                                $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").html(data);
                                                                if (data == "" || data == null){
                                                                    $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").hide();
                                                                }
                                                            }
                                                        });
                                                    }else{
                                                        $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").html('برخی پارامتر ها خالی است');
                                                    }
                                                });
                                            });
                                        </script>
                                        <br />
                                        <div class="S_Description" style="text-align: right;float: right">
                                            <p style="display:inline-block"><?= $userClothesRow['count'] ?> عدد</p>
                                            <span style="display:inline-block">موجودی در انبار</span>
                                        </div>
                                        <input class="trash1" name="trash" type="submit" value="حذف" id="trash-<?= $userCartRow['clothes_id'] ?>" style="margin-top: 10px;color: red;border: none;background:none" /><i class="fa fa-trash" style="color: gray;"></i>
                                        <script>
                                            $(document).ready(function(){
                                                $('#trash-<?= $userCartRow['clothes_id'] ?>').click(function (){
                                                    var product_id = $('#product-id-<?= $userCartRow['clothes_id'] ?>').val();
                                                    var trash = $('#trash-<?= $userCartRow['clothes_id'] ?>').val();
                                                    if (product_id != '' && trash){
                                                        $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").html('');
                                                        $.ajax({
                                                            url: "ordersRequest.php",
                                                            method: "post",
                                                            dataType: "text",
                                                            beforeSend: function() {
                                                                $('.loader-outside').show();
                                                            },
                                                            data: {productId: product_id,trash: trash},
                                                            success:function (data) {
                                                                $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").show();
                                                                $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").html(data);
                                                                if (data == "" || data == null){
                                                                    $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").remove();
                                                                    $("#cart-<?= $userCartRow['clothes_id'] ?>").remove();
                                                                    reloadCartOrderCount();
                                                                }else {
                                                                    $("#cart-<?= $userCartRow['clothes_id'] ?>").show();
                                                                }

                                                            }
                                                        });
                                                    }else{
                                                        $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").html('برخی پارامتر ها خالی است');
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endif;
                endwhile;
                ?>

            </div>
        </div>
    </main>

    <script>
        function reloadCartOrderCount () {
            var sum = 0 ;
            var values = $('.add-to-cart-value').length;
            for (i = 0; i < values; i++) {
                //Push each element to the array
                sum += parseInt($('.add-to-cart-value').eq(i).val());
            }
            document.getElementById('cartOrderCount').innerHTML = sum;
        }
    </script>
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
<?php include "Incluedes/footer.php"; ?>