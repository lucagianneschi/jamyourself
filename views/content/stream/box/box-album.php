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
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'album.box.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$albumBox = new AlbumBox();
$albumBox->init($_POST['objectId']);
if (is_null($albumBox->error) || isset($_SESSION['currentUser'])) {
	$currentUser = $_SESSION['currentUser'];
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
					<div class="box royalSlider contentSlider  rsDefault" id="albumSlide">
					<div class="rsContent">
					<?php
					if ($albumCounter > 0) {
						?>
						<div class="row" style="margin-left: 0px; margin-right: 0px;">
							<?php
							$totalView = $albumCounter > 4 ? 4 : $albumCounter;
							$i = 1;
							foreach ($albums as $key => $value) {
								$album_thumbnailCover = $value->getThumbnailCover();
								$album_objectId = $value->getObjectId();
								$album_title = $value->getTitle();
								$album_imageCounter = $value->getImageCounter();
								$album_love = $value->getLoveCounter();
								$album_comment = $value->getCommentCounter();
								$album_share = $value->getShareCounter();
								
								if (in_array($currentUser->getObjectId(), $value->getLovers())) {
									$css_love = '_unlove grey';
									$text_love = $views['LOVE'];
								} else{
									$css_love = '_love orange';
									$text_love = $views['UNLOVE'];
								}
								?> 
								<div class="small-6 columns box-coveralbum <?php echo $album_objectId; ?>" onclick="albumSelectSingle('<?php echo $album_objectId; ?>',<?php echo $album_imageCounter; ?>)">
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
								<?php
								if ($i % 2 == 0) {
									?>
									</div>
									<div class="row">
									<?php
								}
								if ($i == $totalView) break;
								$i++;
							}
							?>
						</div>
						<?php
					} else {
						?>
						<div class="row  ">
								<div  class="large-12 columns ">
									<p class="grey"><?php echo $views['album']['NODATA'];?></p>
								</div>
						</div>
						<?php
					}
					?>	
					</div>
				</div>
			</div>
			<!----------------------------------------- ALBUM PHOTO SINGLE ------------------------------>	
			<?php
			/*
			for ($i=0; $i<$albumCounter; $i++) {
				if ($data['album' . $i]['showLove'] == 'true') {
						$css_love = '_unlove grey';
						$text_love = $views['LOVE'];
					} elseif ($data['album' . $i]['showLove'] == 'false') {
						$css_love = '_love orange';
						$text_love = $views['UNLOVE'];
					}
					?>
					<div id="profile-singleAlbum">
						<div class="box no-display box-singleAlbum" id="<?php echo $data['album' . $i]['objectId'];?>">
							<div class="row box-album">
								<div class="large-12 columns">					
									<a class="ico-label _back_page text white" onclick="albumSelectNext('<?php echo $data['album' . $i]['objectId']; ?>')"><?php echo $views['BACK'];?></a>
								</div>
							</div>
							<div class="row" style="padding-bottom: 10px;">
								<div  class="large-12 columns"><div class="line"></div></div>
							</div>
							<!----------------------------------------- ALBUM DETAIL--------------------------->			
							<div id='box-albumDetailTH'></div>
							<!----------------------------------------- FINE ALBUM DETAIL --------------------------->	
							<div class="row album-single-propriety">
								 <div class="box-propriety">
									<div class="small-6 columns">
										<a class="note grey" onclick="love(this, 'Album', '<?php echo $data['album' . $i]['objectId']; ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love;?></a>
										<a class="note grey" onclick="setCounter(this,'<?php echo $data['album' . $i]['objectId']; ?>','Album')"><?php echo $views['COMM'];?></a>
										<a class="note grey" onclick="share(this,'<?php echo $data['album' . $i]['objectId']; ?>','profile-singleAlbum')"><?php echo $views['SHARE'];?></a>
									</div>
									<div class="small-6 columns propriety ">					
										<a class="icon-propriety <?php echo $css_love ?>"><?php echo $data['album' . $i]['counters']['loveCounter']; ?></a>
										<a class="icon-propriety _comment"><?php echo $data['album' . $i]['counters']['commentCounter']; ?></a>
										<a class="icon-propriety _share"><?php echo $data['album' . $i]['counters']['shareCounter']; ?></a>	
									</div>
								</div>		
							</div>	
						</div>
						<!---------------------------------------- COMMENT ------------------------------------------------->
						<div class="box-comment no-display"></div>
						<!---------------------------------------- SHARE ------------------------------------------------->
						<?php
						$paramsAlbum = getShareParameters('Album', $data['album' . $i]['objectId'], $data['album' . $i]['image' . $j]['thumbnail']);
						?>
						<!-- AddThis Button BEGIN -->
						<div class="addthis_toolbox">
							<div class="hover_menu">
									<div class="addthis_toolbox addthis_default_style"
										addThis:url="http://www.socialmusicdiscovering.com/views/share.php?classType=Album&objectId=&imgPath=<?php echo $data['album' . $i]['image' . $j]['thumbnail']; ?>"
										addThis:title="<?php echo $paramsAlbum['title']; ?>"
										onclick="addShare('<?php echo $objectIdUser; ?>', 'Album', '<?php echo $data['album' . $i]['objectId']; ?>')">
									<a class="addthis_button_twitter"></a>
									<a class="addthis_button_facebook"></a>
									<a class="addthis_button_google_plusone_share"></a>
								   </div>	        
							</div>
						</div>
						<!-- AddThis Button END -->
					</div>
				<!---------------------------------------- LIGHTBOX ------------------------------------------------->
				<div id='box-albumDetailLB'></div>
				<?php
			}
			*/
			?>	
		</div>
	</div>
	<?php
}
?>