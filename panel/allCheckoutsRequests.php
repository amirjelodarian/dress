<?php
require_once "../Classes/initialize.php";
if(!empty($_POST['delivery'])){
    $Delivery->addOrRemoveDelivery($_POST['delivery']);
}
?>