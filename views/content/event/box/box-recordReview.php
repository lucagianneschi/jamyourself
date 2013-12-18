<?php
/* box review RECORD
 * box chiamato tramite load con:
 * data: {data,typeUser}
 * 
 * box 
 */
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
require_once BOXES_DIR . 'review.box.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$objectId = $_POST['eventObjectId'];
$limit = 5;
$skip = 0;

$reviewBox = new ReviewBox();
$reviewBox->initForMediaPage($objectId, 'Record', $limit, $skip);
if (is_null($reviewBox->error) || isset($_SESSION['currentUser'])) {
	$currentUser = $_SESSION['currentUser'];
	$reviews = $reviewBox->reviewArray;
	$reviewCounter = count($reviews);
	?>
	<div class="row" id="social-RecordReview">
		<div  class="large-12 columns">
			<div class="row">
				<div  class="large-12 columns">
					<h3>Reviews</h3>
				</div>			
			</div>	
			
			<?php 
			$review_3count = $reviewCounter > 3 ? 3 : $reviewCounter;
			$review_other = $review_3count > $reviewCounter ? 0 : ($reviewCounter - $review_3count); 
			if ($reviewCounter > 0) {
				foreach ($reviews as $key => $value) {
					// dati utente che ha generato la review 
					$review_user_objectId = $value->getFromUser()->getObjectId();
					$review_user_thumbnail  = $value->getFromUser()->getProfileThumbnail();
					$review_user_username = $value->getFromUser()->getUsername();
					$review_user_type = $value->getFromUser->getType();
					$review_objectId = $value->getObjectId();
					$review_data = $value->getCreatedAt()->format('l j F Y - H:i');
					$review_title = $value->getTitle();
					$review_text = $value->getText();
					#TODO
					//$review_rating = $value->getRating();
					$review_counters = $value->getCounters();
					?>
					<div class="row" id='social-RecordReview-<?php echo $review_objectId  ?>'>
						<div  class="large-12 columns ">
							<div class="box">				
								<div id='recordReview_<?php echo $review_objectId ?>'>					
									<div class="row <?php echo $review_user_objectId ?>">											
										<div  class="small-1 columns ">
											<div class="userThumb">
												<img src="../media/<?php echo $review_user_thumbnail ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
											</div>
										</div>
										<div  class="small-5 columns">
											<div class="text grey" style="margin-left: 20px; margin-bottom: 0px !important;"><strong><?php echo $review_user_username ?></strong></div>
											<small class="orange" style="margin-left: 20px;"><?php echo $review_user_type ?></small>
										</div>
										<div  class="small-6 columns propriety">
											<div class="note grey-light">
												<?php echo $review_data ?>
											</div>
										</div>	
									</div>
									<div class="row">
										<div  class="large-12 columns"><div class="line"></div></div>
									</div>
									
									<div class="row">							
										<div  class="small-12 columns ">
											<div class="row ">							
												<div  class="small-12 columns ">
													<div class="sottotitle grey-dark"><?php echo $review_title ?></div>
												</div>	
											</div>								
											<div class="row ">						
												<div  class="small-12 columns ">
													<div class="note grey">Rating
													<?php
													for ($i = 1; $i <= 5 ; $i++) {
														if ($review_rating >= $i) {
															echo '<a class="icon-propriety _star-orange"></a>';
														} else {
															echo '<a class="icon-propriety _star-grey"></a>';
														}
													}
													?>										
													</div>								
												</div>
											</div>													
										</div>									
									</div>
									<div class="row " style=" margin-top:10px;">						
										<div  class="small-12 columns ">
											<div class="text grey cropText inline" style="line-height: 18px !important;">
												<?php echo $review_text ?>									
											</div>
											<a href="#" class="orange  no-display viewText"><strong onclick="toggleText(this,'recordReview_<?php echo $i ?>','<?php echo $review_text ?>')">View All</strong></a>
											<a href="#" class="orange no-display closeText"><strong onclick="toggleText(this,'recordReview_<?php echo $i ?>','<?php echo $review_text ?>')">Close</strong></a>
										</div>
									</div>					
									
									<div class="row">
										<div  class="large-12 columns">
											<div class="line"></div>
										</div>
									</div>
									<div class="row recordReview-propriety">
										<div class="box-propriety">
											<div class="small-6 columns ">
												<a class="note grey " onclick="setCounter()"><?php echo $views['LOVE'];?></a>
												<a class="note grey" onclick="setCounterMedia(this,'<?php echo $review_objectId; ?>','<?php echo $review_user_objectId; ?>','RecordReview')"><?php echo $views['COMM'];?></a>
												<!-- a class="note grey" onclick="setCounter(this,'<?php echo $review_objectId; ?>','RecordReview')"><?php echo $views['SHARE'];?></a -->
											</div>
											<div class="small-6 columns propriety ">					
												<a class="icon-propriety _unlove grey" ><?php echo $review_counters->loveCounter; ?></a>
												<a class="icon-propriety _comment" ><?php echo $review_counters->commentCounter; ?></a>
												<!-- a class="icon-propriety _share" ><?php echo $review_counters->shareCounter; ?></a -->
											</div>	
										</div>		
									</div>
								</div>					
							</div>
							<!---------------------------------------- comment ------------------------------------------------->
							<div class="box-comment no-display"></div>						
						</div> 
					</div>
					<?php
				}
			}
			if ($review_other > 0) {
				?>
				<div class="row otherSet">
					<div class="large-12 colums">
						<div class="text">Other <?php echo $review_other; ?> Review</div>	
					</div>	
				</div>
				<?php
			}
			if($reviewCounter == 0){
				?>
				<div class="row">
					<div  class="large-12 columns ">
						<div class="box">						
							<div class="row">
								<div  class="large-12 columns"><p class="grey"><?php echo $views['RecordReview']['NODATA'];?></p></div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div> <!--- <div class="row" id="social-EventReview"> -->
	<?php
}
?>