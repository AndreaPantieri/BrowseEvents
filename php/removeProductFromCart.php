<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();

if (isset($_SESSION["userid"]) && isset($_POST["product_id"])) {
    $userid = $_SESSION["userid"];
    $productid = $_POST["product_id"];

    $sql = "DELETE FROM cart WHERE User_idUsers = $userid AND Event_idEvent = $productid";
    $DBHandler->genericQuery($sql);
}
