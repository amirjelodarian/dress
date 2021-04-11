<?php
require_once "../Classes/initialize.php";
!empty($_GET['searchPage']) ? $searchPage = $DB->escapeValue($_GET['searchPage'],true) : $searchPage = 1;
$recordPerPage = 50;
$startFrom = ($searchPage-1)*$recordPerPage;
if (isset($_POST['usersSearch']) && !(empty($_POST['usersSearch'])) && isset($_POST['usersOrderBy']) && !(empty($_POST['usersOrderBy']))){
    $allResult = $Users->searchByUsernameOrEmailOrTell('users',$_POST['usersSearch'],$_POST['usersOrderBy']," LIMIT {$startFrom},{$recordPerPage}");
    if ($Funcs->checkValue([$allResult],false,true) && $DB->numRows($allResult) > 0){  ?>
        <?php if ($Users->isAdministrator() || $Users->isAdmin()) : ?>
            <?= $users->user_mode ?>
            <table class="table table-bordered table-striped">
                <thead style="background: #454242;color: white">
                <tr>
                    <th scope="col" class="text-center">Id</th>
                    <th scope="col" class="text-center">نام کاربری</th>
                    <th scope="col" class="text-center">آخرین ورود</th>
                    <th scope="col" class="text-center">ایمیل</th>
                    <th scope="col" class="text-center">دسترسی</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($allUser = $DB->fetchArray($allResult)): ?>
                    <tr class="text-center">
                        <th scope="row">
                            <?= $allUser['id'] ?>
                            <?php
                            switch ($allUser['account_status']){
                                case "verified": ?>
                                    <img style="width: 15px;height: 15px" src="../style/images/SitePics/verified.png" alt="Verified" /><?php
                                    break;
                                case "not_verified": ?>
                                    <img style="width: 15px;height: 15px" src="../style/images/SitePics/not-verified.png" alt="Verified" /><?php
                                    break;
                            }
                            ?>
                        </th>
                        <td>
                            <?php
                            switch ($users) {
                                case $users->user_mode == "administrator":
                                    switch ($allUser['user_mode']) {
                                        case 'administrator':
                                            if ($users->id == $allUser['id']){ ?>
                                                <a href="editUser.php?id=<?= htmlspecialchars($allUser['id']) ?>">
                                                    <img class="profile-icon" id="user-profile-pic" alt="404" src=<?= $Funcs->showPic('../style/images/UsersPics/' , $allUser['pro_pic'],'../style/images/Defaults/default-user.png') ?> />
                                                    <?= $allUser['username'] ?>
                                                </a>
                                                <?php
                                            }else{ ?>
                                                <img class="profile-icon" id="user-profile-pic" alt="404" src=<?= $Funcs->showPic('../style/images/UsersPics/' , $allUser['pro_pic'],'../style/images/Defaults/default-user.png') ?> />
                                                <?= $allUser['username'] ?>
                                                <?php
                                            }
                                            break;
                                        case 'admin' || 'standard': ?>
                                            <a href="editUser.php?id=<?= htmlspecialchars($allUser['id']) ?>">
                                                <img class="profile-icon" id="user-profile-pic" alt="404" src=<?= $Funcs->showPic('../style/images/UsersPics/' , $allUser['pro_pic'],'../style/images/Defaults/default-user.png') ?> />
                                                <?= $allUser['username'] ?>
                                            </a>
                                            <?php
                                            break;
                                    }
                                    break;
                                case $users->user_mode == "admin":
                                    switch ($allUser['user_mode']) {
                                        case 'administrator': ?>
                                            <img class="profile-icon" id="user-profile-pic" alt="404" src=<?= $Funcs->showPic('../style/images/UsersPics/' , $allUser['pro_pic'],'../style/images/Defaults/default-user.png') ?> />
                                            <?= $allUser['username'] ?><?php
                                            break;
                                        case 'admin':
                                            if ($users->id == $allUser['id']){ ?>
                                            <a href="editUser.php?id=<?= htmlspecialchars($allUser['id']) ?>">
                                                <img class="profile-icon" id="user-profile-pic" alt="404" src=<?= $Funcs->showPic('../style/images/UsersPics/' , $allUser['pro_pic'],'../style/images/Defaults/default-user.png') ?> />
                                                <?= $allUser['username'] ?>
                                                </a><?php
                                            }else{ ?>
                                                <img class="profile-icon" id="user-profile-pic" alt="404" src=<?= $Funcs->showPic('../style/images/UsersPics/' , $allUser['pro_pic'],'../style/images/Defaults/default-user.png') ?> />
                                                <?= $allUser['username'] ?><?php
                                            }
                                            break;
                                        case 'standard': ?>
                                        <a href="editUser.php?id=<?= htmlspecialchars($allUser['id']) ?>">
                                            <img class="profile-icon" id="user-profile-pic" alt="404" src=<?= $Funcs->showPic('../style/images/UsersPics/' , $allUser['pro_pic'],'../style/images/Defaults/default-user.png') ?> />
                                            <?= $allUser['username'] ?>
                                            </a><?php
                                            break;
                                    }
                                    break;
                                default:
                                    echo "User Mode Have Error In DB !";
                                    break;
                            }
                            ?>
                        </td>
                        <td><?= $Funcs->dateTimeToJalaliDate($allUser['last_login'],'-',true) ?></td>
                        <td>
                            <?php
                            switch ($allUser['user_mode']) {
                                case "administrator":
                                    if ($users->user_mode == "admin" || $users->user_mode == "standard")
                                        echo $Funcs->hideEmail($allUser['email']);
                                    else
                                        echo $allUser['email'];
                                    break;
                                default:
                                    echo $allUser['email'];
                                    break;
                            }
                            ?>
                        </td>
                        <?php
                        switch ($allUser['user_mode']){
                            case "administrator": echo "<td style='background: #ff931d;text-align: center;color: white'>مدیر</td>"; break;
                            case "admin": echo "<td style='background: #007bff;text-align: center;color: white'>ادمین</td>"; break;
                            case "standard": echo "<td style='text-align: center'>استاندارد</td>"; break;
                        }
                        ?>
                    </tr>
                <?php
                endwhile;
                ?>
                </tbody>
            </table>
        <?php endif; ?>
<?php
        }else
        echo "<p class='product-route' style='position: relative;top: 20px;font-size: 20px;float: right;right: 0;'>Error 404 ! Not Found</p>";
    }
    ?>


    <!--                <div class="container">-->
    <!--                    <a href="more-Product.php" class="float-right mt-3" style="color: red;text-decoration: none"><i class="fa fa-angle-left" style="margin-right: 10px;"></i> More Product</a>-->
    <!--                </div>-->
    </div>
    <?php $Funcs->usersSearchPagination('users',$_POST['usersSearch'],$_POST['usersOrderBy'],'id',$searchPage,$recordPerPage); ?>
    </div>