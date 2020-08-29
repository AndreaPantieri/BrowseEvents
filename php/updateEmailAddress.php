<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();


if (isset($_POST["newEmail"]) && isset($_SESSION["userid"])) {
    $email = $_POST["newEmail"];
    $userid = $_SESSION["userid"];

    $sql = "UPDATE user SET Email = '$email' WHERE idUsers = '$userid'";
    $result = $DBHandler->select($sql);
}

