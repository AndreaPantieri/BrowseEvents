<?php
require_once './php/DBHandler.php';
function isMobile()
{
    return is_numeric(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), "mobile"));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>BrowseEvents</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- JQuery + Ajax -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style-common.css">
    <?php

    if (isMobile()) {
        echo "<link rel=\"stylesheet\" href=\"css/style-mobile.css\">";
    } else {
        echo "<link rel=\"stylesheet\" href=\"css/style-dekstop.css\">";
    }

    ?>

</head>

<body>
    <?php
    $cookie_name = "logged";

    if (isset($_COOKIE[$cookie_name])) {
        include 'login.php';
    } else {
        $cookie_name_type_account = "type_account";
        if (isset($_COOKIE[$cookie_name_type_account])) {
            die('Error, type of account missing!');
        } else {
            $type_account = 1/*$_COOKIE[$cookie_name_type_account]*/;
            include 'baseLogged.php';
        }
    }
    ?>
</body>

</html>