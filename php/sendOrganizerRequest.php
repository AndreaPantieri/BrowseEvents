<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    $sql = "UPDATE user SET isApproved = 0 WHERE idUsers = '$userid'";
    $result = $DBHandler->genericQuery($sql);
}

echo $result;
