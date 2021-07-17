<?php require_once "Classes/initialize.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $Funcs->pageTitle ?></title>
    <link rel="stylesheet" href="style/css/style.css">
    <link rel="stylesheet" href="style/bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script type="text/javascript" src="style/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="style/jquery/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="style/jquery/jquery-3.5.1.min.js"></script>
    <script src="vendor/stefangabos/zebra_pagination/public/javascript/zebra_pagination.js"></script>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <link rel="stylesheet" href="node_modules/ion-rangeslider/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="style/fontawesome/fontawesome-free-5.14.0-web/css/all.min.css">
    <link rel="stylesheet" href="vendor/stefangabos/zebra_pagination/public/css/zebra_pagination.css" type="text/css">
</head>
<body style="background: #eeeeee;">
<?php
if ($Funcs->checkValue($_SESSION["errorMessage"],false,true)){
    echo '<script>window.alert("'.$Sessions::showErrorMessage().'");</script>';
    $SS->unsetErrorMessage();
}
?>
<!--    For-header-->
<header id="header-for-desktop">
    <div class="container">
        <div class="row">
            <div class="col-5">
                <div class="L-header">
                    <form action="">
                        <input type="text" placeholder="دنبال چی میگردی ؟">
                    </form>
                    <nav>
                        <ul class="d-flex">
                            <?php if ($SS->loggedIn()){
                                ?>
                                <li><a href="panel" class="panel-btn">پنل کاربری</a></li>
                                <li><a class="logout" href="logout.php">خروج</a></li>
                            <?php }else{ ?>
                            <li><a href="login.php">ورود</a></li>
                            <li><a href="register.php">ثبت نام</a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-2">
                <div class="C-header text-center">
                    <img src="style/images/SitePics/img_245610.png" alt="">
                </div>
            </div>
            <div class="col-5">
                <div class="R-header">
                    <nav>
                        <ul>
                            <li><a href="index.php">صفحه اصلی</a></li>
                            <li><a href="product.php">محصولات</a></li>
                            <li>
                                <a href="cart.php"><i class="fa fa-shopping-cart"></i>
                                    <?php if($SS->loggedIn()){ ?>
                                        <span style="color: red"><?=  $cart->cartOrderCount() ?></span>
                                    <?php } ?>
                                    سبد خرید
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<header id="header-for-phone" class="text-center">
    <div class="container">
        <img src="style/images/SitePics/img_245610.png" alt="">
        <i class="fa fa-bars" id="menu-btn"></i>
    </div>
</header>
<!--Start-for-bars-->
<div class="bars" id="mobile-menu">
    <header id="mobile-menu-child">
        <div class="container">
            <form action="">
                <input type="text" placeholder="دنبال چی میگردی ؟">
            </form>
            <i class="fa fa-times"></i>
        </div>
    </header>
    <main id="mobile-menu-child">
        <div class="row">
            <?php if ($SS->loggedIn()){ ?>
                <div class="col-12">
                    <div class="box">
                        <div class="container">
                            <a href="panel" class="panel-btn">پنل کاربری</a>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="box">
                        <div class="container">
                            <a class="logout" href="logout.php">خروج</a>
                        </div>
                    </div>
                </div>
            <?php }else{ ?>

            <div class="col-12">
                <div class="box">
                    <div class="container">
                        <a href="register.php">ثبت نام</a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="box">
                    <div class="container">
                        <a href="login.php">ورود</a>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-12">
                <div class="box">
                    <div class="container">
                        <a href="index.php">صفحه اصلی</a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="box">
                    <div class="container">
                        <a href="product.php">محصولات</a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="box">
                    <div class="container">
                        <a href="cart.php"><i class="fa fa-shopping-cart"></i>
                            <?php if($SS->loggedIn()){ ?>
                                <span style="color: red"><?=  $cart->cartOrderCount() ?></span>
                            <?php } ?>
                            سبد خرید
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
