<?php
    namespace Database;
    use Sessions\Sessions;

    class Database{

        private $connection;
        public $tableName;
        private $lastQuery;

        function __construct(){
            $this->openConnection();
            $this->Query(" SET NAMES 'utf8' ");
        }
        private function openConnection(){
            $this->connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            if (mysqli_connect_error() || mysqli_errno($this->connection)){
                die("Error Database Connection ". mysqli_connect_errno() . "<br />" . mysqli_connect_error());
            }
        }
        public function closeConnection(){
            if (isset($this->connection)){
                mysqli_close($this->connection);
                unset($this->connection);
            }
        }
        public function Query($sql){
            $this->lastQuery = $sql;
            $sql = $sql;
            $result = mysqli_query($this->connection,$sql);
            $this->confirmQuery($result);
            return $result;
        }
        private function confirmQuery($result){
            if (!$result){
                $output = "Database Query Failed : <br />" . mysqli_connect_error() . "<br /><br />";
                $output .= "Last SQL Query : <br /> " . $this->lastQuery;
                die($output);
            }
        }
        public function fetchArray($result){
            return mysqli_fetch_assoc($result);
        }
        public function numRows($result){
            return mysqli_num_rows($result);
        }
        private function affectedRows($result){
            return mysqli_affected_rows($result);
        }
        public function escapeValue($value,$giveInt = false){
            if ($giveInt == true)
                settype($value,'integer');
            $magicQuotesActive = get_magic_quotes_gpc();
            $newEnoughPhp = function_exists("mysqli_real_escape_string");// i.e. PHP >= v4.3.0
            if ($newEnoughPhp){ // PHP v4.3.0 or higher
                // undo any magic quote effects so mysql_real_escape_string can do the work
                if ($magicQuotesActive){
                    $value = stripslashes($value);
                }
                $value = mysqli_real_escape_string($this->connection,$value);
            } else{ // Before PHP v4.3.0
                // if magic quotes aren't already on then add slashes manually
                if (!$magicQuotesActive){
                    $value = addslashes($value);
                }
                // if magic quotes are active, then the slashes already exist
            }
            return $value;
        }
        public function selectAll($columnsName = "*",$tableName,$customSQL = ""){
            $sql = "SELECT {$columnsName} FROM {$tableName} ";
            !empty($sql) ? $sql .= $customSQL : false;
            $result = $this->Query($sql);
            return $result;
        }

        public function selectById($tableName,$id,$columnsName = "*",$customSQL = "",$idColName = "id"){
            $id = $this->escapeValue($id,true);
//            isset($idColName) ? $idColName = $idColName : $idColName = "id";
            $sql = "SELECT {$columnsName} FROM {$tableName} WHERE {$idColName}={$id}";
            !empty($sql) ? $sql .= $customSQL : false;
            $result = $this->Query($sql);
            return $result;
        }
        public function insert($tableName,$columnsName,$values = array(),$customSQL = ""){
            foreach ($values as $Value) {
                if (preg_match("/'/",$Value))
                    $allValues[] = '"' . $this->escapeValue($Value) . '"';
                elseif (preg_match('/"/',$Value))
                    $allValues[] = "'" . $this->escapeValue($Value) . "'";
                else
                    $allValues[] = '"' . $this->escapeValue($Value) . '"';
            }
            $allValues = implode(',',$allValues);
            $sql = " INSERT INTO {$tableName}({$columnsName})VALUES({$allValues})";
            !empty($customSQL) ? $sql .= " $customSQL" : false;
            $result = $this->Query($sql);
            if($result) return true; else return false;
        }

        public function update($tableName,$columnsName,$values = array(),$customSQL = ""){
            if (is_array($values)){
                foreach ($values as $Value) {
                    if (preg_match("/'/",$Value))
                        $allValues[] = '"' . $this->escapeValue($Value) . '"';
                    elseif (preg_match('/"/',$Value))
                        $allValues[] = "'" . $this->escapeValue($Value) . "'";
                    else
                        $allValues[] = '"' . $this->escapeValue($Value) . '"';
                }
                $columnsName = explode(',',$columnsName);
                $setSql = "";
                if (sizeof($columnsName) == sizeof($values)){
                    for($i = 0;$i < sizeof($columnsName);$i++){
                        $setSql .= "{$columnsName[$i]} = {$allValues[$i]} , ";
                    }
                    $setSql = substr($setSql,0,strlen($setSql)-2);
                    $sql = "UPDATE {$tableName} SET {$setSql} ";
                    !empty($customSQL) ? $sql .= " {$customSQL}" : false;
                    $result = $this->Query($sql);
                    if($result) return true; else return false;
                }else
                    $_SESSION['errorMessage'] .= "Update Query Argument Not Valid !";
            }else{
                if (preg_match("/'/",$values))
                    $values = '"' . $this->escapeValue($values) . '"';
                elseif (preg_match('/"/',$values))
                    $values = "'" . $this->escapeValue($values) . "'";
                else
                    $values = '"' . $this->escapeValue($values) . '"';

                $sql = "UPDATE {$tableName} SET {$columnsName}={$values} ";
                !empty($customSQL) ? $sql .= " {$customSQL}" : false;
                $result = $this->Query($sql);
                if($result) return true; else return false;
            }

        }

        public function delete($tableName,$columnsName,$values = array(),$deleteCondition = "AND",$customSQL = ""){
            if (is_array($values)){
                foreach ($values as $Value) {
                    if (preg_match("/'/",$Value))
                        $allValues[] = '"' . $this->escapeValue($Value) . '"';
                    elseif (preg_match('/"/',$Value))
                        $allValues[] = "'" . $this->escapeValue($Value) . "'";
                    else
                        $allValues[] = '"' . $this->escapeValue($Value) . '"';
                }
                $columnsName = explode(',',$columnsName);
                $setSql = "";
                if (sizeof($columnsName) == sizeof($values)){
                    for($i = 0;$i < sizeof($columnsName);$i++){
                        $setSql .= "{$columnsName[$i]} = {$allValues[$i]} ";
                        if ($i !== sizeof($columnsName)-1)
                            $setSql .= " " . $deleteCondition . " ";
                    }
                    $sql = "DELETE FROM {$tableName} WHERE {$setSql} ";
                    !empty($customSQL) ? $sql .= " {$customSQL}" : false;
                    $result = $this->Query($sql);
                    if($result) return true; else return false;
                }else
                    $_SESSION['errorMessage'] .= "DELETE Query Argument Not Valid !";
            }else{
                $values = $this->escapeValue($values);
                $sql = "DELETE FROM {$tableName} WHERE {$columnsName}={$values} ";
                !empty($customSQL) ? $sql .= " {$customSQL}" : false;
                $result = $this->Query($sql);
                if($result) return true; else return false;
            }


        }

        public function freeResult($result){
            return mysqli_free_result($result);
        }
        public function count($tableName,$columnName,$customSql = ""){
            $result = $this->selectAll("COUNT({$columnName}) AS {$columnName}",$tableName,$customSql);
            if ($row = $this->fetchArray($result)) return $row[$columnName];
        }

    }
    $Database = new Database();
    $db =& $Database;
    $DB =& $Database;
?>