<div id="container-fluid">
	<div id="events-container" class="mt-5 mb-5">
		<div id="events-display" 
		<?php
		if(isset($_GET["s"])){
			echo "data-s='" . $_GET["s"] . "' ";
		}
		?>>
		</div>
		<button id="events-more" class="btn btn-success" onclick="moreEvents()">More</button>

		<script type="text/javascript">
			function moreEvents(){
				var url = "php/getEvents.php?";
				var ed = $("#events-display");
				var s = ed.attr("data-s");
				var o = ed.attr("data-o");
				var c = ed.attr("data-c");

				if(typeof s != "undefined"){
					url += "s=" + s +"&";
				}
				if(typeof o != "undefined"){
					url += "o=" + o +"&";
				}
				if(typeof c != "undefined"){
					url += "c=" + c +"&";
				}

				includeContent(url, (h) => {
		            $("#events-display").append(h);

	        	});
			}
			function openEvent(e){
				var idEvent = e.getAttribute("data-id");
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
			}
			$(document).ready(() =>{
				includeContent("php/getEvents.php?r=1", (h) => {
		            document.getElementById("events-display").innerHTML = h;
	        	});
			});
		</script>	
	</div>
	<div id="filters" class="col-md-4 offset-md-1 border rounded mt-5 bg-white">
        <div class="pt-4">
            <h6>Filters</h6>
            <hr>
            <div class="form-group">
            	<label class="col-form-label">Order by</label>
	            <select class="form-control col-sm-8" id="orderby">
	            	<option selected="">Datetime</option>
					<option>Price</option>
					<option>Name</option>
				</select>
            </div>
            <div class="form-group">
            	<label class="col-form-label">Category</label>
	            <select class="form-control col-sm-8" id="categories">
	            	<option selected="">All</option>
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

    <script type="text/javascript">
    	function apply(){
    		var o = $("#orderby").val();
    		var c = $("#categories").val();
    		var s = $("#events-display").attr("data-s");
    		var url = "php/getEvents.php?r=1&c=" + c + "&o=" + o;

    		if(typeof s != "undefined"){
    			url += "&s=" + s;
    		}

    		$("#events-display").attr("data-o", o);
    		$("#events-display").attr("data-c", c);

    		includeContent(url, (h) => {
	            document.getElementById("events-display").innerHTML = h;
	            var s = document.getElementById("events-display").getElementsByTagName('script');
	            for (var i = 0; i < s.length ; i++) {
	                var node=s[i], parent=node.parentElement, d = document.createElement('script');
	                d.async=node.async;
	                d.textContent = node.textContent;
	                d.setAttribute('type','text/javascript');
	                parent.insertBefore(d,node);
	                parent.removeChild(node);
	            }
        	});
    	}
    </script>
</div>


