<?php
require_once 'DBHandler.php';

class Response{
	public $result = false;
}

$Response = new Response();


if(isset($_POST["event-name"]) &&
isset($_POST["event-date"]) &&
isset($_POST["event-place"]) &&
isset($_POST["event-price"]) &&
isset($_POST["event-maxtickets"]) &&
isset($_POST["event-category"]) &&
isset($_POST["event-description"]) &&
isset($_POST["imagesPresents"])){
	$imagesPresents = (int)$_POST["imagesPresents"];
	$images = array();
	
	for($i = 0; $i < $imagesPresents; $i++){
		if(isset($_POST["Image" . $i])){
			$images[$i] = $_POST["Image" . $i];
		}
	}

	if(count($images) == $imagesPresents){

		$user_id = $_SESSION["userid"];
		$name = $_POST["event-name"];
		$date = $_POST["event-date"];
		$place = $_POST["event-place"];
		$price = $_POST["event-price"];
		$maxtickets = $_POST["event-maxtickets"];
		$category = $_POST["event-category"];
		$description = $_POST["event-description"];


		$DBHandler = new DBHandler();
		$sql_e = "INSERT INTO browseeventsdb.event (Name, Datetime, Price, Place, TicketNumber, Description, User_idUsers) VALUES ('$name', '$date', $price, '$place', $maxtickets, '$description', $user_id);";
		$event_id = $DBHandler->genericQuery($sql_e);

		$sql_ci = "SELECT idCategory FROM category WHERE Name = '$category'";
		$res = $DBHandler->select($sql_ci);
		if($res){
			$id_catefory = $res[0]["idCategory"];
			$sql_ce = "INSERT INTO category_has_event (Event_idEvent, Category_idCategory) VALUES ($event_id, $id_catefory)";
			if($DBHandler->genericQuery($sql_ce)){
				$Response->result = true;
			}
		}

		//TODO SAVE IMAGES
	}
	
	

}
echo json_encode($Response);
?>