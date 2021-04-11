<?php
require_once "../Classes/initialize.php";
if (!empty($_GET['username'])) {
    $username = $DB->escapeValue($_GET['username']);
    $uniqueResult = $DB->selectAll('username', 'users', " WHERE username='{$username}'");
    if ($DB->numRows($uniqueResult) !== 0 && $username !== $users->username)
        echo " از قبل وجود دارد {$username} کاربر";
}
?>
