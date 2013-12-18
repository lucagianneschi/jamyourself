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
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'review.box.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$objectId = $_POST['objectId'];
$type = $_POST['type'];

$reviewBox = new ReviewBox();
$reviewBox->initForPersonalPage($objectId, $type, 'Record');
if (is_null($reviewBox->error) || isset($_SESSION['currentUser'])) {
	$currentUser = $_SESSION['currentUser'];
	$reviews = $reviewBox->reviewArray;
	$reviewCounter = count($reviews);
	?>
	<!------------------------------------- Reviews ------------------------------------>
	<div class="row" id="social-RecordReview">
		<div  class="large-12 columns">	
		<div class="row">
			<div  class="small-5 columns">
				<h3><?php echo $views['RecordReview']['TITLE']; ?></h3>
			</div>	
			<div  class="small-7 columns align-right">
				<?php
				if ($reviewCounter > 1) {
					?>
					<a class="icon-block _nextPage grey" onclick="royalSlideNext('RecordReview')" style="top: 5px !important; margin-top: 15px !important"></a>
					<a class="icon-block _prevPage grey text" onclick="royalSlidePrev('RecordReview')" style="top: 5px !important; margin-top: 15px !important"><span class="indexBox">1</span>/<?php echo $reviewCounter; ?></a>
					<?php
				}
				?>
			</div>	
		</div>	
		
		<div class="row">
			<div  class="large-12 columns ">
				<div class="box">
				<div class="royalSlider contentSlider  rsDefault" id="recordReviewSlide">				
				<?php 
				if ($reviewCounter > 0) {
					foreach ($reviews as $key => $value) {
						$recordReview_objectId = $value->getObjectId();
						$recordReview_user_objectId = $value->getFromUser()->getObjectId();
						$recordReview_user_thumbnail = $value->getFromUser()->getProfileThumbnail();
						$recordReview_user_username = $value->getFromUser()->getUsername();
						$recordReview_thumbnailCover = $value->getRecord()->getThumbnailCover();
						$recordReview_title = $value->getRecord()->getTitle();
						#TODO
						//$recordReview_rating = $value->getRecord()->getRating();
						$recordReview_text = $value->getText();
						$recordReview_love = $value->getLoveCounter();
						$recordReview_comment = $value->getCommentCounter();
						$recordReview_share = $value->getShareCounter();
						if (in_array($currentUser->getObjectId(), $value->getLovers())) {
							$css_love = '_unlove grey';
							$text_love = $views['LOVE'];
						} else {
							$css_love = '_love orange';
							$text_love = $views['UNLOVE'];
						}
						?>
						<div  class="rsContent">	
						<div id='recordReview_<?php echo $recordReview_objectId ?>'>
						<?php
						if ($type != 'SPOTTER') {
							?>		
							<div class="row <?php echo $recordReview_user_objectId ?>">
								<div  class="small-1 columns ">
									<div class="userThumb">
										<img src="../media/<?php echo $recordReview_user_thumbnail ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
									</div>
								</div>
								<div  class="small-11 columns">
									<div class="text grey" style="margin-left: 10px;"><strong><?php echo $recordReview_user_username ?></strong></div>
								</div>	
							</div>
							<div class="row">
								<div  class="large-12 columns"><div class="line"></div></div>
							</div>
							<?php
						}
						?>
						<div class="row">
							<div  class="small-2 columns ">
								<div class="coverThumb"><img src="../media/<?php echo $recordReview_thumbnailCover?>" onerror="this.src='../media/<?php echo DEFRECORDTHUMB; ?>'"></div>						
							</div>
							<div  class="small-8 columns ">
								<div class="row ">							
									<div  class="small-12 columns ">
										<div class="sottotitle grey-dark"><?php echo $recordReview_title ?></div>
									</div>	
								</div>	
								<div class="row">						
									<div  class="small-12 columns ">
										<div class="note grey"><?php echo $views['RecordReview']['RATING'];?></div>
									</div>
								</div>
								<div class="row ">						
									<div  class="small-12 columns ">
										<?php
										for ($index = 0; $index < 5; $index++) {
											if($index <= $recordReview_rating) {
												echo '<a class="icon-propriety _star-orange"></a>';
											} else {
												echo '<a class="icon-propriety _star-grey"></a>';
											}
										}
										?>
									</div>
								</div>													
							</div>
							<div  class="small-2 columns align-right viewAlbumReview">
								<a href="#" class="orange"><strong onclick="toggleTextRecordReview(this,'recordReview_<?php echo $recordReview_objectId ?>')"><?php echo $views['RecordReview']['READ'];?></strong></a>
							</div>				
						</div>
							
						<div class="textReview no-display">
							<div class="row ">						
								<div  class="small-12 columns ">
									<div class="text grey" style="line-height: 18px !important;">
										<?php echo $recordReview_text; ?>
									</div>
								</div>
							</div>					
						</div>
						<div class="row">
							<div  class="large-12 columns"><div class="line"></div></div>
						</div>
						<div class="row recordReview-propriety">
							<div class="box-propriety">
								<div class="small-6 columns ">
									<a class="note grey" onclick="love(this, 'Comment', '<?php echo $recordReview_objectId; ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love;?></a>
									<a class="note grey" onclick="setCounter(this,'<?php echo $recordReview_objectId; ?>','RecordReview')"><?php echo $views['COMM'];?></a>
									<a class="note grey" onclick="share(this,'<?php echo $recordReview_objectId; ?>','social-RecordReview')"><?php echo $views['SHARE'];?></a>
								</div>
								<div class="small-6 columns propriety ">					
									<a class="icon-propriety <?php echo $css_love;?>" ><?php echo $recordReview_love ?></a>
									<a class="icon-propriety _comment" ><?php echo $recordReview_comment ?></a>
									<a class="icon-propriety _share" ><?php echo $recordReview_share ?></a>
								</div>	
							</div>		
						</div>
							
						</div>	
						</div>	
						<?php
					}
				} else {
					?>
					<div  class="rsContent">	
					<div class="row">
						<div  class="large-12 columns"><p class="grey"><?php echo $views['RecordReview']['NODATA'];?></p></div>
					</div>
					</div>			
					<?php
				}
				?>
				</div>
				</div>
			</div>
		</div>
		<!---------------------------------------- comment ------------------------------------------------->
		<div class="box-comment no-display"></div>
		<!---------------------------------------- SHARE ---------------------------------------------------->
		<!-- AddThis Button BEGIN -->		
		<div class="addthis_toolbox">   
			<div class="hover_menu">
				<div class="addthis_toolbox addthis_default_style"
				addThis:url="http://socialmusicdiscovering.com/tests/controllers/share/testShare2.controller.php?classe=Album"
				addThis:title="Titolo della pagina di un album">
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_google_plusone_share"></a>
			   </div>
				
			</div>
		</div>
		<!-- AddThis Button END -->
		</div>
	</div>
	<?php
}
?>