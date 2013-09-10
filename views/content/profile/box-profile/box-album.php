<?php
/* box album
 * box chiamato tramite load con:
 * data: {user: objectId}, 
 * data-type: html,
 * type: POST o GET
 * 
 * box per tutti gli utenti
 */
 
$data = $_POST['data'];
$typeUser = $_POST['typeUser'];

$albumCounter = $data['albumCounter'];	



$id_photo1 = "photo1";
$id_photo2 = "photo2";
$id_photo3 = "photo3";
$id_photo4 = "photo4";
$id_photo5 = "photo5";
$id_photo6 = "photo6";
$id_photo7 = "photo7";
$id_photo8 = "photo8";
$id_photo9 = "photo9";
?>
<!----------------------------------- Photography -------------------------------------------------->
<div class="row" id='album'>
	<div class="large-12 columns ">
	<div class="row">
		<div  class="large-5 columns">
			<h3>Photography</h3>
		</div>	
		<div  class="large-7 columns align-right">
			<?php if($albumCounter > 4){ ?>
				<a class="icon-block _nextPage " onclick="royalSlideNext(this,'album')" style="top: 5px !important; margin-top: 15px !important">Next </a>
				<a class="icon-block _prevPage grey text" onclick="royalSlidePrev(this,'album')" style="top: 5px !important; margin-top: 15px !important; ">Previous </a>
	 		
			<?php } ?>
		</div>
	</div>	
	<!-------------------------------------- LIST ALBUM PHOTO -------------------------------->
	<div class="box" id="albumcover-list">
		<div class="" id="albumSlide">	
		<?php if($albumCounter > 0 ){ 
					$totalView = $albumCounter > 4 ? 4 : $albumCounter;
					for($i=0; $i<$totalView; $i=$i+2){
						
		?>
		<div  class="rsContent">	
		<div class="row">				
			<div class="small-6 columns box-coveralbum <?php echo $albumCounter.' ' .$i ?>">
				<img class="albumcover" src="../media/<?php echo $data['album' . $i]['thumbnailCover'] ?>" onError="this.src='../media/images/default/defaultAlbumcoverthumb.jpg'" onclick="albumcover('<?php echo $data['album' . $i]['objectId']; ?>','<?php echo $data['album' . ($i+1)]['imageCounter']; ?>')">  
				<div class="text white"><?php echo $data['album' . $i]['title']; ?></div>
				<div class="row">
					<div class="small-5 columns ">
						<a class="note grey"><?php echo $data['album' . $i]['imageCounter']; ?> Foto</a>								
					</div>
					<div class="small-7 columns propriety ">					
						<a class="icon-propriety _love orange"><?php echo $data['album' . $i]['counters']['loveCounter']; ?></a>
						<a class="icon-propriety _comment"><?php echo $data['album' . $i]['counters']['commentCounter']; ?></a>
						<a class="icon-propriety _shere"><?php echo $data['album' . $i]['counters']['shareCounter']; ?></a>	
					</div>		
				</div>
			</div>
			<?php if(isset($data['album' . ($i+1)]['objectId'])){ ?>
			<div class="small-6 columns box-coveralbum <?php echo $i+1 ?>">
				<img class="albumcover" src="../media/<?php echo $data['album' . ($i+1)]['thumbnailCover'] ?>" onError="this.src='../media/images/default/defaultAlbumcoverthumb.jpg'" onclick="albumcover('<?php echo $data['album' . ($i+1)]['objectId']; ?>','<?php echo $data['album' . ($i+1)]['imageCounter']; ?>')">  
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
	
	<!----------------------------------------- ALBUM PHOTO SINGLE ------------------------------>
	<?php for($i=0; $i<$albumCounter; $i++){ 
			
		?>
	<div class="box no-display" id="<?php echo $data['album' . $i]['objectId'];?>">
		<div class="row box-album">
			<div class="large-12 columns">					
				<a class="ico-label _back_page text white" onclick="albumSelectNext('<?php echo $data['album' . $i]['objectId']; ?>'>Back to Set</a>
			</div>
		</div>
		<ul class="small-block-grid-3 small-block-grid-2 ">			
		  <?php for($j=0; $j<$data['album' . $i]['imageCounter']; $j++){ ?>
		  <li><img data-reveal-id='<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>' data-reveal-ajax="./content/profile/box-profile/box-photoslide.php" class=" photo" src="../media/<?php $data['album' . $i]['image' . $j]['thumbnail']?>"></li>
			<?php } ?>
		</ul>		
		
		<div class="row album-single-propriety">
			 <div class="box-propriety">
				<div class="small-6 columns ">
					<a class="note grey " onclick="setCounter(this,'<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>','album')">Love</a>
								<a class="note grey" onclick="setCounter(this,'<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>','album')">Comment</a>
								<a class="note grey" onclick="setCounter(this,'<?php echo $data['album' . $i]['image' . $j]['objectId']; ?>','album')">Shere</a>
				</div>
				<div class="small-6 columns propriety ">					
					<a class="icon-propriety _unlove grey"><?php echo $data['album' . ($i+1)]['counters']['loveCounter']; ?></a>
					<a class="icon-propriety _comment"><?php echo $data['album' . ($i+1)]['counters']['commentCounter']; ?></a>
					<a class="icon-propriety _shere"><?php echo $data['album' . ($i+1)]['counters']['shareCounter']; ?></a>	
				</div>
			</div>		
		</div>	
	</div>
	<?php  } ?>
	</div>	
</div>