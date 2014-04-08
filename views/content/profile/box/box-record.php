<?php
/* box per gli album musicali
 * box chiamato tramite ajax con:
 * data: {currentUser: id},
 * data-type: html,
 * type: POST o GET
 *
 * box solo per jammer
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'log.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'record.box.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'select.service.php';

if (session_id() == '')
    session_start();

$recordBox = new RecordBox();
$recordBox->init($_POST['id'],9,0);

if (is_null($recordBox->error)) {
    if (isset($_SESSION['id']))
	$currentUserId = $_SESSION['id'];
    $records = $recordBox->recordArray;
    $recordCounter = count($records);

    $fileManagerService = new FileManagerService();
    ?>
    <!----------------------------------------- PLAYER ALBUM ----------------------------------------------->
    <script>
        rsi_record = slideReview('recordSlide');
    </script>
    <div class="row" id="profile-Record">
        <div class="large-12 columns">
    	<div class="row">
    	    <div  class="small-5 columns">
    		<h3><?php echo $views['record']['title']; ?></h3>
    	    </div>	
    	    <div  class="small-7 columns align-right">
		    <?php
		    if ($recordCounter > 3) {
			?>
			<div class="row">					
			    <div  class="small-9 columns">
				<a class="slide-button-prev _prevPage slide-button-prev-disabled" onclick="royalSlidePrev(this, 'record')"><?php echo $views['prev']; ?> </a>
			    </div>
			    <div  class="small-3 columns">
				<a class="slide-button-next _nextPage" onclick="royalSlideNext(this, 'record')"><?php echo $views['next']; ?> </a>
			    </div>
			</div>
			<?php
		    }
		    ?>
    	    </div>
    	</div>	
    	<!---------------------------- LISTA RECORD --------------------------------------------->
    	<div class="box" id="record-list">

		<?php
		if ($recordCounter > 0) {
		    $index = 0;
		    ?>
		    <div class="row">
			<div class="large-12 columns" style="border-bottom: 1px solid #303030;margin-bottom: 10px;">
			    <div class="text white" style="padding: 10px;"><?php echo $views['record']['list']; ?></div>
			</div>
		    </div>
		    <div id="recordSlide" class="royalSlider rsMinW">
			<!---------------------------- PRIMO RECORD ----------------------------------------------->					
			<?php
			foreach ($records as $key => $value) {
			    if ($index % 3 == 0) {
				?><div class="rsContent">	<?php
			    }
			    $record_thumbnail = $value->getThumbnail();
			    $record_id = $value->getId();
			    $record_title = $value->getTitle();
			    $record_data = $value->getYear();
			    $record_songCounter = $value->getSongcounter();
			    $record_love = $value->getLovecounter();
			    $record_comment = $value->getCommentcounter();
			    $record_share = $value->getSharecounter();
			    $record_review = $value->getReviewcounter();
			     $connectionService = new ConnectionService();
			    if (existsRelation($connectionService,'user', $currentUserId, 'record', $record_id, 'LOVE')) {
					$css_love = '_love orange';
					$text_love = $views['unlove'];
			    } else {
					$css_love = '_unlove grey';
					$text_love = $views['love'];
			    }
			    $textData = '';
			    if (!is_null($record_data) && $record_data != '') {
				$textData = $views['record']['recorded'];
			    }
			    ?>
	    		    <div id="<?php echo $record_id ?>" class="box-element <?php echo 'record_' . $record_id; ?>" >
	    			<!------------------ CODICE ALBUM: $record_id - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
	    			<div class="row">
	    			    <div class="small-4 columns">
	    				<a href="record.php?record=<?php echo $record_id ?>">
	    				    <img src="<?php echo $fileManagerService->getRecordPhotoPath($_POST['id'], $record_thumbnail); ?>"  onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" style="padding-bottom: 5px;" alt="<?php echo $record_title ?>">
	    				</a>
	    			    </div>
	    			    <div class="small-8 columns" style="height: 134px;">						
	    				<div class="row">
	    				    <div class="large-12 columns">
	    					<a href="record.php?record=<?php echo $record_id ?>">
	    					    <div class="sottotitle white breakOffTest" ><?php echo $record_title ?></div>
	    					</a>
	    				    </div>
	    				</div>
	    				<div class="row">
	    				    <div class="large-12 columns">
	    					<div class="note grey breakOffTest"><?php echo $textData; ?> <?php echo $record_data ?></div>
	    				    </div>
	    				</div>
	    				<div class="row">
	    				    <div class="small-5 columns" onclick="loadBoxRecordDetail('<?php echo $_POST['id'] ?>', '<?php echo $record_id ?>', '<?php echo $pathCoverRecord . $record_thumbnail ?>')">
	    					<div class="play_now"><a class="ico-label _play_white white" ><?php echo $views['record']['play']; ?></a></div>
	    				    </div>
	    				    <div class="small-7 columns" style="position: absolute;bottom: 0px;right: 0px;">
	    					<div class="row propriety">
	    					    <div class="large-12 columns">
	    						<a class="icon-propriety <?php echo $css_love ?>"><?php echo $record_love ?></a>
	    						<a class="icon-propriety _comment" ><?php echo $record_comment ?></a>
	    						<a class="icon-propriety _share" ><?php echo $record_share ?></a>
	    						<a class="icon-propriety _review"><?php echo $record_review ?></a>
	    					    </div>
	    					</div>
	    				    </div>	
	    				</div>								
	    			    </div>

	    			</div>
	    		    </div>			
				<?php if (($index + 1) % 3 == 0 || $recordCounter == ($index + 1)) { ?> </div> <?php
			    }
			    $index++;
			}
			?>
		    </div>

		<?php } else { ?>
		    <div class="row" style="padding-left: 20px !important; padding-top: 20px !important;}">
			<div  class="large-12 columns"><p class="grey"><?php echo $views['record']['nodata'] ?></p></div>
		    </div>

		<?php } ?>		
    	</div>	

    	<!---------------------------- RECORD SINGOLO --------------------------------------------->
	    <?php
	    foreach ($records as $key => $value) {
		$recordSingle_thumbnailCover = $value->getThumbnail();
		$recordSingle_id = $value->getId();
		$recordSingle_title = $value->getTitle();
		$recordSingle_data = $value->getYear();
		$recordSinle_songCounter = $value->getSongcounter();
		$recordSingle_fromUser_id = $value->getFromuser();
		$recordSingle_love = $value->getLovecounter();
		$recordSingle_comment = $value->getCommentcounter();
		$recordSingle_share = $value->getSharecounter();
		$recordSingle_review = $value->getReviewcounter();
		$connectionService = new ConnectionService();		
		if (existsRelation($connectionService,'user', $currentUserId, 'record', $recordSingle_id, 'LOVE')) {
		    $recordSingle_css_love = '_love orange';
		    $recordSingle_text_love = $views['unlove'];
		} else {
		    $recordSingle_css_love = '_unlove grey';
		    $recordSingle_text_love = $views['love'];
		}
		$textData = '';
		if (!is_null($recordSingle_data) && $recordSingle_data != '') {
		    $textData = $views['record']['recorded'];
		}
		?>
		<div class="box no-display <?php echo $recordSingle_id ?>" >
		    <div class="row" onclick="recordSelectNext('<?php echo $recordSingle_id ?>')">
			<div class="large-12 columns" style="border-bottom: 1px solid #303030;padding-bottom: 5px;">					
			    <a class="ico-label _back_page text white" onclick="loadBoxRecord()"><?php echo $views['next']; ?></a>
			</div>
		    </div>
		    <div class="box-info-element">
			<div class="row">
			    <div class="small-4 columns">
				<a href="record.php?record=<?php echo $recordSingle_id; ?>">
				    <img src="<?php echo $fileManagerService->getRecordPhotoPath($_POST['id'], $recordSingle_thumbnailCover); ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" style="padding-bottom: 5px;" alt="<?php echo $recordSingle_title ?>">
				</a>
			    </div>
			    <div class="small-8 columns">						
				<div class="row">
				    <div class="large-12 colums">
					<a href="record.php?record=<?php echo $recordSingle_id ?>">
					    <div class="sottotitle white breakOffTest"><?php echo $recordSingle_title ?></div>
					</a>
				    </div>
				</div>				
				<div class="row">
				    <div class="large-12 colums">
					<div class="note grey album-player-data"><?php echo $textData; ?> <?php echo $recordSingle_data ?></div>
				    </div>
				</div>


			    </div>
			</div>
			<!------------------------------- RECORD DETAIL ------------------------------------------>
			<div class="box-recordDetail"></div>
			<script type="text/javascript">
			function loadBoxRecordDetail(userId, id, pathCover) {
			    var json_data = {};
			    json_data.userId = userId;
			    json_data.id = id;
			    json_data.username = '<?php echo $_POST['username'] ?>';
			    json_data.pathCover = pathCover;
			    $.ajax({
				type: "POST",
				url: "content/profile/box/box-recordDetail.php",
				data: json_data,
				beforeSend: function(xhr) {
				    //spinner.show();
				    $("#profile-Record #record-list").fadeOut(100, function() {
					$('#profile-Record .' + id).fadeIn(100);
					goSpinnerBox("." + id + " .box-recordDetail", '');
				    });
				    console.log('Sono partito box-recordDetail');
		
				}
			    }).done(function(message, status, xhr) {
		
				$("." + id + " .box-recordDetail").html(message);
				code = xhr.status;
				//console.log("Code: " + code + " | Message: " + message);
				//gestione visualizzazione box detail
				addthis.init();
				addthis.toolbox(".addthis_toolbox");
				rsi_record.updateSliderSize(true);
		
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
			<?php /* 
			<!------------------------------- FINE RECORD DETAIL ------------------------------------->
			<div class="row album-single-propriety">
			    <div class="box-propriety">
				<div class="small-6 columns ">
				    <a class="note white" onclick="love(this, 'Record', '<?php echo $recordSingle_id; ?>', '<?php echo $recordSingle_fromUser_id; ?>')"><?php echo $recordSingle_text_love; ?></a>
				    <a class="note white" onclick="loadBoxOpinion('<?php echo $recordSingle_id; ?>', '<?php echo $recordSingle_fromUser_id; ?>', 'Record', '.<?php echo $recordSingle_id; ?> .box-opinion', 10, 0)"><?php echo $views['comm']; ?></a>
				    <a class="note white" onclick="share(this, '<?php echo $recordSingle_id ?>', 'profile-Record')"><?php echo $views['share']; ?></a>
				    <a class="note white" onclick="location.href = 'uploadReview.php?rewiewId=<?php echo $recordSingle_id ?>&type=Record'"><?php echo $views['review']; ?></a>	
				</div>
				<div class="small-6 columns propriety ">					
				    <a class="icon-propriety <?php echo $recordSingle_css_love ?>" ><?php echo $recordSingle_love ?></a>
				    <a class="icon-propriety _comment" ><?php echo $recordSingle_comment ?></a>
				    <a class="icon-propriety _share" ><?php echo $recordSingle_share ?></a>
				    <a class="icon-propriety _review"><?php echo $recordSingle_review ?></a>
				</div>	
			    </div>		
			</div> */ ?>
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
		    <!---------------------------------------- comment ------------------------------------------------->
		    <div class="box-opinion no-display" style="margin-bottom: 0px !important;"></div>	
		</div>

		<?php
	    }
	    ?>

        </div>
    </div>
    <?php
} else {
    echo 'Errore';
}