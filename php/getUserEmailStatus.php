<?php
require_once 'DBHandler.php';

class getUserEmailStatusResponse
{
    public $result = false;
}

$DBHandler = new DBHandler();
$getUserEmailStatusResponse = new getUserEmailStatusResponse();

if (isset($_POST["username"])) {
    $username = $_POST["username"];
    $sql = "SELECT EmailStatus FROM user WHERE Username = '$username'";
    $result = $DBHandler->select($sql);
    $counts = array_map('count', $result);

    if (count($counts) == 1) {
        if ($result[0]["EmailStatus"] == 'verified') {
            $getUserEmailStatusResponse->result = true;
        } else {
            $getUserEmailStatusResponse->result = false;
        }
    }
}
echo json_encode($getUserEmailStatusResponse);
