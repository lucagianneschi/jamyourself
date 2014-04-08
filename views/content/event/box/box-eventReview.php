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
require_once SERVICES_DIR . 'fileManager.service.php';
require_once BOXES_DIR . 'review.box.php';
require_once CLASSES_DIR . 'user.class.php';
session_start();

$id = $_POST['id'];
$limit = $_POST['limit'];
$skip = $_POST['skip'];
$reviewToShow = 3;

$reviewBox = new ReviewEventBox();
$reviewBox->initForMediaPage($id, $limit, $skip);
if (is_null($reviewBox->error) || isset($_SESSION['id'])) {
    $currentUserId = $_SESSION['id'];
    $reviews = $reviewBox->reviewArray;
    $reviewCounter = count($reviews);
    ?>

    <div class="row" id="social-EventReview">
        <div  class="large-12 columns">
    	<div class="row">
    	    <div  class="large-12 columns">
    		<h3><?php echo $views['media']['eventReview']['title']; ?></h3>
    	    </div>			
    	</div>	

	    <?php
	    $review_limit_count = $reviewCounter > $limit ? $limit : $reviewCounter;
	    $review_other = $review_limit_count >= $reviewCounter ? 0 : ($reviewCounter - $review_limit_count);
	    if ($reviewCounter > 0) {
		$indice = 1;
		foreach ($reviews as $key => $value) {
		    $review_user_objectId = $value->getFromuser()->getId();
		    $review_user_thumbnail = $value->getFromuser()->getThumbnail();
		    $review_user_username = $value->getFromuser()->getUsername();
		    $review_user_type = $value->getFromuser()->getType();
		    $review_objectId = $value->getId();
		    $review_data = ucwords(strftime("%A %d %B %Y - %H:%M", $value->getCreatedat()->getTimestamp()));
		    $review_title = $value->getTitle();
		    $review_text = $value->getText();
		    $review_rating = $value->getVote();
		    $review_counter_love = $value->getLovecounter();
		    $review_counter_comment = $value->getCommentcounter();
		    $review_counter_share = $value->getSharecounter();
			$connectionService = new ConnectionService();
		    if(existsRelation($connectionService,'user', $currentUserId, 'comment', $comment_objectId, 'LOVE')){
			$css_love = '_love orange';
			$text_love = $views['unlove'];
		    } else {
			$css_love = '_unlove grey';
			$text_love = $views['love'];
		    }
		    ?>
	    	<div class="row" id="social-EventReview-<?php echo $review_objectId; ?>">
	    	    <div  class="large-12 columns ">
	    		<div class="box">
	    		    <div id="eventReview_<?php echo $review_objectId; ?>">
	    			<a href="profile.php?user=<?php echo $review_user_objectId ?>">	    
	    			    <div class="row <?php echo $review_user_objectId; ?>">
	    				<div  class="small-1 columns ">
	    				    <div class="userThumb">
	    					<!-- THUMB USER-->
						    <?php
						    $fileManagerService = new FileManagerService();
						    $thumbPath = $fileManagerService->getPhotoPath($review_user_objectId, $review_user_thumbnail);
						    ?>
	    					<img src="<?php echo $thumbPath; ?>" onerror="this.src='<?php echo DEFTHUMBSPOTTER; ?>'" alt ="<?php echo $review_user_username; ?> ">
	    				    </div>
	    				</div>
	    				<div  class="small-5 columns">
	    				    <div class="text grey" style="margin-left: 20px; margin-bottom: 0px !important;"><strong><?php echo $review_user_username ?></strong></div>
	    				    <!--small class="orange" style="margin-left: 20px;"><?php echo $review_user_type; ?></small-->
	    				</div>
	    				<div  class="small-6 columns propriety">
	    				    <div class="note grey-light">
						    <?php echo $review_data; ?>
	    				    </div>
	    				</div>	
	    			    </div>
	    			</a>
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
							for ($i = 1; $i <= 5; $i++) {
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
						<?php echo $review_text; ?>
	    				</div>
	    				<a href="#" class="orange no-display viewText"><strong onclick="toggleText(this, 'eventReview_<?php echo $i ?>', '<?php echo $review_text ?>');"><?php echo $views['viewall']; ?></strong></a>
	    				<a href="#" class="orange no-display closeText"><strong onclick="toggleText(this, 'eventReview_<?php echo $i ?>', '<?php echo $review_text ?>');"><?php echo $views['close']; ?></strong></a>
	    			    </div>
	    			</div>
	    			<div class="row">
	    			    <div  class="large-12 columns">
	    				<div class="line"></div>
	    			    </div>
	    			</div>
	    			<div class="row eventReview-propriety">
	    			    <div class="box-propriety">
	    				<div class="small-6 columns ">
	    				    <a class="note grey" onclick="love(this, 'Comment', '<?php echo $review_objectId; ?>', '<?php echo $currentUserId; ?>')"><?php echo $text_love; ?></a>
	    				    <a class="note grey" onclick="loadBoxOpinion('<?php echo $review_objectId; ?>', '<?php echo $review_user_objectId; ?>', 'Comment', '#social-EventReview-<?php echo $review_objectId; ?> .box-opinion', 10, 0)"><?php echo $views['comm']; ?></a>
	    				    <!-- a class="note grey" onclick="setCounter(this,'<?php echo $review_objectId; ?>','EventReview')"><?php echo $views['share']; ?></a -->
	    				</div>
	    				<div class="small-6 columns propriety ">
	    				    <a class="icon-propriety <?php echo $css_love; ?>" ><?php echo $review_counter_love; ?></a>
	    				    <a class="icon-propriety _comment" ><?php echo $review_counter_comment; ?></a>
	    				    <!-- a class="icon-propriety _share" ><?php echo $review_counter_share; ?></a -->
	    				</div>
	    			    </div>
	    			</div>
	    		    </div>
	    		</div>
	    		<!---------------------------------------- comment ------------------------------------------------->
	    		<div class="box-opinion no-display"></div>
	    	    </div>
	    	</div>
		    <?php
		    if ($indice == $review_limit_count)
			break;
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
			<div class="text" onClick="loadBoxEventReview(<?php echo $limit + $reviewToShow; ?>, 0);"><?php echo $views['other_rew']; ?></div>
		    </div>
		</div>
		<?php
	    }
	    if ($reviewCounter == 0) {
		?>
		<div class="row">
		    <div  class="large-12 columns ">
			<div class="box">
			    <div class="row">
				<div class="large-12 columns"><p class="grey"><?php echo $views['eventReview']['nodata']; ?></p></div>
			    </div>
			</div>
		    </div>
		</div>
		<?php
	    }
	    ?>
        </div> <!--- 24 -->
    </div> <!--- <div class="row" id="social-EventReview"> -->
    <?php
}