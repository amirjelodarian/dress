<?php
require_once 'Classes/initialize.php';
// Add To Cart
if(!empty($_POST['productId']) && !empty($_POST['addToCartValue']))
    $Cart->addCart($_POST['productId'],$_POST['addToCartValue']);

if(!empty($_POST['productId']) && !empty($_POST['trash']))
    $Cart->deleteCart($_POST['productId']);
// End Add To Cart
?>