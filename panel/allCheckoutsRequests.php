<?php
require_once "../Classes/initialize.php";
//if (($Users->isAdministrator() || $Users->isAdmin()) && !empty($_POST['delivery']))
//    $Delivery->addOrRemoveDelivery($_POST['delivery']);
//if ($Users->isDeliveryAgent() && !empty($_POST['delivery']) && !empty($_POST['codeDigitValue']))
//    echo $_POST['codeDigitValue'];
if (!empty($_POST['delivery']))
    if($Users->isAdministrator() || $Users->isAdmin() || $Users->isDeliveryAgent())
        $Delivery->addOrRemoveDelivery($_POST['delivery']);

?>