<div id="events-display">
	<?php
	require_once 'php/DBHandler.php';
	$DBHandler = new DBHandler();
	$last_id = 0;

	if(isset($_SESSION["event_last_id"])){
		$last_id = $_SESSION["event_last_id"];
	}
	
	$sql_e = "SELECT idEvent, Name, Datetime FROM `event` WHERE idEvent > $last_id ORDER BY Datetime DESC LIMIT 5 ";
	$result = $DBHandler->select($sql_e);

	foreach ($result as $var) {
		?>
	<div class="event-container card mb-3 clickable" <?php echo "data-id='" . $var["idEvent"] ."'";?>>
		<img class="event-image card-img-top img-fluid" <?php echo 'src="./res/img/events/' . $var["idEvent"] .'/0.jpg"'; ?>/>
		<div class="event-text card-body">
			<div class="event-title card-title"><?php echo $var["Name"];?></div>
			<div class="event-date card-text"><?php echo $var["Datetime"];?></div>
			<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right event-arrow" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
			  <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
			</svg>
		</div>	
	</div>
		<?php
	}
	?>
</div>

<script type="text/javascript">
	$(".event-container").click((e) => {
		var idEvent = e.currentTarget.getAttribute("data-id");
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	console.log(xhttp);
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
</script>
