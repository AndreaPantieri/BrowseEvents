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
				<h1 id="title-showevent" class="mt-4 mb-4"><b><?php echo $result[0]["Name"]; ?></b></h1>

				<?php
				if ($numImages > 0) {
					?>
					<div id="carousel" class="carousel slide px-5" data-ride="carousel">
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
							$sql_ia = "SELECT Description FROM Image WHERE Event_idEvent = $event_id";
							$res = $DBHandler->select($sql_ia);

							for ($i = 0; $i < $numImages; $i++) {
								$tmpHTML = '<div class="carousel-item ';

								if ($i == 0) {
									$tmpHTML .=  'active';
								}
								$tmpHTML .= '" id="carousel-item-div-' . $i . '">';
								if ($res) {
									$tmpHTML .= '<img class="inputImage d-block" alt="' . $res[$i]["Description"] . '" src="' . $images[$i] . '"">
									</div>';
								} else {
									$tmpHTML .= '<img class="inputImage d-block" alt="' . $i . '° slide" src="' . $images[$i] . '"">
									</div>';
								}

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
				<div id="showevent-info" class="transparent-layout-white rounded border mt-5 mb-5 px-5 py-5">
					<div>
						<div class="col-form-label"><b>Date</b></div>
						<div id="showevent-date" class="col-form-label">
							<?php
							echo $result[0]["Datetime"];
							?>
						</div>
						<div class="col-form-label"><b>Place</b></div>
						<div id="showevent-place" class="col-form-label">
							<?php
							echo $result[0]["Place"];
							?>
						</div>
					</div>
					<div>
						<div class="col-form-label"><b>Price per ticket</b></div>
						<div id="showevent-price" class="col-form-label">
							<?php
							echo $result[0]["Price"] . "€";
							?>
						</div>
						<div class="col-form-label"><b>Max num. tickets</b></div>
						<div id="showevent-maxtickets" class="col-form-label">
							<?php
							echo $result[0]["TicketNumber"];
							?>
						</div>
					</div>
					<div>
						<div class="col-form-label"><b>Category</b></div>
						<div class="col-form-label" id="showevent-category">
							<?php
							echo $result[0]["Category"];
							?>
						</div>
					</div>
					<div>
						<div class="col-form-label"><b>Description</b></div>
						<div class="col-form-label" id="showevent-description">
							<?php
							echo $result[0]["Description"];
							?>
						</div>
					</div>
					<div>
						<div class="col-form-label"><b>Buy tickets</b></div>
						<input id="event-tickets" class="form-control mr-3 mb-3" type="number" name="event-tickets" placeholder="Type the number of tickets to add to cart" value="1" min="1" oninput="checkQuantity(this)" data-maxquantity="<?php echo $result[0]['TicketNumber']; ?>" max="99">
					</div>
					<div class="w-mc">
						<button id="btn-addcart" class="btn btn-primary" onclick="addToCart(this)" data-eventid="<?php echo $result[0]['idEvent']; ?>" data-userid="<?php if (isset($_SESSION["userid"])) { echo $_SESSION["userid"];} ?>" data-maxquantity="<?php echo $result[0]['TicketNumber']; ?>">Add to cart</button>
						<?php
						if ($result[0]["User_idUsers"] == $_SESSION["userid"]) {
							?>
							<button id="btn-modify" class="btn btn-warning mt-1" onclick="includeMainContent(<?php echo "'modifyEvent.php?event_id=" . $result[0]['idEvent'] . "'"; ?>)">Modify</button>
							<?php
						}
						?>
					</div>
				</div>
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

		$.ajax({
			type: "POST",
			url: "php/checkProductsInCart.php",
			data: {
				event_id: event_id,
				user_id: user_id
			}
		}).then(function(data) {
			if (data) {
				Swal.fire({
					title: "This product is already in your cart!",
					icon: "error"
				});
			} else {
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
						});
					})
				} else if (maxQuantity == 0) {
					Swal.fire({
						title: "Tickets for this event are finished!",
						icon: "error"
					});
				} else {
					Swal.fire({
						title: "You can't buy more than the available quantity!",
						icon: "error"
					});
				}
			}
		})
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
		if (ticket_quantity > 99) {
			Swal.fire({
				title: "You can't buy more than 99 of the same product!",
				icon: "error"
			});
		}
	}
</script>