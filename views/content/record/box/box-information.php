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

$objectId = $record->getObjectId();
#TODO
//$city = $record->getCity();
$city = 'City_non_presente';
$year = $record->getYear();
$label = $record->getLabel();
$buylink = $record->getBuylink();
$description = $record->getDescription();
$fromUserObjectId = $record->getFromUser()->getObjectId();
$fromUserThumbnail = $record->getFromUser()->getProfileThumbnail();
$fromUserUsername = $record->getfromUser()->getUsername();

?>
<!--------- INFORMATION --------------------->
<div class="row" id="profile-information">
	<div class="large-12 columns">
	<h3><?php echo $views['information']['TITLE'];?></h3>		
		<div class="section-container accordion" data-section="accordion">
		  <section class="active" >
		  	<!--------------------------------- ABOUT ---------------------------------------------------->
		    <p class="title" data-section-title onclick="removeMap()"><a href="#"><?php echo $views['media']['Information']['CONTENT1_RECORD'] ?></a></p>
		    <div class="content" data-section-content>
		    	
				<div class="row " id="user_<?php echo $fromUserObjectId; ?>">
					<div class="small-1 columns ">
						<div class="icon-header">
							<img src="<?php echo $fromUserThumbnail; ?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
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
								<a class="ico-label white breakOff <?php if ($city != '') echo '_pin-white' ?>"><?php echo $city; ?></a>
								<a class="ico-label white breakOff <?php if ($year != '') echo '_calendar' ?>"><?php echo $year; ?></a>
							</div>
						</div>
                        <div class="row">
		    				<div class="small-12 columns">
		    					<a class="ico-label white breakOff <?php if($label != '') echo '_tag' ?>"><?php echo $label; ?></a>		    								    					
		    				</div>
						</div>
		    		</div>
		    			
		    	</div>
		    </div>
            <div class="content" data-section-content>
		    	<div class="row">
    				<div class="small-12 columns">
    					<div class="text orange"><span class="white">Buy this album</span> <?php echo $buylink; ?></div>		    								    					
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
						url: "content/record/box/box-informationFeaturing.php",
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
		</div>
	</div>
</div>