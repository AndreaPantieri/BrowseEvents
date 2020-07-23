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

		global $server, $db_name, $db_user, $db_pass, $conn;

		$conn = mysqli_connect($server, $db_user, $db_pass, $db_name);

		if (!$conn) {
		  die("Connection failed: " . mysqli_connect_error());
		}
		else{
			echo "OK";
		}
	}

	function closeConnectionDB(){
		global $conn;
		mysqli_close($conn);
	}

	function queryDB($querySQL){
		global $conn;

		connectDB();
		$result = mysqli_query($conn, $querySQL);
		return $result;
	}

	function select($querySQL){
		$result = queryDB($querySQL);
		$setResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		closeConnectionDB();
		return $setResult;
		
	}

	function genericQuery($querySQL){
		$result = queryDB($querySQL);
		closeConnectionDB();

		return $result;
	}
?>