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
require_once VIEWS_DIR . 'utilities/share.php'; 

$data = $_POST['data'];

$objectIdUser  = $_POST['objectIdUser'];
$typeUser = $_POST['typeUser'];

$albumCounter = $data['albumCounter'];	


?>
<!----------------------------------- Photography -------------------------------------------------->
<div class="row" id='profile-Album'>
	<div class="large-12 columns ">
		<div class="row">
			<div  class="large-5 columns">
				<h3><?php echo $views['album']['TITLE'];?></h3>
			</div>	
			<div  class="large-7 columns align-right">
				<?php if($albumCounter > 4){ ?>
					<div class="row">					
						<div  class="small-9 columns">
							<a class="slide-button-prev _prevPage" onclick="royalSlidePrev('album')"><?php echo $views['PREV'];?> </a>
						</div>
						<div  class="small-3 columns">
							<a class="slide-button-next _nextPage" onclick="royalSlideNext('album')"><?php echo $views['NEXT'];?> </a>
						</div>
					</div>		 		
				<?php } ?>
			</div>
		</div>	
		<!-------------------------------------- LIST ALBUM PHOTO -------------------------------->
		<div class="row">
			<div class="large-12 columns ">
				<div class="box royalSlider contentSlider  rsDefault" id="albumSlide">
					
					<?php if($albumCounter > 0 ){
							for($j=0; $j<$albumCounter; $j=$j+4){
							
						?> 
						<div  class="rsContent">
						<?php 
								for($i=$j; $i<($j+4); $i=$i+2){
													
									
						?>
					
							
					<div class="row" style="margin-left: 0px; margin-right: 0px;">
						<?php if(isset($data['album' . ($i)]['objectId'])){
							 	$css_love = $data['album' . $i]['showLove'] == 'false' ?  '_love orange' : '_unlove grey';
							?>				
						<div class="small-6 columns box-coveralbum <?php echo $data['album' . ($i)]['objectId'] ?>"  onclick="albumSelectSingle('<?php echo $data['album' . $i]['objectId']; ?>',<?php echo $data['album' . $i]['imageCounter']; ?>)">
							<img class="albumcover" src="../media/<?php echo $data['album' . $i]['thumbnailCover'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFALBUMTHUMB'];?>'">  
							<div class="text white breakOffTest"><?php echo $data['album' . $i]['title']; ?></div>
							<div class="row">
								<div class="small-5 columns ">
									<a class="note grey"><?php echo $data['album' . $i]['imageCounter']; ?> <?php echo $views['album']['PHOTO'];?></a>								
								</div>
								<div class="small-7 columns propriety ">					
									<a class="icon-propriety <?php echo $css_love ?>"><?php echo $data['album' . $i]['counters']['loveCounter']; ?></a>
									<a class="icon-propriety _comment"><?php echo $data['album' . $i]['counters']['commentCounter']; ?></a>
									<a class="icon-propriety _share"><?php echo $data['album' . $i]['counters']['shareCounter']; ?></a>	
								</div>		
							</div>
						</div>
						<?php }
						if(isset($data['album' . ($i+1)]['objectId'])){ 
							$css_love = $data['album' . ($i+1)]['showLove'] == 'true' ?  '_love orange' : '_unlove grey';
							?>
						<div class="small-6 columns box-coveralbum <?php echo $data['album' . ($i+1)]['objectId']?>"  onclick="albumSelectSingle('<?php echo $data['album' . ($i+1)]['objectId']; ?>',<?php echo $data['album' . ($i+1)]['imageCounter']; ?>)">
							<img class="albumcover" src="../media/<?php echo $data['album' . ($i+1)]['thumbnailCover'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFALBUMTHUMB'];?>'">  
							<div class="text white breakOffTest"><?php echo $data['album' . ($i+1)]['title']; ?></div>
							<div class="row">
								<div class="small-5 columns ">
									<a class="note grey"><?php echo $data['album' . ($i+1)]['imageCounter']; ?> <?php echo $views['album']['PHOTO'];?></a>								
								</div>
								<div class="small-7 columns propriety ">					
									<a class="icon-propriety <?php echo $css_love ?>"><?php echo $data['album' . ($i+1)]['counters']['loveCounter']; ?></a>
									<a class="icon-propriety _comment"><?php echo $data['album' . ($i+1)]['counters']['commentCounter']; ?></a>
									<a class="icon-propriety _share"><?php echo $data['album' . ($i+1)]['counters']['shareCounter']; ?></a>	
								</div>		
							</div>
						</div>
						<?php } ?>
					</div>
						<?php } ?>
					</div>
					<?php }} else{ ?>
						<div class="row  ">
								<div  class="large-12 columns ">
									<p class="grey"><?php echo $views['album']['NODATA'];?></p>
								</div>
						</div>
					<?php } ?>	
					
				</div>
			</div>
		</div>
	<!----------------------------------------- ALBUM PHOTO SINGLE ------------------------------>
	
	<?php 
		
		for($i=0; $i<$albumCounter; $i++){ 
			if($data['album' . $i]['showLove'] == 'true'){
					$css_love = '_unlove grey';
					$text_love = $views['LOVE'];
				}
				elseif($data['album' . $i]['showLove'] == 'false'){
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
		
		<?php  } ?>	
	</div>
	
</div>
