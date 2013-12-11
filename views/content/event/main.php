<div class="bg-double">	
		<div id='scroll-profile' class='hcento' style="width: 50%;float: left;">						
			<div id="profile" style="width:100%; max-width:500px; float:right">
				<div class="row">
					<div class="large-12 columns">
						
						<div id='box-userinfo'>
							<?php require_once(VIEWS_DIR . "content/event/box/box-classinfo.php"); ?>
						</div>
						
						<div id='box-information'>
							<?php require_once(VIEWS_DIR . "content/event/box/box-information.php"); ?>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div id='scroll-social' class='hcento' style="width: 50%;float: right;">
			<div id="social" style="width:100%; max-width:500px; float:left">
				<div class="row">
					<div class="large-12 columns">
						<div id='box-status' ></div>
						<script type="text/javascript">
							function loadBoxStatus() {
								var json_data = {};
								$.ajax({
									type: "POST",
									url: "content/event/box/box-status.php",
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-status").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									message = $.parseJSON(xhr.responseText).status;
									code = xhr.status;
									console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
						
						<div id="box-RecordReview"></div>
						<script type="text/javascript">
							function loadBoxRecordReview() {
								var json_data = {};
								json_data.eventObjectId = '<?php echo $eventObjectId; ?>';
								json_data.limit = 5;
								json_data.skip = 1;
								$.ajax({
									type: "POST",
									url: "content/event/box/box-recordReview.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-RecordReview").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									message = $.parseJSON(xhr.responseText).status;
									code = xhr.status;
									console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>

						<div id="box-EventReview"></div>
						<script type="text/javascript">
							function loadBoxEventReview() {
								var json_data = {};
								json_data.eventObjectId = '<?php echo $eventObjectId; ?>';
								json_data.limit = 5;
								json_data.skip = 1;
								$.ajax({
									type: "POST",
									url: "content/event/box/box-eventReview.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-EventReview").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									message = $.parseJSON(xhr.responseText).status;
									code = xhr.status;
									console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
						
						<div id="box-comment"></div>
						<script type="text/javascript">
							function loadBoxComment() {
								var json_data = {};
								json_data.eventObjectId = '<?php echo $eventObjectId; ?>';
								json_data.limit = 5;
								json_data.skip = 1;
								$.ajax({
									type: "POST",
									url: "content/event/box/box-comment.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito');
									}
								})
								.done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-comment").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								})
								.fail(function(xhr) {
									//spinner.hide();
									console.log('ERRORE=>'+richiesta+' '+stato+' '+errori);
									message = $.parseJSON(xhr.responseText).status;
									code = xhr.status;
									console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
					</div>
				</div>			
			</div>
		</div>	
	</div>		
</div>