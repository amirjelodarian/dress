<?php
require_once "../Classes/initialize.php";
$DB->tableName = 'clothes';
if (!($SS->loggedIn())) $Funcs->redirectTo('../product.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $Funcs->pageTitle ?></title>
    <link rel="stylesheet" href="../style/css/style.css">
    <link rel="stylesheet" href="../style/bootstrap-4.1.3-dist/css/bootstrap.min.css">
    <script type="text/javascript" src="../style/bootstrap-4.1.3-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../style/jquery/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../style/js/app.js"></script>
    <script type="text/javascript" src="../style/jquery/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="../style/fontawesome/fontawesome-free-5.14.0-web/css/all.min.css">
    <link href="../style/select2/css/select2.min.css" rel="stylesheet" />
    <script src="../style/select2/js/select2.min.js"></script>
    <script type="text/javascript" src="../style/inline-jquery-editor/jq.js"></script>
    <script src="../style/inline-jquery-editor/jquery.inline-edit.js"></script>

</head>
<body onload="startTime()" id="bgc">
<?php
/* This is Error Message For All Request */
/* Start */
if ($Funcs->checkValue($_SESSION["errorMessage"],false,true)){
    echo '<script>window.alert("'.$Sessions::showErrorMessage().'");</script>';
    $SS->unsetErrorMessage();
}

/* End */
?>
<header id="header-panel">
    <div class="container">
        <img id="user-profile-pic" style="margin-top: 10px;border: 2px solid grey" src=<?= $Funcs->showPic('../style/images/UsersPics/' , $users->pro_pic,'../style/images/Defaults/default-user.png') ?> alt="" />
        <input type="file" id="user-profile-pic">
        <i class="fa fa-bars" id="panel-menu-icon"></i>
    </div>
</header>
<!--Start-for-Bars-->
<div class="panels" id="bars">
    <div class="panel">
        <nav>
            <ul>
                <li class="home-panel-btn"><a href="../">خانه</a><i class="fa fa-times" id="close" style="color: red;cursor: pointer"></i></li>
                <div class="DateTime">
                    <p id="today-time"></p>
                    <p id="today-date">
                        <?php $Funcs->todayDate(); ?>
                    </p>
                </div>
            </ul>
        </nav>
    </div>

    <div class="panel">

        <ul class="dropdown-list-panel">
            <li class="dropdown-main">
                <a href="profile.php">پروفایل</a>
            </li><br />
<!--            <li class="dropdown">-->
<!--                <a href="#" data-toggle="dropdown">سفارش های ساخته شده <i class="icon-arrow"></i></a>-->
<!--                <ul class="dropdown-menu">-->
<!--                    <li><a href="#">تیشرت</a></li><br />-->
<!--                    <li><a href="#">آستین بلند</a></li><br />-->
<!--                    <li><a href="#">شلوارک</a></li><br />-->
<!--                    <li><a href="#">شرت</a></li><br />-->
<!--                </ul>-->
<!--            </li><br />-->
                <li class="dropdown">
                    <a href="checkouts.php" data-toggle="dropdown">سفارش ها<i class="icon-arrow"></i></a>
                </li><br />
            <?php
            if($Users->isAdministrator() || $Users->isAdmin()){
                    if ($Clothes->selectPanelMenu('type',$DB->tableName)):
                        $menuResult = $Clothes->selectPanelMenu('type',$DB->tableName);
                        while ($Menu = $DB->fetchArray($menuResult)) : ?>
                            <li class="dropdown">
                                <a href="#" style="color: #FFFFFF" data-toggle="dropdown"><?= $Menu['type']; ?>
                                    <i class="icon-arrow"></i>
                                    <span style="color: #007bff"><?= $DB->count('clothes','id',"WHERE type='{$Menu['type']}'") ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    $subMenuResult = $Clothes->selectPanelSubMenu('model',$DB->tableName,$Menu['type']);
                                    while ($subMenu = $DB->fetchArray($subMenuResult)): ?>
                                        <li>
                                            <a href=<?= htmlspecialchars('index.php'). '?clothesType=' ?><?= urlencode($Menu['type']) . '&clothesModel=' . urlencode($subMenu['model']) ?> >
                                                <span style="color: #007bff"><?= $DB->count('clothes','id',"WHERE model='{$subMenu['model']}'") ?></span>

                                                    <?= $subMenu['model']; ?>
                                            </a>
                                        </li><br />
                                    <?php endwhile; ?>
                                </ul>
                            </li><br />
                        <?php
                        endwhile;
                    endif; ?>
                    <li class="dropdown-main">
                        <a href="addProduct.php" style="color: #FFFFFF">اضافه کردن محصول</a>
                    </li><br />
                    <li class="dropdown-main">
                        <a href="usersList.php">کاربران <span style="color: #007bff"><?= $DB->count('users','id') ?></span></a>
                    </li><br />
                    <?php
            }
            if($Users->isAdministrator() || $Users->isAdmin()): ?>
                <li class="dropdown-main">
                    <a href="commentsList.php">کامنت ها <span style="color: #007bff"><?= $DB->count('comments','id') ?></span></a>
                </li><br />
            <?php endif;
            if ($Users->isStandard()): ?>
                <li class="dropdown-main">
                    <a href="commentsList.php">کامنت ها <span style="color: #007bff"><?= $DB->count('comments','id'," WHERE user_id = {$Users->id}") ?></span></a>
                </li><br />
            <?php endif; ?>

            <li class="dropdown-main">
                <a href="../logout.php" id="logout">خروج</a>
            </li>
        </ul>
    </div>
</div>
