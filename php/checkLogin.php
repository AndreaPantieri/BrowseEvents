<?php
    require_once('./DBHandler.php');

    //BOZZA
    if (isset($_POST['loginData'])) {
        $DBHandler = new DBHandler();
        $username = $_POST['user'];
        $password = md5($_POST['pwd']);

        $sql = "SELECT Username, Password FROM user WHERE Username ='$username' AND Password='$password'";
        $result = $DBHandler->select($sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo "Login successful!";
                //TODO set cookie o informazioni per sessione utente. mancano anche i messaggi di errore che ritornano su login.php, per registrazione già fatti ma da sistemare
            }
        } else {
            echo "Login failed!";
        }
    }
?>