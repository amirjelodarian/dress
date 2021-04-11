<?php
date_default_timezone_set('Asia/Tehran');
    ob_start();

    // Database Configuration
    defined('DB_HOST') ? null : define('DB_HOST','localhost');
    defined('DB_USER') ? null : define('DB_USER','root');
    defined('DB_PASS') ? null : define('DB_PASS','');
    defined('DB_NAME') ? null : define('DB_NAME','dress');
    ///////////////////////////

    // Email Configuration
    defined('EMAIL_USERNAME') ? null : define('EMAIL_USERNAME','amirjelodarian@gmail.com');
    defined('EMAIL_PASSWORD') ? null : define('EMAIL_PASSWORD','amir0007amir0007');
    defined('EMAIL_FROM') ? null : define('EMAIL_FROM','امروز کالا');
    defined('EMAIL_SUBJECT') ? null : define('EMAIL_SUBJECT','کد شما');
    //////////////////////


    // Administrator Emails
    defined('ADMINISTRATOR_EMAIL') ? null : define('ADMINISTRATOR_EMAIL',[

    ]);
    ///////////////////////


    // Cancel Administrator Emails
    defined('CANCEL_ADMINISTRATOR_EMAIL') ? null : define('CANCEL_ADMINISTRATOR_EMAIL',[
      
    ]);

    ///////////////////////////

    // For Default Page Title
    defined('DEFAULT_PAGE_TITLE') ? null : define('DEFAULT_PAGE_TITLE','امروز کالا');
    //////////////////////////

    require_once "Database.php";
    require_once "Validate.php";
    require_once "Sessions.php";
    require_once "Functions.php";
    require_once "Clothes.php";
    require_once "Users.php";
    require_once "Comments.php";
    $currentDir = getcwd();
    if (preg_match('/\/panel/',$currentDir) || preg_match('/\/Classes/',$currentDir)) {
        require_once '../vendor/stefangabos/zebra_pagination/Zebra_Pagination.php';
        require '../vendor/phpmailer/phpmailer/src/Exception.php';
        require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require '../vendor/phpmailer/phpmailer/src/SMTP.php';
    }
    else{
        require_once 'vendor/stefangabos/zebra_pagination/Zebra_Pagination.php';
        require 'vendor/phpmailer/phpmailer/src/Exception.php';
        require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require 'vendor/phpmailer/phpmailer/src/SMTP.php';
    }
?>
