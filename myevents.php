<div class="w-75">
	<h1 class="mt-3">My Events</h1>
	<hr>
	<?php
	require_once 'php/DBHandler.php';
	$DBHandler = new DBHandler();
	$user_id = $_SESSION["userid"];

	$sql_e = "SELECT * FROM `event` WHERE User_idUsers = $user_id";
	$result = $DBHandler->select($sql_e);

	if($result){
		foreach ($result as $var) {
			$idEvent = $var["idEvent"];
			$name = $var["Name"];

			$date = $var["Datetime"];
			$place = $var["Place"];
			$price = $var["Price"];
			$path = 'res/img/events/' . $idEvent .'/';
			$files = glob($path . "0.{jpg,png,jpeg}",GLOB_BRACE);
			$file = '';
			if(count($files) > 0){
				$file = $files[0];
			}
			?>
			<div class="border rounded mt-4 mb-4 clickable" data-id='<?php echo $idEvent; ?>' onclick="manageEvent(this)">
				<div class="transparent-layout-white">
				    <div class="row px-3" style="position: relative;">
				        <div class="col-md-4 py-3">
				            <img src='<?php echo $file; ?>' alt='<?php echo $name; ?>' class="img-fluid">
				        </div>
				        <div class="col-md-7 py-3">
				            <h4 class="pt-2"><b><?php echo $name; ?></b></h4>
				            <h5 class="pt-2"><b>Date: </b><?php echo $date; ?></h5>
				            <h5 class="pt-2"><b>Price: </b><?php echo $price; ?>€</h5>
				            <h5 class="pt-2"><b>Place: </b><?php echo $place; ?></h5>
				        </div>
				        <div class="mr-3 mb-2" style="position: absolute; bottom: 0; right: 0;">
				        	<svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-chevron-right event-arrow" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							  <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
							</svg>
				        </div>
				        
				    </div>

				</div>
			</div>
			<?php
		}
	}
	?>
	<script type="text/javascript">
		function manageEvent(event){
			var idEvent = event.getAttribute("data-id");

			includeMainContent("modifyevent.php?event_id=" + idEvent);
		}
	</script>
</div>
