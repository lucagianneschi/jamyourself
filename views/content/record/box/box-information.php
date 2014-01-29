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
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';

$objectId = $record->getObjectId();

$city = $record->getCity();

$year = $record->getYear();
$label = $record->getLabel();
$buylink = $record->getBuylink();
$description = $record->getDescription();
$fromUserObjectId = $record->getFromUser()->getObjectId();
$fromUserThumbnail = $record->getFromUser()->getProfileThumbnail();
$fromUserUsername = $record->getfromUser()->getUsername();

switch ($record->getfromUser()->getType()) {
    case 'JAMMER':
	$defaultThum = DEFTHUMBJAMMER;
	break;
    case 'VENUE':
	$defaultThum = DEFTHUMBVENUE;
	break;
    case 'SPOTTER':
	$defaultThum = DEFTHUMBSPOTTER;
	break;
}

$css_city = (!isset($city) || $city == '') ? 'no-display' : '';
$css_year = (!isset($year) || $year == '') ? 'no-display' : '';
$css_label = (!isset($label) || $label == '') ? 'no-display' : '';
$css_buylink = (!isset($buylink) || $buylink == '') ? 'no-display' : '';
$css_description = (!isset($description) || $description == '') ? 'no-display' : '';

?>
<!--------- INFORMATION --------------------->
<div class="row" id="profile-information">
    <div class="large-12 columns">
	<h3><?php echo $views['information']['TITLE']; ?></h3>		
	<div class="section-container accordion" data-section="accordion">
	    <section class="active" >
		<!--------------------------------- ABOUT ---------------------------------------------------->
		<p class="title" data-section-title onclick="removeMap()"><a href="#"><?php echo $views['media']['Information']['CONTENT1_RECORD'] ?></a></p>
		<div class="content" data-section-content>
			<a href="profile.php?user=<?php echo $fromUserObjectId ?>">
			    <div class="row " style="cursor: pointer" id="user_<?php echo $fromUserObjectId; ?>">
					<div class="small-1 columns ">
					    <div class="icon-header">
							<img src="<?php echo $fromUserThumbnail; ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
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
				    <a class="ico-label white breakOff _pin-white <?php echo $css_city ?>"><?php echo $city; ?></a>
				    <a class="ico-label white breakOff _calendar <?php echo $css_year ?>"><?php echo $year; ?></a>
				</div>
			    </div>
			    <div class="row">
				<div class="small-12 columns">
				    <a class="ico-label white breakOff _tag <?php echo $css_label ?>"><?php echo $label; ?></a>		    								    					
				</div>
			    </div>
			</div>

		    </div>
		</div>
		<div class="content <?php echo $css_buylink ?>" data-section-content>
		    <div class="row">
			<div class="small-12 columns">
			    <div class="text orange"><span class="white"><?php echo $views['media']['Record']['buy']; ?></span> <a class="orange" href="<?php echo $buylink; ?>"><?php echo $buylink; ?></a></div>		    								    					
			</div>
		    </div> 
		</div>
		<div class="content <?php echo $css_description ?>" data-section-content>
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