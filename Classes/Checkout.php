<?php


namespace Classes;

class Checkout{
    public $id; // INT(9)
    public $user_id; // INT(9)
    public $clothes_id; // TEXT  [1,5,4,8,9]
    public $first_name; // VARCHAR(255)
    public $last_name; // VARCHAR(255)
    public $tell; // VARCHAR(255)
    public $state; // VARCHAR(255)
    public $city; // VARCHAR(255)
    public $address; // VARCHAR(255)
    public $zip; // VARCHAR(255)
    public $order_desciption; // TEXT
    public $delivery_id; // // VARCHAR(255)
    public $create_at; // // VARCHAR(255)
    public function fillCheckoutAttribute(){
        global $DB,$Users;
        $checkoutResult = $DB->selectById('checkout',$Users->id,'*','','user_id');
        if ($checkoutRow = $DB->fetchArray($checkoutResult)){
            $allAttr = get_class_vars(get_class($this));
            $arrKey = array_keys($allAttr);
            foreach ($arrKey as $key)
                $this->{$key} = $checkoutRow[$key];
            $DB->freeResult($checkoutResult);
        }
    }

    public function addCheckout($values = []){
        global $DB,$Users,$Funcs;
        $values = $this->fillAddProductValues($values);

        if ($DB->insert('checkout','user_id,clothes_id,first_name,last_name,tell,address,state,city,zip,order_description,create_at',$values)){
            // Change clothes.count product when checkout
            $cartClothesIdAndCountResult = $DB->selectAll('clothes_id AS clothes_id,cart.count AS count','cart',"WHERE user_id={$Users->id} AND checkout_id = 0");
            while ($cartClothesIdAndCountRow = $DB->fetchArray($cartClothesIdAndCountResult)){
                $countOfCart = $cartClothesIdAndCountRow['count'];
                settype($countOfCart,"integer");
                $clothesCountResult = $DB->selectAll('clothes.id AS id , clothes.count AS count','clothes',"WHERE clothes.id={$cartClothesIdAndCountRow['clothes_id']}");
                if ($clothesCountRow = $DB->fetchArray($clothesCountResult)){
                    $countOfClothes = $clothesCountRow['count'];
                    settype($countOfClothes,'integer');
                    $nowCountOfStock = $countOfClothes - $countOfCart;
                    $DB->update('clothes','clothes.count',[$nowCountOfStock],"WHERE clothes.id={$clothesCountRow['id']}");
                }
            }
            /////////////////////////////////////////////


            // find this check out id for change cart.checkout_id
            $changeCartCheckoutId = $this->changeCartCheckoutId();
            /////////////////////////////////////////////////////


            $Funcs->redirectTo("panel/singleCheckout.php?id={$changeCartCheckoutId}");
        }
    }
    protected function fillAddProductValues($values){
        global $DB,$Users,$Funcs;
        $clothesId = [];
        $userCartResult = $DB->selectById('cart',$Users->id,'clothes_id AS clothes_id',' AND checkout_id = 0','user_id');

        // find cart clothes_id and insert to array = 1,8,9
        while ($userCartRow = $DB->fetchArray($userCartResult))
            array_push($clothesId,$userCartRow['clothes_id']);
        $clothesId = implode(',',$clothesId);
        array_unshift($values,$clothesId);
        ///////////////////////////////////////////////////

        // insert user_id in array values
        array_unshift($values,$Users->id);
        /////////////////////////////////

        // insert now time
        array_push($values,$Funcs::nowDataTime());
        //////////////////
        return $values;
    }
    protected function changeCartCheckoutId(){
        global $DB,$Users;
        // find this check out id for change cart.checkout_id
        $checkoutIdResult = $DB->selectAll('max(id) AS id','checkout',"WHERE user_id={$Users->id} ORDER BY id DESC LIMIT 1");
        /////////////////////////////////////////////////////

        // and update cart.ckeckout_id to top value
        if ($checkoutIdRow = $DB->fetchArray($checkoutIdResult))
            $DB->update('cart','checkout_id',[$checkoutIdRow['id']],"WHERE user_id={$Users->id} AND checkout_id = 0");
        ///////////////////////////////////////////

        return $checkoutIdRow['id'];
    }

