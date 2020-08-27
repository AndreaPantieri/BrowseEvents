<div id="events-container">
	<div id="events-display">
		<?php
			include_once 'php/getEvents.php';
		?>
	</div>

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
</div>

