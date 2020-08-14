<?php 
require_once 'DBHandler.php';
require_once 'addUserResponse.php';

$addUserResponse = new addUserResponse();
if (
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['email']) &&
    isset($_POST['firstname']) &&
    isset($_POST['lastname'])
) {

    $DBHandler = new DBHandler();
    $username = $_POST['username'];
    $password = md5($_POST['password']); //pwd hashed in POST, SSL required
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $organizer = isset($_POST['organizer']) ? 2 : 3;

    $addUserResponse->username = $username;
    $addUserResponse->email = $email;
    $addUserResponse->firstname = $firstname;
    $addUserResponse->lastname = $lastname;

    $sql_u = "SELECT Username FROM user WHERE Username = '$username'";
    $sql_e = "SELECT Email FROM user WHERE Email = '$email'";
    $result_u = $DBHandler->select($sql_u);
    $result_e = $DBHandler->select($sql_e);
    $counts_u = array_map('count', $result_u);
    $counts_e = array_map('count', $result_e);
    if ($result_u) {
        if (count($counts_u) > 0) {
            $addUserResponse->userError = true;
        }
    }

    if ($result_e) {
        if (count($counts_e) > 0) {
            $addUserResponse->mailError = true;
        }
    }

    if (!$result_e && !$result_u) {
        $verificationCode = rand(100000, time()); //generates a random verification code for user based on current time..
        mail($email, 'Confirm your registration to BrowseEvents.com', 'Thanks for signing to BrowseEvents! Here\'s your code: ' . $verificationCode, 'From: infobrowseevents@gmail.com');
        $verificationCode = md5($verificationCode); //..and hashes it before saving it in DB

        $sql = "INSERT INTO user (Username, Password, Email, FirstName, LastName, UserType_idUserType, VerificationCode)"
            . "VALUES ('$username', '$password', '$email', '$firstname', '$lastname', '$organizer', '$verificationCode')";
        $result = $DBHandler->genericQuery($sql);

        if ($result) {
            $addUserResponse->status = true;
        } else {
            //echo "There was a problem inserting your informations to DB, please register again!";
        }
    }
}

return json_encode($addUserResponse);
