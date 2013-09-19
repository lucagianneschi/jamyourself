<?php

/* 
 * box album
 * box chiamato tramite load con:
 * data: {data: data, typeUser: objectId}
 * 
 * box per tutti gli utenti
 */
 
$data = $_POST['data'];
$typeUser = $_POST['typeUser'];

$albumCounter = $data['albumCounter'];	


?>
<!----------------------------------- Photography -------------------------------------------------->
<div class="row" id='profile-album'>
	<div class="large-12 columns ">
		<div class="row">
			<div  class="large-5 columns">
				<h3>Photography</h3>
			</div>	
			<div  class="large-7 columns align-right">
				<?php if($albumCounter > 4){ ?>
					<div class="row">					
						<div  class="small-6 columns">
							<a class="icon-block _prevPage grey text" onclick="royalSlidePrev(this,'album')" style="top: 5px !important; margin-top: 15px !important; ">Previous </a>
						</div>
						<div  class="small-6 columns">
							<a class="icon-block _nextPage " id="profile-album-next" onclick="royalSlideNext(this,'album')" style="top: 5px !important; margin-top: 15px !important">Next </a>
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
						<?php if(isset($data['album' . ($i)]['objectId'])){ ?>				
						<div class="small-6 columns box-coveralbum <?php echo $data['album' . ($i)]['objectId'] ?>"  onclick="albumSelectSingle('<?php echo $data['album' . $i]['objectId']; ?>',<?php echo $data['album' . $i]['imageCounter']; ?>)">
							<img class="albumcover" src="../media/<?php echo $data['album' . $i]['thumbnailCover'] ?>" onError="this.src='../media/images/default/defaultAlbumcoverthumb.jpg'">  
							<div class="text white"><?php echo $data['album' . $i]['title']; ?></div>
							<div class="row">
								<div class="small-5 columns ">
									<a class="note grey"><?php echo $data['album' . $i]['imageCounter']; ?> Foto</a>								
								</div>
								<div class="small-7 columns propriety ">					
									<a class="icon-propriety _unlove grey"><?php echo $data['album' . $i]['counters']['loveCounter']; ?></a>
									<a class="icon-propriety _comment"><?php echo $data['album' . $i]['counters']['commentCounter']; ?></a>
									<a class="icon-propriety _shere"><?php echo $data['album' . $i]['counters']['shareCounter']; ?></a>	
								</div>		
							</div>
						</div>
						<?php }
						if(isset($data['album' . ($i+1)]['objectId'])){ ?>
						<div class="small-6 columns box-coveralbum <?php echo $data['album' . ($i+1)]['objectId']?>"  onclick="albumSelectSingle('<?php echo $data['album' . ($i+1)]['objectId']; ?>',<?php echo $data['album' . ($i+1)]['imageCounter']; ?>)">
							<img class="albumcover" src="../media/<?php echo $data['album' . ($i+1)]['thumbnailCover'] ?>" onError="this.src='../media/images/default/defaultAlbumcoverthumb.jpg'">  
							<div class="text white"><?php echo $data['album' . ($i+1)]['title']; ?></div>
							<div class="row">
								<div class="small-5 columns ">
									<a class="note grey"><?php echo $data['album' . ($i+1)]['imageCounter']; ?> Foto</a>								
								</div>
								<div class="small-7 columns propriety ">					
									<a class="icon-propriety _unlove grey"><?php echo $data['album' . ($i+1)]['counters']['loveCounter']; ?></a>
									<a class="icon-propriety _comment"><?php echo $data['album' . ($i+1)]['counters']['commentCounter']; ?></a>
									<a class="icon-propriety _shere"><?php echo $data['album' . ($i+1)]['counters']['shareCounter']; ?></a>	
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
									<p class="grey">There are no Photo</p>
								</div>
						</div>
					<?php } ?>	
					
				</div>
			</div>
		</div>
	<!----------------------------------------- ALBUM PHOTO SINGLE ------------------------------>
	<?php for($i=0; $i<$albumCounter; $i++){ 
			
		?>
		<div class="box no-display box-singleAlbum" id="<?php echo $data['album' . $i]['objectId'];?>">
			<div class="row box-album">
				<div class="large-12 columns">					
					<a class="ico-label _back_page text white" onclick="albumSelectNext('<?php echo $data['album' . $i]['objectId']; ?>')">Back to Set</a>
				</div>
			</div>
			<div class="row" style="padding-bottom: 10px;">
				<div  class="large-12 columns"><div class="line"></div></div>
			</div>
			<ul class="small-block-grid-3 small-block-grid-2 ">			
			  <?php for($j=0; $j<$data['album' . $i]['imageCounter']; $j++){ ?>
			  <li><a class="photo-colorbox-group" href="#<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>"><img class="photo" src="../media/<?php $data['album' . $i]['image' . $j]['thumbnail']?>" onerror="this.src='../media/images/default/defaultImage.jpg'"></a></li>
				<?php } ?>
			</ul>		
			
			<div class="row album-single-propriety">
				 <div class="box-propriety">
					<div class="small-6 columns ">
						<a class="note grey " onclick="setCounter(this,'<?php echo $data['album' . $i]['objectId']; ?>','album')">Love</a>
						<a class="note grey" onclick="setCounter(this,'<?php echo $data['album' . $i]['objectId']; ?>','album')">Comment</a>
						<a class="note grey" onclick="setCounter(this,'<?php echo $data['album' . $i]['objectId']; ?>','album')">Shere</a>
					</div>
					<div class="small-6 columns propriety ">					
						<a class="icon-propriety _unlove grey"><?php echo $data['album' . $i]['counters']['loveCounter']; ?></a>
						<a class="icon-propriety _comment"><?php echo $data['album' . $i]['counters']['commentCounter']; ?></a>
						<a class="icon-propriety _shere"><?php echo $data['album' . $i]['counters']['shareCounter']; ?></a>	
					</div>
				</div>		
			</div>	
		</div>
		<div class="row no-display">
			<div class="large-12 columns">
				 <?php for($j=0; $j<$data['album' . $i]['imageCounter']; $j++){ ?>				 	
					<div id="<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>" class="lightbox-photo">
						<div class="row ">
							<div class="large-12 columns lightbox-photo-box" >
								<img src="../media/images/image/<?php echo $data['album' . $i]['image' . $j]['filePath']; ?>" onerror="this.src='../media/images/default/defaultImage.jpg'"/>
					 			<div class="row">
					 				<div  class="large-12 columns" style="padding-top: 15px;padding-bottom: 15px"><div class="line"></div></div>
					 			</div>
					 			<div class="row">
					 				<div  class="small-6 columns">
					 					<a class="note grey " onclick="setCounter(this,'<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>','album')">Love</a>
										<a class="note grey" onclick="setCounter(this,'<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>','album')">Comment</a>
										<a class="note grey" onclick="setCounter(this,'<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>','album')">Shere</a>
					 				</div>
					 				<div  class="small-6 columns propriety">
					 					<a class="icon-propriety _unlove grey"><?php echo $data['album' . $i]['image' . $j]['counters']['loveCounter']; ?></a>
										<a class="icon-propriety _comment"><?php echo $data['album' . $i]['image' . $j]['counters']['commentCounter']; ?></a>
										<a class="icon-propriety _shere"><?php echo $data['album' . $i]['image' . $j]['counters']['shareCounter']; ?></a>	
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
