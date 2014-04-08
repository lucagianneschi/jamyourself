<?php
/*
 * box album
 * box chiamato tramite load con:
 * data: {data: data, typeUser: id}
 * 
 * box per tutti gli utenti
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once BOXES_DIR . 'album.box.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'select.service.php';
require_once SERVICES_DIR . 'connection.service.php';


session_start();
$userId = $_POST['id'];
$albumBox = new AlbumBox();
$albumBox->init($userId);
if (is_null($albumBox->error)) {
    if (isset($_SESSION['id']))
	$currentUserId = $_SESSION['id'];
    $albums = $albumBox->albumArray;
    $albumCounter = count($albums);
    $fileManagerService = new FileManagerService();
    ?>
    <!----------------------------------- Photography -------------------------------------------------->
    <div class="row" id='profile-Album'>
        <div class="large-12 columns ">
    	<div class="row">
    	    <div  class="large-5 columns">
    		<h3><?php echo $views['album']['title']; ?></h3>
    	    </div>	
    	    <div  class="large-7 columns align-right" id="albumBottonSlide">
		    <?php if ($albumCounter > 4) { ?>
			<div class="row">					
			    <div  class="small-9 columns">
				<a class="slide-button-prev _prevPage slide-button-prev-disabled" onclick="royalSlidePrev(this, 'album')"><?php echo $views['prev']; ?> </a>
			    </div>
			    <div  class="small-3 columns">
				<a class="slide-button-next _nextPage" onclick="royalSlideNext(this, 'album')"><?php echo $views['next']; ?> </a>
			    </div>
			</div>		 		
		    <?php } ?>
    	    </div>
    	</div>	
    	<!-------------------------------------- LIST ALBUM PHOTO -------------------------------->
    	<div class="row">
    	    <div class="large-12 columns ">
		    <?php
		    if ($albumCounter > 0) {
			$index = 0;
			?>
			<div class="box royalSlider rsMinW" id="albumSlide">						
			    <?php
			    foreach ($albums as $key => $value) {
				$album_thumbnail = $value->getThumbnail();
				$album_id = $value->getId();
				$album_title = $value->getTitle();
				$album_imageCounter = $value->getImagecounter();
				$album_love = $value->getLovecounter();
				$album_comment = $value->getCommentcounter();
				$album_share = $value->getSharecounter();
				$pathCoverAlbum = $fileManagerService->getPhotoPath($userId, $album_thumbnail);
				$connectionService = new ConnectionService();				
				if (existsRelation($connectionService,'user', $currentUserId, 'album', $album_id, 'LOVE')) {
				    $css_love = '_love orange';
				    $text_love = $views['unlove'];
				} else {
				    $css_love = '_unlove grey';
				    $text_love = $views['love'];
				}
				?> 
				<?php if ($index % 4 == 0) { ?> <div class="rsContent">	<?php
				}
				if ($index % 2 == 0) {
				    ?>									
					<div class="row" style="margin-left: 0px; margin-right: 0px;">
					<?php } ?>	
	    			    <div class="small-6 columns box-coveralbum <?php echo $album_id; ?>" onclick="loadBoxAlbumDetail('<?php echo $userId ?>', '<?php echo $album_id; ?>',<?php echo $album_imageCounter; ?>, 30, 0)">
	    				<img class="albumcover" src="<?php echo $pathCoverAlbum; ?>" onerror="this.src='<?php echo DEFALBUMTHUMB; ?>'" alt="<?php echo $album_title; ?>"/>  
	    				<div class="text white breakOffTest"><?php echo $album_title; ?></div>
	    				<div class="row">
	    				    <div class="small-5 columns ">
	    					<a class="note grey"><?php echo $album_imageCounter; ?> <?php echo $views['album']['photos']; ?></a>								
	    				    </div>
	    				    <div class="small-7 columns propriety ">					
	    					<a class="icon-propriety <?php echo $css_love ?>"><?php echo $album_love; ?></a>
	    					<a class="icon-propriety _comment"><?php echo $album_comment; ?></a>
	    					<a class="icon-propriety _share"><?php echo $album_share; ?></a>	
	    				    </div>		
	    				</div>
	    			    </div>
					<?php if (($index + 1) % 2 == 0 || $albumCounter == $index + 1) { ?> </div> <?php }
					if (($index + 1) % 4 == 0 || $albumCounter == $index + 1) {
					?> </div> <?php }
					$index++;
					}
				?>							
			</div>
		    <?php } else { ?>
			<div class="row  ">
			    <div  class="large-12 columns ">
				<p class="grey"><?php echo $views['album']['nodata']; ?></p>
			    </div>
			</div>
		    <?php } ?>		
    	    </div>
    	</div>
    	<!----------------------------------------- ALBUM PHOTO SINGLE ------------------------------>	
	    <?php
	    foreach ($albums as $key => $value) {
		$album_id = $value->getId();
		$album_user_objectId = $value->getFromuser()->getId();
		$album_title = $value->getTitle();
		$album_imageCounter = $value->getImagecounter();
		$album_love = $value->getLovecounter();
		$album_comment = $value->getCommentcounter();
		$album_share = $value->getSharecounter();
		$connectionService = new ConnectionService();
		if (existsRelation($connectionService,'user', $currentUserId, 'album', $album_id, 'LOVE')) {
		    $css_love = '_love orange';
		    $text_love = $views['unlove'];
		} else {
		    $css_love = '_unlove grey';
		    $text_love = $views['love'];
		}
		?>
		<div class="profile-singleAlbum">
		    <div id="<?php echo $album_id; ?>" class='no-display box-singleAlbum'>
			<div class="box" >
			    <div class="row box-album" style="border-bottom: 1px solid #303030;margin-bottom: 20px;">
				<div class="large-12 columns" >					
				    <a class="ico-label _back_page text white" style="margin-bottom: 10px;" onclick="loadBoxAlbum()"><?php echo $views['back']; ?></a>
				</div>
			    </div>	
			    <!----------------------------------------- ALBUM DETAIL--------------------------->			
			    <div id='box-albumDetail'></div>
			    <script type="text/javascript">
					function loadBoxAlbumDetail(userId, id, countImage, limit, skip) {
						var json_data = {};
						json_data.userId = userId;
						json_data.id = id;
						json_data.countImage = countImage;
						json_data.limit = limit;
						json_data.skip = skip;
						$.ajax({
							type : "POST",
							url : "content/profile/box/box-albumDetail.php",
							data : json_data,
							beforeSend : function(xhr) {
								//spinner.show();
								$("#albumSlide").fadeOut(100, function() {
									$('#' + id).fadeIn(100);
									if (skip == 0)
										goSpinnerBox('#' + id + ' #box-albumDetail', '');
									else {
										$('#' + id + ' #box-albumDetail .otherObject').addClass('no-display');
										goSpinnerBox('#' + id + ' #box-albumDetail .spinnerDetail', '');
									}
								});
								console.log('Sono partito box-albumDetail');
							}
						}).done(function(message, status, xhr) {
							//spinner.hide();
							if (skip > 0) {
								$('#' + id + ' #box-albumDetail .otherObject').addClass('no-display');
								$('#' + id + ' #box-albumDetail .spinnerDetail').addClass('no-display');
							} else {
								$("#" + id + " #box-albumDetail").html('');
							}
							$('#albumBottonSlide').addClass('no-display');
							$(message).appendTo("#" + id + " #box-albumDetail");
							lightBoxPhoto('photo-colorbox-group');
							addthis.init();
							addthis.toolbox(".addthis_toolbox");
							//    rsi_album.updateSliderSize(true);

							//	$("#"+id+" #box-albumDetail").html(message);
							code = xhr.status;
							//console.log("Code: " + code + " | Message: " + message);
							//gestione visualizzazione box detail
							console.log("Code: " + code + " | Message: <omitted because too large>");
						}).fail(function(xhr) {
							//spinner.hide();
							console.log("Error: " + $.parseJSON(xhr));
							//message = $.parseJSON(xhr.responseText).status;
							//code = xhr.status;
							//console.log("Code: " + code + " | Message: " + message);
						});
					}
			    </script>
			    <!----------------------------------------- FINE ALBUM DETAIL --------------------------->	
			    <div class="row album-single-propriety">
				<div class="box-propriety">
				    <div class="small-6 columns">
					<a class="note grey" onclick="love(this, 'Album', '<?php echo $album_id; ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love; ?></a>
					<a class="note grey" onclick="loadBoxOpinion('<?php echo $album_id; ?>', '<?php echo $album_user_objectId; ?>', 'Album', '#<?php echo $album_id; ?> .albumOpinion.box-opinion', 10, 0)"><?php echo $views['comm']; ?></a>
					<a class="note grey" onclick="share(this, '<?php echo $album_id; ?>', 'profile-singleAlbum')"><?php echo $views['share']; ?></a>
				    </div>
				    <div class="small-6 columns propriety ">					
					<a class="icon-propriety <?php echo $css_love ?>"><?php echo $album_love; ?></a>
					<a class="icon-propriety _comment"><?php echo $album_comment; ?></a>
					<a class="icon-propriety _share"><?php echo $album_share; ?></a>	
				    </div>
				</div>		
			    </div>			
			    <!---------------------------------------- SHARE ------------------------------------------------->
			    <?php //		$paramsAlbum = getShareParameters('Album', $album_id, $thumbImage); ?>
			    <!-- AddThis Button BEGIN -->
			    <div class="addthis_toolbox">
				<div class="hover_menu">
				    <div class="addthis_toolbox addthis_default_style"
					 addThis:url="http://www.socialmusicdiscovering.com/views/share.php?classType=Album&id=&imgPath=<?php echo $thumbImage ?>"
					 addThis:title="<?php echo $paramsImage['title']; ?>"
					 onclick="addShare('<?php echo $objectIdUser; ?>', 'Album', '<?php echo $album_id; ?>')">
					<a class="addthis_button_twitter"></a>
					<a class="addthis_button_facebook"></a>
					<a class="addthis_button_google_plusone_share"></a>
				    </div>	        
				</div>
			    </div>
			    <!-- AddThis Button END -->
			</div>
			<!---------------------------------------- OPINION ------------------------------------------------->
			<div class="albumOpinion box-opinion no-display"></div>
		    </div>				
		</div>
		<?php } ?>	
        </div>
    </div>
    <?php
	}
?>