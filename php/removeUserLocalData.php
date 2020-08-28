<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();
$cookie_name = "remindme";

if (isset($_COOKIE[$cookie_name])) {
    unset($_COOKIE[$cookie_name]);
    setcookie($cookie_name, "", time() - 3600, '/');

    if (isset($_SESSION["userid"])) {
        $userid = $_SESSION["userid"];

        $sql = "DELETE FROM session WHERE User_idUsers = $userid";
        $DBHandler->genericQuery($sql);
    }
}

session_destroy();
