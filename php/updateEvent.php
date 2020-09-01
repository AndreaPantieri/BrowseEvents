<?php
require_once 'DBHandler.php';

class Response{
	public $result = false;
	public $tmp;
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
	isset($_POST["imagesPresents"]))
{
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
		$event_id = $_SESSION["event_id"];

		$DBHandler = new DBHandler();
		$sql_e = "UPDATE browseeventsdb.event SET Name='$name',Datetime='$date',Price=$price,Place='$place',TicketNumber=$maxtickets,Description='$description',User_idUsers=$user_id,LastModifyDate='" . date("Y-m-d H:i:s") ."' WHERE idEvent =  $event_id;";
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
			$pathForImagesTmp = "../res/img/events/tmp" . $event_id . "/";
			$mainImage = "res/img/events/" . $event_id . "/";

			$types = array();
			$datas = array();
			$oldFilesPosition  = array();
			$posOldarray = 0;

			$sql_di = "DELETE FROM Image WHERE Event_idEvent = $event_id";
			$DBHandler->genericQuery($sql_di);
			$Response->tmp = $sql_di;

			if(!file_exists($pathForImages)){
				mkdir($pathForImages, 0777, true);
			}

			if(!file_exists($pathForImagesTmp)){
				mkdir($pathForImagesTmp, 0777, true);
			}

			for($i = 0; $i < $imagesPresents; $i++){
				if(strcmp($pathForImages, "../" . substr($images[$i],0, 15). $event_id . "/") == 0){
					$types[$i] = mime_content_type("../" . $images[$i]);
					$extType = substr($types[$i], 6);
					$oldFilesPosition[$posOldarray] = $i;
					rename("../" . $images[$i], $pathForImagesTmp . "n" . $posOldarray . "." . $extType);
					$posOldarray++;
				}else{
					$types[$i] = mime_content_type($images[$i]);
				}
			}
			$oldFiles = glob($pathForImages . "*",GLOB_BRACE);
			foreach ($oldFiles as $file) {
				if(is_file($file)){
					unlink($file);
				}
			}

			for($i = 0; $i < $imagesPresents; $i++){
				$found = array_search($i, $oldFilesPosition);
				$extType = substr($types[$i], 6);

				if($i == 0){
					$mainImage .= "0." . $extType;
				}

				$path = $pathForImages . $i . "." . $extType;
				if(file_exists($path)){
					unlink($path);
				}
				if($found !== false){

					rename($pathForImagesTmp . "n" . $found . "." . $extType, $path);
				}
				else{
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
			
			$oldFiles = glob($pathForImagesTmp . "*",GLOB_BRACE);
			foreach ($oldFiles as $file) {
				if(is_file($file)){
					unlink($file);
				}
			}
			rmdir($pathForImagesTmp);

			if($imagesPresents > 0){
				$sql_i = "UPDATE browseeventsdb.event SET Image = '$mainImage' WHERE idEvent = $event_id";
				if($DBHandler->genericQuery($sql_i)){
					$Response->result = true;
				}
			}
		}		
	}
}
echo json_encode($Response);
?>
