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
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'fileManager.service.php';

$id = $event->getId();
$city = $event->getCity();
$description = $event->getDescription();
$eventDate= ucwords(strftime("%A %d %B %Y - %H:%M", strtotime($event->getEventdate())));
$lat = $event->getLatitude();
$lon = $event->getLongitude();
$fromUserObjectId = $event->getFromuser()->getId();
$fromUserThumbnail = $event->getFromuser()->getThumbnail();
$fromUserUsername = $event->getFromuser()->getUsername();
switch ($event->getFromuser()->getType()) {
    case 'JAMMER':
	$defaultThum = DEFTHUMBJAMMER;
	break;
    case 'VENUE':
	$defaultThum = DEFTHUMBVENUE;
	break;
}
$fileManagerService = new FileManagerService();
$thumbPath = $fileManagerService->getPhotoPath($fromUserObjectId, $fromUserThumbnail);
?>
<!--------- INFORMATION --------------------->
<div class="row" id="profile-information">
    <div class="large-12 columns">
	<h3><?php echo $views['information']['title']; ?></h3>		
	<div class="section-container accordion" data-section="accordion">
	    <section class="active" >
		<!--------------------------------- ABOUT ---------------------------------------------------->
		<p class="title" data-section-title onclick="removeMap();"><a href="#"><?php echo $views['media']['information']['content1_event'] ?></a></p>
		<div class="content" data-section-content>
		    <a href="profile.php?user=<?php echo $fromUserObjectId ?>">
			<div class="row" id="user_<?php echo $fromUserObjectId ?>">
			    <div class="small-1 columns ">
				<div class="icon-header" onclick="location.href = 'profile.php?user=<?php echo $fromUserObjectId; ?>'">
				    <img src="<?php echo $thumbPath ?>" onerror="this.src='<?php echo $defaultThum; ?>'" alt ="<?php echo $fromUserUsername ?>">
				</div>
			    </div>
			    <div  class="small-11 columns ">
				<div class="text white breakOffTest"><strong><?php echo $fromUserUsername ?></strong></div>
			    </div>		
			</div>
		    </a>
		</div>	
		<div class="content" data-section-content>
		    <div class="row">
			<div class="small-12 columns">
			    <div class="row">
				<div class="small-12 columns">				
				    <a class="ico-label white breakOff <?php if ($city != '') echo '_pin-white' ?>"><?php echo $city ?></a>
				    <a class="ico-label white breakOff <?php if ($eventDate != '') echo '_calendar' ?>"><?php echo $eventDate ?></a>
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

	    <section id='box-informationFeaturing'></section>
	    <script type="text/javascript">
		    function loadBoxInformationFeaturing() {
			var json_data = {};
			json_data.id = '<?php echo $id; ?>';
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
		<p class="title" data-section-title onclick="viewMap('<?php echo $lat; ?>', '<?php echo $lon; ?>')"><a href="#"><?php echo $views['information']['content3']; ?></a></p>
		<div class="content" data-section-content>
		    <div class="row">
			<div class="small-12 columns">     					  	
			    <div  id="map_venue"></div>	
			</div>
		    </div>
		    <div class="row">
			<!-- div class="small-12 columns" >
			    <a class="ico-label _pin white " onclick="getDirectionMap()"><?php echo $views['information']['content3_direction']; ?></a> 
			</div -->
		    </div>				 	
		</div>
	    </section>

	    <!--------------------------------------- ATTENDING --------------------------------------->
	    <section id='box-informationAttendee'></section>
	    <script type="text/javascript">
		    function loadBoxInformationAttendee() {
			var json_data = {};
			json_data.id = '<?php echo $id; ?>';
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
	    <section id='box-informationInvited'></section>
	    <script type="text/javascript">
		function loadBoxInformationInvited() {
		    var json_data = {};
		    json_data.id = '<?php echo $id; ?>';
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