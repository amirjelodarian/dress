<?php
namespace Classes;
class Cart{
    public $productsId;

    public function addCart($productId,$count,$redirect = ""){
        global $SS,$DB,$Funcs,$Users;
        if ($SS->loggedIn()) {
            $userId = $DB->escapeValue($Users->id, true);
            $productId = $DB->escapeValue($productId, true);
            $cartCountResult = $DB->selectAll('count', 'cart', "WHERE user_id={$userId} AND clothes_id={$productId} AND checkout_id=0");
            $clothesCountResult = $DB->selectAll('count', 'clothes', "WHERE id={$productId}");
            if ($clothesCount = $DB->fetchArray($clothesCountResult)) {
                if ($this->cartCountValidate($count, $clothesCount['count'])){
                    if ($DB->numRows($cartCountResult) == 0)
                        if ($DB->insert("cart", "clothes_id,user_id,count,create_at", [$productId, $userId, $count, $Funcs::nowDataTime()]))
                            echo "به سبد خرید درج شد";
                        else echo "مشکلی پیش آمد ! دوباره امتحان کنید";
                    else {
                        if ($cartCount = $DB->fetchArray($cartCountResult)) {
                            if ($DB->update("cart", "count,create_at", [$count, $Funcs::nowDataTime()],"WHERE user_id={$userId} AND clothes_id={$productId}"))
                                echo "به سبد خرید درج شد";
                            else echo "مشکلی پیش آمد ! دوباره امتحان کنید";
                        }
                    }
                }
            }
        }else{
            if (!empty($redirect)){
                echo "برای افزودن به سبد خرید ابتدا وارد شوید یا حسابی بسازید";
                $Funcs->redirectTo($redirect);
            }else echo "برای افزودن به سبد خرید ابتدا وارد شوید یا حسابی بسازید";
        }

    }

    public function cartCountValidate($count,$clothesCount){
        $errMssg = "";
        switch ($count){
            case !(filter_var($count, FILTER_VALIDATE_INT)):
                $errMssg = "تعداد عدد نیست !";
                break;
            case !($count <= $clothesCount):
                $errMssg = "تعداد وارد شده حد مجاز نیست ! !";
                break;
        }
        if($errMssg !== ""){
            echo $errMssg;
            return false;
        }else{
            return true;
        }
    }

    public function cartOrderCount(){
        global $DB,$Users;
        $result = $DB->selectById('cart',$Users->id,'SUM(count) AS count',' AND checkout_id = 0','user_id');
        if($row = $DB->fetchArray($result))
                $order = $row['count'];
        ($order == "" || empty($order)) ? $order = '0' : $order;
        return $order;
    }

    public function showCartByUserId($startFrom,$recordPerPage){
        global $DB,$Users;
        $result = $DB->selectAll('*','cart',"WHERE user_id={$Users->id} AND checkout_id = 0 ORDER BY cart.id DESC LIMIT {$startFrom},{$recordPerPage}");
        return $result;
    }
    public function cartByUserId(){
        global $DB,$Users;
        $result = $DB->selectAll('*','cart',"WHERE user_id={$Users->id} AND checkout_id = 0");
        return $result;
    }

    public function deleteCart($productId){
        global $DB,$Users;
        if(!($DB->delete("cart", "clothes_id,user_id", [$productId,$Users->id])))
            echo "مشکی در حذف پیش آمد!";
    }

    public function calculateCart(){
        global $DB,$Users;
//        $userCartResult = $DB->selectAll('*','cart',"WHERE user_id={$Users->id}");
        $userCartResult = $DB->selectById('cart',$Users->id,'*',' AND checkout_id = 0','user_id');
        $sum = 0;
        $count = [];
        $price = [];
        $title = [];
        while ($userCartRow = $DB->fetchArray($userCartResult)){
//            $userClothesResult = $DB->selectAll('off_price AS off_price','clothes',"WHERE clothes.id={$userCartRow['clothes_id']}");
            $userClothesResult = $DB->selectById('clothes',$userCartRow['clothes_id'],'off_price AS off_price,title AS title');
            if ($userClothesRow = $DB->fetchArray($userClothesResult)){
                $sum += (int)$userCartRow['count'] * (int)$userClothesRow['off_price'];
                array_push($count,$userCartRow['count']);
                array_push($price,$userClothesRow['off_price']);
                array_push($title,$userClothesRow['title']);
            }
        }
        return [
            'sum'   => $sum,
            'count' => $count,
            'price' => $price,
            'title' => $title
        ];
    }
}
$Carts = new Cart();
$Cart =& $Carts;
$cart =& $Carts;
$carts =& $Carts;
?>