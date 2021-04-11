<?php
namespace Validate;
    class Validate{
        public static $errors = "";

        public function __construct(){

        }
        public static function validate($allRulesValues = [],$confirmValues = []){
            foreach ($allRulesValues as $key => $value){
                if (preg_match('/|/',$value)){
                    $rules = explode('|',$value);
                    foreach ($rules as $rule)
                        self::validation($key,$rule);

                }
                else{
                    self::validation($key,$value);
                }
            }
            if (isset($confirmValues)){
                foreach ($confirmValues as $confirmKey => $confirmValue){
                    if ($confirmKey == $confirmValue){
                    }else{
                        self::$errors .= "مغایرت در تکرار کپچا یا رمز|";
                    }
                }
            }
            return self::$errors;
        }
        private static function validation($key,$value){
            global $DB,$Funcs,$users;
            // Key equal POST or GET value :)
            if ($value == 'required'){
                if (empty($key))
                    self::$errors .= "برخی از فیلد ها خالی است|";
            }
            if ($value == 'set'){
                if (!(isset($key)))
                    self::$errors .= "برخی از فیلد ها ست نیست|";
            }
            if ($value == 'email'){
                if (!(filter_var($key,FILTER_VALIDATE_EMAIL)))
                    self::$errors .= "فرمت ایمیل وارد شده اشتباه است|";
            }
            if (preg_match('/min/',$value)){
                $minRule = explode(':',$value);
                if (strlen($key) < $minRule[1])
                    self::$errors .= "طول متن بیشتر از {$minRule[1]} کارکتر باشد|";
            }
            if (preg_match('/max/',$value)){
                $maxRule = explode(':',$value);
                if (strlen($key) > $maxRule[1])
                    self::$errors .= "طول متن کمتر از {$maxRule[1]} کارکتر باشد|";
            }
            if (preg_match('/unique/',$value)){
                $uniqueRule = explode(':',$value);
                $tableRule = $uniqueRule[1];
                $columnRule = $uniqueRule[2];
                $key = $DB->escapeValue($key);
                $uniqueResult = $DB->selectAll($columnRule,$tableRule," WHERE {$columnRule}='{$key}'");
                if ($DB->numRows($uniqueResult) !== 0)
                    self::$errors .= " از قبل وجود دارد {$key} |";
            }
            if ($value == 'tell'){
                if (!(filter_var($key,FILTER_VALIDATE_INT)) && !is_numeric($key) && !is_int($key))
                    self::$errors .= "شماره تلفن یا موبایل اشتباه است|";
            }


        }

        public static function fileUploadEmpty($fileName){
            if($_FILES[$fileName]['size'] == 0 && $_FILES[$fileName]['name'] == "")
                return true;
            else
                return false;

        }
        public static function showErrors(){
            if (self::$errors !== "") {
                $errors = explode('|',Validate::$errors);
                return $errors;
            }else
                return null;
        }
    }
$Validate = new Validate;
$validate =& $Validate;

?>