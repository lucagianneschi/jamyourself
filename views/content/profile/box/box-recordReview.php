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
require_once SERVICES_DIR . 'log.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'review.box.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'select.service.php';
session_start();

$id = $_POST['id'];
$type = $_POST['type'];

$reviewBox = new ReviewRecordBox();
$reviewBox->initForPersonalPage($id, $type, 10, 0);
if (is_null($reviewBox->error) || isset($_SESSION['id'])) {
    $currentUserId = $_SESSION['id'];
    $reviews = $reviewBox->reviewArray;
    $reviewCounter = count($reviews);
    ?>
    <!------------------------------------- Reviews ------------------------------------>
    <div class="row" id="social-RecordReview">
        <div  class="large-12 columns">	
    	<div class="row">
    	    <div  class="small-5 columns">
    		<h3><?php echo $views['recordReview']['title']; ?></h3>
    	    </div>	
    	    <div  class="small-7 columns align-right">
		    <?php
		    if ($reviewCounter > 1) {
			?>
			<div class="row">					
			    <div  class="small-9 columns">
				<a class="slide-button-prev _prevPage slide-button-prev-disabled" onclick="royalSlidePrev(this, 'RecordReview')"><?php echo $views['prev']; ?> </a>
			    </div>
			    <div  class="small-3 columns">
				<a class="slide-button-next _nextPage" onclick="royalSlideNext(this, 'RecordReview')"><?php echo $views['next']; ?> </a>
			    </div>
			</div>
			<?php
		    }
		    ?>
    	    </div>	
    	</div>	

    	<div class="row">
    	    <div  class="large-12 columns ">
    		<div class="box" style="padding: 15px !important">
    		    <div class="royalSlider contentSlider  rsDefault" id="recordReviewSlide">				
			    <?php
			    if ($reviewCounter > 0) {
				foreach ($reviews as $key => $value) {
				    $recordReview_objectId = $value->getId();
				    $recordReview_user_objectId = $value->getFromuser()->getId();
				    $recordReview_user_thumbnail = $value->getFromuser()->getThumbnail();
				    $recordReview_user_username = $value->getFromuser()->getUsername();
				    $recordReview_user_type = $value->getFromuser()->getType();
				    $recordReview_thumbnailCover = $value->getRecord()->getThumbnail();
				    $recordObjectId = $value->getRecord()->getId();
				    $recordReview_title = $value->getRecord()->getTitle();
				    $recordReview_data = ucwords(strftime("%A %d %B %Y - %H:%M", strtotime($value->getCreatedat())));
				    $recordReview_rating = $value->getVote();
				    $recordReview_text = $value->getText();
				    $recordReview_love = $value->getLovecounter();
				    $recordReview_comment = $value->getCommentcounter();
				    $recordReview_share = $value->getSharecounter();
					$connectionService = new ConnectionService();						
				    if (existsRelation($connectionService,'user', $currentUserId, 'comment',$recordReview_objectId, 'LOVE')) {
					$css_love = '_love orange';
					$text_love = $views['unlove'];
				    } else {
					$css_love = '_unlove grey';
					$text_love = $views['love'];
				    }
				    ?>
	    			<div  class="rsContent">	
	    			    <div id='recordReview_<?php echo $recordReview_objectId ?>'>
					    <?php
					    if ($type != 'SPOTTER') {
						switch ($recordReview_user_type) {
						    case 'JAMMER':
							$defaultThum = DEFTHUMBJAMMER;
							break;
						    case 'VENUE':
							$defaultThum = DEFTHUMBVENUE;
							break;
						}
						$fileManagerService = new FileManagerService();
						$pathUser = $fileManagerService->getPhotoPath($eventReview_user_objectId, $recordReview_user_thumbnail);
						$pathRecord = $fileManagerService->getPhotoPath($currentUserId, $recordReview_thumbnailCover);
						?>
						<a href="profile.php?user=<?php echo $recordReview_user_objectId ?>">	
						    <div class="row">
							<div  class="small-1 columns ">
							    <div class="userThumb">
								<img src="<?php echo $pathUser; ?>" onerror="this.src='<?php echo $defaultThum; ?>'" alt="<?php echo $recordReview_user_username; ?>">
							    </div>
							</div>
							<div  class="small-5 columns">
							    <div class="text grey" style="margin-left: 20px;"><strong><?php echo $recordReview_user_username ?></strong></div>
							</div>
							<div  class="small-6 columns" style="text-align: right;">
							    <div class="note grey-light">
								<?php echo $recordReview_data; ?>
							    </div>
							</div>		
						    </div>
						</a>	
						<div class="row">
						    <div  class="large-12 columns"><div class="line"></div></div>
						</div>
						<?php
					    }
					    ?>
	    				<a href="record.php?record=<?php echo $recordObjectId ?>">
	    				    <div class="row">
	    					<div  class="small-2 columns ">
	    					    <div class="coverThumb"><img src="<?php echo $pathRecord; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" alt="<?php echo $recordReview_title; ?>"></div>						
	    					</div>
	    					<div  class="small-10 columns ">
	    					    <div class="row ">							
	    						<div  class="small-12 columns ">
	    						    <div class="sottotitle grey-dark"><?php echo $recordReview_title ?></div>
	    						</div>	
	    					    </div>	
	    					    <div class="row">						
	    						<div  class="small-12 columns ">
	    						    <div class="note grey"><?php echo $views['recordReview']['rating']; ?></div>
	    						</div>
	    					    </div>
	    					    <div class="row ">						
	    						<div  class="small-12 columns ">
								<?php
								for ($index = 1; $index <= 5; $index++) {
								    if ($index <= $recordReview_rating) {
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
	    				</a>
	    				<div class="row " style=" margin-top:10px;">						
	    				    <div  class="small-12 columns ">
	    					<div class="text grey cropText inline" style="line-height: 18px !important;">
							<?php echo $recordReview_text; ?>
	    					</div>
	    					<a href="#" class="orange no-display viewText"><strong onclick="toggleText(this, 'recordReview_<?php echo $recordReview_objectId ?>', '<?php echo $recordReview_text ?>')">View All</strong></a>
	    					<a href="#" class="orange no-display closeText"><strong onclick="toggleText(this, 'recordReview_<?php echo $recordReview_objectId ?>', '<?php echo $recordReview_text ?>')">Close</strong></a>
	    				    </div>
	    				</div>	
	    				<div class="row">
	    				    <div  class="large-12 columns"><div class="line"></div></div>
	    				</div>
	    				<div class="row recordReview-propriety">
	    				    <div class="box-propriety">
	    					<div class="small-6 columns ">
	    					    <a class="note grey" onclick="love(this, 'Comment', '<?php echo $recordReview_objectId; ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love; ?></a>
	    					    <a class="note grey" onclick="loadBoxOpinion('<?php echo $recordReview_objectId; ?>', '<?php echo $recordReview_user_objectId; ?>', 'Comment', '#social-RecordReview .box-opinion', 10, 0)"><?php echo $views['comm']; ?></a>
	    					    <a class="note grey" onclick="share(this, '<?php echo $recordReview_objectId; ?>', 'social-RecordReview')"><?php echo $views['share']; ?></a>
	    					</div>
	    					<div class="small-6 columns propriety ">					
	    					    <a class="icon-propriety <?php echo $css_love; ?>" ><?php echo $recordReview_love ?></a>
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
					<div  class="large-12 columns grey"><?php echo $views['recordReview']['nodata']; ?></div>
				    </div>
				</div>			
				<?php
			    }
			    ?>
    		    </div>
    		</div>
    		<!---------------------------------------- comment ------------------------------------------------->
    		<div class="box-opinion no-display"></div>
    	    </div>
    	</div>
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