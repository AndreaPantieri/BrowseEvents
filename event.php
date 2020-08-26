<?php
require_once 'php/DBHandler.php';
$DBHandler = new DBHandler();

if(isset($_GET["event_id"])){
	$event_id = $_GET["event_id"];
	$sql = "SELECT browseeventsdb.event.*, category.Name AS Category 
	FROM browseeventsdb.event INNER JOIN category_has_event ON category_has_event.Event_idEvent = browseeventsdb.event.idEvent
	INNER JOIN category ON category_has_event.Category_idCategory = category.idCategory
	WHERE browseeventsdb.event.idEvent = $event_id";

	$result = $DBHandler->select($sql);

	if($result){
		$path = "./res/img/events/" . $result[0]["idEvent"]."/";
		$images = glob($path . "*.{jpg,png,jpeg}",GLOB_BRACE);
		$numImages = count($images);
		?>
<div id="div-event">
	<h1 id="title-showevent">Event</h1>

		<?php
		if($numImages > 0){
			?>
			<div id="carousel" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php
			for($i = 0; $i < $numImages; $i++) {
				$tmpHTML = '<li id="carousel-li-' . $i .'" data-target="#carousel" data-slide-to="' . $i . '"';

				if($i == 0){
					$tmpHTML .=  'class="active"';
				}
				$tmpHTML .= '></li>';
				echo $tmpHTML;
			}
			?>
		</ol>
		<div class="carousel-inner">
			<?php
			for($i = 0; $i < $numImages; $i++) {
				$tmpHTML = '<div class="carousel-item ';

				if($i == 0){
					$tmpHTML .=  'active';
				}
				$tmpHTML .= '" id="carousel-item-div-' . $i .'">';
				$tmpHTML .= '<img class="inputImage d-block" alt="'. $i .'° slide" src="' . $images[$i] . '"">
			</div>';
				echo $tmpHTML;
			}
			?>
		</div>
		<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
			<?php
		}
	
		?>
	<div class="row">
		<label class="col-sm-2 col-form-label">Event name</label>
		<p id="showevent-name" class="col-sm-10">
			<?php
			echo $result[0]["Name"];
			?>
		</p>
	</div>
	<div class="row">
		<label class="col-sm-2 col-form-label">Date/Hour</label>
		<p id="showevent-date"  class="col-sm-10">
			<?php
			echo $result[0]["Datetime"];
			?>
		</p>
		<label class="col-sm-2 col-form-label">Place</label>
		<p id="showevent-place" class="col-sm-10">
			<?php
			echo $result[0]["Place"];
			?>
		</p>
	</div>
	<div class="row">
		<label class="col-sm-2 col-form-label">Price per ticket</label>
		<p id="showevent-price" class="col-sm-10">
			<?php
			echo $result[0]["Price"];
			?>
		</p>
		<label class="col-sm-2 col-form-label">Max num. tickets</label>
		<p id="showevent-maxtickets" class="col-sm-10">
			<?php
			echo $result[0]["TicketNumber"];
			?>
		</p>
	</div>
	<div class="row">
		<label class="col-sm-2 col-form-label">Category</label>
		<p class="col-sm-10" id="showevent-category">
			<?php
			echo $result[0]["Category"];
			?>
		</p>
	</div>
	<div class="row">
	    <label class="col-sm-2 col-form-label">Description</label>
	    <p class="col-sm-10" id="showevent-description">
	    	<?php
			echo $result[0]["Description"];
			?>
	    </p>
  </div>
</div>
		<?php
	}
}
?>