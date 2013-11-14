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
				<ul class="small-block-grid-3 small-block-grid-2 ">			
				  <?php 
				  $totalPhotoView = $data['album' . $i]['imageCounter'] > 15 ? 15 : $data['album' . $i]['imageCounter'];
				  for($j=0; $j<$totalPhotoView; $j++){ ?>
				  <li><a class="photo-colorbox-group" href="#<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>"><img class="photo" src="../media/<?php $data['album' . $i]['image' . $j]['thumbnail']?>" onerror="this.src='../media/<?php echo $default_img['DEFIMAGE']; ?>'"></a></li>
					<?php } ?>
				</ul>		
				
				<div class="row album-single-propriety">
					 <div class="box-propriety">
						<div class="small-6 columns ">
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
			$paramsAlbum = getShareParameters('Album');
			?>
			<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox">
				<div class="hover_menu">
				        <div class="addthis_toolbox addthis_default_style addthis_32x32_style"
							addThis:url="http://www.socialmusicdiscovering.com/views/share.php?classType=Album"
							addThis:title="<?php echo $paramsAlbum['title']; ?>">
				        <a class="addthis_button_twitter"></a>
				        <a class="addthis_button_facebook"></a>
				        <a class="addthis_button_google_plusone_share"></a>
				       </div>	        
				</div>
			</div>
			<!-- AddThis Button END -->
		</div>
		<!---------------------------------------- LIGHTBOX ------------------------------------------------->
		<div class="row no-display box" id="profile-Image">
			<div class="large-12 columns">
				 <?php for($j=0; $j<$data['album' . $i]['imageCounter']; $j++){ 
				 			if($data['album' . $i]['image' . $j]['showLove'] == 'true'){
								$css_love = '_unlove grey';
								$text_love = $views['LOVE'];
							}
							elseif($data['album' . $i]['image' . $j]['showLove'] == 'false'){
								$css_love = '_love orange';
								$text_love = $views['UNLOVE'];
							}
				 	
				 	?>				 	
					<div id="<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>" class="lightbox-photo <?php echo $data['album' . $i]['image' . $j]['filePath']; ?>">
						<div class="row " style="max-width: none;">
							<div class="large-12 columns lightbox-photo-box"   >
								<div class="album-photo-box" onclick="nextLightBox()"><img class="album-photo"  src="../media/images/image/<?php echo $data['album' . $i]['image' . $j]['filePath']; ?>" onerror="this.src='../media/<?php echo $default_img['DEFIMAGE']; ?>'"/></div>
					 			<div class="row">
					 				<div  class="large-12 columns" style="padding-top: 15px;padding-bottom: 15px"><div class="line"></div></div>
					 			</div>
					 			<div class="row" style="margin-bottom: 10px">
					 				<div  class="small-6 columns">
					 					<a class="note grey " onclick="love(this, 'Image', '<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love;?></a>
										<a class="note grey" onclick="setCounter(this,'<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>','Image')"><?php echo $views['COMM'];?></a>
										<a class="note grey" onclick="share(this,'<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>','profile-Image')"><?php echo $views['SHARE'];?></a>
					 				</div>
					 				<div  class="small-6 columns propriety">
					 					<a class="icon-propriety <?php echo $css_love ?>"><?php echo $data['album' . $i]['image' . $j]['counters']['loveCounter']; ?></a>
										<a class="icon-propriety _comment"><?php echo $data['album' . $i]['image' . $j]['counters']['commentCounter']; ?></a>
										<a class="icon-propriety _share"><?php echo $data['album' . $i]['image' . $j]['counters']['shareCounter']; ?></a>	
					 				</div>
					 			</div>
					 			<div class="row">
					 				<div  class="small-5 columns">
					 					<div class="sottotitle white"><?php echo $data['album' . $i]['title']; ?></div>
					 					<?php if($data['album' . $i]['image' . $j]['description'] != ""){?>
					 					<div class="text grey"><?php echo $data['album' . $i]['image' . $j]['description']; ?></div>
					 					
					 					<?php }if($data['album' . $i]['image' . $j]['location'] != ""){?>
					 						
					 					<div class="text grey"><?php echo $data['album' . $i]['image' . $j]['location'];?></div>
					 					
					 					<?php
										} 
					 						$tag = "";
					 						if(is_array ($data['album' . $i]['image' . $j]['tags'])){					 							
					 							foreach ($data['album' . $i]['image' . $j]['tags'] as $key => $value) {
													 $tag = $tag + ' ' + $value;
												 }
					 						?>
											<div class="text grey"><?php echo $tag; ?></div>
										<?php	} 
					 						?>
					 				</div>
					 				<div  class="small-7 columns">
					 					<!---------------------------------------- COMMENT ------------------------------------------------->
										<div class="box-comment no-display" ></div>
										<!---------------------------------------- SHARE ---------------------------------------------------->
											<?php
											$paramsImage = getShareParameters('Image');
											?>
											<!-- AddThis Button BEGIN -->
											<div class="addthis_toolbox">
												<div class="hover_menu">
												        <div class="addthis_toolbox addthis_default_style addthis_32x32_style"
															addThis:url="http://www.socialmusicdiscovering.com/views/share.php?classType=Image"
															addThis:title="<?php echo $paramsImage['title']; ?>">
												        <a class="addthis_button_twitter"></a>
												        <a class="addthis_button_facebook"></a>
												        <a class="addthis_button_google_plusone_share"></a>
												       </div>	        
												</div>
											</div>
											<!-- AddThis Button END -->	
					 				</div>
					 			</div>			
					 		</div>
					 	</div>
					 	
					</div>
					
				<?php } ?>
				
			</div>	
		</div>
		
		<?php  } ?>	
	</div>
	
</div>
