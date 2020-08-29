<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();

if (isset($_POST["cart_id"]) && isset($_POST["newQuantity"])) {
    $cart_id = $_POST["cart_id"];
    $newQuantity = $_POST["newQuantity"];

    $sql = "UPDATE cart SET TicketQuantity = $newQuantity WHERE idCart = $cart_id";
    $DBHandler->genericQuery($sql);
}
