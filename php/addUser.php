<?php
    require_once('./DBHandler.php');

    if (isset($_POST['data'])) {
        $DBHandler = new DBHandler();
        $username = $_POST['username'];
        $password = md5($_POST['password']); //MD5(pwd) in POST, SSL still required
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $organizer = isset($_POST['organizer']);

        /*
        foreach($_POST as $key => $value) {
            echo $value . " ";
        }
        echo "<br />";
        */

        $sql_u = "SELECT Username FROM user WHERE Username ='$username'";
        $sql_e = "SELECT Email FROM user WHERE Email ='$email'";
        $result_u = $DBHandler->select($sql_u);
        $result_e = $DBHandler->select($sql_e);

        if ($result_u) {
            if (mysqli_num_rows($result_u) > 0) {
                $name_error = "Username already exist!";
            }
        }

        if ($result_e) {
            if (mysqli_num_rows($result_e) > 0) {
                $mail_error = "Email address is already in use!";
            }
        }

        if (!$result_e && !$result_u) {
            $sql = "INSERT INTO user (Username, Password, Email, FirstName, LastName, UserType_idUserType)"
                . "VALUES ('$username', '$password', '$email', '$firstname', '$lastname', '$organizer')";
            $result = $DBHandler->genericQuery($sql);

            if ($result) {
                echo "<br />Registration success!";
            } else {
                echo "<br />Insertion error";
            }
        }
    } else {
        echo "no data in POST";
    }
?>