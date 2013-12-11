<?php
/*
 * Contiene il box information dell'utente
 * Il contenuto varia a seconda del tipo di utente:
 * spotter: abount
 * jammer: abount e member
 * venue: abount e map
 * 
 * box chiamato tramite load con:
 * data: array conente infomazoini di tipo userInfo, 
 * 
 * 
 */

$objectId = $event->getObjectId();
$city = $event->getCity();
$description = $event->getDescription();
$eventDate = $event->getEventDate()->format('l j F Y - H:i');
$lat = $event->getLocation()->lat;
$lon = $event->getLocation()->lon;
$fromUserObjectId = $event->getFromUser()->getObjectId();
$fromUserThumbnail = $event->getFromUser()->getProfileThumbnail();
$fromUserUsername = $event->getfromUser()->getUsername();

?>
<!--------- INFORMATION --------------------->
<div class="row" id="profile-information">
	<div class="large-12 columns">
	<h3><?php echo $views['information']['TITLE'];?></h3>		
		<div class="section-container accordion" data-section="accordion">
		  <section class="active" >
		  	<!--------------------------------- ABOUT ---------------------------------------------------->
		    <p class="title" data-section-title onclick="removeMap()"><a href="#"><?php echo $views['media']['Information']['CONTENT1_EVENT'] ?></a></p>
		    <div class="content" data-section-content>
		    	
				<div class="row " id="user_<?php echo $fromUserObjectId ?>">
					<div class="small-1 columns ">
						<div class="icon-header">
							<img src="<?php echo $fromUserThumbnail ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
						</div>
					</div>
					<div  class="small-11 columns ">
						<div class="text white breakOffTest"><strong><?php echo $fromUserUsername ?></strong></div>
					</div>		
				</div>
					
		    </div>	
		   <div class="content" data-section-content>
		    	<div class="row">
		    		<div class="small-12 columns">
		    			<div class="row">
		    				<div class="small-12 columns">				
								<a class="ico-label white breakOff <?php if ($city != '') echo '_pin-white' ?>"><?php echo $city ?></a>
								<a class="ico-label white breakOff <?php if ($eventDate != '') echo '_calendar' ?>"><?php echo $eventDate?></a>
							</div>
						</div>
		    		</div>
		    			
		    	</div>
		    </div>
		    <div class="content" data-section-content>
		    	<p class="text grey">
		    	<?php echo $description; ?>
		    	</p> 
		    </div>
			</section>
		    <!--------------------------------------- FEATURING - PERFORMED BY --------------------------------------->
			<div id='box-informationFeaturing'></div>
			<script type="text/javascript">
				function loadBoxInformationFeaturing() {
					var json_data = {};
					json_data.objectId = '<?php echo $objectId; ?>';
					$.ajax({
						type: "POST",
						url: "content/event/box/box-informationFeaturing.php",
						data: json_data,
						beforeSend: function(xhr) {
							//spinner.show();
							console.log('Sono partito informationFeaturing');
						}
					}).done(function(message, status, xhr) {
						//spinner.hide();
						$("#box-informationFeaturing").html(message);
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
			
			<section id="profile_map_venue" > 
				<p class="title" data-section-title onclick="viewMap('<?php echo $lat; ?>','<?php echo $lon; ?>')"><a href="#"><?php echo $views['information']['CONTENT3'];?></a></p>
				<div class="content" data-section-content>
					<div class="row">
						<div class="small-12 columns">     					  	
							<div  id="map_venue"></div>	
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns ">
							<a class="ico-label _pin white " onclick="getDirectionMap()"><?php echo $views['information']['CONTENT3_DIRECTION'];?></a> 
						</div>
					</div>				 	
				</div>
			</section>
			
			<!--------------------------------------- ATTENDING --------------------------------------->
			<div id='box-informationAttendee'></div>
			<script type="text/javascript">
				function loadBoxInformationAttendee() {
					var json_data = {};
					json_data.objectId = '<?php echo $objectId; ?>';
					$.ajax({
						type: "POST",
						url: "content/event/box/box-informationAttendee.php",
						data: json_data,
						beforeSend: function(xhr) {
							//spinner.show();
							console.log('Sono partito informationAttendee');
						}
					}).done(function(message, status, xhr) {
						//spinner.hide();
						$("#box-informationAttendee").html(message);
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
			
			<!--------------------------------------- INVITED --------------------------------------->
			<div id='box-informationInvited'></div>
			<script type="text/javascript">
				function loadBoxInformationInvited() {
					var json_data = {};
					json_data.objectId = '<?php echo $objectId; ?>';
					$.ajax({
						type: "POST",
						url: "content/event/box/box-informationInvited.php",
						data: json_data,
						beforeSend: function(xhr) {
							//spinner.show();
							console.log('Sono partito informationInvited');
						}
					}).done(function(message, status, xhr) {
						//spinner.hide();
						$("#box-informationInvited").html(message);
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
		</div>
	</div>
</div>