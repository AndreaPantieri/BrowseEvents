<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();

if (isset($_POST["userid"])) {
    $userid = $_POST["userid"];

    $sql = "UPDATE user SET isApproved = 1, UserType_idUserType = 2 WHERE idUsers = '$userid'";
    $result = $DBHandler->genericQuery($sql);
}
echo $result;
