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
	$imagesAlt = array();
	
	for($i = 0; $i < $imagesPresents; $i++){
		if(isset($_POST["Image" . $i])){
			$images[$i] = $_POST["Image" . $i];
		}
		if(isset($_POST["ImageAlt" . $i])){
			$imagesAlt[$i] = $_POST["ImageAlt" . $i];
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
		$event_id = $DBHandler->insert($sql_e);
		
		$sql_ci = "SELECT idCategory FROM category WHERE Name = '$category'";
		$res = $DBHandler->select($sql_ci);
		if($res){
			$id_catefory = $res[0]["idCategory"];
			$sql_ce = "INSERT INTO category_has_event (Event_idEvent, Category_idCategory) VALUES ($event_id, $id_catefory)";
			if($DBHandler->genericQuery($sql_ce)){
				$Response->result = true;
			}
		}

		$pathForImages = "../res/img/events/" . $event_id . "/";

		if(!file_exists($pathForImages)){
			mkdir($pathForImages, 0777, true);
		}

		for($i = 0; $i < $imagesPresents; $i++){
			$type = mime_content_type($images[$i]);
			$extType = substr($type, 6);
			$path = $pathForImages . $i . "." . $extType;
			if(!file_exists($path)){
				$data = $images[$i];
				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				file_put_contents($path, $data);
			}
			$sql_i = "INSERT INTO Image (Image, Description, Event_idEvent) VALUES('" . substr($path, 3) . "', '" . $imagesAlt[$i] ."'" . ", $event_id)";
			if($DBHandler->genericQuery($sql_i)){
				$Response->result = true;
			}
		}

		if($imagesPresents > 0){
			$type = mime_content_type($images[0]);
			$extType = substr($type, 6);
			$mainImage = "res/img/events/" . $event_id . "/0." .  $extType;
			$sql_i = "UPDATE browseeventsdb.event SET Image = '$mainImage' WHERE idEvent = $event_id";

			if($DBHandler->genericQuery($sql_i)){
				$Response->result = true;
			}
		}
	}
	
	

}
echo json_encode($Response);
?>