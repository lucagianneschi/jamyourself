<?php
/* Box degli eventi, viene effettuata la chiamata a tale box solo se typeUser: jammer or venue
 * box chiamato tramite load con:
 * data: {data: data, typeUser: typeUser}
 * 
 * @data: array contenente tutti di dati relativi agli eventi
 * @typeUser: tipo utente (JAMMER, VENUE o SPOTTER)
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'event.box.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'select.service.php';

if (session_id() == '')
    session_start();

$eventBox = new EventBox();
$eventBox->init($_POST['id']);
$typeUser = $_POST['typeUser'];

if (is_null($eventBox->error)) {
    if (isset($_SESSION['currentUser']))
	$currentUser = $_SESSION['currentUser'];
    $currentUserId = $_SESSION['id'];
    $events = $eventBox->eventArray;
    $eventCounter = count($events);
    ?>
    <div class="row" id='profile-Event'>
        <div class="large-12 columns ">	
    	<div class="row">
    	    <div  class="small-5 columns">
    		<h3><?php echo $views['event']['title']; ?> </h3>
    	    </div>	
    	    <div  class="small-7 columns align-right">
		    <?php
		    if ($eventCounter > 3) {
			?>
			<div class="row">					
			    <div  class="small-9 columns">
				<a class="slide-button-prev _prevPage slide-button-prev-disabled" onclick="royalSlidePrev(this, 'event')"><?php echo $views['prev']; ?> </a>
			    </div>
			    <div  class="small-3 columns">
				<a class="slide-button-next _nextPage" onclick="royalSlideNext(this, 'event')"><?php echo $views['next']; ?> </a>
			    </div>
			</div>
			<?php
		    }
		    ?>
    	    </div>
    	</div>		
    	<!------------------------------------ LISTA Event --------------------------------------->
    	<div class="box">
		<?php
		if ($eventCounter > 0) {
		    $index = 0;
		    ?>
		    <div class="royalSlider rsMinW>" id="eventSlide">					
			<?php
			$fileManagerService = new FileManagerService();
			foreach ($events as $key => $value) {
			    if ($index % 3 == 0) {
				?><div class="rsContent">	<?php
			    }
			    $event_thumbnail = $value->getThumbnail();
			    $event_id = $value->getId();
			    $event_locationName = $value->getLocationName();
			    $event_title = $value->getTitle();
			    $event_featuring = "";
				
			    //TODO RECUPERARE FEATURING
			    $featurings = array();
			    //	$featuringsCounter = count($featurings);
			    $indexFeat = 0;
			    foreach ($featurings as $key1 => $feat) {
				if ($indexFeat == 0)
				    $event_featuring = $feat->getUsername();
				elseif ($indexFeat < 5) {
				    $event_featuring = $event_featuring + ', ' + $feat->getUsername();
				}
				else
				    $event_featuring = $feat->getUsername() . '...';
				$indexFeat++;
			    }

			    #TODO
			    /*
			      if(is_array($value->getfeaturing']) && count($value->getfeaturing'])>0){
			      foreach ($value->getfeaturing'] as $keyFeaturing => $valueFeaturing) {
			      $event_featuring = $event_featuring.' '.$value['username'];
			      }
			      }
			     */
			    $event_eventDate = ucwords(strftime("%A %d %B %Y - %H:%M", $value->getEventDate()->getTimestamp()));
			    $css_location = '';
			    if (is_null($value->getCity()) || $value->getCity() == '') {
				if (is_null($value->getAddress()) || $value->getAddress() == '' || $value->getAddress() == ', ') {
				    $event_location = '';
				    $css_location = 'no-display';
				}
				else
				    $event_location = $value->getAddress();
			    }else {
				if (is_null($value->getAddress()) || $value->getAddress() == '' || $value->getAddress() == ', ')
				    $event_location = $value->getCity();
				else
				    $event_location = $value->getCity() . ' - ' . $value->getAddress();
			    }

			    $event_love = $value->getLovecounter();
			    $event_comment = $value->getCommentcounter();
			    $event_review = $value->getReviewcounter();
			    $event_share = $value->getSharecounter();
			    $pathCoverEvent = $fileManagerService->getEventPhotoPath($_POST['id'], $event_thumbnail);
				$connectionService = new ConnectionService();
			    if (existsRelation($connectionService,'user', $currentUserId, 'event', $event_id, 'loved')) {
				$css_love = '_love orange';
				$text_love = $views['unlove'];
			    } else {
				$css_love = '_unlove grey';
				$text_love = $views['love'];
			    }
			    ?>
	    		    <!----------------------------------- SINGLE Event ------------------------------------>
	    		    <a href="event.php?event=<?php echo $event_id ?>">
	    			<div class="box-element" id='<?php echo $event_id ?>'>
	    			    <div class="row">
	    				<div class="small-4 columns" >
	    				    <img class="eventcover" src="<?php echo $pathCoverEvent; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB ?>'" alt="<?php echo $event_title ?>">
	    				</div>
	    				<div class="small-8 columns" style="min-height: 130px;">
						<?php
						if ($typeUser == 'JAMMER') {
						    ?>
						    <div class="row">
							<div class="large-12 colums">
							    <div class="sottotitle white breakOffTest"><?php echo $event_locationName ?></div>
							</div>
						    </div>
						    <div class="row">
							<div class="large-12 colums">
							    <div class="sottotitle grey breakOffTest"><?php echo $event_title ?></div>
							</div>
						    </div>
						    <?php
						} else {
						    ?>	
						    <div class="row">
							<div class="large-12 colums">
							    <div class="sottotitle white breakOffTest"><?php echo $event_title ?></div>
							</div>
						    </div>
						    <?php
						}
						?>
	    				    <div class="row">
	    					<div class="large-12 colums">
	    					    <div class="sottotitle white breakOffTest"><?php echo $event_featuring ?></div>
	    					</div>
	    				    </div>
	    				    <div class="row">
	    					<div class="large-12 colums">
	    					    <a class="ico-label _calendar inline text grey breakOff"><?php echo $event_eventDate ?></a>
	    					</div>
	    				    </div>
						<?php
						if ($typeUser == 'JAMMER') {
						    ?>
						    <div class="row">
							<div class="large-12 colums">
							    <a class="ico-label _pin inline text grey breakOff <?php echo $css_location ?>"><?php echo $event_location ?></a>
							</div>
						    </div>	
						    <?php
						}
						?>
	    				    <div class="row">
	    					<div class="box-propriety ">					
	    					    <div class="small-7 columns no-display">
	    						<a class="icon-propriety _menu-small note orange "> <?php echo $views['event']['calendar'] ?></a>	
	    						<a class="note grey " onclick="setCounter(this, '<?php echo $event_id; ?>', 'Event')"><?php echo $text_love ?></a>
	    						<a class="note grey" onclick="setCounter(this, '<?php echo $event_id; ?>', 'Event')"><?php echo $views['comm'] ?></a>
	    						<a class="note grey" onclick="setCounter(this, '<?php echo $event_id; ?>', 'Event')"><?php echo $views['share'] ?></a>
	    						<a class="note grey" onclick="setCounter(this, '<?php echo $event_id; ?>', 'Event')"><?php echo $views['review'] ?></a>	
	    					    </div>
	    					    <div class="small-5 columns propriety " style="position: absolute;bottom: 0px;right: 0px;">					
	    						<a class="icon-propriety <?php echo $css_love ?>"><?php echo $event_love ?></a>
	    						<a class="icon-propriety _comment"><?php echo $event_comment ?></a>
	    						<a class="icon-propriety _share"><?php echo $event_share ?></a>
	    						<a class="icon-propriety _review"><?php echo $event_review ?></a>		
	    					    </div>
	    					</div>		
	    				    </div>
	    				</div>
	    			    </div>

	    			</div>					
	    		    </a>
				<?php if (($index + 1) % 3 == 0 || $eventCounter == $index + 1) { ?> </div> <?php
			    }
			    $index++;
			} //fine foreach
			?>
			<!--------------------------- FINE ------------------------------------------------>						
		    </div>
		    <?php
		} else {
		    ?>
		    <div class="row" style="padding-left: 20px !important; padding-top: 20px !important;}">
			<div  class="large-12 columns"><p class="grey"><?php echo $views['event']['nodata'] ?></p></div>
		    </div>
		    <?php
		}
		?>
    	</div>
        </div>
    </div>	
    <?php
} else {
    echo 'Errore';
}
?>