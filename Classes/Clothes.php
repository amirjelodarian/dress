<?php
namespace Clothes;
    use Database\Database;
    use Functions\Functions;

    class Clothes{
        private $id; // INT(9)
        private $type; // TINYTEXT 255 Char
        private $model; // TINYTEXT 255 Char
        private $title; // TINYTEXT 255 Char
        private $fabricType; // TINYTEXT 255 Char
        private $description; // TEXT
        private $size; // TINYTEXT 255 Char
        private $color; // TINYTEXT 255 Char
        private $price; // TINYTEXT 255 Char
        private $offPrice; // TINYTEXT 255 Char
        public $tableColumns_= array();

        public function selectAutoComplete($keyword = "",$columnName = ""){
            global $DB;
            if(!empty($keyword)){
                $keyword = $DB->escapeValue($keyword);
                $result = $DB->selectAll('DISTINCT('.$columnName.')','clothes',"WHERE {$columnName} LIKE '{$keyword}%'");
                if($DB->numRows($result) > 0){
                    while ($AutoCompleteRow = $DB->fetchArray($result))
                        echo "<li>{$AutoCompleteRow[$columnName]}</li>";
                }else
                    return null;
            }
        }
        public function selectPanelMenu($columnName = "",$tableName,$reverseId = ""){
            global $DB;
                if ($reverseId == true)
                    $result = $DB->selectAll('DISTINCT('.$columnName.')',$tableName,' ORDER BY id DESC');
                else
                    $result = $DB->selectAll('DISTINCT('.$columnName.')',$tableName);
                if($DB->numRows($result) > 0)
                    return $result;
                else
                    return false;
        }
        public function selectPanelSubMenu($columnName = "",$tableName,$value,$reverseId = ""){
            global $DB;
                $value = $DB->escapeValue($value);
                if ($reverseId == true)
                    $result = $DB->selectAll('DISTINCT('.$columnName.')',$tableName,"WHERE type='{$value}' ORDER BY id DESC");
                else
                    $result = $DB->selectAll('DISTINCT('.$columnName.')',$tableName,"WHERE type='{$value}'");
                if($DB->numRows($result) > 0)
                    return $result;
                else
                    return false;
        }
        public function selectByTypeAndModel($tableName,$type,$model,$reverseId = "",$customSql = ""){
            global $DB;
            $allSubMenu[] = array();
            if ($reverseId == true)
                $result = $DB->selectAll('*',$tableName,"WHERE type='{$type}' AND model='{$model}' ORDER BY id DESC {$customSql}");
            else
                $result = $DB->selectAll('*',$tableName,"WHERE type='{$type}' AND model='{$model}' {$customSql}");
            if($DB->numRows($result) > 0){
                return $result;
            }else{
                return false;
            }

        }

        public function selectByTypeAndModelSearch($tableName,$type,$model,$customSql = ""){
            global $DB;
            if ($type == '*')
                $result = $DB->selectAll('*',$tableName,"{$customSql}");
            if ($model == '*')
                $result = $DB->selectAll('*',$tableName," WHERE type='{$type}' {$customSql}");
            if ($model !== '*' && $type !== '*')
                $result = $DB->selectAll('*',$tableName,"WHERE type='{$type}' AND model='{$model}' {$customSql}");
            if ($model == '*' && $type == '*')
                $result = $DB->selectAll('*',$tableName,"{$customSql}");
            if($DB->numRows($result) > 0){
                return $result;
            }else{
                return false;
            }
        }
        public function selectByModel($tableName,$model,$customSQL = "",$reverseId = ""){
            global $DB;
            $allSubMenu[] = array();
            $model = $DB->escapeValue($model);
            if ($reverseId == true)
                $result = $DB->selectAll('*',$tableName,"WHERE model='{$model}' ORDER BY id DESC {$customSQL}");
            else
                $result = $DB->selectAll('*',$tableName,"WHERE model='{$model}' {$customSQL}");
            if($DB->numRows($result) > 0){
                return $result;
            }else{
                return false;
            }
        }
        public function addProduct($values = array(),$fileNameForUpload = ""){
            global $DB,$Funcs,$Sessions;

            if ($Funcs->checkValue($fileNameForUpload,true,true)){
                $Funcs->uploadPic($fileNameForUpload, '../style/images/ProductPics/', '2097152');
                    array_push($values,Functions::$fileName);
                    if($DB->insert("clothes", "type,model,title,fabric_type,description,size,color,price,off_price,pic_loc", $values))
                        $Funcs->redirectTo("addProduct.php");
                    else
                        $_SESSION['errorMessage'] = "خطایی رخ داد !|";
            } else {
                if($DB->insert("clothes", "type,model,title,fabric_type,description,size,color,price,off_price", $values))
                    $Funcs->redirectTo("addProduct.php");
                else
                    $_SESSION['errorMessage'] = "خطایی رخ داد !|";
            }
        }

        public function editProduct($values = array(),$fileNameForUpload = "",$id){
            global $DB,$Funcs,$Sessions;
            $id = $DB->escapeValue($id,true);
            if ($Funcs->checkValue($fileNameForUpload,true,true)){
                $Funcs->uploadPic($fileNameForUpload, '../style/images/ProductPics/', '2097152');
                array_push($values,Functions::$fileName);
                if($DB->update("clothes", "title,fabric_type,description,size,color,model,type,price,off_price,pic_loc", $values," WHERE id = {$id}"))
                    $Funcs->redirectTo("editProduct.php?id={$id}");
                else
                    $_SESSION['errorMessage'] = "خطایی رخ داد !|";
            } else {
                if($DB->update("clothes", "title,fabric_type,description,size,color,model,type,price,off_price", $values," WHERE id = {$id} "))
                    $Funcs->redirectTo("editProduct.php?id={$id}");
                else
                    $_SESSION['errorMessage'] = "خطایی رخ داد !|";
            }
        }
        public function deleteProduct($id){
            global $DB,$Funcs,$Sessions;
            $id = $DB->escapeValue($id,true);

                    $result = $DB->selectById('clothes',$id,"pic_loc");
                    if ($row = $DB->fetchArray($result)) {
                        $pic_name = $row['pic_loc'];
                        unlink("../style/images/ProductPics/{$pic_name}");
                        $DB->delete("clothes", "id", $id);
                        $Funcs->redirectTo("index.php");
                    } else
                    $_SESSION['errorMessage'] = "خطایی رخ داد !|";
        }
        public function deleteProductImg($id){
            global $DB,$Funcs,$Sessions;
            $id = $DB->escapeValue($id,true);

            $result = $DB->selectById('clothes',$id,"pic_loc");
                if ($row = $DB->fetchArray($result)) {
                    $pic_name = $row['pic_loc'];
                    unlink("../style/images/ProductPics/" . "{$pic_name}");
                    $DB->update('clothes','pic_loc',''," WHERE id={$id} ");
                    $Funcs->redirectTo("editProduct.php?id={$id}");
                }
                else
                $_SESSION['errorMessage'] = "خطایی رخ داد !|";
        }



        //MoreProduct Page
        public function doPriceFilter($Type,$Model,$startFrom,$recordPerPage,$filterValue){
            global $DB;
            $priceFilter = $DB->escapeValue($filterValue);
            switch ($priceFilter){
                case "cheapest":
                    $allResult = $this->selectByTypeAndModelSearch($DB->tableName,$Type,$Model," ORDER BY off_price ASC LIMIT {$startFrom},{$recordPerPage}");
                    break;
                case "theMostExpensive":
                    $allResult = $this->selectByTypeAndModelSearch($DB->tableName,$Type,$Model," ORDER BY off_price DESC LIMIT {$startFrom},{$recordPerPage}");
                    break;
                default:
                    $allResult = $this->selectByTypeAndModelSearch($DB->tableName,$Type,$Model," ORDER BY id DESC LIMIT {$startFrom},{$recordPerPage}");
                    break;
            }
            return $allResult;
        }
        public function doPriceFilterBetween($Type,$Model,$startFrom,$recordPerPage,$filterValue){
            global $DB;
            $betweenPrice = explode(';',$filterValue);
            if ((count($betweenPrice)) == 2) {
                $betweenPrice['first'] = $DB->escapeValue($betweenPrice[0], true);
                $betweenPrice['second'] = $DB->escapeValue($betweenPrice[1], true);
                $allResult = $this->selectByTypeAndModelSearch($DB->tableName, $Type, $Model, " AND off_price BETWEEN {$betweenPrice['first']} AND {$betweenPrice['second']} ORDER BY id DESC LIMIT {$startFrom},{$recordPerPage}");
            }else
                $allResult = $this->selectByTypeAndModelSearch($DB->tableName, $Type, $Model, " ORDER BY id DESC LIMIT {$startFrom},{$recordPerPage}");

            return $allResult;
        }
        public function searchByTitleOrPrice($tableName,$keyword,$titleOrPrice,$customSQL = "",$reverseId = ""){
            global $DB;
            $keyword = $DB->escapeValue($keyword);
            $titleOrPrice = $DB->escapeValue($titleOrPrice);
            switch ($titleOrPrice){
                case 'clothes_title':
                    if ($reverseId == true)
                        $result = $DB->selectAll('*',$tableName,"WHERE title LIKE '%{$keyword}%' ORDER BY id DESC {$customSQL}");
                    else
                        $result = $DB->selectAll('*',$tableName,"WHERE title LIKE '%{$keyword}%' {$customSQL}");
                    break;
                case 'clothes_price':
                    if ($reverseId == true)
                        $result = $DB->selectAll('*',$tableName,"WHERE off_price LIKE '{$keyword}%' ORDER BY id DESC {$customSQL}");
                    else
                        $result = $DB->selectAll('*',$tableName,"WHERE off_price LIKE '{$keyword}%' {$customSQL}");
                    break;
                default:
                    echo 'I know You Are A Hacker :)';
                    break;
            }
            if (isset($result)){
                if($DB->numRows($result) > 0){
                    return $result;
                }else{
                    return false;
                }
            }else
                return false;
        }
        //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    }
    $Clothes = new Clothes();
?>
