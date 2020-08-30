<div class="flex-col-c w-75">

	<?php
	require_once 'php/DBHandler.php';

	$DBHandler = new DBHandler();

	if (isset($_GET["event_id"])) {
		$event_id = $_GET["event_id"];
		$sql = "SELECT browseeventsdb.event.*, category.Name AS Category 
		FROM browseeventsdb.event INNER JOIN category_has_event ON category_has_event.Event_idEvent = browseeventsdb.event.idEvent
		INNER JOIN category ON category_has_event.Category_idCategory = category.idCategory
		WHERE browseeventsdb.event.idEvent = $event_id";

		$result = $DBHandler->select($sql);

		if ($result) {
			$path = "./res/img/events/" . $result[0]["idEvent"] . "/";
			$images = glob($path . "*.{jpg,png,jpeg}", GLOB_BRACE);
			sort($images);
			$numImages = count($images);
			?>
			<div id="div-event" class="w-75">
				<h1 id="title-showevent">Event</h1>

				<?php
				if ($numImages > 0) {
					?>
					<div id="carousel" class="carousel slide row w-100" data-ride="carousel">
						<ol class="carousel-indicators">
							<?php
							for ($i = 0; $i < $numImages; $i++) {
								$tmpHTML = '<li id="carousel-li-' . $i . '" data-target="#carousel" data-slide-to="' . $i . '"';

								if ($i == 0) {
									$tmpHTML .=  'class="active"';
								}
								$tmpHTML .= '></li>';
								echo $tmpHTML;
							}
							?>
						</ol>
						<div class="carousel-inner">
							<?php
							for ($i = 0; $i < $numImages; $i++) {
								$tmpHTML = '<div class="carousel-item ';

								if ($i == 0) {
									$tmpHTML .=  'active';
								}
								$tmpHTML .= '" id="carousel-item-div-' . $i . '">';
								$tmpHTML .= '<img class="inputImage d-block" alt="' . $i . '° slide" src="' . $images[$i] . '""></div>';
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
					<p id="showevent-date" class="col-sm-10">
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
				<div class="row">
					<label class="col-sm-2 col-form-label">Buy tickets</label>
					<input id="event-tickets" class="form-control" type="number" name="event-tickets" placeholder="Type the number of tickets to add to cart" value="1" min="1" oninput="checkQuantity(this)" data-maxquantity="<?php echo $result[0]['TicketNumber']; ?>" max="<?php echo $result[0]['TicketNumber']; ?>">
					<button class="btn btn-primary" onclick="addToCart(this)" data-eventid="<?php echo $result[0]['idEvent']; ?>" data-userid="<?php if (isset($_SESSION["userid"])) { echo $_SESSION["userid"];} ?>" data-maxquantity="<?php echo $result[0]['TicketNumber']; ?>">Add to cart</button>
				</div>
				<?php
				if ($result[0]["User_idUsers"] == $_SESSION["userid"]) {
					?>
					<button class="btn btn-primary" onclick="includeMainContent(<?php echo "'modifyEvent.php?event_id=" . $result[0]['idEvent'] . "'"; ?>)">Modify</button>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
	?>
</div>

<script>
	function addToCart(elem) {
		var event_id = jQuery(elem).attr('data-eventid');
		var user_id = jQuery(elem).attr('data-userid');
		var ticket_quantity = parseInt($("#event-tickets").val());
		var maxQuantity = jQuery(elem).attr('data-maxquantity');

		if (ticket_quantity <= maxQuantity) {
			$.ajax({
				type: "POST",
				url: "php/addProductToCart.php",
				data: {
					event_id: event_id,
					user_id: user_id,
					ticket_quantity: ticket_quantity
				}
			}).then(function(data) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Tickets have been added to your cart!',
					showConfirmButton: false,
					timer: 1500
				})
			})
		} else {
			Swal.fire({
				title: "You can't buy more than the available quantity!",
				icon: "error"
			});
		}

	}

	function checkQuantity(elem) {
		var ticket_quantity = parseInt($("#event-tickets").val());
		var maxQuantity = jQuery(elem).attr('data-maxquantity');

		if (ticket_quantity > maxQuantity) {
			Swal.fire({
				title: "You can't buy more than the available quantity!",
				icon: "error"
			});
		}
	}
</script>