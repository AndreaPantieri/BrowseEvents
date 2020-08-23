<?php
	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}
	
	$_SESSION["sessionId"] = session_id();
	include './base.php';
?>
