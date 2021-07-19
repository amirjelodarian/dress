<?php include "../Incluedes/panel-menu.php"; ?>
<div class="main-col">
    <div class="container-fluid">
        <div class="row" style="margin-top: 12px">

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 dashboard-col-4">
                <a href="../">
                    <p class="dashboard-p-title">صفحه اصلی</p>
                    <i class="dashboard-icons icon-home"></i>
                    <div class="more-info-dashboard"><span class="icon-left-4"></span></div>
                </a>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 dashboard-col-3">
                <a href="commentsList.php">
                    <p class="dashboard-p-title">کامنت ها</p>
                    <p class="dashboard-count">
                        <?php if($Users->isAdministrator() || $Users->isAdmin()): ?>
                            <?= $DB->count('comments','id') ?>
                        <?php endif;
                        if ($Users->isStandard()): ?>
                            <?= $DB->count('comments','id'," WHERE user_id = {$Users->id}") ?>
                        <?php endif; ?>
                    </p>
                    <i class="dashboard-icons icon-comment"></i>
                    <div class="more-info-dashboard"><span class="icon-left-4"></span></div>
                </a>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 dashboard-col-2">
                <a href="checkouts.php">
                    <p class="dashboard-p-title">سفارشات</p>
                    <p class="dashboard-count"><?= $DB->count('checkout','id',"WHERE user_id = {$Users->id}") ?></p>
                    <i class="dashboard-icons icon-basket-2"></i>
                    <div class="more-info-dashboard"><span class="icon-left-4"></span></div>
                </a>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 dashboard-col-1">
                <a href="profile.php">
                    <p class="dashboard-p-title">پروفایل</p>
                    <i class="dashboard-icons icon-user"></i>
                    <div class="more-info-dashboard"><span class="icon-left-4"></span></div>
                </a>
            </div>

        </div>
    </div>
</div>
<?php include "../Incluedes/panel-footer.php"; ?>
