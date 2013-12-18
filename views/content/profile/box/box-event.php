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
require_once CLASSES_DIR . 'userParse.class.php';

if(session_id() == '') session_start();

$eventBox = new EventBox();
$eventBox->initForPersonalPage($_POST['objectId']);

$typeUser = $_POST['typeUser'];

if (is_null($eventBox->error)) {
	if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
	$events = $eventBox->eventArray;
	$eventCounter = count($events);
	?>
	<div class="row" id='profile-Event'>
		<div class="large-12 columns ">	
			<div class="row">
				<div  class="small-5 columns">
					<h3><?php echo $views['event']['TITLE'];?> </h3>
				</div>	
				<div  class="small-7 columns align-right">
					<?php
					if ($eventCounter > 3) {
						?>
						<div class="row">					
							<div  class="small-9 columns">
								<a class="slide-button-prev _prevPage slide-button-prev-disabled" onclick="royalSlidePrev(this,'event')"><?php echo $views['PREV'];?> </a>
							</div>
							<div  class="small-3 columns">
								<a class="slide-button-next _nextPage" onclick="royalSlideNext(this,'event')"><?php echo $views['NEXT'];?> </a>
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
						foreach ($events as $key => $value) {							
							if ($index % 3 == 0) {?><div class="rsContent">	<?php }
							$event_thumbnail = $value->getThumbnail();
							$event_objectId = $value->getObjectId();					
							$event_locationName = $value->getLocationName();
							$event_title = $value->getTitle();
							$event_featuring = "";
							#TODO
							/*
							if(is_array($value->getfeaturing']) && count($value->getfeaturing'])>0){
								foreach ($value->getfeaturing'] as $keyFeaturing => $valueFeaturing) {
									$event_featuring = $event_featuring.' '.$value['username'];
								}
							}
							*/
							$event_eventDate = $value->getEventDate()->format('l j F Y - H:i');
							$event_location = $value->getCity(). ' - ' .$value->getAddress();					
							
							$event_love = $value->getLoveCounter();
							$event_comment = $value->getCommentCounter();
							$event_review = $value->getReviewCounter();
							$event_share = $value->getShareCounter();
							
							if (isset($_SESSION['currentUser']) && is_array($value->getLovers()) && in_array($currentUser->getObjectId(), $value->getLovers())) {
								$css_love = '_love orange';
								$text_love = $views['UNLOVE'];								
							} else {
								$css_love = '_unlove grey';
								$text_love = $views['LOVE'];
							}						
								?>
								<!----------------------------------- SINGLE Event ------------------------------------>
								<div class="box-element" id='<?php echo  $event_objectId ?>'>
									<div class="row">
										<div class="small-4 columns" >
											<img class="eventcover" src="../media/<?php echo $event_thumbnail; ?>" onError="this.src='../media/images/default/defaultEventcoverthumb.jpg'">
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
														<div class="sottotitle grey breakOffTest"><?php echo $event_title  ?></div>
													</div>
												</div>
												<?php
											} else {
												?>	
												<div class="row">
													<div class="large-12 colums">
														<div class="sottotitle white breakOffTest"><?php echo $event_title  ?></div>
													</div>
												</div>
												<?php 
											}
											?>
											<div class="row">
												<div class="large-12 colums">
													<div class="sottotitle white breakOffTest"><?php echo $event_featuring  ?></div>
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
														<a class="ico-label _pin inline text grey breakOff"><?php echo $event_location ?></a>
													</div>
												</div>	
												<?php
											}
											?>
											<div class="row">
												<div class="box-propriety ">					
													<div class="small-7 columns no-display">
														<a class="icon-propriety _menu-small note orange "> <?php echo $views['event']['CALENDAR']?></a>	
														<a class="note grey " onclick="setCounter(this,'<?php echo $event_objectId; ?>','Event')"><?php echo $text_love?></a>
														<a class="note grey" onclick="setCounter(this,'<?php echo $event_objectId; ?>','Event')"><?php echo $views['COMM']?></a>
														<a class="note grey" onclick="setCounter(this,'<?php echo $event_objectId; ?>','Event')"><?php echo $views['SHARE']?></a>
														<a class="note grey" onclick="setCounter(this,'<?php echo $event_objectId; ?>','Event')"><?php echo $views['REVIEW']?></a>	
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
				
								<?php 
								if (($index+1) % 3 == 0 || $eventCounter == $index+1) { ?> </div> <?php }
							$index++;
						} //fine foreach
						?>
						<!--------------------------- FINE ------------------------------------------------>						
				</div>
				<?php
			} else {
				?>
				<div class="row">
					<div  class="large-12 columns"><p class="grey"><?php echo $views['event']['NODATA'] ?></p></div>
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
