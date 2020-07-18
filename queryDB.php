<?php
	function setDBConfigs(){
		global $server, $db_name, $db_user, $db_pass;

		$file_name = "configDB.ini";
		$file = fopen($file_name, "r");

		while (! feof($file)) {
			$file_row = fgets($file);
			$valueVar = "";

			$pos = strpos($file_row, " ");
			if(!($pos === false)){
				$valueVar = substr($file_row, 0, $pos);
			}

			$pos = strpos($file_row, "=");
			if(!($pos === false)){
				$value = substr($file_row, $pos + 2, -2);

				if(strcmp($valueVar, "db_name") == 0){
					$db_name = $value;
				}
				elseif (strcmp($valueVar, "db_user") == 0) {
					$db_user = $value;
				}
				elseif (strcmp($valueVar, "db_pass") == 0) {
					$db_pass = $value;
				}
				elseif (strcmp($valueVar, "server") == 0) {
					$server = $value;
				}
			}
		}
		fclose($file);
	}

	function connectDB(){
		setDBConfigs();

		global $server, $db_name, $db_user, $db_pass;
		echo $server;
		echo $db_name;
		echo $db_user;
		echo $db_pass;

		$conn = mysqli_connect($server, $db_user, $db_pass, $db_name);

		if (!$conn) {
		  die("Connection failed: " . mysqli_connect_error());
		}
		else{
			echo "OK";
		}
	}
?>