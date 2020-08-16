<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();
$sql = "SELECT Name FROM category";
$result = $DBHandler->select($sql);

$HTML = "";
foreach ($result as $var) {
	$HTML .= "<option>" . $var["Name"] . "</option>";
}
echo $HTML;
?>