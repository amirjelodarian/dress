<?php

namespace Functions;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Clothes\Clothes;
use Sessions\Sessions;
use Rakit\Validation\Validator;
    class Functions {
        public $pageTitle = DEFAULT_PAGE_TITLE;
        public static $fileName;
        public function __construct(){
            self::$fileName = "";
        }
        public function uploadPic($file = "",$targetDir = "",$maxFileSize){
            global $DB,$Sessions;
                $targetDir = $targetDir;
                settype($maxFileSize, "integer");
                $files = $_FILES[$file];
                $targetFile = $targetDir . basename($files["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($files["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $_SESSION['errorMessage'] .= "فایل عکس نیس : {$check["mime"]} |";
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($targetFile)) {
                    $_SESSION['errorMessage'] .= "متاسفانه این عکس وجود دارد |";
                    $uploadOk = 0;
                }

                // Check file size
                if ($files["size"] > $maxFileSize) {
                    $_SESSION['errorMessage'] .= "حچم عکس کمتر از ۲ مگابایت باشد |";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $_SESSION['errorMessage'] .= "پسوند عکس نامعتبر است |";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $_SESSION['errorMessage'] .= "خطا هنگام آپلود فایل ! |";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($files["tmp_name"], $targetFile)) {
                        self::$fileName = $DB->escapeValue(basename($files["name"]));
                        return true;
                    } else {
                        $_SESSION['errorMessage'] .= "خطا هنگام آپلود فایل ! |";
                    }
                }
                    return $Sessions::showErrorMessage();

        }

        public function redirectTo($to,$jsRedirect = false){
            if ($jsRedirect == true){
                ?><script>window.location = '<?= $to ?>';</script><?php
            }else{
                header('Location: '.$to);
            }
        }

        public function checkValue($values = array(),$isset = false,$empty = false){
            $boolArr = array();
            if (is_array($values)){
                foreach ($values as $value) {
                    if($isset == true) {
                        if (isset($value))
                            array_push($boolArr,true);
                        else
                            array_push($boolArr,false);
                    }

                    if ($empty == true) {
                        if (!empty($value) && $value !== "")
                            array_push($boolArr,true);
                        else
                            array_push($boolArr,false);
                    }
                }
            }else{
                if($isset == true) {
                    if (isset($values))
                        array_push($boolArr,true);
                    else
                        array_push($boolArr,false);
                }

                if ($empty == true) {
                    if (!empty($values) && $values !== "")
                        array_push($boolArr,true);
                    else
                        array_push($boolArr,false);
                }
            }
                $failArr = array(false);
                if(array_intersect($boolArr,$failArr))
                    return false;
                else
                    return true;
        }

        public function calcOff($beforeOff = 0,$afterOff = 0){
            if (is_numeric($beforeOff) && is_numeric($afterOff)){
                settype($beforeOff,"integer");
                settype($afterOff,"integer");
                $calc = ($afterOff*100)/$beforeOff;
                return round(100-$calc);
            }else
                return "DB0";
        }

        public function EnFa($value,$toFa = false,$toEn = false){
            $en = array("0","1","2","3","4","5","6","7","8","9");
            $fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
            if ($toFa == true)
                return str_replace($en, $fa, $value);
            if ($toEn == true)
                return str_replace($fa, $en, $value);
        }
        public function showPic($picPath = "",$picName = "",$defaultPic = ""){
            if ($this->checkValue($picName,true,true)){
                $picName = stripslashes($picName);
                if (preg_match('/"/',$picName))
                    return "'" . $picPath.$picName . "'";
                elseif (preg_match("/'/",$picName))
                    return '"' . $picPath.$picName . '"';
                else
                    return '"' . $picPath.$picName . '"';
            }else
                return $defaultPic;
        }

        public function urlValue($value,$encode = ''){
            if ($encode == true)
                $value = str_replace(' ','%20',$value);
            if ($encode == false)
                $value = str_replace('%20',' ',$value);
            return $value;
        }

        public function clothesPagination($tableName,$type,$model,$tableId,$page = 1,$recordsPerPage = 10){
            global $Zebra,$DB;
            if ($type == '*')
                $result = $DB->selectAll('*',$tableName);
            if ($model == '*')
                $result = $DB->selectAll('*',$tableName," WHERE type='{$type}'");
            if ($model !== '*' && $type !== '*')
                $result = $DB->selectAll('*',$tableName,"WHERE type='{$type}' AND model='{$model}'");
            if ($model == '*' && $type == '*')
                $result = $DB->selectAll('*',$tableName);

            $totalRecord = $DB->numRows($result);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public function pagination($tableName,$tableId,$page = 1,$recordsPerPage = 10){
            global $Zebra,$DB;
            $result = $DB->selectAll($tableId,$tableName);
            $totalRecord = $DB->numRows($result);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public function cartPagination($tableName,$tableId,$page = 1,$recordsPerPage = 10){
            global $Zebra,$DB,$Users;
            $result = $DB->selectAll($tableId,$tableName,"WHERE user_id={$Users->id} AND checkout_id = 0 ");
            $totalRecord = $DB->numRows($result);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public function clothesSearchPagination($tableName,$keyword,$orderBy,$tableId,$page = 1,$recordsPerPage = 10,$indexPage = ''){
            global $Zebra,$DB;
            $keyword = $DB->escapeValue($keyword);
            switch ($orderBy){
                case 'clothes_title':
                    $result = $DB->selectAll('*',$tableName,"WHERE title LIKE '%{$keyword}%'");
                    break;
                case 'clothes_price':
                    $result = $DB->selectAll('*',$tableName,"WHERE off_price LIKE '{$keyword}%'");
                    break;
                case 'clothes_id':
                    settype($keyword,'integer');
                    $result = $DB->selectAll('*',$tableName,"WHERE id = {$keyword}");
                    break;
                default:
                    echo 'I know You Are A Hacker :)';
                    break;
            }

            $totalRecord = $DB->numRows($result);
            if ($indexPage == true){
                $Zebra->_properties['variable_name'] = 'searchPage';
            }else{
                $Zebra->base_url('index.php?'.'orderBy='.$orderBy.'&keyword='.$keyword);
                $Zebra->_properties['variable_name'] = 'orderBy='.$orderBy.'&keyword='.$keyword.'&searchPage';
                $Zebra->_properties['avoid_duplicate_content'] = false;
            }

//            $Zebra->_build_uri('index.php');
            $Zebra->set_page($page);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }

        public function usersSearchPagination($tableName,$keyword,$orderBy,$tableId,$page = 1,$recordsPerPage = 10,$indexPage = ''){
            global $Zebra,$DB;
            $keyword = $DB->escapeValue($keyword);
            switch ($orderBy){
                case 'user_username':
                    $result = $DB->selectAll('*',$tableName,"WHERE username LIKE '%{$keyword}%'");
                    break;
                case 'user_email':
                    $result = $DB->selectAll('*',$tableName,"WHERE email LIKE '%{$keyword}%'");
                    break;
                case 'user_tell':
                    $result = $DB->selectAll('*',$tableName,"WHERE tell LIKE '{$keyword}%'");
                    break;
                case 'user_id':
                        settype($keyword,'integer');
                        $result = $DB->selectAll('*',$tableName,"WHERE id = {$keyword}");
                    break;
                default:
                    echo 'I know You Are A Hacker :)';
                    break;
            }

            $totalRecord = $DB->numRows($result);
            if ($indexPage == true){
                $Zebra->_properties['variable_name'] = 'searchPage';
            }else{
                $Zebra->base_url('usersList.php?'.'orderBy='.$orderBy.'&keyword='.$keyword);
                $Zebra->_properties['variable_name'] = 'orderBy='.$orderBy.'&keyword='.$keyword.'&searchPage';
                $Zebra->_properties['avoid_duplicate_content'] = false;
            }

//            $Zebra->_build_uri('index.php');
            $Zebra->set_page($page);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }

        public function commentsSearchPagination($tableName,$keyword,$orderBy,$tableId,$page = 1,$recordsPerPage = 10,$indexPage = ''){
            global $Zebra,$DB;
            $keyword = $DB->escapeValue($keyword);
            switch ($orderBy){
                case 'comment_title':
                    $result = $DB->selectAll('*',$tableName,"WHERE title LIKE '%{$keyword}%'");
                    break;
                case 'comment_description':
                    $result = $DB->selectAll('*',$tableName,"WHERE description LIKE '%{$keyword}%'");
                    break;
                case 'comment_user_id':
                    settype($keyword,'integer');
                    $result = $DB->selectAll('*',$tableName,"WHERE user_id = {$keyword}");
                    break;
//                case 'comment_username':
//                        $result = $DB->selectAll('*',$tableName,"INNER JOIN users ON users.username LIKE '{$keyword}%'");
//                    break;
                case 'comment_email':
                    $result = $DB->selectAll('*',$tableName,"WHERE email LIKE '{$keyword}%'");
                    break;
                case 'comment_id':
                    settype($keyword,'integer');
                    $result = $DB->selectAll('*',$tableName,"WHERE id = {$keyword}");
                    break;
                default:
                    echo 'I know You Are A Hacker :)';
                    exit;
                    break;
            }

            $totalRecord = $DB->numRows($result);
            if ($indexPage == true){
                $Zebra->_properties['variable_name'] = 'searchPage';
            }else{
                $Zebra->base_url('commentsList.php?'.'orderBy='.$orderBy.'&keyword='.$keyword);
                $Zebra->_properties['variable_name'] = 'orderBy='.$orderBy.'&keyword='.$keyword.'&searchPage';
                $Zebra->_properties['avoid_duplicate_content'] = false;
            }

//            $Zebra->_build_uri('index.php');
            $Zebra->set_page($page);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public function checkoutsSearchPagination($tableName,$keyword,$orderBy,$tableId,$page = 1,$recordsPerPage = 10,$indexPage = ''){
            global $Zebra,$DB,$Users;
            switch ($orderBy){
                case 'checkout_id':
                    settype($keyword,'integer');
                    $result = $DB->selectAll('*',$tableName,"WHERE id = {$keyword} AND user_id = {$Users->id}");
                    break;
                default:
                    echo 'I know You Are A Hacker :)';
                    exit;
                    break;
            }

            $totalRecord = $DB->numRows($result);
            if ($indexPage == true){
                $Zebra->_properties['variable_name'] = 'searchPage';
            }else{
                $Zebra->base_url('checkouts.php?'.'orderBy='.$orderBy.'&keyword='.$keyword);
                $Zebra->_properties['variable_name'] = 'orderBy='.$orderBy.'&keyword='.$keyword.'&searchPage';
                $Zebra->_properties['avoid_duplicate_content'] = false;
            }

//            $Zebra->_build_uri('index.php');
            $Zebra->set_page($page);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public function divid_date_time_database($date_time){
            $time = substr($date_time,-8);
            $date = substr($date_time,0,10);
            return array($time,$date);
        }
        public function commentPagination($tableName,$tableId,$page = 1,$recordsPerPage = 10,$publish_mode){
            global $Zebra,$DB;
            $publish_mode = $DB->escapeValue($publish_mode);
            $result = $DB->selectAll($tableId,$tableName," WHERE publish_mode='{$publish_mode}'");
            $totalRecord = $DB->numRows($result);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public function checkoutsPagination($tableName,$tableId,$page = 1,$recordsPerPage = 10,$delivery){
            global $Zebra,$DB,$Users;
            $delivery = $DB->escapeValue($delivery);
            switch ($delivery){
                case 'delivery':
                    $result = $DB->selectAll($tableId,$tableName," WHERE user_id = {$Users->id} AND delivery_at != 0");
                    break;
                case 'not_delivery':
                    $result = $DB->selectAll($tableId,$tableName," WHERE user_id = {$Users->id} AND delivery_at = 0");
                    break;
                default:
                    break;
            }
            $totalRecord = $DB->numRows($result);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public function userCommentPagination($tableName,$tableId,$page = 1,$recordsPerPage = 10,$userId){
            global $Zebra,$DB;
            $userId = $DB->escapeValue($userId,true);
            $result = $DB->selectAll($tableId,$tableName," WHERE user_id = {$userId}");
            $totalRecord = $DB->numRows($result);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public function clothesCommentPagination($tableName,$tableId,$page = 1,$recordsPerPage = 10,$productId){
            global $Zebra,$DB;
            $productId = $DB->escapeValue($productId,true);
            $result = $DB->selectAll($tableId,$tableName," WHERE clothes_id = {$productId}");
            $totalRecord = $DB->numRows($result);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public static function nowDataTime(){
            return strftime('%Y-%m-%d %H:%M:%S');
        }
        public function todayDate($ger = ""){
            $now = strftime("%Y-%m-%d",time());
            $nowSplit = explode("-",$now);
            $YMD = array('year' => $nowSplit[0] , 'month' => $nowSplit[1] , 'day' => $nowSplit[2]);
            if (isset($ger) && $ger == true){
                echo $now;
            }else{
                $jalali = $this->gregorianToJalali($YMD['year'],$YMD['month'],$YMD['day']);
                echo $jalali[0]."/".$jalali[1]."/".$jalali[2];
            }
        }
        public function sendMail($sendToAddress,$code){
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->Mailer = "smtp";
                $mail->isSMTP();
                $mail->Host = 'ssl://smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;
//                $mail->SMTPOptions = array(
//                    'ssl' => array(
//                        'verify_peer' => false,
//                        'verify_peer_name' => false,
//                        'allow_self_signed' => true
//                    )
//                );
                $mail->Username   = EMAIL_USERNAME;
                $mail->Password   = EMAIL_PASSWORD;
                $mail->setFrom(EMAIL_USERNAME, EMAIL_FROM);
                $mail->addAddress($sendToAddress);
                $mail->CharSet = 'utf-8';
                $mail->ContentType = 'text/html;charset=utf-8';
                $mail->isHTML(true);

                $mail->Subject = EMAIL_SUBJECT;
                $mail->Body = $code;
                $send = $mail->send();
                if ($send){
                    echo "<br />";
                    echo 'کد با موفقیت به ایمیل ارسال شد';
                }
            }catch(Exception $e){
                echo 'مشکلی در ارسال کد به ایمیل پیش آمده';
            }
            $mail->SmtpClose();
        }

        public function rnd($values){
            global $DB;
            foreach ($values as $key => $value){
                if ($key == 'from' || $key == 'FROM' || $key == 'From' || $key == 'to' || $key == 'TO' || $key == 'To'){
                    if($key == 'from' || $key == 'FROM' || $key == 'From'){
                        $from = $DB->escapeValue($value,true);
                    }
                    if($key == 'to' || $key == 'TO' || $key == 'To'){
                        $to = $DB->escapeValue($value,true);
                        $rnd = rand($from,$to);
                        $_SESSION['randomCode'] = $rnd;
                        return $rnd;
                    }
                }
            }
            if ($key == 'mix' || $key == 'MIX' || $key == 'Mix' || $key == 'mixed' || $key == 'Mixed' || $key == 'MIXED'){
                $length = $value;
                $randomAlpha = md5(random_bytes(64));
                $captchaCode = substr($randomAlpha, 0, $length);
                $_SESSION['randomCode'] = $captchaCode;
                return $captchaCode;
            }

            // Example
            // echo $Funcs->rnd(['mix' => 5]);
            // echo $Funcs->rnd(['from' => 1000,'to' => 9999]);
        }
        public function showCaptcha(){
            $currentDir = getcwd();
            if (preg_match('/\/panel/',$currentDir))
                return '../Classes/captcha.php';
            else
                return 'Classes/captcha.php';
        }

        public function hideEmail($email){
            // extract email text before @ symbol
            $em = explode("@", $email);
            $name = implode(array_slice($em, 0, count($em) - 1), '@');

            // count half characters length to hide
            $length = floor(strlen($name) / 2);

            // Replace half characters with * symbol
            return substr($name, 0, $length-1) . str_repeat('*', $length-1) . substr($name, -1, 1) . "@" . end($em);

        }
        public function returnSomeThingByEqualTwoVal($firstVal,$secondVal,$message){
          if ($firstVal == $secondVal)
            return $message;
        }
        public function gregorianToJalali($gy, $gm, $gd) {
          $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
          $gy2 = ($gm > 2)? ($gy + 1) : $gy;
          $days = 355666 + (365 * $gy) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100)) + ((int)(($gy2 + 399) / 400)) + $gd + $g_d_m[$gm - 1];
          $jy = -1595 + (33 * ((int)($days / 12053)));
          $days %= 12053;
          $jy += 4 * ((int)($days / 1461));
          $days %= 1461;
          if ($days > 365) {
            $jy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
          }
          if ($days < 186) {
            $jm = 1 + (int)($days / 31);
            $jd = 1 + ($days % 31);
          } else{
            $jm = 7 + (int)(($days - 186) / 30);
            $jd = 1 + (($days - 186) % 30);
          }
          return array($jy, $jm, $jd);
        }
        public function jalaliToGregorian($jy, $jm, $jd) {
          $jy += 1595;
          $days = -355668 + (365 * $jy) + (((int)($jy / 33)) * 8) + ((int)((($jy % 33) + 3) / 4)) + $jd + (($jm < 7)? ($jm - 1) * 31 : (($jm - 7) * 30) + 186);
          $gy = 400 * ((int)($days / 146097));
          $days %= 146097;
          if ($days > 36524) {
            $gy += 100 * ((int)(--$days / 36524));
            $days %= 36524;
            if ($days >= 365) $days++;
          }
          $gy += 4 * ((int)($days / 1461));
          $days %= 1461;
          if ($days > 365) {
            $gy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
          }
          $gd = $days + 1;
          $sal_a = array(0, 31, (($gy % 4 == 0 and $gy % 100 != 0) or ($gy % 400 == 0))?29:28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
          for ($gm = 0; $gm < 13 and $gd > $sal_a[$gm]; $gm++) $gd -= $sal_a[$gm];
          return array($gy, $gm, $gd);
        }
        public function dateTimeToJalaliDate($dateTime = '',$seprator,$time = false){
          $date = substr($dateTime,0,10);
          $year = substr($date,0,4);
          $month = substr($date,5,2);
          $day = substr($date,8,2);
          $jalaliDate = $this->gregorianToJalali($year,$month,$day,'/');
          if ($time == true){
            $time = substr($dateTime,11);
            return $jalaliDate[0] . $seprator . $jalaliDate[1] . $seprator . $jalaliDate[2] . " " . $time;
          }
          else
            return $jalaliDate[0] . $seprator . $jalaliDate[1] . $seprator . $jalaliDate[2];
        }
        public function starByScore($star){
            settype($star,"string");
            switch($star){
                case "1":
                    echo '
                        <label id="deactive-star">☆</label>
                        <label id="deactive-star">☆</label>
                        <label id="deactive-star">☆</label>
                        <label id="deactive-star">☆</label>
                        <label id="active-star">★</label>
                    ';
                    break;
                case "2":
                    echo '
                        <label id="deactive-star">☆</label>
                        <label id="deactive-star">☆</label>
                        <label id="deactive-star">☆</label>
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                    ';
                    break;
                case "3":
                    echo '
                        <label id="deactive-star">☆</label>
                        <label id="deactive-star">☆</label>
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                    ';
                    break;
                case "4":
                    echo '
                        <label id="deactive-star">☆</label>
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                    ';
                    break;
                case "5":
                    echo '
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                        <label id="active-star">★</label>
                    ';
                    break;
                default:
                    echo "";
                    break;
                    
            }
        }
        public function ifEqual($value,$value2,$doAnyThing){
            if ($value == $value2){
                return $doAnyThing;
            }
        }
        public function insertSeperator($num) {
            settype($num,"String");
            $n = strlen($num);
            $i = 0;
            $help = $n % 3;
            while ($help != 0) {
                $num = '0'.$num;
                $i++;
                $n = strlen($num);
                $help = $n % 3;
            }
            $arr = str_split($num,3);
            $str = "";
            foreach ($arr as $index) {
                $str = $str.",".$index;
            }
            $i++;
            return substr($str,$i);
        }

        public function hash($password){
            $salt = "ODIN-NIDO-ENOLA-FERI-FERYR-THOR-LOKI-RAGNAROK";
            $salt2 = "OdIn-nIDo-EnOlA-FeRi-feRyR-tHoR-LokI-raGNaROk";
            $password = $salt.$password.$salt2;
            echo $password . "<hr />";
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            echo $hashed_password."<hr />".strlen($hashed_password)."<hr />";
            if(password_verify($password,$hashed_password))
                return false;
            else
                return true;
        }
        public function encrypt_decrypt($action, $string){
            /* =================================================
             * ENCRYPTION-DECRYPTION
             * =================================================
             * ENCRYPTION: encrypt_decrypt('encrypt', $string);
             * DECRYPTION: encrypt_decrypt('decrypt', $string) ;
             */
            $output = false;
            $encrypt_method = "AES-256-CBC";
            $secret_key = 'ODIN-NIDO-ENOLA-FERI-FERYR-THOR-LOKI-RAGNAROK';
            $secret_iv = 'OdIn-nIDo-EnOlA-FeRi-feRyR-tHoR-LokI-raGNaROk';
            // hash
            $key = hash('sha256', $secret_key);
            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $secret_iv), 0, 16);
            if ($action == 'encrypt') {
                $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
            } else {
                if ($action == 'decrypt') {
                    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
                }
            }
            return $output;
        }
    }
    $Funcs = new Functions();
    $Functions =& $Funcs;
?>
