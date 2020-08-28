<div id="container-fluid">
	<div id="events-container">
		<div id="events-display">
			<?php
				include_once 'php/getEvents.php';
			?>
		</div>
		<?php
		if(isset($_SESSION["numb_events"]) && $_SESSION["numb_events"] != 0){
			?>
		<button id="events-more" onclick="moreEvents()">More</button>

		<script type="text/javascript">
			$(".event-container").click((e) => {
				var idEvent = e.currentTarget.getAttribute("data-id");
				var xhttp = new XMLHttpRequest();
		        xhttp.onreadystatechange = function() {
		            if (this.readyState == 4 && this.status == 200) {
		            	document.getElementById("maincontent").innerHTML = xhttp.responseText;
			            var s = document.getElementById("maincontent").getElementsByTagName('script');
			            for (var i = 0; i < s.length ; i++) {
			                var node=s[i], parent=node.parentElement, d = document.createElement('script');
			                d.async=node.async;
			                d.textContent = node.textContent;
			                d.setAttribute('type','text/javascript');
			                parent.insertBefore(d,node);
			                parent.removeChild(node);
			            }
		            }
		        };
		        xhttp.open("GET", "event.php?event_id=" + idEvent, true);
		        xhttp.send();
			});

			function moreEvents(){
				var xhttp = new XMLHttpRequest();
		        xhttp.onreadystatechange = function() {
		            if (this.readyState == 4 && this.status == 200) {
		            	$("#events-display").append(xhttp.responseText);

			            var s = document.getElementById("maincontent").getElementsByTagName('script');
			            for (var i = 0; i < s.length ; i++) {
			                var node=s[i], parent=node.parentElement, d = document.createElement('script');
			                d.async=node.async;
			                d.textContent = node.textContent;
			                d.setAttribute('type','text/javascript');
			                parent.insertBefore(d,node);
			                parent.removeChild(node);
			            }
		            }
		        };
		        xhttp.open("GET", "php/getEvents.php", true);
		        xhttp.send();
			}
		</script>
			<?php
		} else {
			?>
		<div>There are no events yet!</div>
			<?php
		}
		?>
		
	</div>
	<div id="filters" class="col-md-4 offset-md-1 border rounded mt-5 bg-white">
        <div class="pt-4">
            <h6>Filters</h6>
            <hr>
            <div class="form-group">
            	<label class="col-form-label">Order by</label>
	            <select class="form-control col-sm-8" id="categories">
					<option>Price</option>
					<option>Date</option>
					<option>Name</option>
				</select>
            </div>
            <div class="form-group">
            	<label class="col-form-label">Category</label>
	            <select class="form-control col-sm-8" id="categories">
					<?php
						require 'php/getCategories.php';
					?>
				</select>
            </div>
            
            <div>
                <button type="submit" class="btn btn-success mt-2 mb-3" onClick="apply()">Apply</button>
            </div>
        </div>
    </div>
</div>


