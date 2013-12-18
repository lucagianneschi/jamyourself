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

$currentUser = $_SESSION['currentUser'];
$objectId = $_POST['objectId'];
$limit = $_POST['limit'];
$skip = $_POST['skip'];
$reviewToShow = 3;

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
			$review_limit_count = $reviewCounter > $limit ? $limit : $reviewCounter;
            $review_other = $review_limit_count >= $reviewCounter ? 0 : ($reviewCounter - $review_limit_count); 
            if ($reviewCounter > 0) {
                $indice = 1;
                foreach ($reviews as $key => $value) {
                    // dati utente che ha generato la review 
                    $review_user_objectId = $value->getFromUser()->getObjectId();
                    $review_user_thumbnail = $value->getFromUser()->getProfileThumbnail();
                    $review_user_username = $value->getFromUser()->getUsername();
                    $review_user_type = $value->getFromUser()->getType();
                    $review_objectId = $value->getObjectId();
                    $review_data = $value->getCreatedAt()->format('l j F Y - H:i');
                    $review_title = $value->getTitle();
                    $review_text = $value->getText();
                    #TODO
                    //$review_rating = $value->getRating();
                    $review_counter_love = $value->getLoveCounter();
                    $review_counter_comment = $value->getCommentCounter();
                    $review_counter_share = $value->getShareCounter();
                    
                    if (in_array($currentUser->getObjectId(), $value->getLovers())) {
                        $css_love = '_love orange';
                        $text_love = $views['UNLOVE'];
                    } else{
                        $css_love = '_unlove grey';
                        $text_love = $views['LOVE'];
                    }
                    ?>
					<div class="row" id='social-RecordReview-<?php echo $review_objectId; ?>'>
						<div  class="large-12 columns ">
							<div class="box">				
								<div id='recordReview_<?php echo $review_objectId; ?>'>					
									<div class="row <?php echo $review_user_objectId; ?>">											
										<div  class="small-1 columns ">
											<div class="userThumb">
												<img src="../media/<?php echo $review_user_thumbnail; ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
											</div>
										</div>
										<div  class="small-5 columns">
											<div class="text grey" style="margin-left: 20px; margin-bottom: 0px !important;"><strong><?php echo $review_user_username ?></strong></div>
											<small class="orange" style="margin-left: 20px;"><?php echo $review_user_type; ?></small>
										</div>
										<div  class="small-6 columns propriety">
											<div class="note grey-light">
												<?php echo $review_data; ?>
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
													<div class="sottotitle grey-dark"><?php echo $review_title; ?></div>
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
											<a href="#" class="orange no-display viewText"><strong onclick="toggleText(this,'recordReview_<?php echo $i ?>','<?php echo $review_text ?>')">View All</strong></a>
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
												<a class="note grey " onclick="love(this, 'Comment', '<?php echo $review_objectId; ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
												<a class="note grey" onclick="setCounterMedia(this,'<?php echo $review_objectId; ?>','<?php echo $review_user_objectId; ?>','RecordReview')"><?php echo $views['COMM'];?></a>
												<!-- a class="note grey" onclick="setCounter(this,'<?php echo $review_objectId; ?>','RecordReview')"><?php echo $views['SHARE'];?></a -->
											</div>
											<div class="small-6 columns propriety ">					
												<a class="icon-propriety <?php echo $css_love; ?>"><?php echo $review_counter_love; ?></a>
												<a class="icon-propriety _comment" ><?php echo $review_counter_comment; ?></a>
												<!-- a class="icon-propriety _share" ><?php echo $review_counter_share; ?></a -->
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
                    if ($indice == $review_limit_count) break;
                    $indice++;
				}
			}
			if ($review_other > 0) {
				?>
				<div class="row otherSet">
					<div class="large-12 colums">
                        <?php
                        $nextToShow = ($reviewCounter - $limit > $reviewToShow) ? $reviewToShow : ($reviewCounter - $limit);
                        ?>
                        <div class="text" onClick="loadBoxRecordReview(<?php echo $limit + $reviewToShow; ?>, 0);">Other <?php echo $nextToShow; ?> Review</div>
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
	</div>
	<?php
}
?>