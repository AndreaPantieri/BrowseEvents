<?php
	require 'DBHandler.php';

	if(isset($_GET["par"]) && isset($_GET["table"])){
		$DBHandler = new DBHandler();
		$result = $DBHandler->select("SELECT $_GET["par"] FROM $_GET["table"];");
		echo "OK";
	}
	

?>