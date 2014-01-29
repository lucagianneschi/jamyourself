<?php
/* box le activity
 * box chiamato tramite ajax con:
 * data-type: html,
 * type: POST o GET
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'stream.box.php';
require_once CLASSES_DIR . 'userParse.class.php';

if (session_id() == '')
    session_start();

$currentUser = $_SESSION['currentUser'];

$streamBox = new StreamBox();
$streamBox->init(10, 0);
if (is_null($streamBox->error)) {
    $activities = $streamBox->activitiesArray;
    $activityCounter = count($activities);
    ?>
    <!---------------- POST ----------------->
    <h3><?php echo $views['stream']['write_post']; ?></h3>
    <div class="row  ">
        <div class="large-12 columns ">
    	  <form action="" class="box-write" onsubmit="sendPost('', $('#post').val());
    		  return false;">
    	    <div class="">
    		<div class="row  ">
    		    <div class="small-9 columns ">
    			<input id="post" type="text" class="post inline" placeholder="<?php echo $views['stream']['spread_world']; ?>">
    		    </div>
    		    <div class="small-3 columns ">
    			<input type="button" id="button-post" class="post-button inline" value="<?php echo $views['post_button']; ?>" onclick="sendPost('<?php echo $currentUser->getObjectId(); ?>', $('#post').val())">
    		    </div>
    		</div>
    	    </div>

    	</form>
        </div>
    </div>

    <!---------------- STREAM ----------------->
    <h3 style="margin-top:30px"><?php echo $views['stream']['stream']; ?></h3>


    <?php
    foreach ($activities as $key => $value) {
	?>
	<div id="<?php echo $value->getObjectId(); ?>">
	    <div class="box">
		<a href="profile.php?user=<?php echo $value->getFromUser()->getObjectId(); ?>">
		    <div class="row line">
			<div class="small-1 columns ">
			    <div class="icon-header">
				<?php
				switch ($value->getFromUser()->getType()) {
				    case 'JAMMER':
					$defaultThumb = DEFTHUMBJAMMER;
					break;
				    case 'VENUE':
					$defaultThumb = DEFTHUMBVENUE;
					break;
				    case 'SPOTTER':
					$defaultThumb = DEFTHUMBSPOTTER;
					break;
				}
				?>
				<!--THUMB FROMUSER-->
				<?php $pathPictureThumbFromUser = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . 'profilepicturethumb' . DIRECTORY_SEPARATOR . $value->getFromUser()->getProfileThumbnail(); ?>
				<img src="<?php echo $pathPictureThumbFromUser; ?>" onerror="this.src='<?php echo $defaultThumb; ?>'">
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
			    <div class="note grey-light">
				<?php echo ucwords(strftime("%A %d %B %Y - %H:%M", $value->getCreatedAt()->getTimestamp())); ?>
			    </div>
			</div>
		    </div>
		</a>
		<?php
		switch ($value->getType()) {
		    case 'ALBUMCREATED':
			if (is_array($value->getAlbum()->getLovers()) && in_array($currentUser->getObjectId(), $value->getAlbum()->getLovers())) {
			    $css_love = '_love orange';
			    $text_love = $views['UNLOVE'];
			} else {
			    $css_love = '_unlove grey';
			    $text_love = $views['LOVE'];
			}
			?>
			<div class="row line">
			    <div class="small-12 columns ">
				<div class="row ">
				    <div class="small-12 columns ">
					<div class="row  ">
					    <div class="large-12 columns ">
						<div class="text orange"><?php echo $views['stream']['new_photo']; ?></div>
						<div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?> - <?php echo $value->getAlbum()->getImageCounter(); ?> <?php echo $views['stream']['photos']; ?></div>
					    </div>
					</div>
					<div class="row">
					    <div class="small-12 columns">
						<div id="box-albumDetail" style="margin-top: 10px;">
						    <ul class="small-block-grid-3 small-block-grid-2 ">
							<!-- THUMBNAIL ALBUM -->
							<?php $pathAlbumThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "photos" . DIRECTORY_SEPARATOR . $value->getAlbum()->getThumbnailCover(); ?>
							<li><a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathAlbumThumb; ?>" onerror="this.src='<?php echo DEFALBUMTHUMB; ?>'"></a></li>
						    </ul>
						</div>
					    </div>
					</div>
				    </div>
				</div>
			    </div>
			</div>
			<div class="row">
			    <div class="box-propriety">
				<div class="small-7 columns ">
				    <a class="note grey" onclick="love(this, 'Album', '<?php echo $value->getAlbum()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
				    <a class="note grey" onclick="setCounter(this, 'Khlv07KRGH', 'EventReview')"><?php echo $views['COMM']; ?></a>
				    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
				</div>
				<div class="small-5 columns propriety ">			
				    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getAlbum()->getLoveCounter(); ?></a>
				    <a class="icon-propriety _comment"><?php echo $value->getAlbum()->getCommentCounter(); ?></a>
				    <a class="icon-propriety _share"><?php echo $value->getAlbum()->getShareCounter(); ?></a>
				</div>
			    </div>
			</div>
		    </div>
		    <!---- COMMENT ---->
		    <div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'COLLABORATIONREQUEST':
		?>
		<div class="row  line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['just_added']; ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-6 columns">
					<div class="box-membre">
					    <div class="row " id="collaborator_03VPczLItB">
						<div class="small-3 columns ">
						    <div class="icon-header">
							<?php
							switch ($value->getToUser()->getType()) {
							    case 'JAMMER':
								$defThumb = DEFTHUMBJAMMER;
								break;
							    case 'VENUE':
								$defThumb = DEFTHUMBVENUE;
								break;
							    case 'SPOTTER':
								$defThumb = DEFTHUMBSPOTTER;
								break;
							}
							?>
							<!--THUMB TOUSER-->
							<?php $pathPictureThumbToUser = USERS_DIR . $value->getToUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . 'profilepicturethumb' . DIRECTORY_SEPARATOR . $value->getFromUser()->getProfileThumbnail(); ?>
							<img src="<?php echo $pathPictureThumbToUser; ?>" onerror="this.src='<?php echo $defThumb; ?>'">
						    </div>
						</div>
						<div class="small-9 columns ">
						    <div class="text grey-dark breakOffTest"><strong><?php echo $value->getToUser()->getUsername(); ?></strong></div>
						</div>		
					    </div>	
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		</div>
		</div>
		<?php
		break;
	    case 'COMMENTEDONALBUM':
		if (is_array($value->getAlbum()->getLovers()) && in_array($currentUser->getObjectId(), $value->getAlbum()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['comm_album']; ?></div>
					<div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<li>
						    <!-- THUMBNAIL ALBUM -->
						    <?php $pathAlbumThumb = USERS_DIR . $value->getAlbum()->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "photos" . DIRECTORY_SEPARATOR . $value->getAlbum()->getThumbnailCover(); ?>
						    <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathAlbumThumb; ?>" onerror="this.src='<?php echo DEFALBUMTHUMB; ?>'"></a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Album', '<?php echo $value->getAlbum()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getAlbum()->getObjectId(); ?>', 'Album')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getAlbum()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getAlbum()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getAlbum()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'COMMENTEDONIMAGE':
		if (is_array($value->getImage()->getLovers()) && in_array($currentUser->getObjectId(), $value->getImage()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['comm_img']; ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<!-- THUMBNAIL OF THE CLASS -->
						<li>
						    <!-- THUMBNAIL IMAGE -->
						    <?php $pathImageThumb = USERS_DIR . $value->getImage()->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "photos" . DIRECTORY_SEPARATOR . $value->getImage()->getThumbnail(); ?>
						    <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathImageThumb; ?>" onerror="this.src='<?php echo DEFIMAGETHUMB; ?>'"></a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Image', '<?php echo $value->getImage()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getImage()->getObjectId(); ?>', 'Image')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getImage()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getImage()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getImage()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'COMMENTEDONEVENT':
		if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getObjectId(), $value->getEvent()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['comm_event']; ?></div>
					<div class="sottotitle grey-dark"><?php echo $value->getEvent()->getTitle(); ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<li>
						    <!-- THUMBNAIL EVENT -->
						    <?php $pathEventThumb = USERS_DIR . $value->getEvent()->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcoverthumb" . DIRECTORY_SEPARATOR . $value->getEvent()->getThumbnail(); ?>
						    <a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $value->getEvent()->getObjectId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'"></a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Event', '<?php echo $value->getEvent()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getEvent()->getObjectId(); ?>', 'Event')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getEvent()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'COMMENTEDONEVENTREVIEW':
		if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getObjectId(), $value->getComment()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['comm_event_rev']; ?></div>
					<div class="sottotitle grey-dark">
					    <?php
					    echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
					    ?>
					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<li>
						    <!-- THUMBNAIL EVENT -->
						    <?php $pathEventThumb = USERS_DIR . $value->getEvent()->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcoverthumb" . DIRECTORY_SEPARATOR . $value->getEvent()->getThumbnail(); ?>
						    <a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $value->getEvent()->getObjectId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'"></a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Comment', '<?php echo $value->getComment()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getComment()->getObjectId(); ?>', 'EventReview')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'COMMENTEDONPOST':
		if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getObjectId(), $value->getComment()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['comm_post']; ?></div>
					<div class="sottotitle grey-dark">
					    <?php
					    echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
					    ?>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Comment', '<?php echo $value->getComment()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getComment()->getObjectId(); ?>', 'Post')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'COMMENTEDONRECORD':
		if (is_array($value->getRecord()->getLovers()) && in_array($currentUser->getObjectId(), $value->getRecord()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['comm_record']; ?></div>
					<div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<li>
						    <!-- THUMBNAIL RECORD -->
						    <?php $pathRecordThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $value->getRecord()->getThumbnailCover(); ?>
						    <a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $value->getRecord()->getObjectId(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Record', '<?php echo $value->getRecord()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getRecord()->getObjectId(); ?>', 'Record')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getRecord()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getRecord()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getRecord()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'COMMENTEDONRECORDREVIEW':
		if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getObjectId(), $value->getComment()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['comm_record_rev']; ?></div>
					<div class="sottotitle grey-dark">
					    <?php
					    echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
					    ?>
					</div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<!-- THUMBNAIL RECORD -->
						<?php $pathRecordThumb = USERS_DIR . $value->getRecord()->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $value->getRecord()->getThumbnailCover(); ?>
						<li><a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $value->getComment()->getRecord(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a></li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Comment', '<?php echo $value->getComment()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getComment()->getObjectId(); ?>', 'RecordReview')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'COMMENTEDONVIDEO':
		if (is_array($value->getVideo()->getLovers()) && in_array($currentUser->getObjectId(), $value->getVideo()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['comm_video']; ?></div>
					<div class="sottotitle grey-dark"><?php echo $value->getVideo()->getTitle(); ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<!-- THUMBNAIL OF THE CLASS -->
						<li>
						    <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $value->getVideo()->getThumbnail(); ?>" onerror="this.src='<?php echo DEFVIDEOTHUMB; ?>'"></a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Video', '<?php echo $value->getVideo()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getVideo()->getObjectId(); ?>', 'Video')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getVideo()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getVideo()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getVideo()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'EVENTCREATED':
		if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getObjectId(), $value->getEvent()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['new_event']; ?></div>
					<div class="sottotitle grey-dark"><?php echo $value->getEvent()->getTitle(); ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<!-- THUMBNAIL EVENT -->
						<?php $pathEventThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcoverthumb" . DIRECTORY_SEPARATOR . $value->getEvent()->getThumbnail(); ?>
						<li><a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $value->getEvent()->getObjectId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'"></a></li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Event', '<?php echo $value->getEvent()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getEvent()->getObjectId(); ?>', 'Event')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getEvent()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'FOLLOWING':
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['just_added']; ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-6 columns">
					<div class="box-membre">
					    <div class="row " id="collaborator_03VPczLItB">
						<div class="small-3 columns ">
						    <div class="icon-header">
							<!--THUMB TOUSER-->
							<?php $pathPictureThumbToUser = USERS_DIR . $value->getToUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . 'profilepicturethumb' . DIRECTORY_SEPARATOR . $value->getFromUser()->getProfileThumbnail(); ?>
							<img src="<?php echo $pathPictureThumbToUser; ?>" onerror="this.src='<?php echo $defThumb; ?>'">
						    </div>
						</div>
						<div class="small-9 columns ">
						    <div class="text grey-dark breakOffTest"><strong><?php echo $value->getToUser()->getUsername(); ?></strong></div>
						</div>		
					    </div>	
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		</div>
		</div>
		<?php
		break;
	    case 'FRIENDSHIPREQUEST':
		?>
		<div class="row  line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['just_added']; ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-6 columns">
					<div class="box-membre">
					    <div class="row " id="collaborator_03VPczLItB">
						<div class="small-3 columns ">
						    <div class="icon-header">
							<!--THUMB TOUSER-->
							<?php $pathPictureThumbToUser = USERS_DIR . $value->getToUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . 'profilepicturethumb' . DIRECTORY_SEPARATOR . $value->getFromUser()->getProfileThumbnail(); ?>
							<img src="<?php echo $pathPictureThumbToUser; ?>" onerror="this.src='<?php echo $defThumb; ?>'">
						    </div>
						</div>
						<div class="small-9 columns ">
						    <div class="text grey-dark breakOffTest"><strong><?php echo $value->getToUser()->getUsername(); ?></strong></div>
						</div>		
					    </div>	
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		</div>
		</div>
		<?php
		break;
	    case 'IMAGEADDEDTOALBUM':
		if (is_array($value->getImage()->getLovers()) && in_array($currentUser->getObjectId(), $value->getImage()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['add_img']; ?></div>
					<div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<li>
						    <!--THUMB Image-->
						    <?php $pathImageThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . $value->getImage()->getThumbnail(); ?>
						    <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathImageThumb; ?>" onerror="this.src='<?php echo DEFIMAGETHUMB; ?>'"></a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Image', '<?php echo $value->getImage()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getImage()->getObjectId(); ?>', 'Image')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getImage()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getImage()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getImage()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'IMAGEUPLOADED':
		if (is_array($value->getImage()->getLovers()) && in_array($currentUser->getObjectId(), $value->getImage()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['image_uploaded']; ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<!--THUMB Image-->
						<?php $pathImageThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR . $value->getImage()->getThumbnail(); ?>
						<li><a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathImageThumb; ?>" onerror="this.src='<?php echo DEFIMAGETHUMB; ?>'"></a></li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Image', '<?php echo $value->getImage()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getImage()->getObjectId(); ?>', 'Image')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getImage()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getImage()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getImage()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'INVITED':
		if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getObjectId(), $value->getEvent()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['invite_ok']; ?></div>
					<div class="sottotitle grey-dark"><?php echo $value->getEvent()->getTitle(); ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<!-- THUMBNAIL EVENT -->
						<?php $pathEventThumb = USERS_DIR . $value->getEvent()->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcoverthumb" . DIRECTORY_SEPARATOR . $value->getEvent()->getThumbnail(); ?>
						<li>
						    <a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $value->getEvent()->getObjectId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'"></a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Event', '<?php echo $value->getEvent()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getEvent()->getObjectId(); ?>', 'Event')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getEvent()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'NEWBADGE':
		?>
		<div class="row  line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['new_badge']; ?></div>
				    </div>
				</div>
				<div class="row newBadge">
				    <div class="small-2 columns">
					<div class="badgeThumb"><img src="views/resources/images/badge/badgeElectro.png" onerror="this.src='<?php echo BADGE0; ?>'"></div>						
				    </div>
				    <div class="small-10 columns ">
					<div class="row ">							
					    <div class="small-12 columns ">
						<h5>Electro Addicted</h5>
						<p>Descrizione lunga badge</p>
					    </div>	
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		</div>
		</div>
		<?php
		break;
	    case 'NEWEVENTREVIEW':
		if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getObjectId(), $value->getEvent()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row  line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['event_review']; ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-2 columns ">
					<!-- THUMBNAIL EVENT -->
					<?php $pathEventThumb = USERS_DIR . $value->getEvent()->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "eventcoverthumb" . DIRECTORY_SEPARATOR . $value->getEvent()->getThumbnail(); ?>
					<div class="coverThumb"><a href="event.php?event=<?php echo $value->getEvent()->getObjectId(); ?>"><img src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'"></a></div>
				    </div>
				    <div class="small-10 columns ">
					<div class="row ">							
					    <div class="small-12 columns ">
						<div class="sottotitle grey-dark">
						    <?php
						    echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
						    ?>
						</div>
					    </div>	
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Event', '<?php echo $value->getEvent()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getEvent()->getObjectId(); ?>', 'Event')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getEvent()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'NEWLEVEL':
		?>
		<div class="row  line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['new_level']; ?></div>
					<div class="sottotitle grey-dark">Titolo del Livello</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		</div>
		</div>
		<?php
		break;
	    case 'NEWRECORDREVIEW':
		if (is_array($value->getRecord()->getLovers()) && in_array($currentUser->getObjectId(), $value->getRecord()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row  line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['record_review']; ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-2 columns "
					 <!-- THUMBNAIL EVENT -->
					 <?php $pathRecordThumb = USERS_DIR . $value->getRecord()->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $value->getRecord()->getThumbnailCover(); ?>
					 <div class="coverThumb"><a href="record.php?record=<?php echo $pathRecordThumb; ?>"><img src="<?php echo $value->getRecord()->getThumbnailCover(); ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a></div>
				    </div>
				    <div class="small-10 columns ">
					<div class="row ">							
					    <div class="small-12 columns ">
						<div class="sottotitle grey-dark">
						    <?php
						    echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
						    ?>
						</div>
					    </div>	
					</div>
				    </div>		
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Record', '<?php echo $value->getRecord()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getRecord()->getObjectId(); ?>', 'RecordReview')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getRecord()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getRecord()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getRecord()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'POSTED':
		if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getObjectId(), $value->getComment()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="text grey">
				    <?php
				    echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
				    ?>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Comment', '<?php echo $value->getComment()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getComment()->getObjectId(); ?>', 'Post')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'RECORDCREATED':
		if (is_array($value->getRecord()->getLovers()) && in_array($currentUser->getObjectId(), $value->getRecord()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['record_created']; ?></div>
					<div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<!-- THUMBNAIL RECORD -->
						<?php $pathRecordThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $value->getRecord()->getThumbnailCover(); ?>
						<li>
						    <a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $value->getRecord()->getObjectId(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a>
						</li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Record', '<?php echo $value->getRecord()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getRecord()->getObjectId(); ?>', 'Record')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getRecord()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getRecord()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getRecord()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    #TODO
	    /* --> saranno implementate in un secondo momento
	      case 'SHAREDIMAGE':
	      break;
	      case 'SHAREDSONG':
	      break;
	     */
	    case 'SONGAADDEDTORECORD':
		if (is_array($value->getSong()->getLovers()) && in_array($currentUser->getObjectId(), $value->getSong()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['song_added']; ?></div>
					<div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
				    </div>
				</div>
				<div class="row">
				    <div class="small-12 columns">
					<div id="box-albumDetail" style="margin-top: 10px;">
					    <ul class="small-block-grid-3 small-block-grid-2 ">
						<!-- THUMBNAIL RECORD -->
						<?php $pathRecordThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $value->getRecord()->getThumbnailCover(); ?>
						<li><a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $value->getSong()->getRecord(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a></li>
					    </ul>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Song', '<?php echo $value->getSong()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getSong()->getObjectId(); ?>', 'Song')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getSong()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getSong()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getSong()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	    case 'SONGUPLOADED':
		if (is_array($value->getSong()->getLovers()) && in_array($currentUser->getObjectId(), $value->getSong()->getLovers())) {
		    $css_love = '_love orange';
		    $text_love = $views['UNLOVE'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['LOVE'];
		}
		?>
		<div class="row line">
		    <div class="small-12 columns ">
			<div class="row ">
			    <div class="small-12 columns ">
				<div class="row  ">
				    <div class="large-12 columns ">
					<div class="text orange"><?php echo $views['stream']['song_uploaded']; ?></div>
				    </div>
				</div>
				<div class="row box-detail" onclick="">
				    <!-- THUMBNAIL RECORD -->
				    <?php $pathRecordThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $value->getRecord()->getThumbnailCover(); ?>
				    <div class="small-2 columns">
					<div class="coverThumb"><a href="record.php?record=<?php echo $value->getSong()->getRecord(); ?>"><img src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a></div>
				    </div>
				    <div class="small-10 columns">
					<div class="row">							
					    <div class="small-12 columns">
						<div class="sottotitle grey-dark"><?php echo $value->getSong()->getTitle(); ?></div>
					    </div>	
					</div>	
					<div class="row">						
					    <div class="small-12 columns">
						<div class="grey"><?php echo $value->getRecord()->getTitle(); ?></div>
					    </div>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row">
		    <div class="box-propriety">
			<div class="small-7 columns ">
			    <a class="note grey" onclick="love(this, 'Song', '<?php echo $value->getSong()->getObjectId(); ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
			    <a class="note grey" onclick="setCounter(this, '<?php echo $value->getSong()->getObjectId(); ?>', 'Song')"><?php echo $views['COMM']; ?></a>
			    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
			</div>
			<div class="small-5 columns propriety ">			
			    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getSong()->getLoveCounter(); ?></a>
			    <a class="icon-propriety _comment"><?php echo $value->getSong()->getCommentCounter(); ?></a>
			    <a class="icon-propriety _share"><?php echo $value->getSong()->getShareCounter(); ?></a>
			</div>
		    </div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display"></div>
		</div>
		<?php
		break;
	}
    }
}
?>