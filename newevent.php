<form id="form-newevent" action="php/addEvent.php" method="POST" enctype="multipart/form-data">
	<h1 id="title-newevent">New Event</h1>
	
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
</script>
