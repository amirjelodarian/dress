<?php
require_once "Classes/initialize.php";
$Funcs->pageTitle = "سبد خرید";
include "Incluedes/header.php"; ?>



<main id="order-main">
   <div class="container">
       <div class="row">
           <div class="col-12">
               <a href="#"><i class="fa fa-shopping-cart"></i><span>3</span></a>
           </div>
<!--Start-order-1-->
           <div class="col-12 col-sm-6 col-md-6 col-lg-4 pt-5">
               <div class="orders" id="orders1">
                   <div class="L-order text-right">
                       <div class="container"><br>
                           <img src="style/images/SitePics/zh1.jpg" alt="">
                       </div>
                   </div>
                   <br>
                   <div class="R-order text-right">
                       <div class="container">
                           <h5>ژاکت مردانه با کیفیت و قیمت مناسب </h5>
                           <p>جنس : کاموا</p>
                           <p>رنگ : قهوه ای تیره</p>
                           <p>گارانتی اصالت و سلامت فیزیکی کالا</p>

                           <div class="btns d-flex float-right">
                               <button type="button" class="btn" onclick="plus1()"><i class="fa fa-plus"></i></button>
                               <p id="Number">0</p>
                               <button type="button" class="btn" onclick="minuse1()"><i class="fa fa-minus"></i></button>
                           </div>
                           <p class="trash1" style="margin-top: 80px;">حذف <i class="fa fa-trash" style="color: gray;"></i></p>
                           <p>120,000 تومان</p>
                       </div>
                   </div>
               </div>
           </div>
<!--End-order-1-->
<!--Start-order-2-->
           <div class="col-12 col-sm-6 col-md-6 col-lg-4 pt-5">
               <div class="orders" id="orders2">
                   <div class="L-order text-right">
                       <div class="container"><br>
                           <img src="style/images/SitePics/zh1.jpg" alt="">
                       </div>
                   </div>
                   <br>
                   <div class="R-order text-right">
                       <div class="container">
                           <h5>ژاکت مردانه با کیفیت و قیمت مناسب </h5>
                           <p>جنس : کاموا</p>
                           <p>رنگ : قهوه ای تیره</p>
                           <p>گارانتی اصالت و سلامت فیزیکی کالا</p>

                           <div class="btns d-flex float-right">
                               <button type="button" class="btn" onclick="plus2()"><i class="fa fa-plus"></i></button>
                               <p id="Number2">0</p>
                               <button type="button" class="btn" onclick="minuse2()"><i class="fa fa-minus"></i></button>
                           </div>
                           <p class="trash2" style="margin-top: 80px;">حذف <i class="fa fa-trash" style="color: gray;"></i></p>
                           <p>120,000 تومان</p>
                       </div>
                   </div>
               </div>
           </div>
<!--End-order-2-->
           <!--Start-order-3-->
           <div class="col-12 col-sm-6 col-md-6 col-lg-4 pt-5">
               <div class="orders" id="orders3">
                   <div class="L-order text-right">
                       <div class="container"><br>
                           <img src="style/images/SitePics/zh1.jpg" alt="">
                       </div>
                   </div>
                   <br>
                   <div class="R-order text-right">
                       <div class="container">
                           <h5>ژاکت مردانه با کیفیت و قیمت مناسب </h5>
                           <p>جنس : کاموا</p>
                           <p>رنگ : قهوه ای تیره</p>
                           <p>گارانتی اصالت و سلامت فیزیکی کالا</p>

                           <div class="btns d-flex float-right">
                               <button type="button" class="btn" onclick="plus3()"><i class="fa fa-plus"></i></button>
                               <p id="Number3">0</p>
                               <button type="button" class="btn" onclick="minuse3()"><i class="fa fa-minus"></i></button>
                           </div>
                           <p class="trash3" style="margin-top: 80px;">حذف <i class="fa fa-trash" style="color: gray;"></i></p>
                           <p>120,000 تومان</p>
                       </div>
                   </div>
               </div>
           </div>
           <!--End-order-3--> 

           <!--Start-order-4-->

           <!--End-order-4-->

       </div>
   </div>
</main>


<script type="text/javascript" src="style/js/app.js"></script>
<script>
    var a = 0 ;
    function plus1() {
        document.getElementById('Number').innerText = a++;
    }
    function minuse1() {
        document.getElementById('Number').innerText = a--;
    }
    $('.trash1').click(function () {
        $('#orders1').hide();
    })
    // Start-order2
    var b = 0;
    function plus2() {
        document.getElementById('Number2').innerText = b++;
    }
    function minuse2() {
        document.getElementById('Number2').innerText = b--;
    }
    $('.trash2').click(function () {
        $('#orders2').hide();
    })
    // End-order2

    // Start-order1
    var c = 0 ;
    function plus3() {
        document.getElementById('Number3').innerText = c++;
    }
    function minuse3() {
        document.getElementById('Number3').innerText = c--;
    }
    $('.trash3').click(function () {
        $('#orders3').hide();
    })
    // End-order1
</script>
<?php include "Incluedes/footer.php"; ?>