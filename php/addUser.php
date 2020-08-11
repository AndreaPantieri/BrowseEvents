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
    $password = md5($_POST['password']); //pwd hashed in POST, SSL required
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $organizer = isset($_POST['organizer']);

    $sql_u = "SELECT Username FROM user WHERE Username ='$username'";
    $sql_e = "SELECT Email FROM user WHERE Email ='$email'";
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
        $sql = "INSERT INTO user (Username, Password, Email, FirstName, LastName, UserType_idUserType)"
            . "VALUES ('$username', '$password', '$email', '$firstname', '$lastname', '$organizer')";
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
