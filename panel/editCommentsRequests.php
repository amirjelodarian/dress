<?php
require_once "../Classes/initialize.php";
// Comment Title Ajax And Live Edit
if ($Users->isAdministrator() || $Users->isAdmin()) {
    if (isset($_POST['commentTitleId']) && !(empty($_POST['commentTitleId'])) && isset($_POST['commentTitleValue']) && !(empty($_POST['commentTitleValue'])))
        $Comments->editPanelCommentTitle($_POST['commentTitleId'], $_POST['commentTitleValue']);
////////////////////////////////////


// Comment Description Ajax And Live Edit
    if (isset($_POST['commentDescriptionId']) && !(empty($_POST['commentDescriptionId'])) && isset($_POST['commentDescriptionValue']) && !(empty($_POST['commentDescriptionValue'])))
        $Comments->editPanelCommentDescription($_POST['commentDescriptionId'], $_POST['commentDescriptionValue']);
/////////////////////////////////////////


// Comment Publish Mode Ajax And Live Edit
    if (isset($_POST['commentPublishModeValue']) && !(empty($_POST['commentPublishModeValue'])))
        $Comments->editPanelCommentPublishMode($_POST['commentPublishModeValue']);
//////////////////////////////////////////
}else
    echo "I know you are hacker :)";
?>