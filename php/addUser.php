<?php require_once('DBHandler.php');

if (
    isset($_POST['username']) &&
    isset($_POST['password']) &&
    isset($_POST['email']) &&
    isset($_POST['firstname']) &&
    isset($_POST['lastname'])
) {
    $DBHandler = new DBHandler();
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //pwd hashed in POST, SSL required
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $organizer = isset($_POST['organizer']);

    $sql_u = "SELECT Username FROM user WHERE Username = '$username'";
    $sql_e = "SELECT Email FROM user WHERE Email = '$email'";
    $result_u = $DBHandler->select($sql_u);
    $result_e = $DBHandler->select($sql_e);

    if ($result_u) {
        if (mysqli_num_rows($result_u) > 0) { //RISOLVERE MYSQLI NUM ROWS NON FUNZIONANTE 
            echo "Username already exist!";
            return $userError = true;
        } else {
            $userError = false;
        }
    }

    if ($result_e) {
        if (mysqli_num_rows($result_e) > 0) {
            echo "Email address is already in use!";
            return $mailError = true;
        } else {
            $mailError = false;
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
            return $status = true;
        } else {
            echo "There was a problem inserting your informations to DB, please register again!";
        }
    }
} else {
    return $status = false;
}
