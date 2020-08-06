<?php require_once('./DBHandler.php');

$DBHandler = new DBHandler();
$username = isset($_POST['user']);
$password = md5(isset($_POST['pwd']));

echo $password;

$sql = "SELECT Username, Password FROM user WHERE (Username = '$username' OR Email = '$username') AND Password = '$password'";
$result = $DBHandler->select($sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        echo "Login successful!";
        //TODO set cookie o informazioni per sessione utente.
    }
} else {
    echo "Login failed, wrong username or password!"; //mancano i messaggi di errore che ritornano su login.php
}
