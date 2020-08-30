<?php
require_once 'DBHandler.php';

class Response{
	public $result = false;
}

$DBHandler = new DBHandler();
$Response = new Response();

if(isset($_POST["id"])){
	$idNotification = $_POST["id"];
	$idUser = $_SESSION["userid"];

	$sql = "UPDATE user_has_notification SET isRead = 1 WHERE User_idUsers = $idUser AND Notification_idNotification = $idNotification";
	$result = $DBHandler->genericQuery($sql);

	if($result){
		$Response->result = true;
	}
}
echo json_encode($Response);
?>