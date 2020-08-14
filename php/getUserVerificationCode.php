<?php
require_once 'DBHandler.php';
class getUserVerificationCodeResponse{
	public $result = false;
}

$DBHandler = new DBHandler();
$getUserVerificationCodeResponse = new getUserVerificationCodeResponse();

if(isset($_POST["username"]) && isset($_POST["code"])){
	$username = $_POST["username"];
	$code = $_POST["code"];
	$sql = "SELECT VerificationCode, UserType_idUserType FROM user WHERE Username = '$username'";
	$result = $DBHandler->select($sql);
	$counts = array_map('count', $result);

	if(count($counts) == 1){
		if(!is_null($result[0]["VerificationCode"]) && $result[0]["VerificationCode"] == $code){
			$sql_u = "UPDATE user SET EmailStatus = 'verified' WHERE Username = '$username'";
			$tmp = $DBHandler->genericQuery($sql_u);

			if($tmp){
				setcookie("logged", $username, time() + (86400 * 2), "/");
	        	setcookie("typeaccount", $result[0]["UserType_idUserType"], time() + (86400 * 2), "/");
				$getUserVerificationCodeResponse->result = true;
			}
		}
	}
}
echo json_encode($getUserVerificationCodeResponse);
?>