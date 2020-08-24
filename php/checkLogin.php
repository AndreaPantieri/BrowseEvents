<?php
require_once('./DBHandler.php');

class checkLoginResponse
{
	public $result = false;
	public $cookie;
}

$DBHandler = new DBHandler();
$checkLoginResponse = new checkLoginResponse();

if (isset($_POST['user']) && isset($_POST['pwd'])) {
	$username = $_POST['user'];
	$password = md5($_POST['pwd']);
	$reminder = isset($_POST['reminder']);


	$sql = "SELECT idUsers, Username, Password, UserType_idUserType FROM user WHERE (Username = '$username') AND Password = '$password'";
	$result = $DBHandler->select($sql);

	if ($result) {
		$counts = array_map('count', $result);

		if (count($counts) == 1) {
			$_SESSION["userid"] = $result[0]['idUsers'];
			$_SESSION["username"] = $result[0]['Username'];
			$_SESSION["idUserType"] = $result[0]['UserType_idUserType'];

			$checkLoginResponse->result = true;

			if ($reminder) {
				$session_id = $_SESSION["sessionId"];
				$token = bin2hex(random_bytes(256));
				$cookie = $session_id . ':' . $token;
				$hash = hash_hmac('sha256', $cookie, "85053461164796801949539541639542805770666392330682673302530819774105141531698707146930307290253537320447270457");
				$cookie .= ':' . $hash;
				$checkLoginResponse->cookie = $cookie;

				setcookie('remindme', $cookie, [
					'expires' => time() + 86400,
    				'path' => '/',
    				'secure' => true,
    				'samesite' => 'none'
				]);
				
				$sql = "INSERT INTO Session (idSession, User_idUsers, Token) VALUE ('$session_id', ". $_SESSION['userid'] . ", '$token')";
				$res = $DBHandler->genericQuery($sql);

				if (!$res) {
					$checkLoginResponse->result = false;
				}
			}
		}
	} else {
		$checkLoginResponse->result = false;
	}
}
echo json_encode($checkLoginResponse);
