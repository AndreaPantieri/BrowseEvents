<?php
require_once 'DBHandler.php';

$DBHandler = new DBHandler();

$sql = "SELECT * from user WHERE isApproved = 0";
$result = $DBHandler->select($sql);
$counts = array_map('count', $result);

if (count($counts) != 0) {
    foreach ($result as $row) {
        $HTML .= '<option data-userid="' . $row["idUsers"] . '">' . $row["Username"] . '</option>';
    }
} else {
    $HTML = "<option>No requests to show</option>";
}

echo $HTML;
