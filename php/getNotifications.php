<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();

if(isset($_COOKIE["logged"])){
	$user_id = $_COOKIE["logged"];
	$last_id_read = isset($_SESSION["last_notification_read_id"]) ? $_SESSION["last_notification_read_id"] : 0;
	$sql_n = 
	"SELECT TOP 10 Notification.idNotification, Notification.Title, Notification.Description, Notification.Date
	FROM Notification INNER JOIN user_has_notification ON Notification.idNotification = user_has_notification.Notification_idNotification
	WHERE user_has_notification.User_idUsers = $user_id AND Notification.idNotification > $last_id_read
	ORDER BY Notification.Date
	";
	$result = $DBHandler->select($sql_n);
	$HTML = "<div class='dropdown-item'>No notifications</div>";
	if($result){
		$HTML = "";
		foreach ($result as $row) {
			$HTML .= '<div class="dropdown-item" role="button">
		<h4>$row["Notification.Title"]</h4>
		<p>$row["Notification.Description"]</p>
	</div>';
			$_SESSION["latest_notification_id"] = $row["Notification.idNotification"];
		}
	}
	
	echo $HTML;
}
?>