<?php
require_once 'DBHandler.php';

class Response{
	public $result = true;
}

$DBHandler = new DBHandler();
$Response = new Response();

if(isset($_POST["numEls"])){
	$numEls = $_POST["numEls"];
	$idUser = $_SESSION["userid"];

	for($i = 0; $i < $numEls; $i++){
		if(isset($_POST["id" . $i])){
			$idNotification = $_POST["id" . $i];
	
			$sql = "UPDATE user_has_notification SET isRead = 1 WHERE User_idUsers = $idUser AND Notification_idNotification = $idNotification";
			$result = $DBHandler->genericQuery($sql);

			if(!$result){
				$Response->result = false;
			}
		}
	}
	
}
echo json_encode($Response);
?>