<?php
namespace Classes;
class Cart{
    public $productsId;

    public function addCart($productId,$redirect = ""){
        global $SS,$DB,$Funcs,$Users;
        if ($SS->loggedIn()) {
            $userId = $DB->escapeValue($Users->id, true);
            $productId = $DB->escapeValue($productId, true);

            $cartCountResult = $DB->selectAll('count', 'cart', "WHERE user_id={$userId} AND clothes_id={$productId}");

            if ($DB->numRows($cartCountResult) == 0)
                if ($DB->insert("cart", "clothes_id,user_id,count,create_at", [$productId,$userId,1,$Funcs::nowDataTime()]))
                    echo "به سبد خرید با موفقیت افروده شد";
                else echo "مشکلی پیش آمد ! دوباره امتحان کنید";
            else{
                if($cartCount = $DB->fetchArray($cartCountResult)){
                    $cartCountVar = ((int)$cartCount['count'])+1;
                    if ($DB->update("cart", "count,create_at", [$cartCountVar,$Funcs::nowDataTime()]))
                        echo "به سبد خرید با موفقیت افروده شد";
                    else echo "مشکلی پیش آمد ! دوباره امتحان کنید";
                }
            }
        }else{
            if (!empty($redirect)){
                echo "برای افزودن به سبد خرید ابتدا وارد شوید یا حسابی بسازید";
                $Funcs->redirectTo($redirect);
            }else echo "برای افزودن به سبد خرید ابتدا وارد شوید یا حسابی بسازید";
        }


    }
}
$Carts = new Cart();
$Cart =& $Carts;
$cart =& $Carts;
$carts =& $Carts;
?>