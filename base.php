<?php
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

    <!-- Bootstrap CSS + JS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- JQuery + Ajax -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript" src="js/md5.js"></script>

    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style-common.css">
    <link rel="stylesheet" href="css/style-mobile.css">
    <link rel="stylesheet" href="css/style-dekstop.css">

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
    $cookie_name = "remindme";
    if(isset($_COOKIE[$cookie_name])){
        //TODO CHECKS COOKIE
        list ($session_id, $token, $hash) = explode(':', $cookie);

        if (!hash_equals(hash_hmac('sha256', $user . ':' . $token, "85053461164796801949539541639542805770666392330682673302530819774105141531698707146930307290253537320447270457"), $hash)) {
            die("Error in cookie");
        }

        $DBHandler = new DBHandler();
        $sql = "SELECT User_idUsers AS idUser, Username, UserType_idUserType, Token FROM Session 
        INNER JOIN User ON Session.User_idUsers = User.idUsers WHERE idSession = '$session_id'";
        $result = $DBHandler->select($sql);

        if($result){
            $counts = array_map('count', $result);
            $count = count($counts);

            if($count == 1){
                $tokenFromDB = $result[0]["Token"];
                if (hash_equals($usertoken, $token)) {

                    $_SESSION["userid"] = $result[0]['idUser'];
                    $_SESSION["username"] = $result[0]['Username'];
                    $_SESSION["idUserType"] = $result[0]['UserType_idUserType'];
                    $_SESSION["sessionId"] = $session_id;
                    include 'baseLogged.php';
                }
            } 
        }
    }
    else{
        if(isset($_SESSION["userid"]) && isset($_SESSION["username"]) && isset($_SESSION["idUserType"])){
            $type_account = $_SESSION["idUserType"];
            include 'baseLogged.php';
        }
        else{
            include 'login.php';
        }   
        
    }
    ?>
    
</body>

</html>