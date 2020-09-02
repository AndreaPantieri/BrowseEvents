<?php

function recursiveRemoveDirectory($directory)
{
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}

class Response{
	public $result = false;
}

require_once 'DBHandler.php';
$DBHandler = new DBHandler();
$Response = new Response();

if(isset($_SESSION["event_id"])){
	$event_id = $_SESSION["event_id"];
	$sql_de = "DELETE FROM `event` WHERE idEvent = $event_id";
	$Response->result = $DBHandler->genericQuery($sql_de);

	$pathImgs = "../res/img/events/".$event_id."/";

	recursiveRemoveDirectory($pathImgs);
}
echo json_encode($Response);

?>