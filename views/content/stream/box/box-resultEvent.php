<?php
/* box le activity
 * box chiamato tramite ajax con:
 * data-type: html,
 * type: POST o GET
 *
 */
ini_set('display_errors', '1');
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'event.box.php';

$lat = $_POST['latitude'];
$lon = $_POST['longitude'];
$city = $_POST['city'];
$country = $_POST['country'];
$genre = $_POST['genre'];
$eventDate = $_POST['eventDate'];

$eventBox = new EventBox();
$eventBox->initForStream($lat, $long, $city, $country, $genre, $eventDate);
if (is_null($eventBox->error)) {
    $events = $eventBox->eventArray;
    $index = 0;
    if (count($events) > 0) { ?>    	
    	<div class="row">
    		<div  class="small-5 columns">
            	<div onclick="hideResult()" style="cursor: pointer"><h6 class="orange" style="padding-top: 15px"><?php echo $views['stream']['new_search']; ?></h6></div>
        	</div>
        	<?php if(count($events) > 3){ ?>					
		        <div  class="small-5 columns">
		            <a class="slide-button-prev _prevPage slide-button-prev-disabled" onclick="resultSlidePrev(this)"><?php echo $views['PREV']; ?></a>
		        </div>
		        <div  class="small-2 columns">
		            <a class="slide-button-next _nextPage" onclick="resultSlideNext(this)"><?php echo $views['NEXT']; ?></a>
		        </div>
	        <?php } ?>
	    </div>
		<div class="royalSlider rsMinW>" id="resultSlide">					
		<?php foreach ($events as $key => $value) { 
    	if ($index % 3 == 0) { ?><div class="rsContent"> <?php } ?>
            <div id="<?php echo $value->getObjectId(); ?>">
                <div class="box ">
                	<a href="profile.php?user=<?php echo $value->getFromUser()->getObjectId() ?>">
	                    <div class="row line">
	                        <div class="small-1 columns ">
	                            <div class="icon-header">
	                                <!--THUMB FROMUSER-->
	                                <?php $pathPictureThumbFromUser = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . 'profilepicturethumb' . DIRECTORY_SEPARATOR . $value->getFromUser()->getProfileThumbnail(); ?>
	                                <img src="<?php echo $pathPictureThumbFromUser; ?>" onerror="this.src='<?php echo DEFAVATARJAMMER; ?>'">
	                            </div>
	                        </div>
	                        <div class="small-5 columns">
	                            <div class="text grey" style="margin-bottom: 0px;">
	                                <strong><?php echo $value->getFromUser()->getUsername(); ?></strong>
	                            </div>
	                            <div class="note orange">
	                                <strong><?php echo $value->getFromUser()->getType(); ?></strong>
	                            </div>
	                        </div>
	                        <div class="small-6 columns propriety">
	                        </div>
	                    </div>
                    </a>
                    <a href="event.php?event=<?php echo $value->getObjectId() ?>">
	                    <div class="row">
	                        <div class="small-12 columns box-detail">
	                            <div class="row ">
	                                <div class="small-12 columns">
	                                    <div class="row">
	                                        <div class="small-2 columns ">
	                                            <?php $pathRecordThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $value->getThumbnail(); ?>
	                                            <div class="coverThumb"><img src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></div>						
	                                        </div>
	                                        <div class="small-10 columns ">
	                                            <div class="row ">							
	                                                <div class="small-12 columns ">
	                                                    <h5><?php echo $value->getTitle(); ?></h5>
	                                                    <h6><?php echo $value->getGenre(); ?></h6>
	                                                </div>	
	                                            </div>	
	                                            <div class="row">						
	                                                <div class="small-12 columns ">
	                                                </div>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
                    </a>
                </div>
        	</div>
		<?php if (($index + 1) % 3 == 0 || count($events) == $index + 1) { ?> </div> <?php  }
	    $index++; 
        } ?>
    </div>
    <script>
    var rsi_result;
    $(document).ready(function() {
    	rsi_result  = slideReview('resultSlide');
        rsi_result.updateSliderSize(true);
        
    });
    function resultSlideNext(btn){    	
    	slideNext(btn, rsi_result);
    }
    function resultSlidePrev(btn){
    	slidePrev(btn, rsi_result);
    }
    </script>
	
   <?php } else {
        ?>
        <div class="row">
    		<div  class="small-12 columns">
            	<div onclick="hideResult()" style="cursor: pointer"><h6 class="orange" style="padding-top: 15px"><?php echo $views['stream']['new_search']; ?></h6></div>
        	</div>
        </div>
       <div class="box">
	        <div class="row">						
	            <div class="small-12 columns " style="padding-bottom: 20px;">
	            	<?php echo $views['stream']['noresult'] ?>
	            </div>
	        </div>
        </div>
        <?php
    }
    ?>

    
    <?php
}
?>
