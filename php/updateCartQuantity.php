<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();

if (isset($_SESSION["userid"]) && isset($_POST["product_id"]) && isset($_POST["newQuantity"])) {
    $userid = $_SESSION["userid"];
    $productid = $_POST["product_id"];
    $newQuantity = $_POST["newQuantity"];

    $sql = "UPDATE cart SET TicketQuantity = $newQuantity WHERE User_idUsers = $userid AND Event_idEvent = $productid";
    $DBHandler->genericQuery($sql);
}
