<?php
require_once 'DBHandler.php';

function createCartElements() {
    if (isset($_POST['user']) {
        $sql = "SELECT * FROM cart WHERE (User_idUsers = '$username'";
        $result = $DBHandler->select($sql);
    }
    
}


?>