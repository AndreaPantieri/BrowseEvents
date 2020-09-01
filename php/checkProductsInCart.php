<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();

if (isset($_POST["user_id"]) && isset($_POST["event_id"])) {
    $user_id = $_POST["user_id"];
    $event_id = $_POST["event_id"];

    $sql = "SELECT * FROM cart WHERE User_idUsers = '$user_id' AND Event_idEvent = '$event_id' AND isAcquired = 'false'";
    $result = $DBHandler->select($sql);
    $counts = array_map('count', $result);

    if (count($counts) > 0) { 
        $result = true;
    } else {
        $result = false;
    }
}

echo $result;
