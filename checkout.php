<?php
require_once "Classes/initialize.php";
$Funcs->pageTitle = "نهایی کردن خرید";
include "Incluedes/header.php";
include "vendor/autoload.php";
use Rakit\Validation\Validator;
if(  ($SS->loggedIn())   &&   ($DB->numRows($cart->cartByUserId()) !== 0)  ): ?>
    <div class="container checkout">
        <div class="py-5 text-center">
            <h2 class="checkout-title">نهایی کردن خرید</h2>
<!--            <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>-->
        </div>

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 order-md-1">
                <?php
                if (isset($_POST['checkoutSubmit'])){
                    $validator = new Validator;
                    $validation = $validator->make($_POST, [
                        'firstName' => 'required|min:2|max:255',
                        'lastName'  => 'required|min:2|max:255',
                        'tell'      => 'required|min:11|max:11|regex:/^((09))[0-9]{9}/',
                        'address'   => 'required|min:8|max:600',
                        'state'     => 'required|min:2|max:255',
                        'city'      => 'required|min:2|max:255',
                        'zip'       => 'required|min:10|max:10|regex:/^[0-9]{10}/',
                        'orderDescription'  => 'nullable|max:500'
                    ]);

                    $validation->setMessages([
                        'required'      => 'برخی از فیلد ها خالی است',
                        'firstName:min' => '"نام" نمی تواند کمتر از 2 حرف باشد',
                        'firstName:max' => '"نام" نمی تواند بیشتر از 255 حرف باشد',
                        'lastName:min'  => '"نام خانوادگی" نمی تواند کمتر از 3 حرف باشد',
                        'lastName:max'  => '"نام خانوادگی" نمی تواند بیشتر از 255 حرف باشد',
                        'tell:min'      => '"شماره تلفن" نباید کمتر از 11 رقم باشد',
                        'tell:max'      => '"شماره تلفن" نباید بیشتر از 11 رقم باشد',
                        'tell:regex'    => '"شماره تلفن" معتبر نیست',
                        'address:min'   => '"آدرس" نباید کمتر از 8 حرف باشد',
                        'address:max'   => '"آدرس" نباید بیشتر از 600 حرف باشد',
                        'state:min'     => '"استان" نباید کمتر از ۲ حرف باشد',
                        'state:max'     => '"استان" نباید بیشتر از 255 حرف باشد',
                        'city:min'      => '"شهر" نباید کمتر از 2 حرف باشد',
                        'city:max'      => '"شهر" نباید بیشتر از 255 حرف باشد',
                        'zip:regex'     => '"کد پستی" معتبر نیست',
                        'zip:min'       => '"کد پستی" نباید کمتر از 10 رقم باشد',
                        'zip:max'       => '"کد پستی" نباید بیشتر از 10 رقم باشد',
                        'orderDescription:min' => '"توضیحات سفارش" نباید بیشتر از 500 حرف باشد'
                    ]);
                    $validation->validate();
                    if($validation->fails()) {
                        $errors = $validation->errors();
                        echo "<div class='e-message' style='direction: rtl;text-align: right'>
                                <h4 style='margin: 8px'>خطاهای زیر را رفع کنید</h4>";
                        foreach ($errors->all() as $error)
                            echo "<p style='margin: 6px;'>{$error}</p>";
                        echo "</div>";
                    }else{
//                        !empty($_POST['orderDescription']) ? '' : $_POST['orderDescription'] = " ";
                       $checkout->addCheckout([
                               $_POST['firstName'],
                               $_POST['lastName'],
                               $_POST['tell'],
                               $_POST['address'],
                               $_POST['state'],
                               $_POST['city'],
                               $_POST['zip'],
                               $_POST['orderDescription']
                       ]);
                    }



                }
                ?>
<!--                <h4 class="mb-3">Billing address</h4>-->
                <form class="needs-validation" method="post">
                    <div class="row">
                        <div class="col-md-4 col-xs-12" id="checkout-first-name">
                            <label for="firstName">نام</label>
                            <input type="text" class="form-control" name="firstName" placeholder="علی" value="<?= $Users->first_name ?>" required />
                        </div>
                        <div class="col-md-4 col-xs-12" id="checkout-last-name">
                            <label for="lastName">نام خانوادگی</label>
                            <input type="text" class="form-control" name="lastName" placeholder="کریمی" value="<?= $Users->last_name ?>" required />
                        </div>
                        <div class="col-md-4 col-xs-12" id="checkout-tell">
                            <label for="tell">شماره تلفن معتبر</label>
                            <input type="text" class="form-control" name="tell" value="<?= $Users->tell ?>" placeholder="09121234567" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3" id="checkout-state">
                            <label for="country">استان</label>
                            <input type="text" name="state" class="form-control"placeholder="تهران" required />
                        </div>
                        <div class="col-md-4 mb-3" id="checkout-city">
                            <label for="city">شهر</label>
                            <input type="text" name="city" class="form-control" placeholder="تهران" required />
                        </div>
                        <div class="col-md-4 mb-3" id="checkout-zip">
                            <label for="zip">کد پستی</label>
                            <input type="text" class="form-control" name="zip" placeholder="1234567891" required />
                        </div>
                    </div>
                    <div class="mb-3" id="checkout-address">
                        <label for="address">آدرس دقیق</label>
                        <input type="text" class="form-control" name="address" value="<?= $Users->address ?>" placeholder="خیابان طاهری - کوچه بهار - پلاک ۱" required />
                    </div>
                    <hr class="mb-4">
                    <h4 class="mb-3">راه پرداخت</h4>

                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked />
                            <label class="custom-control-label" for="credit">پرداخت در محل</label>
                        </div>
                    </div>
                    <div class="mb-3" id="checkout-address">
                        <label for="address">توضیحات سفارش (دلخواه)</label>
                        <input type="text" class="form-control" name="orderDescription" placeholder="ممنون از سایت شما" />
                    </div>
                    <hr class="mb-4">
                    <div class="outside-checkout-submit">
                        <input class="checkout-btn checkout-submit" value="تایید" name="checkoutSubmit" type="submit" />
                    </div>

                </form>
            </div>
            <div class="col-md-2" style="position: absolute;float: right"></div>
        </div>

    </div>
<?php else: $Funcs->redirectTo('product.php'); ?>
<?php endif; ?>
<?php include "Incluedes/footer.php"; ?>