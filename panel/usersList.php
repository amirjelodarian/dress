<?php include "../Incluedes/panel-menu.php"; ?>
<?php
    !empty($_GET['page']) ? $page = $DB->escapeValue($_GET['page'],true) : $page = 1;
    $recordPerPage = 50;
    $startFrom = ($page-1)*$recordPerPage;

if (!empty($_GET['orderBy']) && !empty($_GET['keyword'])) $searchMode = true;
else $searchMode = false;

if ($searchMode){
    !empty($_GET['searchPage']) ? $searchPage = $DB->escapeValue($_GET['searchPage'],true) : $searchPage = 1;
    $searchRecordPerPage = 50;
    $searchStartFrom = ($searchPage-1)*$searchRecordPerPage;
    if (!empty($_GET['keyword']) && !empty($_GET['orderBy'])) {
        $result = $Users->searchByUsernameOrEmailOrTell('users', $_GET['keyword'], $_GET['orderBy'], " LIMIT {$searchStartFrom},{$searchRecordPerPage}");
    }
}else
    $result = $Users->allUsersPanel($startFrom,$recordPerPage);
?>
<div class="main-col" style="overflow-x: scroll">
    <div class="panel-search">
        <input type="text" name="usersSearch" id="users-search" class="panel-search-bar"  placeholder="Search" />
        <select name="usersOrderBy" id="users-order-by" class="order-by">
            <option value="user_username">نام کاربری</option>
            <option value="user_email">ایمیل</option>
            <option value="user_tell">موبایل</option>
        </select>
    </div>
    <div class="loader-outside">
        <div class="loader"></div>
    </div>
    <div id="users-search-result"></div>
    <div id="users-main-result">
    <?php
        if ($Users->isAdministrator() || $Users->isAdmin()) { ?>
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
                        <?php
                    if ($Funcs->checkValue(array($result),false,true) && $DB->numRows($result) > 0) {
                        while ($allUser = $DB->fetchArray($result)): ?>
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
                    }else
                        echo "<p class='product-route' style='position: relative;top: 20px;font-size: 20px;float: right;right: 0;'>Error 404 ! Not Found</p>";
                        ?>
                    </tbody>
                </table>
                <?php
                if ($searchMode)
                    $Funcs->usersSearchPagination('users', $_GET['keyword'], $_GET['orderBy'], 'id', $searchPage, $searchRecordPerPage,true);
                else
                    $Funcs->pagination('users','id',$page,$recordPerPage);
        }
    ?>
    </div>
</div>
<?php include "../Incluedes/panel-footer.php"; ?>
