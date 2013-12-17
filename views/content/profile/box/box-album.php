<?php
/* 
 * box album
 * box chiamato tramite load con:
 * data: {data: data, typeUser: objectId}
 * 
 * box per tutti gli utenti
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'album.box.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$objectIdUser = $_POST['objectIdUser'];

$albumBox = new AlbumBox();
$albumBox->init($_POST['objectId']);
if (is_null($albumBox->error)) {
	if(isset($_SESSION['currentUser'])) $currentUser = $_SESSION['currentUser'];
	$albums = $albumBox->albumArray;
	$albumCounter = count($albums);
	?>
	<!----------------------------------- Photography -------------------------------------------------->
	<div class="row" id='profile-Album'>
		<div class="large-12 columns ">
			<div class="row">
				<div  class="large-5 columns">
					<h3><?php echo $views['album']['TITLE'];?></h3>
				</div>	
				<div  class="large-7 columns align-right">
					<?php
					if ($albumCounter > 4) {
						?>
						<div class="row">					
							<div  class="small-9 columns">
								<a class="slide-button-prev _prevPage" onclick="royalSlidePrev('album')"><?php echo $views['PREV'];?> </a>
							</div>
							<div  class="small-3 columns">
								<a class="slide-button-next _nextPage" onclick="royalSlideNext('album')"><?php echo $views['NEXT'];?> </a>
							</div>
						</div>		 		
						<?php
					}
					?>
				</div>
			</div>	
			<!-------------------------------------- LIST ALBUM PHOTO -------------------------------->
			<div class="row">
				<div class="large-12 columns ">
					
					<?php
					if ($albumCounter > 0) {
						$index = 0; ?>
						<div class="box royalSlider contentSlider  rsDefault" id="albumSlide">
							<?php if ($index % 4 == 0) {?><div class="rsContent">	<?php } ?>						
								<div class="row" style="margin-left: 0px; margin-right: 0px;">
									<?php foreach ($albums as $key => $value) {
											$album_thumbnailCover = $value->getThumbnailCover();
											$album_objectId = $value->getObjectId();
											$album_title = $value->getTitle();
											$album_imageCounter = $value->getImageCounter();
											$album_love = $value->getLoveCounter();
											$album_comment = $value->getCommentCounter();
											$album_share = $value->getShareCounter();											
											if(isset($_SESSION['currentUser']) && is_array($value->getLovers()) && in_array($currentUser->getObjectId(), $value->getLovers())) {
												$css_love = '_love orange';
												$text_love = $views['UNLOVE'];							
												
											} else{
												$css_love = '_unlove grey';
												$text_love = $views['LOVE'];
											} ?> 
										<div class="small-6 columns box-coveralbum <?php echo $album_objectId; ?>" onclick="loadBoxAlbumDetail('<?php echo $album_objectId; ?>',<?php echo $album_imageCounter; ?>,30,0)">
											<img class="albumcover" src="../media/<?php echo $album_thumbnailCover; ?>" onerror="this.src='../media/<?php echo DEFALBUMTHUMB;?>'">  
											<div class="text white breakOffTest"><?php echo $album_title; ?></div>
											<div class="row">
												<div class="small-5 columns ">
													<a class="note grey"><?php echo $album_imageCounter; ?> <?php echo $views['album']['PHOTO'];?></a>								
												</div>
												<div class="small-7 columns propriety ">					
													<a class="icon-propriety <?php echo $css_love ?>"><?php echo $album_love; ?></a>
													<a class="icon-propriety _comment"><?php echo $album_comment; ?></a>
													<a class="icon-propriety _share"><?php echo $album_share; ?></a>	
												</div>		
											</div>
										</div>
									<?php } ?>
								</div>
							<?php 
							if (($index+1) % 4 == 0 || $albumCounter == $index+1) { ?> </div> <?php }
								$index++;	
							?>								
						</div>
					<?php } else { ?>
						<div class="row  ">
							<div  class="large-12 columns ">
								<p class="grey"><?php echo $views['album']['NODATA'];?></p>
							</div>
						</div>
					<?php }	 ?>	
					
				</div>
			</div>
			<!----------------------------------------- ALBUM PHOTO SINGLE ------------------------------>	
	<?php
		
		foreach ($albums as $key => $value) {
			$album_objectId = $value->getObjectId();
			$album_title = $value->getTitle();
			$album_imageCounter = $value->getImageCounter();
			$album_love = $value->getLoveCounter();
			$album_comment = $value->getCommentCounter();
			$album_share = $value->getShareCounter();
			
			
			if(isset($_SESSION['currentUser']) && is_array($value->getLovers()) && in_array($currentUser->getObjectId(), $value->getLovers())) {
				$css_love = '_love orange';
				$text_love = $views['UNLOVE'];							
				
			} else{
				$css_love = '_unlove grey';
				$text_love = $views['LOVE'];
			}
		?>
			<div class="profile-singleAlbum"  >
				<div id="<?php echo $album_objectId;?>" class='no-display box-singleAlbum'>
					<div class="box" >
						<div class="row box-album" style="border-bottom: 1px solid #303030;margin-bottom: 20px;">
							<div class="large-12 columns" >					
								<a class="ico-label _back_page text white" style="margin-bottom: 10px;" onclick="loadBoxAlbum()"><?php echo $views['BACK'];?></a>
							</div>
						</div>
						
						<!----------------------------------------- ALBUM DETAIL--------------------------->			
						<div id='box-albumDetail'></div>
						<script type="text/javascript">
						function loadBoxAlbumDetail(objectId,countImage,limit,skip) {
							var json_data = {};
							json_data.objectId = objectId;
							json_data.countImage = countImage;
							json_data.limit = limit;
							json_data.skip = skip;
							$.ajax({
								type: "POST",
								url: "content/profile/box/box-albumDetail.php",
								data: json_data,
								beforeSend: function(xhr) {
									//spinner.show();
									$( "#albumSlide" ).fadeOut( 100, function() {
										$('#'+objectId ).fadeIn( 100 );
							    		if(skip == 0) goSpinner('#box-albumDetail', '');
							    		else{
							    			$('#box-albumDetail .otherObject').addClass('no-display');
							    			goSpinner('#box-albumDetail .spinnerDetail', '');
							    		} 
									});
									
									console.log('Sono partito box-albumDetail');								
								}
							}).done(function(message, status, xhr) {
								//spinner.hide();
								if(skip > 0){
									$('#box-albumDetail .otherObject').addClass('no-display');
									$('#box-albumDetail .spinnerDetail').addClass('no-display');
								}
									
								else $("#"+objectId+" #box-albumDetail").html('');
								$(message).appendTo("#"+objectId+" #box-albumDetail");
								lightBoxPhoto('photo-colorbox-group');		
								addthis.init();
								addthis.toolbox(".addthis_toolbox");
								rsi_record.updateSliderSize(true);
								
							//	$("#"+objectId+" #box-albumDetail").html(message);
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
									<a class="note grey" onclick="love(this, 'Album', '<?php echo $album_objectId; ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love;?></a>
									<a class="note grey" onclick="loadBoxOpinion('<?php echo $album_objectId; ?>', 'Album', '#<?php echo $album_objectId; ?> .box-opinion', 10, 0)"><?php echo $views['COMM'];?></a>
									<a class="note grey" onclick="share(this,'<?php echo $album_objectId; ?>','profile-singleAlbum')"><?php echo $views['SHARE'];?></a>
								</div>
								<div class="small-6 columns propriety ">					
									<a class="icon-propriety <?php echo $css_love ?>"><?php echo $album_love; ?></a>
									<a class="icon-propriety _comment"><?php echo $album_comment; ?></a>
									<a class="icon-propriety _share"><?php echo $album_share; ?></a>	
								</div>
							</div>		
						</div>			
						
						<!---------------------------------------- SHARE ------------------------------------------------->
						<?php
				//		$paramsAlbum = getShareParameters('Album', $album_objectId, $thumbImage);
						?>
						<!-- AddThis Button BEGIN -->
						<div class="addthis_toolbox">
							<div class="hover_menu">
								<div class="addthis_toolbox addthis_default_style"
										addThis:url="http://www.socialmusicdiscovering.com/views/share.php?classType=Album&objectId=&imgPath=<?php echo $thumbImage ?>"
										addThis:title="<?php echo $paramsImage['title']; ?>"
										onclick="addShare('<?php echo $objectIdUser; ?>', 'Album', '<?php echo $album_objectId; ?>')">
									<a class="addthis_button_twitter"></a>
									<a class="addthis_button_facebook"></a>
									<a class="addthis_button_google_plusone_share"></a>
							   </div>	        
							</div>
						</div>
						<!-- AddThis Button END -->
					</div>
					<!---------------------------------------- OPINION ------------------------------------------------->
					<div class="box-opinion no-display"></div>
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