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
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'record.box.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$recordBox = new RecordBox();
$recordBox->initForPersonalPage($_POST['objectId']);
if (is_null($recordBox->error) || isset($_SESSION['currentUser'])) {
	$currentUser = $_SESSION['currentUser'];
	$records = $recordBox->recordArray;
	$recordCounter = count($records);
	?>
	<!----------------------------------------- PLAYER ALBUM ----------------------------------------------->
	<script>
		rsi_record = slideReview('recordSlide');
	</script>
	<div class="row" id="profile-Record">
		<div class="large-12 columns">
			<div class="row">
				<div  class="small-5 columns">
					<h3><?php echo $views['record']['TITLE'];?></h3>
				</div>	
				<div  class="small-7 columns align-right">
					<?php 
					if ($recordCounter > 4) {
						?>
						<div class="row">					
							<div  class="small-9 columns">
								<a class="slide-button-prev _prevPage" onclick="royalSlidePrev('record')"><?php echo $views['PREV'];?> </a>
							</div>
							<div  class="small-3 columns">
								<a class="slide-button-next _nextPage" onclick="royalSlideNext('record')"><?php echo $views['NEXT'];?> </a>
							</div>
						</div>
						<?php
					}
					?>
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
					<div class="rsContent">
					<?php
					foreach ($records as $key => $value) {
						$record_thumbnailCover = $value->getThumbnailCover();
						$record_objectId = $value->getObjectId();
						$record_title = $value->getTitle();
						$record_data = $value->getYear();
						$record_songCounter = $value->getSongCounter();
						
						$record_love = $value->getLoveCounter();
						$record_comment = $value->getCommentCounter();
						$record_share = $value->getShareCounter();
						$record_review = $value->getReviewCounter();
						
						if (in_array($currentUser->getObjectId(), $value->getLovers())) {
							$css_love = '_unlove grey';
							$text_love = $views['LOVE'];
						} else{
							$css_love = '_love orange';
							$text_love = $views['UNLOVE'];
						}
						?>
						<div id="<?php echo $record_objectId ?>" class="box-element <?php echo 'record_' . $record_objectId; ?>">
							<!------------------ CODICE ALBUM: $record_objectId - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
							<div class="row">
								<div class="small-4 columns">
									<img src="<?php echo $record_thumbnailCover ?>"  onerror="this.src='<?php echo DEFRECORDTHUMB;?>'" style="padding-bottom: 5px;">
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
											<div class="play_now"><a class="ico-label _play_white white" onclick="loadBoxRecordDetail('<?php echo $record_objectId ?>')"><?php echo $views['record']['PLAY'];?></a></div>
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
					}
					?>
					</div>
				</div>	
			</div>	
			
			<!---------------------------- ALBUM SINGOLO --------------------------------------------->
			<?php
			foreach ($records as $key => $value) {
				$recordSingle_thumbnailCover = $value->getThumbnailCover();
				$recordSingle_objectId = $value->getObjectId();
				$recordSingle_title = $value->getTitle();
				$recordSingle_data = $value->getYear();
				$recordSinle_songCounter = $value->getSongCounter();
				
				$recordSingle_love = $value->getLoveCounter();
				$recordSingle_comment = $value->getCommentCounter();
				$recordSingle_share = $value->getShareCounter();
				$recordSingle_review = $value->getReviewCounter();
				
				if (in_array($currentUser->getObjectId(), $value->getLovers())) {
					$recordSingle_css_love = '_unlove grey';
					$recordSingle_text_love = $views['LOVE'];
				} else{
					$recordSingle_css_love = '_love orange';
					$recordSingle_text_love = $views['UNLOVE'];
				}
				?>
				<div class="box no-display <?php echo $recordSingle_objectId ?>" >
					
					<div class="row" onclick="recordSelectNext('<?php echo $recordSingle_objectId ?>')">
						<div class="large-12 columns">					
							<a class="ico-label _back_page text white" onclick="loadBoxRecord()"><?php echo $views['BACK'];?></a>
						</div>
					</div>
					<div class="box-info-element">
						<div class="row">
							<div class="small-4 columns">
								<img src="../media/<?php echo $recordSingle_thumbnailCover ?>" onerror="this.src='../media/<?php echo DEFRECORDTHUMB;?>'" style="padding-bottom: 5px;">
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
						<!------------------------------- RECORD DETAIL ------------------------------------------>
						<div class="box-recordDetail"></div>
						<script type="text/javascript">
							function loadBoxRecordDetail(objectId) {
								var json_data = {};
								json_data.objectId = objectId;
								$.ajax({
									type: "POST",
									url: "content/profile/box/box-recordDetail.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito box-recordDetail');
										
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("."+objectId+" .box-recordDetail").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									//gestione visualizzazione box detail
									$( "#profile-Record #record-list" ).fadeOut( 100, function() {
							    		$('#profile-Record .'+objectId).fadeIn( 100 );
							    		addthis.init();
										addthis.toolbox(".addthis_toolbox");
									});							
									
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
						<!------------------------------- FINE RECORD DETAIL ------------------------------------->
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
						<!---------------------------------------- SHARE ------------------------------------------------->
						<!-- AddThis Button BEGIN -->
						<div class="addthis_toolbox">
							<div class="hover_menu hover_record">
									<div class="addthis_toolbox addthis_default_style"
										addThis:url="http://socialmusicdiscovering.com/tests/controllers/share/testShare2.controller.php?classe=Album"
										addThis:title="Titolo della pagina di un album">
									<a class="addthis_button_twitter"></a>
									<a class="addthis_button_facebook"></a>
									<a class="addthis_button_google_plusone_share"></a>
								   </div>	        
							</div>
						</div>
						<!-- AddThis Button END -->
					</div>	
				</div>
					
			<?php
			}
			?>
			<!---------------------------------------- comment ------------------------------------------------->
			<div class="box-comment no-display"></div>
		</div>
	</div>
	<?php
} else {
	echo 'Errore';
}