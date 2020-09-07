<div class="flex-col-c w-75">
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
			$_SESSION["event_id"] = $event_id;
			$path = "res/img/events/" . $result[0]["idEvent"]."/";
			$images = glob($path . "*.{jpg,png,jpeg}",GLOB_BRACE);
			sort($images);
			$numImages = count($images);
			?>
			<form id="form-modifyevent" class="w-75" action="php/updateEvent.php" method="POST" enctype="multipart/form-data">
				<h2 id="title-modifyevent" class="mt-4 mb-4">Modify Event</h2>
				<svg id="emptyEventImage" viewBox="0 0 16 16" <?php if($numImages > 0){
					echo 'class="bi bi-card-image inputImage d-block px-5 nonVisible"';
				} else{
					echo 'class="bi bi-card-image inputImage d-block px-5"';
				} ?> fill="currentColor" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
				<path d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>
				<path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
			</svg>

			<div id="carousel" <?php if($numImages == 0){
				echo 'class="carousel slide px-5 nonVisible"';
			} else{
				echo 'class="carousel slide px-5"';
			} ?> data-ride="carousel">
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
				$sql_ia = "SELECT Description FROM Image WHERE Event_idEvent = $event_id";
				$res = $DBHandler->select($sql_ia);

				for($i = 0; $i < $numImages; $i++) {
					$tmpHTML = '<div class="carousel-item ';

					if($i == 0){
						$tmpHTML .=  'active';
					}
					$tmpHTML .= '" id="carousel-item-div-' . $i .'">';
					if($res){
						$tmpHTML .= '<img class="inputImage d-block" alt="'. $res[$i]["Description"] .'" src="' . $images[$i] . '"">
						</div>';
					} else{
						$tmpHTML .= '<img class="inputImage d-block" alt="'. $i .'° slide" src="' . $images[$i] . '"">
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
		<div class="form-group fj-sa" style="margin: auto;">
			<input type="file" id="selectImage" style="display: none;" accept=".jpg, .jpeg, .png">
			<input type="button" class="btn btn-success mt-3" value="Load a new photo" onclick="document.getElementById('selectImage').click();" />
			<button type="button" class="btn btn-danger mt-3" onclick="removeImage()">Remove selected</button>
		</div>
		<div id="modifyevent-info" class="transparent-layout-white rounded border mt-5 mb-5 px-5 py-5">
			<div class="form-group">
				<label for="name-event" class="col-form-label"><b>Event name</b></label>
				<div class="col-form-label">
					<input id="name-event" class="form-control" type="text" name="event-name" placeholder="Type event name" 
					<?php
					echo 'value="' . $result[0]["Name"] . '"';
					?>>
				</div>
			</div>

			<div class="form-group">
				<label for="event-date" class="col-form-label"><b>Date</b></label>
				<div class="col-form-label">
					<input id="event-date" class="form-control" type="date" name="event-date" 
					<?php
					echo 'value="' . $result[0]["Datetime"] . '"';
					?>>
				</div>
			</div>
			<div class="form-group">
				<label for="event-place" class="col-form-label"><b>Place</b></label>
				<div class="col-form-label">
					<input id="event-place" class="form-control" type="text" name="event-place" placeholder="Type the place" 
					<?php
					echo 'value="' . $result[0]["Place"] . '"';
					?>>
				</div>
			</div>
			<div class="form-group">
				<label for="event-price" class="col-form-label"><b>Price per ticket</b></label>
				<div class="col-form-label">
					<input id="event-price" class="form-control" type="number" name="event-price" placeholder="Type the price per ticket"
					<?php
					echo 'value="' . $result[0]["Price"] . '"';
					?>>
				</div>
			</div>
			<div class="form-group">
				<label for="event-maxtickets" class="col-form-label"><b>Max num. tickets</b></label>
				<div class="col-form-label">
					<input id="event-maxtickets" class="form-control" type="number" name="event-maxtickets" placeholder="Type the max number of tickets to sell"
					<?php
					echo 'value="' . $result[0]["TicketNumber"] . '"';
					?>>
				</div>
			</div>
			<div class="form-group">
				<label for="event-category" class="col-form-label"><b>Category</b></label>
				<select class="form-control col-form-label" id="event-category" name="event-category" >
					<?php
					$sql_c = "SELECT Name FROM category";
					$result_C = $DBHandler->select($sql_c);

					$tmpHTML3 = "";
					foreach ($result_C as $var) {
						if($var["Name"] === $result[0]["Category"]){
							$tmpHTML3 .= "<option selected>" . $var["Name"] . "</option>";
						} else{
							$tmpHTML3 .= "<option>" . $var["Name"] . "</option>";
						}

					}
					echo $tmpHTML3;
					?>
				</select>
			</div>

			<div class="form-group">
				<label for="event-description" class="col-form-label"><b>Description</b></label>
				<textarea class="form-control col-form-label" id="event-description" name="event-description" rows="5" placeholder="Type the description of the event"><?php print trim($result[0]["Description"]); ?></textarea>
			</div>
			<div class="w-mc">
				<button id="event-modify" type="button" class="btn btn-primary" onclick="checkEvent()">Save changes</button>
				<button id="event-delete" type="button" class="btn btn-danger mt-1" onclick="deleteEvent()">Delete</button>
			</div>
			
		</div>
		
	</form>
</div>


<script type="text/javascript">
	$("#form-modifyevent").submit(function(e){
		e.preventDefault();

		var items = $("#carousel .carousel-inner");
		var imagesPresents = $("#carousel .carousel-indicators li").length;

		var form = $(this);
		var url = form.attr('action');
		var dataToSend = form.serializeArray();
		dataToSend.push({name: "imagesPresents", value: imagesPresents});

		var i;
		for(i = 0; i < imagesPresents; i++){
			var tmpImgSrc = $("#carousel-item-div-" + i + " img").attr('src');
			var tmpImgAlt = $("#carousel-item-div-" + i + " img").attr('alt');
			dataToSend.push({name: "Image" + i, value: tmpImgSrc});
			dataToSend.push({name: "ImageAlt" + i, value: tmpImgAlt});
		}
		$.ajax({
			type: "POST",
			url: url,
			data: $.param(dataToSend),
			success: function(data){
				if(JSON.parse(data)["result"]){
					Swal.fire({
						title: "Event modified successfully!",
						icon: "success"
					}).then(() => location.reload());
				}
				else{
					Swal.fire({
						title: "Data error!",
						icon: "error"
					});
				}
			},
			error: function(data){
				Swal.fire({
					title: "Error!",
					icon: "error"
				});
			}
		});
	});

	function updateImageDisplay(event){
		var target = event.target, files = target.files;
		var imagesPresents = $("#carousel .carousel-indicators li").length;

		var div = $("<div />"), img = $("<img />");
		div.addClass("carousel-item");
		div.attr('id', 'carousel-item-div-' + imagesPresents);
		img.addClass("inputImage d-block");
		img.prop("alt", imagesPresents + "° slide");
		
		

		$(".active").removeClass("active");

		$("#carousel .carousel-indicators").append('<li id="carousel-li-'+ imagesPresents + '" data-target="#carousel" data-slide-to="' + imagesPresents + '"></li>');
		$("#carousel-li-0").addClass("active");
		

		if (FileReader && files && files.length) {
			
			var fr = new FileReader();
			fr.onload = function (e) {
				img.prop("src", e.target.result);
			};
			fr.readAsDataURL(files[0]);
			div.append(img);
			$("#carousel .carousel-inner").append(div);
			$("#carousel-item-div-0").addClass("active");
		}
		$("#carousel").removeClass("nonVisible");
		$("#emptyEventImage").addClass("nonVisible");
		$("#emptyEventImage").removeClass("d-block");

		Swal.fire({
			title: "Insert description for the image",
			showCloseButton: true,
			input: "text"
		}).then((result)=>{
			if(typeof result != "undefined" && result !== ""){
				img.prop("alt", result.value);
			}
		});
	}

	function removeImage(){
		var indicators = $("#carousel .carousel-indicators");
		var items = $("#carousel .carousel-inner");
		var imagesPresents = $("#carousel .carousel-indicators li").length;

		if(imagesPresents > 0){
			var indexActive = $(".carousel-indicators .active").attr("data-slide-to");
			var imgToRemove = $("#carousel-item-div-" + indexActive);

			var imgSrc = [];
			var i;
			for(i = 0; i < imagesPresents; i++){
				imgSrc.push($("#carousel-item-div-" + i + " img").attr('src'));
			}
			imgSrc.splice(indexActive, 1);

			indicators.empty();
			items.empty();

			if(imgSrc.length == 0){
				$("#carousel").addClass("nonVisible");
				$("#emptyEventImage").removeClass("nonVisible");
				$("#emptyEventImage").addClass("d-block");
			} else {
				for(i = 0; i < imgSrc.length; i++){
					indicators.append('<li id="carousel-li-'+ i + '" data-target="#carousel" data-slide-to="' + i + '"></li>');

					var div = $("<div />"), img = $("<img />");
					div.addClass("carousel-item");
					div.attr('id', 'carousel-item-div-' + i);
					img.addClass("inputImage d-block");
					img.prop("alt", i + "° slide");
					img.prop("src", imgSrc[i]);
					div.append(img);
					items.append(div);
				}
				$("#carousel-li-0").addClass("active");
				$("#carousel-item-div-0").addClass("active");
			}
			
		}
		
	}

	function checkEvent(){
		var name = $("#name-event").val();
		var date = $("#event-date").val();
		var place = $("#event-place").val();
		var price = $("#event-price").val();
		var maxtickets = $("#event-maxtickets").val();
		var category = $("#event-category").val();
		var description = $("#event-description").val();
		var imagesPresents = $("#carousel .carousel-indicators li").length;

		function verify(tmp, val){
			return typeof tmp != "undefined" && tmp !== val;
		}

		if(verify(name, "") && verify(date, "") && Date.parse(date) && verify(place, "") && verify(price, "") && verify(maxtickets, "") && maxtickets >= 0 && verify(category, "") && verify(description, "") && verify(imagesPresents, 0) && imagesPresents > 0){
			$("#form-modifyevent").submit();
		}
		else{
			Swal.fire({
				title: "Data error or missing!",
				icon: "error"
			});
		}
	}

	function deleteEvent(){
		Swal.fire({
			title: "Are you sure?",
			text: "You will not be able to recover this event!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, archive it!",
			cancelButtonText: "No, cancel please!",
		}).then(function(res) {
			if (res.isConfirmed) {
				$.ajax({
					type: "POST",
					url: "php/deleteEvent.php",
					success:function(data){
						if(JSON.parse(data)["result"]){
							Swal.fire({
								title: "Event deleted successfully!",
								icon: "success"
							}).then(() => location.reload());
						}
					}
				});
			} else {
				Swal.fire({
					title: "Operation cancelled!",
					text: "Event not deleted!"
				});
			}
		});
		
	}

	$(document).ready(() => {
		document.getElementById("selectImage").addEventListener('change', updateImageDisplay);
	});
</script>

<?php
}
}
?>