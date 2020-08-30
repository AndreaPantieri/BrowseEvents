<?php
require_once 'DBHandler.php';

class Response{
	public $HTML = "<div class='dropdown-item'>No notifications</div>";
	public $count = 0;
}

$DBHandler = new DBHandler();
$Response = new Response();

if(isset($_SESSION["userid"])){
	$user_id = $_SESSION["userid"];
	$sql_n = 
	"SELECT Notification.idNotification, Notification.Title, Notification.Description, Notification.Date, user_has_notification.isRead
	FROM Notification INNER JOIN user_has_notification ON Notification.idNotification = user_has_notification.Notification_idNotification
	WHERE user_has_notification.User_idUsers = $user_id AND user_has_notification.isRead = 0
	ORDER BY Notification.Date DESC
	";
	$result = $DBHandler->select($sql_n);

	if($result){
		$Response->count = count(array_map('count', $result));
		$Response->HTML = "<span id='num_notifications'>" . $count > 99 ? "99+" : $count . "</span>";
		foreach ($result as $row) {
			$HTML .= '<div class="dropdown-item" role="button">
		<h4>$row["Notification.Title"]</h4>
		<p>$row["Notification.Description"]</p>
	</div>';
		}
	}
}
echo json_encode($Response);
?>