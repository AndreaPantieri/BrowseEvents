<?php
require_once 'DBHandler.php';

class Response{
	public $result = false;
}

$Response = new Response();


if(isset($_SESSION["event_id"]) &&
isset($_POST["event-name"]) &&
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
		$event_id = $_SESSION["event_id"];

		$DBHandler = new DBHandler();
		$sql_e = "UPDATE browseeventsdb.event SET Name='$name',Datetime='$date',Price=$price,Place='$place',TicketNumber=$maxtickets,Description='$description',User_idUsers=$user_id,LastModifyDate=" . date("Y-m-d H:i:s") ." WHERE idEvent =  $event_id;";
		
		if($DBHandler->genericQuery($sql_e)){
			$sql_ci = "SELECT idCategory FROM category WHERE Name = '$category'";
			$res = $DBHandler->select($sql_ci);
			if($res){
				$id_catefory = $res[0]["idCategory"];
				$sql_ce = "UPDATE category_has_event SET Category_idCategory=$id_catefory WHERE Event_idEvent=$event_id";

				if($DBHandler->genericQuery($sql_ce)){
					$Response->result = true;
				}
			}

			$pathForImages = "../res/img/events/" . $event_id . "/";


			$files = glob($pathForImages . "*"); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
			    unlink($file); // delete file
			}

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
			}
		}
		
		
	}
	
	

}
echo json_encode($Response);
?>
