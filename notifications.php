<div class="w-75">
	<h1>Notifications!</h1>
	<?php
	require_once 'php/DBHandler.php';
	$DBHandler = new DBHandler();
	$user_id = $_SESSION["userid"];
	$sql_n = 
	"SELECT Notification.idNotification, Notification.Title, Notification.Description, Notification.Date, user_has_notification.isRead
	FROM Notification INNER JOIN user_has_notification ON Notification.idNotification = user_has_notification.Notification_idNotification
	WHERE user_has_notification.User_idUsers = $user_id
	ORDER BY Notification.Date DESC";

	$result = $DBHandler->select($sql_n);

	if($result){
		foreach ($result as $var) {
			$idNotification = $var["idNotification"];
			$title = $var["Title"];

			$date = $var["Date"];
			$description = $var["Description"];
			$isRead = $var["isRead"];
			?>
			<div class="border rounded mt-5 mb-5 clickable" data-id='<?php echo $idNotification; ?>' data-isRead='<?php echo $isRead; ?>' onclick="readNotification(this)">
				<div class="bg-white">
					<div class="row px-3" style="position: relative;">
						<div class="col-md-7 py-3">
							<h4 class="pt-2"><b><?php echo $title; ?></b></h4>
							<small class="pt-2"><b>Date: </b><?php echo $date; ?></small>
							<h6 class="pt-2"><b>Description: </b><?php echo $description; ?></h6>

						</div>
						<div class="mr-5 mb-2" style="position: absolute; bottom: 0; right: 0;">
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
		function readNotification(event){
			var idNotification = event.getAttribute("data-id");
			var isRead = event.getAttribute("data-isRead");
			
			if(isRead == 0){
				$.ajax({
					type: "POST",
					url: "php/readNotification.php",
					data:{
						id: idNotification
					},
					success: function(data){
						console.log(data);
						if(JSON.parse(data)["result"]){
							Swal.fire({
								title: "Notification read",
								type: "success"
							});
						}
					},
					error: function(data){
						Swal.fire({
							title: "Error",
							type: "error"
						});
					}
				});
			}
			
		}
	</script>
</div>
