<?php
require_once 'DBHandler.php';
$DBHandler = new DBHandler();
$numb_events = 0;

if(isset($_SESSION["numb_events"])){
	$numb_events = $_SESSION["numb_events"];
}

$sql_e = "SELECT idEvent, Name, Datetime FROM `event` ORDER BY Datetime DESC LIMIT $numb_events, 5 ";
$result = $DBHandler->select($sql_e);

if($result){
	$numb_events += 5;
	$_SESSION["numb_events"] = $numb_events;

}
foreach ($result as $var) {
	$path = './res/img/events/' . $var["idEvent"] .'/';
	$files = glob($path . "0.{jpg,png,jpeg}",GLOB_BRACE);
	$file = '';
	if(count($files) > 0){
		$file = $files[0];
	}
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
?>