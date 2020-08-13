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
    <link rel="stylesheet" href="css/style-mobile.css">
    <link rel="stylesheet" href="css/style-dekstop.css">
    <?php

        //if (isMobile()) {
         //   echo "<link rel=\"stylesheet\" href=\"css/style-mobile.css\">";
        //} else {
          //  echo "<link rel=\"stylesheet\" href=\"css/style-dekstop.css\">";
        //}

    ?>

    <script type="text/javascript">
        var linkMobileSheet = 'LINK[href="css/style-mobile.css"]';
        var linkDekstopSheet = 'LINK[href="css/style-dekstop.css"]';
        function changeCSSStyleSheet(){
            var w = window.innerWidth;
            var h = window.innerHeight;

            var sW = window.screen.width;
            var sH = window.screen.height;


            if(w < sW / 2.0 || h < sH / 2.0 || w <= 320){
                $(linkDekstopSheet).prop('disabled', true);
                $(linkMobileSheet).prop('disabled', false);
                
            }
            else{
                $(linkMobileSheet).prop('disabled', true);
                $(linkDekstopSheet).prop('disabled', false);
                    
            }
        }

        <?php

            if (isMobile()) {
                echo "$(linkDekstopSheet).prop('disabled', true);";
            } else {
                echo "$(linkMobileSheet).prop('disabled', true);";
            }

        ?>

        window.addEventListener('resize', changeCSSStyleSheet);

    </script>
</head>

<body>
    <?php
    $cookie_name = "logged";

    if (!isset($_COOKIE[$cookie_name])) {
        include 'login.php';
    } else {
        $cookie_name_type_account = "typeaccount";
        if (!isset($_COOKIE[$cookie_name_type_account])) {
            die('Error, type of account missing!');
        } else {
            $type_account = $_COOKIE[$cookie_name_type_account];
            include 'baseLogged.php';
        }
    }
    ?>
    
</body>

</html>