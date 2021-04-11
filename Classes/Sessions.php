<?php
namespace Sessions;
    class Sessions{
        public function __construct(){
            global $Funcs;
            session_start();
            if(!isset($_SESSION['errorMessage'])){
                $_SESSION['errorMessage'] = "";
                $_SESSION['randomCode'] = "";
            }
        }
        public static function showErrorMessage(){
            global $Funcs;
            if ($Funcs->checkValue(array($_SESSION["errorMessage"]),false,true)){
                $_SESSION['errorMessage'] = explode('|',$_SESSION['errorMessage']);
                $_SESSION['errorMessage'] = implode("\\n",$_SESSION['errorMessage']);
                return $_SESSION["errorMessage"];
            }
        }
        public function unsetErrorMessage(){
            $_SESSION["errorMessage"] = "";
            unset($specSess);
        }

        public function loggedIn(){
            global $users;
            if (isset($_SESSION['userId']) && !empty($_SESSION['userId']))
                return true;
            else
                return false;
        }
        public function logOut($redirect){
            global $Funcs;
            if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
                $_SESSION['userId'] = "";
                $_SESSION['userMode'] = "";
                $_SESSION['accountStatus'] = "";
                unset($_SESSION['userId']);
                unset($_SESSION['userMode']);
                unset($_SESSION['accountStatus']);
                $Funcs->redirectTo($redirect);
            }

        }
        public function redirectSession() {
            if (isset($_SESSION['redirect']) && !empty($_SESSION['redirect'])) {
                $_SESSION['redirect'] = '';
                unset($_SESSION['redirect']);
            }
        }
    }
    $Sessions = new Sessions();
    $SS =& $Sessions;
?>