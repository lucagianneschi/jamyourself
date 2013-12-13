<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
?>
<div class="bg-double">	
		<div id='scroll-profile' class='hcento' style="width: 50%;float: left;">						
			<div id="profile" style="max-width:500px; float:right" class="row">
					<div class="large-12 columns">
						<div id='box-userinfo'>
							<?php require_once(VIEWS_DIR . "content/profile/box/box-userinfo.php"); ?>
						</div>
						
						<div id='box-information' >
							<?php require_once(VIEWS_DIR . "content/profile/box/box-information.php"); ?>
						</div>
						
						<div id="box-record"></div>
						<script type="text/javascript">
							function loadBoxRecord() {
								var json_data = {};
								json_data.objectId = '<?php echo $user->getObjectId(); ?>';
								$.ajax({
									type: "POST",
									url: "content/profile/box/box-record.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito box-record');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-record").html(message);
									//plugin scorrimento box
									rsi_record = slideReview('recordSlide');
									//plugin share
									addthis.init();
									addthis.toolbox(".addthis_toolbox");
									//adatta pagina per scroll
									hcento();
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									console.log("Error: " + $.parseJSON(xhr));
									//message = $.parseJSON(xhr.responseText).status;
									//code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
						
						<?php
						if ($user->getType() == 'JAMMER' || $user->getType() == 'VENUE') {
							?>
							<div id='box-event'></div>
							<script type="text/javascript">
								function loadBoxEvent() {
									var json_data = {typeUser:'<?php echo $type?>'};
									json_data.objectId = '<?php echo $user->getObjectId(); ?>';
									$.ajax({
										type: "POST",
										url: "content/profile/box/box-event.php",
										data: json_data,
										beforeSend: function(xhr) {
											//spinner.show();
											console.log('Sono partito box-event');
										}
									}).done(function(message, status, xhr) {
										//spinner.hide();
										$("#box-event").html(message);
										//plugin scorrimento box
										rsi_event = slideReview('eventSlide');
										//adatta pagina per scroll
										hcento();
										code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
										console.log("Code: " + code + " | Message: <omitted because too large>");
									}).fail(function(xhr) {
										//spinner.hide();
										console.log("Error: " + $.parseJSON(xhr));
										//message = $.parseJSON(xhr.responseText).status;
										//code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
									});
								}
							</script>
							<?php
						}
						?>
						
						<?php
						if ($user->getType() == 'SPOTTER') {
							?>
							<div id='box-friends'></div>
							<script type="text/javascript">
								function loadBoxFriends() {
									var json_data = {};
									json_data.objectId = '<?php echo $user->getObjectId(); ?>';
									json_data.friendshipCounter = '<?php echo $user->getFriendshipCounter(); ?>';
									$.ajax({
										type: "POST",
										url: "content/profile/box/box-friends.php",
										data: json_data,
										beforeSend: function(xhr) {
											//spinner.show();
											console.log('Sono partito box-friends');
										}
									}).done(function(message, status, xhr) {
										//spinner.hide();
										$("#box-friends").html(message);
										code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
										console.log("Code: " + code + " | Message: <omitted because too large>");
									}).fail(function(xhr) {
										//spinner.hide();
										console.log("Error: " + $.parseJSON(xhr));
										//message = $.parseJSON(xhr.responseText).status;
										//code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
									});
								}
							</script>
							
							<div id='box-following' ></div>	
							<script type="text/javascript">
								function loadBoxFollowing() {
									var json_data = {};
									json_data.objectId = '<?php echo $user->getObjectId(); ?>';
									json_data.followingCounter = '<?php echo $user->getFollowingCounter(); ?>';
									$.ajax({
										type: "POST",
										url: "content/profile/box/box-following.php",
										data: json_data,
										beforeSend: function(xhr) {
											//spinner.show();
											console.log('Sono partito box-following');
										}
									}).done(function(message, status, xhr) {
										//spinner.hide();
										$("#box-following").html(message);
										code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
										console.log("Code: " + code + " | Message: <omitted because too large>");
									}).fail(function(xhr) {
										//spinner.hide();
										console.log("Error: " + $.parseJSON(xhr));
										//message = $.parseJSON(xhr.responseText).status;
										//code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
									});
								}
							</script>
							<?php
						}
						?>
						
						<div id='box-album'></div>
						<script type="text/javascript">
							function loadBoxAlbum() {
								var json_data = {};
								json_data.objectId = '<?php echo $user->getObjectId(); ?>';
								$.ajax({
									type: "POST",
									url: "content/profile/box/box-album.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito box-album');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-album").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									console.log("Error: " + $.parseJSON(xhr));
									//message = $.parseJSON(xhr.responseText).status;
									//code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
				</div>
			</div>
		</div>
		<div id='scroll-social' class='hcento' style="width: 50%;float: right;">
			<div id="social" style="max-width:500px; float:left" class="row">
					<div class="large-12 columns">
						<div id='box-status'>
							<?php require_once(VIEWS_DIR . "content/profile/box/box-status.php"); ?>
						</div>
						
						<div id="box-recordReview"></div>	
						<script type="text/javascript">
							function loadBoxRecordReview() {
								var json_data = {};
								json_data.objectId = '<?php echo $user->getObjectId(); ?>';
								json_data.type = '<?php echo $user->getType(); ?>';
								$.ajax({
									type: "POST",
									url: "content/profile/box/box-recordReview.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito box-recordReview');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-recordReview").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									console.log("Error: " + $.parseJSON(xhr));
									//message = $.parseJSON(xhr.responseText).status;
									//code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
						
						<div id="box-eventReview"></div>
						<script type="text/javascript">
							function loadBoxEventReview() {
								var json_data = {};
								json_data.objectId = '<?php echo $user->getObjectId(); ?>';
								json_data.type = '<?php echo $user->getType(); ?>';
								$.ajax({
									type: "POST",
									url: "content/profile/box/box-eventReview.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito box-eventReview');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-eventReview").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									console.log("Error: " + $.parseJSON(xhr));
									//message = $.parseJSON(xhr.responseText).status;
									//code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
						
						<div id="box-activity"></div>
						<script type="text/javascript">
							function loadBoxActivity() {
								var json_data = {};
								json_data.objectId = '<?php echo $user->getObjectId(); ?>';
								json_data.type = '<?php echo $user->getType(); ?>';
								$.ajax({
									type: "POST",
									url: "content/profile/box/box-activity.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito box-activity');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-activity").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									console.log("Error: " + $.parseJSON(xhr));
									//message = $.parseJSON(xhr.responseText).status;
									//code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
						
						<?php
						if ($user->getType() == 'JAMMER' || $user->getType() == 'VENUE') {
							?>
							<div id="box-collaboration"></div>
							<script type="text/javascript">
								function loadBoxCollaboration() {
									var json_data = {};
									json_data.objectId = '<?php echo $user->getObjectId(); ?>';
									json_data.type = '<?php echo $user->getType(); ?>';
									json_data.collaborationCounter = '<?php echo $user->getCollaborationCounter(); ?>';
									$.ajax({
										type: "POST",
										url: "content/profile/box/box-collaboration.php",
										data: json_data,
										beforeSend: function(xhr) {
											//spinner.show();
											console.log('Sono partito box-collaboration');
										}
									}).done(function(message, status, xhr) {
										//spinner.hide();
										$("#box-collaboration").html(message);
										code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
										console.log("Code: " + code + " | Message: <omitted because too large>");
									}).fail(function(xhr) {
										//spinner.hide();
										console.log("Error: " + $.parseJSON(xhr));
										//message = $.parseJSON(xhr.responseText).status;
										//code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
									});
								}
							</script>
							
							<div id="box-followers"></div>
							<script type="text/javascript">
								function loadBoxFollowers() {
									var json_data = {};
									json_data.objectId = '<?php echo $user->getObjectId(); ?>';
									json_data.type = '<?php echo $user->getType(); ?>';
									json_data.followersCounter = '<?php echo $user->getFollowersCounter(); ?>';
									$.ajax({
										type: "POST",
										url: "content/profile/box/box-followers.php",
										data: json_data,
										beforeSend: function(xhr) {
											//spinner.show();
											console.log('Sono partito box-followers');
										}
									}).done(function(message, status, xhr) {
										//spinner.hide();
										$("#box-followers").html(message);
										code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
										console.log("Code: " + code + " | Message: <omitted because too large>");
									}).fail(function(xhr) {
										//spinner.hide();
										console.log("Error: " + $.parseJSON(xhr));
										//message = $.parseJSON(xhr.responseText).status;
										//code = xhr.status;
										//console.log("Code: " + code + " | Message: " + message);
									});
								}
							</script>
							<?php
						}
						?>
						
						<div id="box-post"></div>
						<script type="text/javascript">
							function loadBoxPost() {
								var json_data = {};
								json_data.objectId = '<?php echo $user->getObjectId(); ?>';
								json_data.type = '<?php echo $user->getType(); ?>';
								$.ajax({
									type: "POST",
									url: "content/profile/box/box-post.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito box-post');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-post").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									console.log("Error: " + $.parseJSON(xhr));
									//message = $.parseJSON(xhr.responseText).status;
									//code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
				</div>			
			</div>
		</div>	
	</div>		
</div>
