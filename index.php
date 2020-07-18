<?php
	include 'queryDB.php';

	connectDB();

	session_start();

	$cookie_name = "logged";
	
	if(!isset($_COOKIE[$cookie_name])){
		include 'login.php';
	}
	else{
		include 'base.php';
	}
?>
