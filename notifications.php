<div class="w-75">
	<div>
		<div class="mt-3">
			<h6>Notifications</h6>
		</div>
		<hr>
		<div>
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
					<div class="border rounded mt-5 mb-5 <?php echo $isRead == 0 ? 'clickable' : ''; ?>" data-id='<?php echo $idNotification; ?>' data-isRead='<?php echo $isRead; ?>' onclick="readNotification(this)">
						<div class="transparent-layout-white">
							<div class="row px-3" style="position: relative;">
								<div class="col-md-7 py-3">
									<h4 class="pt-2"><b><?php echo $title; ?></b></h4>
									<small class="pt-2"><b>Date: </b><?php echo $date; ?></small>
									<h6 class="pt-2"><b>Description: </b><?php echo $description; ?></h6>

								</div>

							</div>

						</div>
					</div>
					<?php
				}
			}
			else{
				?>
				<div><h1>There are no notifications!</h1></div>
				<?php
			}
			?>
		</div>
	</div>
	
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
						if(JSON.parse(data)["result"]){
							Swal.fire({
								title: "Notification read",
								icon: "success"
							});
							event.setAttribute("data-isRead", 1);
							event.classList.remove("clickable");
						}
					},
					error: function(data){
						Swal.fire({
							title: "Error",
							icon: "error"
						});
					}
				});
			}
			
		}
	</script>
</div>
