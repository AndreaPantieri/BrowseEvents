<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();
$status = false;

if (isset($_POST["oldPwd"]) && isset($_POST["newPwd"]) && isset($_SESSION["userid"])) {
    $oldPwd = md5($_POST["oldPwd"]);
    $newPwd = md5($_POST["newPwd"]);
    $userid = $_SESSION["userid"];

    $sql = "SELECT * FROM user WHERE idUsers = '$userid' AND Password = '$oldPwd'";
    $result = $DBHandler->select($sql);
    $counts = array_map('count', $result);

    if (count($counts) == 1) {
        $sql = "UPDATE user SET Password = '$newPwd' WHERE idUsers = '$userid'";
        $DBHandler->genericQuery($sql);
    } else {
        $status = true;
    }
}
echo $status;
