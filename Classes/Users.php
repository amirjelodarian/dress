<?php
namespace Users;
    use Functions\Functions;
    use Validate\Validate;

    class Users{
        public $id; // INT(9)
        public $username; // TINYTEXT 255 Char
        public $user_mode;
        public $account_status;
        public $email;
        public $password; // TINYTEXT 255 Char
        public $tell; // TINYTEXT 255 Char
        public $address; // TEXT
        public $first_name; // TINYTEXT 255 Char
        public $last_name; // TINYTEXT 255 Char
        public $create_at; // DATETIME
        public $last_login; // DATETIME
        public $pro_pic; // TINYTEXT 255 Char

        public function __construct(){
            global $SS;
            if ($SS->loggedIn()){
                $this->fillUserAttribute($_SESSION['userId']);
                if (empty($this->id) || $this->id == "") $SS->logOut('../product.php');
            }
            $this->administratorByEmail(ADMINISTRATOR_EMAIL);
            $this->cancelAdministratorByEmail(CANCEL_ADMINISTRATOR_EMAIL);
        }
        // This Functions For Register Page
        public function addUser($values = array(),$fileNameForUpload = "",$username,$email,$password,$redirect){
            global $DB,$Funcs,$SS;

            if ($Funcs->checkValue($fileNameForUpload,true,true)){
                $Funcs->uploadPic($fileNameForUpload, 'style/images/UsersPics/', '2097152');
                array_push($values,Functions::$fileName);
                array_push($values,'standard');
                array_push($values,'not_verified');
                if($DB->insert("users", "username,password,email,create_at,last_login,pro_pic,user_mode,account_status", $values)){
                    $this->selectByUsernamePasswordEmail($username,$email,$password);
                    $SS->redirectSession();
                    $Funcs->redirectTo($redirect);
                }
                else
                    $_SESSION['errorMessage'] = "خطایی رخ داد !|";
            } else {
                array_push($values,'standard');
                array_push($values,'not_verified');
                if($DB->insert("users", "username,password,email,create_at,last_login,user_mode,account_status", $values)){
                    $this->selectByUsernamePasswordEmail($username,$email,$password);
                    $SS->redirectSession();
                    $Funcs->redirectTo($redirect);
                }
                else
                    $_SESSION['errorMessage'] = "خطایی رخ داد !|";
            }
        }

        public function editUser($values = [],$username,$fileNameForUpload = ""){
            global $DB,$users,$Funcs;
            $username = $DB->escapeValue($username);
            $uniqueResult = $DB->selectAll('username', 'users', " WHERE username='{$username}'");
            if ($DB->numRows($uniqueResult) !== 0 && $username !== $users->username){
                echo "<div class='e-message'>";
                echo "<p>" . " از قبل وجود دارد {$username}" . "</p>";
                echo "</div>";

            }else{
                if($fileNameForUpload !== "") {
                    $Funcs->uploadPic($fileNameForUpload, '../style/images/UsersPics/', '2097152');
                    array_push($values,Functions::$fileName);
                    $DB->update('users', 'username,first_name,last_name,address,tell,pro_pic', $values, "WHERE id = {$users->id}");
                    $Funcs->redirectTo('profile.php');
                }else{
                    $DB->update('users', 'username,first_name,last_name,address,tell', $values, "WHERE id = {$users->id}");
                    $Funcs->redirectTo('profile.php');
                }
            }
        }

        public function selectByUsernamePasswordEmail($username = "",$email = "",$password =""){
            global $DB;
            $username = $DB->escapeValue($username);
            $password = $DB->escapeValue($password);
            $email = $DB->escapeValue($email);
            $result = $DB->selectAll('*','users',"WHERE username='{$username}' AND password='{$password}' AND email='{$email}'");
            if ($DB->numRows($result) == 1){
                if ($allResult = $DB->fetchArray($result)){
                    $_SESSION['userId'] = $allResult['id'];
                }
            }else{
                $_SESSION['errorMessage'] .= "کاربران یونیکد نیستند|";
            }
        }
        ////////////////////////////////////////////////////////////

        // This Function For Login Page
        public function selectByUsernameOrEmailAndPassword($usernameOrEmail,$password,$redirect = ''){
            global $DB,$validate,$Funcs,$SS;
            $usernameOrEmail = $DB->escapeValue($usernameOrEmail);
            $password = $DB->escapeValue($password);
            if (filter_var($usernameOrEmail,FILTER_VALIDATE_EMAIL))
                $result = $DB->selectAll('*','users',"WHERE email='{$usernameOrEmail}' AND password='{$password}'");
            else
                $result = $DB->selectAll('*','users',"WHERE username='{$usernameOrEmail}' AND password='{$password}'");

            if ($DB->numRows($result) == 1){
                if ($allResult = $DB->fetchArray($result)){
                    $_SESSION['userId'] = $allResult['id'];
                    $DB->update('users','last_login',"{$Funcs::nowDataTime()}"," WHERE id={$_SESSION['userId']}");
                    $SS->redirectSession();
                    $Funcs->redirectTo($redirect);
                }
            }else{
                 echo 'ایمیل یا نام کاربری با رمز مطابقت ندارد';
            }
        }
        ///////////////////////////////////////////

        public function fillUserAttribute($userId){
            global $DB;
            $userResult = $DB->selectById('users',$userId);
            if ($userRow = $DB->fetchArray($userResult)){
                $allAttr = get_class_vars(get_class($this));
                $arrKey = array_keys($allAttr);
                foreach ($arrKey as $key)
                    $this->{$key} = $userRow[$key];
                $DB->freeResult($userResult);
            }
        }
        public function allUsersPanel($startFrom,$recordPerPage){
            global $DB;
            $allUsersResult = $DB->selectAll('*','users',"ORDER BY users.id DESC LIMIT {$startFrom},{$recordPerPage}");
            return $allUsersResult;
        }
        private function administratorByEmail($emails){
            global $DB;
            if ($emails !== ""){
                foreach ($emails as $email){
                    if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
                        $result = $DB->selectAll('user_mode','users',"WHERE email='{$email}'");
                        if ($DB->numRows($result) !== 0) {
                            if ($userModeRow = $DB->fetchArray($result)) {
                                if ($userModeRow['user_mode'] !== "administrator") $DB->update('users', 'user_mode', 'administrator', "WHERE email='{$email}'");
                            }
                        }else{
                            $_SESSION['errorMessage'] = "مشکلی در لیست ایمیل های مدیر وجود دارد و کاربری با این ایمیل وجود ندارد";
                            $_SESSION['errorMessage'] .= "\\n $email \\n";
                        }
                    }else{
                        $_SESSION['errorMessage'] = "فرمت ایمیل مدیران صحیح نیست";
                        $_SESSION['errorMessage'] .= "\\n $email \\n";
                    }
                }
            }
        }
        private function cancelAdministratorByEmail($emails){
            global $DB;
            if ($emails !== ""){
                foreach ($emails as $email=>$user_mode){
                    if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
                        $result = $DB->selectAll('user_mode','users',"WHERE email='{$email}'");
                        if ($DB->numRows($result) !== 0) {
                            if ($userModeRow = $DB->fetchArray($result)) {
                                if ($userModeRow['user_mode'] == "administrator"){
                                  $DB->update('users', 'user_mode', "{$user_mode}", "WHERE email='{$email}'");
                                }
                            }
                        }else{
                            $_SESSION['errorMessage'] = "مشکلی در لیست ایمیل های تبدیل مدیر به کاربر عادی وجود دارد و کاربری با این ایمیل وجود ندارد";
                            $_SESSION['errorMessage'] .= "\\n $email \\n";
                        }
                    }else{
                        $_SESSION['errorMessage'] = "فرمت ایمیل مدیر به کاربر عادی صحیح نیست";
                        $_SESSION['errorMessage'] .= "\\n $email \\n";
                    }
                }
            }
        }
        public function editPanelUser($values = [],$fileNameForUpload = "",$id){
            global $DB,$Funcs,$Sessions,$users;
            $id = $DB->escapeValue($id,true);
            if ($Funcs->checkValue($fileNameForUpload,true,true)){
                $Funcs->uploadPic($fileNameForUpload, '../style/images/UsersPics/', '2097152');
                array_push($values,Functions::$fileName);
                if ($users->user_mode == "administrator"){
                    if($DB->update("users", "first_name,last_name,tell,address,user_mode,pro_pic", $values," WHERE id = {$id}"))
                        $Funcs->redirectTo("editUser.php?id={$id}");
                    else
                        $_SESSION['errorMessage'] = "خطایی رخ داد !|";
                }else {
                    if($DB->update("users", "first_name,last_name,tell,address,pro_pic", $values," WHERE id = {$id}"))
                        $Funcs->redirectTo("editUser.php?id={$id}");
                    else
                        $_SESSION['errorMessage'] = "خطایی رخ داد !|";
                }
            }else {
              if ($users->user_mode == "administrator"){
                  if($DB->update("users", "first_name,last_name,tell,address,user_mode", $values," WHERE id = {$id}"))
                      $Funcs->redirectTo("editUser.php?id={$id}");
                  else
                      $_SESSION['errorMessage'] = "خطایی رخ داد !|";
              }else {
                  if($DB->update("users", "first_name,last_name,tell,address", $values," WHERE id = {$id}"))
                      $Funcs->redirectTo("editUser.php?id={$id}");
                  else
                      $_SESSION['errorMessage'] = "خطایی رخ داد !|";
              }
            }
        }
        public function deletePanelUser($id){
            global $DB,$Funcs,$Sessions;
            $id = $DB->escapeValue($id,true);

                    $result = $DB->selectById('users',$id,"pro_pic");
                    if ($row = $DB->fetchArray($result)) {
                        $pic_name = $row['pro_pic'];
                        unlink("../style/images/UsersPics/{$pic_name}");
                        $DB->delete("users", "id", $id);
                        $Funcs->redirectTo("index.php");
                    } else
                    $_SESSION['errorMessage'] = "خطایی رخ داد !|";
        }
        public function deleteImgPanelUser($id){
            global $DB,$Funcs,$Sessions;
            $id = $DB->escapeValue($id,true);

            $result = $DB->selectById('users',$id,"pro_pic");
                if ($row = $DB->fetchArray($result)) {
                    $pic_name = $row['pro_pic'];
                    unlink("../style/images/UsersPics/{$pic_name}");
                    $DB->update('users','pro_pic',''," WHERE id={$id} ");
                    $Funcs->redirectTo("editUser.php?id={$id}");
                }
                else
                $_SESSION['errorMessage'] = "خطایی رخ داد !|";
        }
        public function isAdministrator($redirectTo = ''){
          global $Funcs;
          if($this->user_mode == "administrator"){
            return true;
          }else{
            if (!empty($redirectTo))
              $Funcs->redirectTo($redirectTo);
          }

        }
        public function isAdmin($redirectTo = ''){
          global $users;
          if($this->user_mode == "admin")
            return true;
          else{
            if (!empty($redirectTo))
              $Funcs->redirectTo($redirectTo);
          }
        }
        public function isStandard($redirectTo = ''){
          global $users;
          if($this->user_mode == "standard")
            return true;
          else{
            if (!empty($redirectTo))
              $Funcs->redirectTo($redirectTo);
          }
        }

        public function searchByUsernameOrEmailOrTell($tableName,$keyword,$usernameOrEmailOrTell,$customSQL = "",$reverseId = ""){
            global $DB;
            $keyword = $DB->escapeValue($keyword);
            $usernameOrEmailOrTell = $DB->escapeValue($usernameOrEmailOrTell);
            switch ($usernameOrEmailOrTell){
                case 'user_username':
                    if ($reverseId == true)
                        $result = $DB->selectAll('*',$tableName,"WHERE username LIKE '%{$keyword}%' ORDER BY id DESC {$customSQL}");
                    else
                        $result = $DB->selectAll('*',$tableName,"WHERE username LIKE '%{$keyword}%' {$customSQL}");
                    break;
                case 'user_email':
                    if ($reverseId == true)
                        $result = $DB->selectAll('*',$tableName,"WHERE email LIKE '%{$keyword}%' ORDER BY id DESC {$customSQL}");
                    else
                        $result = $DB->selectAll('*',$tableName,"WHERE email LIKE '%{$keyword}%' {$customSQL}");
                    break;
                case 'user_tell':
                    if ($reverseId == true)
                        $result = $DB->selectAll('*',$tableName,"WHERE tell LIKE '{$keyword}%' ORDER BY id DESC {$customSQL}");
                    else
                        $result = $DB->selectAll('*',$tableName,"WHERE tell LIKE '{$keyword}%' {$customSQL}");
                    break;
                case 'user_id':
                    settype($keyword,'integer');
                    if ($reverseId == true)
                        $result = $DB->selectAll('*',$tableName,"WHERE id = {$keyword} ORDER BY id DESC {$customSQL}");
                    else
                        $result = $DB->selectAll('*',$tableName,"WHERE id = {$keyword} {$customSQL}");
                    break;
                default:
                    echo 'I know You Are A Hacker :)';
                    break;
            }
            if (isset($result)){
                if($DB->numRows($result) > 0){
                    return $result;
                }else{
                    return false;
                }
            }else
                return false;
        }
    }
    $Users = new Users();
    $users =& $Users;
