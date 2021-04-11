<?
    require_once "../Classes/initialize.php";
    if(isset($_GET["type"]) && !empty($_GET["type"]))
        $Clothes->selectAutoComplete($_GET["type"], 'type');

    if(isset($_GET["model"]) && !empty($_GET["model"]))
        $Clothes->selectAutoComplete($_GET["model"], 'model');

    if(isset($_GET["fabricType"]) && !empty($_GET["fabricType"]))
        $Clothes->selectAutoComplete($_GET["fabricType"], 'fabric_type');

    if(isset($_GET["size"]) && !empty($_GET["size"]))
        $Clothes->selectAutoComplete($_GET["size"], 'size');

    if(isset($_GET["color"]) && !empty($_GET["color"]))
        $Clothes->selectAutoComplete($_GET["color"], 'color');

?>
