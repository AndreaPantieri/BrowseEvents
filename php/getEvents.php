<?php
require_once 'DBHandler.php';
$DBHandler = new DBHandler();
$numb_events = 0;

if(isset($_GET["r"]) && (int)$_GET["r"] == 1){
	$_SESSION["numb_events"] = 0;
}

if(isset($_SESSION["numb_events"])){
	$numb_events = $_SESSION["numb_events"];
}
else{
	$_SESSION["numb_events"] = 0;
}

$sql_e = "SELECT idEvent, `event`.Name, Datetime, Price, Place, `event`.Description, Category.Name AS Category FROM `event` INNER JOIN category_has_event ON  `event`.idEvent = category_has_event.Event_idEvent INNER JOIN Category ON Category.idCategory = category_has_event.Category_idCategory ";

if(isset($_GET["s"]) && $_GET["s"] != ""){
	$s = $_GET["s"];
	$sql_e .= "WHERE (Name LIKE '*" . $s ."*' ||  Place LIKE '*" . $s ."*' || Description LIKE '*" . $s ."*') ";
}

if(isset($_GET["c"]) && $_GET["c"] != "All"){
	$c = $_GET["c"];

	$sql_e .= "&& Category = '" . $c ."' ";
}

if(isset($_GET["o"])){
	$o = $_GET["o"];

	$sql_e .= "ORDER BY " . $o . " DESC";
}

$sql_e .= " LIMIT $numb_events, 5";
echo $sql_e;
$result = $DBHandler->select($sql_e);

if($result){
	$numb_events += 5;
	$_SESSION["numb_events"] = $numb_events;
	foreach ($result as $var) {
		$path = '../res/img/events/' . $var["idEvent"] .'/';
		$files = glob($path . "0.{jpg,png,jpeg}",GLOB_BRACE);
		$file = '';
		if(count($files) > 0){
			$file = $files[0];
		}
		echo $file;
		$file = substr($file, 3);
		echo $file;
		?>
	<div class="event-container card mb-3 clickable" <?php echo "data-id='" . $var["idEvent"] ."'";?>>
		<img class="event-image card-img-top img-fluid" <?php echo 'src="' . $file . '"'; ?>/>
		<div class="event-text card-body">
			<div class="event-title card-title"><?php echo $var["Name"];?></div>
			<div class="event-date card-text"><?php echo $var["Datetime"];?></div>
			<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right event-arrow" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			  <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
			</svg>
		</div>	
	</div>
		<?php
	}

}

?>