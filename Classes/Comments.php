<?php
namespace Comments;
    use Database\Database;
    use Functions\Functions;

    class Comments{
        private $id; // INT(9)
        private $user_id; // TINYTEXT 255 Char
        private $clothes_id; // TINYTEXT 255 Char
        private $title; // TINYTEXT 255 Char
        private $description; // TEXT
        private $create_at; // TINYTEXT 255 Char
        private $score; // TINYTEXT 255 Char
        private $publish_mode; // Publish Mode 255 Char

        public function insertComment($title,$description,$productId,$score) {
            global $DB,$Funcs,$SS,$Users;
            if($Users->isAdmin() || $Users->isAdministrator())
                $publish_mode = "published";
            else
                $publish_mode = "unpublished";
            if($score !== ""){
                $values = [
                    $Users->id,
                    $productId,
                    htmlspecialchars($title),
                    htmlspecialchars($description),
                    $Funcs::nowDataTime(),
                    $score,
                    $publish_mode
                ];
                $dbValues = 'user_id,clothes_id,title,description,create_at,score,publish_mode';
            }else{
                $values = [
                    $Users->id,
                    $productId,
                    htmlspecialchars($title),
                    htmlspecialchars($description),
                    $Funcs::nowDataTime(),
                    $publish_mode
                ];
                $dbValues = 'user_id,clothes_id,title,description,create_at,publish_mode';
            }
            $DB->insert('comments',$dbValues,$values);
            if($Users->isAdmin() || $Users->isAdministrator())
                $_SESSION['errorMessage'] .= '|نظر شما با موفقیت ثبت شد';
            else
                $_SESSION['errorMessage'] .= '|نظر شما پس از تایید قرار خواهد گرفت';
            $Funcs->redirectTo("singleProduct.php?id={$productId}",true);
        }
        public function commentsByProductId($productId,$startFrom,$recordPerPage){
            global $DB;
            $productId = $DB->escapeValue($productId,true);
            $allUsersResult = $DB->selectAll('*','comments',"WHERE clothes_id = {$productId} AND publish_mode='published' ORDER BY comments.id DESC LIMIT {$startFrom},{$recordPerPage}");
            return $allUsersResult;
        }
        public function allComments($publish_mode,$startFrom,$recordPerPage){
            global $DB;
            $allUsersResult = $DB->selectAll('*','comments'," WHERE publish_mode='{$publish_mode}' ORDER BY comments.id DESC LIMIT {$startFrom},{$recordPerPage}");
            return $allUsersResult;
        }

        // Panel Comment

        public function editPanelCommentTitle($commentTitleId,$commentTitleValue){
            global $DB,$Users;
            if ($Users->isAdministrator() || $Users->isAdmin()) {
                $id = $DB->escapeValue($commentTitleId, true);
                if ($DB->update("comments", "title", $commentTitleValue, " WHERE id = {$commentTitleId}"))
                    echo "Title Successful Edited (CID : <span style='color: black;'>{$commentTitleId}</span>)";
            }else
                echo "I know you are hacker :)";
        }
        public function editPanelCommentDescription($commentDescriptionId,$commentDescriptionValue){
            global $DB,$Users;
            if ($Users->isAdministrator() || $Users->isAdmin()) {
                $id = $DB->escapeValue($commentDescriptionId, true);
                if ($DB->update("comments", "description", $commentDescriptionValue, " WHERE id = {$commentDescriptionId}"))
                    echo "Description Successful Edited (CID : <span style='color: black;'>{$commentDescriptionId}</span>)";
            }else
                echo "I know you are hacker :)";
        }
        public function editPanelCommentPublishMode($commentPublishModeValue){
            global $DB,$Users;
            if($Users->isAdministrator() || $Users->isAdmin()) {
                $commentPublishModeValue = $DB->escapeValue($commentPublishModeValue);
                $publishModeArray = explode('_', $commentPublishModeValue);
                $publishMode = $publishModeArray[0];
                $publishModeId = $DB->escapeValue($publishModeArray[1], true);
                switch ($publishMode) {
                    case 'publish':
                        if ($DB->update("comments", "publish_mode", 'published', " WHERE id = {$publishModeId}"))
                            echo "Published (CID : <span style='color: black;'>{$publishModeId}</span>)";
                        break;
                    case 'unpublish':
                        if ($DB->update("comments", "publish_mode", 'unpublished', " WHERE id = {$publishModeId}"))
                            echo "Unpublished (CID : <span style='color: black;'>{$publishModeId}</span>)";
                        break;
                    default:
                        echo "Sorry , Don't Change Value My Hacker Friend :D";
                        break;
                }
            }else{
                echo "I know you are hacker :)";
            }
        }
        public function deleteComment($id,$page = ''){
            global $DB,$Funcs;
            $id = $DB->escapeValue($id,true);
            $DB->delete("comments", "id", $id);
            if (!empty($page)){
                    $Funcs->redirectTo($page);
            }else{
                $Funcs->redirectTo("commentsList.php");
            }
        }

        public function selectCommentByUserId($userId,$startFrom,$recordPerPage){
            global $DB;
            $userId = $DB->escapeValue($userId,true);
            $userCommentResult = $DB->selectAll('*','comments',"WHERE user_id = {$userId} ORDER BY comments.id DESC LIMIT {$startFrom},{$recordPerPage}");
            return $userCommentResult;
        }

        public function selectCommentStandardUser($publish_mode,$startFrom,$recordPerPage){
            global $DB,$Users;
            $userId = $DB->escapeValue($Users->id,true);
            $userCommentResult = $DB->selectAll('*','comments',"WHERE user_id = {$userId} AND publish_mode='{$publish_mode}' ORDER BY comments.id DESC LIMIT {$startFrom},{$recordPerPage}");
            return $userCommentResult;
        }
        public function selectCommentByProductId($productId,$startFrom,$recordPerPage){
            global $DB;
            $productId = $DB->escapeValue($productId,true);
            $productCommentResult = $DB->selectAll('*','comments',"WHERE clothes_id = {$productId} ORDER BY comments.id DESC LIMIT {$startFrom},{$recordPerPage}");
            return $productCommentResult;
        }
        //-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    }
    $Comments = new Comments();
?>
