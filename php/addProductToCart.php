<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();


if (isset($_POST["event_id"]) && isset($_POST["user_id"]) && isset($_POST["ticket_quantity"])) {
    $event_id = $_POST["event_id"];
    $user_id = $_POST["user_id"];
    $ticket_quantity = $_POST["ticket_quantity"];
    $date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO cart (Event_idEvent, User_idUsers, TicketQuantity, Date) VALUES ('$event_id', '$user_id', '$ticket_quantity', '$date')";
    $result = $DBHandler->genericQuery($sql);
}
