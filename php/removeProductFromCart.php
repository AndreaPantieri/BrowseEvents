<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();

if (isset($_POST["cart_id"])) {
    $cart_id = $_POST["cart_id"];

    $sql = "DELETE FROM cart WHERE idCart = $cart_id";
    $DBHandler->genericQuery($sql);
}
