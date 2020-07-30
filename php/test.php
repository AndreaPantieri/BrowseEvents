<?php
	include 'DBHandler.php';
	$DBHandler = new DBHandler();
	$result = $DBHandler->select("SELECT * FROM usertype;");
	$title = $result[2]["Type"];
	echo $title;
?>