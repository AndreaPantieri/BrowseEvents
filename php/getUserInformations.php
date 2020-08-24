<?php
require_once 'DBHandler.php';
//NOT TESTED YET, PROBABLY USELESS

/* this function is used to return user informations if user logged using remindme option
if user didn't log using remindme, you don't need this function to get user informations dinamically but you need to use the $_SESSION variables
*/
class getUserInformationsResponse
{
    public $result = false;
    public $idUser;
    public $username;
    public $email;
    public $usertype;
    public $firstname;
    public $lastname;
    public $lastLogin;
}

$DBHandler = new DBHandler();
$getUserInformationsResponse = new getUserInformationsResponse();

if (isset($_POST["session_id"])) {
    $session_id = $_POST["session_id"];

    $sql = "SELECT User_idUsers AS idUser, Username, Email, UserType_idUserType, FirstName, LastName, LastLoginDate FROM Session 
        INNER JOIN User ON Session.User_idUsers = User.idUsers WHERE idSession = '$session_id'";
    $res = $DBHandler->select($sql);
    $counts = array_map('count', $res);

    if (count($counts) == 1) {
        $iduser =       $res[0]['idUser'];
        $username =     $res[0]['Username'];
        $email =        $res[0]['Email'];
        $usertype =     $res[0]['UserType_idUserType'];
        $firstname =    $res[0]['FirstName'];
        $lastname =     $res[0]['LastName'];
        $lastLogin =    $res[0]['LastLoginDate'];

        $getUserInformationsResponse->result = true;
    } else {
        $getUserInformationsResponse->result = false;
    }
}
echo json_encode($getUserInformationsResponse);