    public function allCheckoutByUserId($delivery,$startFrom,$recordPerPage){
        global $DB,$Users;
        switch ($delivery){
            case 'delivery':
                $result = $DB->selectAll('*','checkout'," WHERE user_id='{$Users->id}' AND delivery_id != 0 ORDER BY checkout.id DESC LIMIT {$startFrom},{$recordPerPage}");
                break;
            case 'not_delivery':
                $result = $DB->selectAll('*','checkout'," WHERE user_id='{$Users->id}' AND delivery_id = 0 ORDER BY checkout.id DESC LIMIT {$startFrom},{$recordPerPage}");
                break;
            default:
                echo "Sorry , Don't Change Value My Hacker Friend :D";
                exit;
                break;
        }
        return $result;
    }
    public function allCheckout($delivery,$startFrom,$recordPerPage){
        global $DB;
        switch ($delivery){
            case 'delivery':
                $result = $DB->selectAll('*','checkout'," WHERE delivery_id != 0 ORDER BY checkout.id DESC LIMIT {$startFrom},{$recordPerPage}");
                break;
            case 'not_delivery':
                $result = $DB->selectAll('*','checkout'," WHERE delivery_id = 0 ORDER BY checkout.id DESC LIMIT {$startFrom},{$recordPerPage}");
                break;
            default:
                echo "Sorry , Don't Change Value My Hacker Friend :D";
                exit;
                break;
        }
        return $result;
    }
    public function allCheckoutSearchByUserId($checkoutId,$startFrom,$recordPerPage){
        global $DB,$Users;
        $checkoutId = $DB->escapeValue($checkoutId,true);
        $result = $DB->selectAll('*','checkout'," WHERE checkout.id = {$checkoutId} AND user_id='{$Users->id}' ORDER BY checkout.id DESC LIMIT {$startFrom},{$recordPerPage}");
        return $result;
    }
    public function allCheckoutSearch($checkoutSearch,$checkoutsOrderBy,$startFrom,$recordPerPage){
        global $DB,$Users;
        $checkoutSearch = $DB->escapeValue($checkoutSearch,true);
        $checkoutsOrderBy = $DB->escapeValue($checkoutsOrderBy);

        switch ($checkoutsOrderBy){
            case 'checkout_id':
                $result = $DB->selectAll('*','checkout'," WHERE checkout.id = {$checkoutSearch} ORDER BY checkout.id DESC LIMIT {$startFrom},{$recordPerPage}");
                break;
            case 'user_id':
                $result = $DB->selectAll('*','checkout'," WHERE checkout.user_id = {$checkoutSearch} ORDER BY checkout.id DESC LIMIT {$startFrom},{$recordPerPage}");
                break;
            case 'delivery_user_id' && ($Users->isAdministrator() || $Users->isAdmin()):
                $deliveryResult = $DB->selectAll('checkout_id AS checkout_id','delivery'," WHERE user_id = {$checkoutSearch} ORDER BY delivery.id DESC LIMIT {$startFrom},{$recordPerPage}");
                $deliveryCheckoutIds = [];
                while ($deliveryRow = $DB->fetchArray($deliveryResult))
                    array_push($deliveryCheckoutIds,$deliveryRow['checkout_id']);
                $deliveryCheckoutIds = implode(',',$deliveryCheckoutIds);
                $result = $DB->selectAll('*','checkout'," WHERE checkout.id IN ({$deliveryCheckoutIds}) ORDER BY checkout.id DESC LIMIT {$startFrom},{$recordPerPage}");
                break;
            default:
                echo 'I know You Are A Hacker :)';
                exit;
                break;
        }
        return $result;
    }
}
$Checkout = new Checkout();
$checkout =& $Checkout;
$CHECKOUT =& $Checkout;
$CheckOut =& $Checkout;
$co =& $Checkout;
$CO =& $Checkout;