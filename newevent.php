<form id="form-newevent" action="php/addEvent.php" method="POST" enctype="multipart/form-data">
	<h1 id="title-newevent">New Event</h1>
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	  <ol class="carousel-indicators">
	    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	  </ol>
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	    	<svg viewBox="0 0 16 16" class="bi bi-card-image inputImage d-block"  alt="First slide" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			  <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
			  <path d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>
			  <path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
			</svg>
	    </div>
	    <div class="carousel-item">
	      <svg viewBox="0 0 16 16" class="bi bi-card-image inputImage d-block"  alt="Second slide" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			  <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
			  <path d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>
			  <path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
			</svg>
	    </div>
	  </div>
	  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>

	<div class="form-group" style="margin: auto;">
		<input type="file" id="selectImage" style="display: none;">
		<input type="button" class="btn btn-primary mb-2" value="Load a new photo" onclick="document.getElementById('selectImage').click();" />
		<button type="button" class="btn btn-primary mb-2">Remove selected</button>
	</div>
	<div class="form-group row">
		<label for="name-event" class="col-sm-2 col-form-label">Event name</label>
		<div class="col-sm-10">
			<input id="name-event" class="form-control" type="text" name="event-name" placeholder="Type event name">
		</div>
	</div>
	<div class="form-group row">
		<label for="event-date" class="col-sm-2 col-form-label">Date/Hour</label>
		<div class="col-sm-10">
			<input id="event-date" class="form-control" type="date" name="event-date">
		</div>
		<label for="event-place" class="col-sm-2 col-form-label">Place</label>
		<div class="col-sm-10">
			<input id="event-place" class="form-control" type="text" name="event-place" placeholder="Type the place">
		</div>
	</div>
	<div class="form-group row">
		<label for="event-price" class="col-sm-2 col-form-label">Price per ticket</label>
		<div class="col-sm-10">
			<input id="event-price" class="form-control" type="number" name="event-price" placeholder="Type the price per ticket">
		</div>
		<label for="event-maxtickets" class="col-sm-2 col-form-label">Max num. tickets</label>
		<div class="col-sm-10">
			<input id="event-maxtickets" class="form-control" type="number" name="event-maxtickets" placeholder="Type the max number of tickets to sell">
		</div>
	</div>
	<div class="form-group row">
		<label for="event-category">Category</label>
		<select class="form-control" id="event-category">
			<?php
				require 'php/getCategories.php';
			?>
		</select>
	</div>
	<div class="form-group">
	    <label for="event-description">Description</label>
	    <textarea class="form-control" id="event-description" rows="5" placeholder="Type the description of the event"></textarea>
  </div>
  <button id="event-publish" type="button" class="btn btn-primary" onclick="checkEvent()">Publish</button>
</form>

<script type="text/javascript">
	$("#form-newevent").submit(function(e){
		e.preventDefault();

		var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data){
                if(JSON.parse(data)["result"]){
                    
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

	function checkEvent(){
		$("#form-newevent").submit();
	}

	$(".inputImage").css("width", "30%");
	$("#form-newevent").css("width", "70%");
</script>
