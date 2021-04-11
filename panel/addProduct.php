<?
    include "../Incluedes/panel-menu.php";
if (isset($_POST['addNewProduct'])){
    if ($Funcs->checkValue([$_POST["type"], $_POST["model"], $_POST["title"], $_POST["fabricType"], $_POST["description"], $_POST["size"], $_POST["color"], $_POST["price"], $_POST["offPrice"]],true,true)){
        if($_FILES['uploadFile']['size'] == 0 && $_FILES['uploadFile']['name'] == "")
            $Clothes->addProduct([$_POST["type"], $_POST["model"], $_POST["title"], $_POST["fabricType"], $_POST["description"], $_POST["size"], $_POST["color"], $Funcs->EnFa($_POST["price"],false,true), $Funcs->EnFa($_POST["offPrice"],false,true)]);
        else
            $Clothes->addProduct([$_POST["type"], $_POST["model"], $_POST["title"], $_POST["fabricType"], $_POST["description"], $_POST["size"], $_POST["color"], $Funcs->EnFa($_POST["price"],false,true), $Funcs->EnFa($_POST["offPrice"],false,true)], "uploadFile");
    }else{
        $_SESSION["errorMessage"] .= "برخی از فیلد ها خالیست .";
        $Funcs->redirectTo("addProduct.php");
    }
}
?>
    <!--        Start-for-add-product-->
<div class="main-col">
    <div id="for-product">
        <form enctype="multipart/form-data" id="add-product-form" name="addNewProductForm" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="img-product2">
                <div class="off-glue">
                    <p id="off-place"></p>
                </div>
                <label for="add-product" id="uploadImageIcon"><i class="fa fa-image"></i></label>
                <input type="file" name="uploadFile" id="add-product" />
                <input type='hidden' name='MAX_FILE_SIZE' value='2097152' />
            </div>
            <div class="add-text">
                <div class="l-add-text">
                    <input type="text" class="limitToNumber" id="clothes-price" name="price" placeholder="قبل تخفیف" required>
                </div>
                <div class="r-add-text">
                    <input type="text" id="clothes-title" name="title" placeholder="نام مدل" required>
                </div>
            </div>
            <div class="add-about-product">
                <textarea name="description" id="description" cols="30" rows="10" placeholder="مشخصات محصول را وارد کنید" required></textarea>
            </div>
            <div class="themselve-clothes-type">

                <input type="text" id='type-clothes' class="clothes-type" name="type" placeholder="مردانه" autocomplete="off" required />
                <ul class="result-list" id="type-result"></ul>

                <input type="text" id="model-clothes" class="clothes-type" name="model" placeholder="تیشرت" autocomplete="off" required />
                <ul class="result-list" id="model-result"></ul>

                <input type="text" id="fabricType-clothes" class="clothes-type" name="fabricType" placeholder="جنس محصول" autocomplete="off" required />
                <ul class="result-list" id="fabricType-result"></ul>

                <input type="text" id="size-clothes" class="clothes-type" name="size" placeholder="سایز" autocomplete="off" required />
                <ul class="result-list" id="size-result"></ul>

                <input type="text" id="color-clothes" class="clothes-type" name="color" placeholder="رنگ" autocomplete="off"  required />
                <ul class="result-list" id="color-result"></ul>

            </div>


            <div class="add-off">
                <input type="text" class="limitToNumber" id="off-price" name="offPrice" placeholder="بعد تخفیف">
                <input type="submit" id="add-product-submit" name="addNewProduct" value="اضافه کردن محصول" />
            </div>
        </form>
    </div>
</div>
<?php include "../Incluedes/panel-footer.php"; ?>
