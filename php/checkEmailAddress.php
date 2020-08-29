<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();
$status = false;

if (isset($_POST["newEmail"]) && isset($_SESSION["userid"])) {
    $email = $_POST["newEmail"];
    $userid = $_SESSION["userid"];

    $sql = "SELECT * FROM user WHERE Email = '$email'";
    $result = $DBHandler->select($sql);
    $counts = array_map('count', $result);

    if (count($counts) > 0) {
        $status = true;
    } else {
        $verificationCode = rand(100000, time()) + 1; //generates a random verification code based on current time..
        mail($email, 'Confirm your registration to BrowseEvents.com', 'Thanks for signing to BrowseEvents! Here\'s your code: ' . $verificationCode, 'From: infobrowseevents@gmail.com');
        $verificationCode = md5($verificationCode); //..and hashes it before saving it in DB

        $sql = "UPDATE user SET VerificationCode = '$verificationCode' WHERE idUsers = '$userid'";
        $result = $DBHandler->genericQuery($sql);
    }
}
echo $status;
