<?php
require_once "Classes/initialize.php";
$Funcs->pageTitle = "سبد خرید";
include "Incluedes/header.php";
!empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
$recordPerPage = 10;
$startFrom = ($page-1)*$recordPerPage;
?>



<main id="order-main">
   <div class="container">
       <?php if($SS->loggedIn()): ?>
            <p class="bg-warning bg-warning-customize">اگر محصول را ویرایش یا حذف کردید ، دکمه (بارگذاری مجدد) را بزنید تا اطلاعات بروز شود</p>
           <div class="col-12">
            <a href="#"><i class="fa fa-shopping-cart"></i><span id="cartOrderCount"><?=  $cart->cartOrderCount() ?></span></a>
           <hr>
            <a href="cart.php?page=<?= $page ?>" class="refresh-page-btn" id="refresh-page">بارگذاری مجدد<img src="style/images/SitePics/refresh-icon.png" /></a>
       <?php else: ?>
            <div class="single-product-message" id="verify-message">
               برای درج محصول و مشاهده سبد خرید باید وارد شوید یا حسابی بسازید
               <ul>
                   <li><a href='login.php?from=cart.php'>ورود</a></li>
                   <li><a href='register.php?from=cart.php'>ثبت نام</a></li>
               </ul>
           </div>
           </div>
       <?php endif; ?>
       <?php if($SS->loggedIn()): ?>
       <div class="row">
           <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
               <table class="table">
                   <thead class="thead-light">
                       <tr>
                           <th>قیمت واحد</th>
                           <th></th>
                           <th>تعداد</th>
                           <th>نام محصول</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php
                       $arrSize = sizeof($cart->calculateCart()['count']);
                       if(sizeof($cart->calculateCart()['price']) == $arrSize && sizeof($cart->calculateCart()['title']) == $arrSize):
                           for ($countPrice = 0 ; $countPrice < sizeof($cart->calculateCart()['count']) ; $countPrice++): ?>
                               <tr class="cart-table">
                                   <td><?= $Funcs->insertSeperator($cart->calculateCart()['price'][$countPrice]) ?><span> تومان </span></td>
                                   <td>x</td>
                                   <td><?= $cart->calculateCart()['count'][$countPrice] ?></td>
                                   <td><?= $cart->calculateCart()['title'][$countPrice] ?></td>
                               </tr><?php
                           endfor;
                       else:
                           echo "Something Wrong !";
                       endif; ?>
                   </tbody>
               </table>
               <hr />
               <div class="sum-product-word">
                   <span class="sum-product">جمع کل : </span>
                   <span class="sum-product sum-product-price"><?= $Funcs->insertSeperator($cart->calculateCart()['sum']) ?> تومان </span>
               </div>
               <a class="checkout-btn" href="checkout.php">نهایی کردن خرید</a>
           </div>
           <?php
           $userCartResult = $cart->showCartByUserId($startFrom,$recordPerPage);
           while($userCartRow = $DB->fetchArray($userCartResult)):
               $userClothesResult = $DB->selectById('clothes',$userCartRow['clothes_id']);
                if ($userClothesRow = $DB->fetchArray($userClothesResult)): ?>
                   <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 customize-col-lg-3-order" id="cart-<?= $userCartRow['clothes_id'] ?>">
                       <div class="around-single-cart">
                       <div class="orders" id="orders1">
                           <div class="L-order text-right">
                               <div class="container"><br>
                                   <img src=<?= $Funcs->showPic("style/images/ProductPics/",$userClothesRow['pic_loc'],'style/images/Defaults/default-product.jpg'); ?> alt=<?= stripslashes($userClothesRow['pic_loc']) ?> />
                               </div>
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
                                           <div class="value-button-decrease" id="decrease-<?= $userCartRow['clothes_id'] ?>" onclick="decreaseValue(<?= $userCartRow['clothes_id'] ?>,<?= $userClothesRow['count'] ?>)" value="Decrease Value">-</div>
                                           <input value="<?= $userCartRow['count'] ?>" id="number-<?= $userCartRow['clothes_id'] ?>" class="add-to-cart-value add-to-cart-value-<?= $userCartRow['clothes_id'] ?>" name="addToCartValue" value="1" min="1" max=<?= $userClothesRow['count'] ?> />
                                           <div class="value-button-increase" id="increase-<?= $userCartRow['clothes_id'] ?>" onclick="increaseValue(<?= $userCartRow['clothes_id'] ?>,<?= $userClothesRow['count'] ?>)" value="Increase Value">+</div>
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
                                                       url: "cartRequest.php",
                                                       method: "post",
                                                       dataType: "text",
                                                       data: {productId: product_id,addToCartValue: add_to_cart_value},
                                                       success:function (data) {
                                                           $("#add-to-cart-result-<?= $userCartRow['clothes_id'] ?>").fadeIn(0).fadeOut(1000);
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
                                       <p class="text-warning count-product-order"><?= $userClothesRow['count'] ?> عدد</p>
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
                                                       url: "cartRequest.php",
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
                                                               // reloadCartOrderCount();
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
                <?php endif;
           endwhile;
           ?>
       </div>
           <?php $Funcs->cartPagination('cart','user_id',$page,$recordPerPage); ?>
       </div>
       <?php endif; ?>
   </div>
</main>

<script>
    // function reloadCartOrderCount () {
    //     var sum = 0 ;
    //     var values = $('.add-to-cart-value').length;
    //     for (i = 0; i < values; i++) {
    //         //Push each element to the array
    //         sum += parseInt($('.add-to-cart-value').eq(i).val());
    //     }
    //     document.getElementById('cartOrderCount').innerHTML = sum;
    // }
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