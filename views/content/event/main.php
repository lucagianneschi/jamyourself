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
										console.log('Sono partito loadBoxStatus()');
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
						
						<div id="box-eventReview"></div>
						<script type="text/javascript">
							function loadBoxEventReview(limit, skip) {
								var json_data = {};
								json_data.objectId = '<?php echo $objectId; ?>';
                                json_data.limit = limit;
                                json_data.skip = skip;
								$.ajax({
									type: "POST",
									url: "content/event/box/box-eventReview.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito loadBoxEventReview(' + limit +', ' + skip + ')');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-eventReview").html(message);
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
							function loadBoxComment(limit, skip) {
								var json_data = {};
								json_data.objectId = '<?php echo $objectId; ?>';
								json_data.limit = limit;
								json_data.skip = skip;
								$.ajax({
									type: "POST",
									url: "content/event/box/box-comment.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito loadBoxComment(' + limit +', ' + skip + ')');
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