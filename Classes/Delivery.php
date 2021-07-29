<?php
namespace Classes;

class Delivery{
    public $id; // INT(9) NOT NULL
    public $checkout_id; // INT(9) NOT NULL
    public $user_id; // INT(9)  deliverer ID NOT NULL
    public $total_price; // VARCHAR(255) NOT NULL
    public $create_at; // VARCHAR(255) NOT NULL


    public function addOrRemoveDelivery($checkoutDeliveryValue){
        global $DB,$Users,$Funcs;
        if($Users->isAdministrator() || $Users->isAdmin() || $Users->isDeliveryAgent()) {
            $checkoutDeliveryValue = $DB->escapeValue($checkoutDeliveryValue);
            $deliveryModeArray = explode('_', $checkoutDeliveryValue);
            $deliveryMode = $deliveryModeArray[0];
            $deliveryModeId = $DB->escapeValue($deliveryModeArray[1], true);
            switch ($deliveryMode) {
                case 'delivery':
                    $deliveryNumRowsResult = $DB->selectAll('id','delivery',"WHERE checkout_id = {$deliveryModeId}");
                    if ($DB->numRows($deliveryNumRowsResult) == 0){
                        $totalPrice = $this->calculateTotalPrice($deliveryModeId);
                        $DB->insert('delivery','checkout_id,user_id,total_price,create_at',[$deliveryModeId,$Users->id,$totalPrice,$Funcs::nowDataTime()]);
                        $deliveryResult = $DB->selectAll('max(id) AS id','delivery',"WHERE checkout_id={$deliveryModeId} AND user_id={$Users->id}");
                        if ($deliveryRow = $DB->fetchArray($deliveryResult)){
                            if ($DB->update("checkout", "delivery_id", $deliveryRow['id'], " WHERE checkout.id = {$deliveryModeId}"))
                                echo "تحویل (CID : <span style='color: black;'>{$deliveryModeId}</span>)";
                        }
                    }else
                        echo "Before Added !";

                    break;
                case 'notDelivery' && ($Users->isAdministrator() || $Users->isAdmin()):
                        $DB->delete('delivery','checkout_id',$deliveryModeId);
                        if ($DB->update("checkout", "delivery_id", "0", " WHERE checkout.id = {$deliveryModeId}"))
                            echo "تحویل نشده (CID : <span style='color: black;'>{$deliveryModeId}</span>)";
                    break;
                default:
                    echo "Access Denied ! ";
                    exit;
                    break;
            }
        }   else{
            echo "I know you are hacker :)";
        }
    }

    private function calculateTotalPrice($checkoutId){
        global $cart,$Funcs;
        return $cart->calculateCart($checkoutId)['sum'];
    }
}
$Delivery = new Delivery();
$delivery =& $Delivery;
$DELIVERY =& $Delivery;
$dlvry =& $Delivery;
$DLVRY =& $Delivery;