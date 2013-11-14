<?php
/* box per gli album musicali
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId},
 * data-type: html,
 * type: POST o GET
 *
 * box solo per jammer
 */

 if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
 
$data = $_POST['data'];
$typeUser = $_POST['typeUser'];
$recordCounter = $data['recordCounter'];
?>
<!----------------------------------------- PLAYER ALBUM ----------------------------------------------->
<div class="row" id="profile-Record">
	<div class="large-12 columns">
	<div class="row">
			<div  class="small-5 columns">
				<h3><?php echo $views['record']['TITLE'];?></h3>
			</div>	
			<div  class="small-7 columns align-right">
				<?php if($recordCounter > 4){ ?>
					<div class="row">					
						<div  class="small-9 columns">
							<a class="slide-button-prev _prevPage" onclick="royalSlidePrev('record')"><?php echo $views['PREV'];?> </a>
						</div>
						<div  class="small-3 columns">
							<a class="slide-button-next _nextPage" onclick="royalSlideNext('record')"><?php echo $views['NEXT'];?> </a>
						</div>
					</div>
		 		<?php } ?>
			</div>
		</div>	
	<!---------------------------- LISTA ALBUM --------------------------------------------->
	<div class="box" id="record-list">
		<div class="row">
			<div class="large-12 columns">
				<div class="text white" style="padding: 10px;"><?php echo $views['record']['LIST'];?></div>
			</div>
		</div>
		<div id="recordSlide" class="royalSlider rsMinW">
		<!---------------------------- PRIMO ALBUM ----------------------------------------------->
		<?php 
		$index = 0;
		for ($i=0; $i < $recordCounter ; $i++) {
			if($i % 3 == 0){
			?>
		<div class="rsContent">
			<?php
			
			for($j=0; $j<3;  $j++){
				if($index < $recordCounter){
					$record_thumbnailCover = $data['record'.$index]['thumbnailCover'];
					$record_objectId = $data['record'.$index]['objectId'];
					$record_title = $data['record'.$index]['title'];
					$record_data = $data['record'.$index]['year'];
					$record_songCounter = $data['record'.$index]['songCounter'];
					
					$record_love = $data['record'.$index]['counters']['loveCounter'];
					$record_comment = $data['record'.$index]['counters']['commentCounter'];
					$record_share = $data['record'.$index]['counters']['shareCounter'];
					$record_review = $data['record'.$index]['counters']['reviewCounter'];
					
					if($data['record' . $index]['showLove'] == 'true'){
						$css_love = '_unlove grey';
						$text_love = $views['LOVE'];
					}
					elseif($data['record' . $index]['showLove'] == 'false'){
						$css_love = '_love orange';
						$text_love = $views['UNLOVE'];
					}			
			
		 ?>
			<div id="<?php echo $record_objectId ?>" class="box-element <?php echo 'record'.$index ?>"><!------------------ CODICE ALBUM: $record_objectId - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
			
				<div class="row">
					<div class="small-4 columns">
						<img src="../media/<?php echo $record_thumbnailCover ?>"  onerror="this.src='../media/<?php echo $default_img['DEFRECORDTHUMB'];?>'" style="padding-bottom: 5px;">
					</div>
					<div class="small-8 columns">						
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white breakOffTest" ><?php echo $record_title ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="note grey breakOffTest"><?php echo $views['record']['RECORDED'];?> <?php echo $record_data ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="play_now"><a class="ico-label _play_white white" onclick="recordSelectSingle('<?php echo $record_objectId ?>')"><?php echo $views['record']['PLAY'];?></a></div>
							</div>
						</div>
						
						
					</div>
				</div>				
				<div class="row propriety album-single-propriety">
					<div class="large-12 colums">
						<a class="icon-propriety <?php echo $css_love ?>"><?php echo $record_love ?></a>
						<a class="icon-propriety _comment" ><?php echo $record_comment ?></a>
						<a class="icon-propriety _share" ><?php echo $record_share ?></a>
						<a class="icon-propriety _review"><?php echo $record_review ?></a>
					</div>
				</div>
			</div>			
			<?php 
			$index++;
			}} ?>
			
		</div>
		
		<?php }} 
		
		?>
		</div>	
	</div>	
	
	<!---------------------------- ALBUM SINGOLO --------------------------------------------->
	<?php for($i=0; $i<$recordCounter;  $i++){ 
			$recordSingle_thumbnailCover = $data['record'.$i]['thumbnailCover'];
			$recordSingle_objectId = $data['record'.$i]['objectId'];
			$recordSingle_title = $data['record'.$i]['title'];
			$recordSingle_data = $data['record'.$i]['year'];
			$recordSinle_songCounter= $data['record'.$i]['songCounter'];
			$recordSingle_detail = $data['record'.$i]['recordDetail']['tracklist'];
			$recordSingle_love = $data['record'.$i]['counters']['loveCounter'];
			$recordSingle_comment = $data['record'.$i]['counters']['commentCounter'];
			$recordSingle_share = $data['record'.$i]['counters']['shareCounter'];
			$recordSingle_review = $data['record'.$i]['counters']['reviewCounter'];
			if($data['record'.$i]['counters']['showLove'] == 'true'){
				$recordSingle_css_love = '_unlove grey';
				$recordSingle_text_love = $views['LOVE'];
			}
			else{
				$recordSingle_css_love = '_love orange';
				$recordSingle_text_love = $views['UNLOVE'];
			}
				
		?>
	<div class="box no-display <?php echo $recordSingle_objectId ?>" >
		
		<div class="row" onclick="recordSelectNext('<?php echo $recordSingle_objectId ?>')">
			<div class="large-12 columns">					
				<a class="ico-label _back_page text white"><?php echo $views['BACK'];?></a>
			</div>
		</div>
		<div class="box-info-element">
			<div class="row">
				<div class="small-4 columns">
					<img src="../media/<?php echo $recordSingle_thumbnailCover ?>" onerror="this.src='../media/<?php echo $default_img['DEFRECORDTHUMB'];?>'" style="padding-bottom: 5px;">
				</div>
				<div class="small-8 columns">						
					<div class="row">
						<div class="large-12 colums">
							<div class="sottotitle white breakOffTest"><?php echo $recordSingle_title ?></div>
						</div>
					</div>				
					<div class="row">
						<div class="large-12 colums">
							<div class="note grey album-player-data"><?php echo $views['record']['RECORDED'];?> <?php echo $recordSingle_data ?></div>
						</div>
					</div>
					
					
				</div>
			</div>
			<?php if(count($recordSingle_detail) > 0 && $recordSingle_detail != $boxes['NOTRACK']){
					foreach ($recordSingle_detail as $key => $value) {
						
					
			?>
			<div class="row track " id="<?php echo $value['objectId'] ?>"> <!------------------ CODICE TRACCIA: track01  ------------------------------------>
				<div class="small-12 columns ">
				
					<div class="row">
						<div class="small-9 columns ">					
							<a class="ico-label _play-large text breakOffTest"><?php echo $key+1 ?>. <?php echo $value['title'] ?></a>
								
						</div>
						<div class="small-3 columns track-propriety align-right" style="padding-right: 15px;">					
							<a class="icon-propriety _menu-small note orange "> <?php echo $views['record']['ADDPLAYLIST'];?></a>
																		
						</div>
						<div class="small-3 columns track-nopropriety align-right" style="padding-right: 15px;">
							<a class="icon-propriety "><?php echo $value['duration'] ?></a>	
						</div>		
					</div>
					<div class="row track-propriety" >
						<div class="box-propriety album-single-propriety">
							<div class="small-5 columns ">
								<a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $text_love;?></a>
								<a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $views['SHARE'];?></a>	
							</div>
							<div class="small-5 columns propriety ">					
								<a class="icon-propriety <?php echo $css_love ?>" ><?php echo $value['counters']['loveCounter'] ?></a>
								<a class="icon-propriety _share" ><?php echo $value['counters']['shareCounter'] ?></a>			
							</div>
						</div>		
					</div>
				</div>
			</div>
			<?php }} ?>
			<div class="row album-single-propriety">
				<div class="box-propriety">
					<div class="small-6 columns ">
						<a class="note white" onclick="setCounter(this, '<?php echo $recordSingle_objectId ?>','Record')"><?php echo $recordSingle_text_love ;?></a>
						<a class="note white" onclick="setCounter(this, '<?php echo $recordSingle_objectId ?>','Record')"><?php echo $views['COMM'];?></a>
						<a class="note white" onclick="share(this, '<?php echo $recordSingle_objectId ?>','profile-Record')"><?php echo $views['SHARE'];?></a>
						<a class="note white" onclick="setCounter(this, '<?php echo $recordSingle_objectId ?>','Record')"><?php echo $views['REVIEW'];?></a>	
					</div>
					<div class="small-6 columns propriety ">					
						<a class="icon-propriety <?php echo $recordSingle_css_love ?>" ><?php echo $recordSingle_love ?></a>
						<a class="icon-propriety _comment" ><?php echo $recordSingle_comment ?></a>
						<a class="icon-propriety _share" ><?php echo $recordSingle_share ?></a>
						<a class="icon-propriety _review"><?php echo $recordSingle_review ?></a>
					</div>	
				</div>		
			</div>
		</div>	
	</div>
			
	<?php } ?>
	
	<!---------------------------------------- comment ------------------------------------------------->
	<div class="box-comment no-display"></div>
	<!---------------------------------------- SHARE ---------------------------------------------------->
	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_default_style"
	addThis:url="http://socialmusicdiscovering.com/tests/controllers/share/testShare2.controller.php?classe=Album"
	addThis:title="Titolo della pagina di un album">
	   <a class="addthis_button_facebook"></a>
	   <a class="addthis_button_twitter"></a>
	   <a class="addthis_button_google_plusone_share"></a>
	</div>
	<!-- AddThis Button END -->
	</div>
</div>
	