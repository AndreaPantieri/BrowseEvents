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
isset($_POST["event-description"])){
	$name = $_POST["event-name"];
	$date = $_POST["event-date"];
	$place = $_POST["event-place"];
	$price = $_POST["event-price"];
	$maxtickets = $_POST["event-maxtickets"];
	$description = $_POST["event-description"];
	


}
echo json_encode($Response);
?>