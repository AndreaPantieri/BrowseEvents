<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();
$status = false;

if (isset($_POST["newUsername"]) && isset($_SESSION["userid"]) && isset($_SESSION["username"])) {
    $username = $_POST["newUsername"];
    $userid = $_SESSION["userid"];

    $sql = "SELECT Username FROM user WHERE Username = '$username'";
    $result = $DBHandler->select($sql);
    $counts = array_map('count', $result);

    if (count($counts) > 0) {
        $status = true;
    } else {
        $sql = "UPDATE user SET Username = '$username' WHERE idUsers = '$userid'";
        $result = $DBHandler->genericQuery($sql);

        if ($result) {
            $_SESSION["username"] = $username;
        }
    }
}
echo $status;
