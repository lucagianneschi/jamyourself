<?php
/* box per gli dettagli album record
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
require_once BOXES_DIR .'record.box.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'select.service.php';
require_once CLASSES_DIR . 'user.class.php';
if (session_id() == '')
    session_start();
$recordId = $_POST['id'];
$recordBox = new RecordBox();
$recordBox->initForTracklist($recordId);
$songs = $recordBox->tracklist;
$pathCover = $_POST['pathCover'];
$userId = $_POST['userId'];
$fileManagerService = new FileManagerService();
//debug("", 'debug.txt', json_encode($songs));

$indice = 0;
if (is_array($songs) && count($songs) > 0) {
    foreach ($songs as $key => $value) {
    $connectionService = new ConnectionService();		
	if (existsRelation($connectionService,'user', $_SESSION['id'], 'song', $value->getId(), 'loved')) {
	    $track_css_love = '_love orange';
	    $track_text_love = $views['unlove'];
	} else {
	    $track_css_love = '_unlove grey';
	    $track_text_love = $views['love'];
	}
	$css_addPlayList = "";
	$css_removePlayList = "";
	if (is_array($_SESSION['playlist']['songs']) && in_array($value->getId(), $_SESSION['playlist']['songs'])) {
	    $css_addPlayList = 'no-display';
	} else {
	    $css_removePlayList = 'no-display';
	}
	$song = json_encode(array(
	    'id' => $value->getId(),
	    'title' => $value->getTitle(),
	    'artist' => $_POST['username'],
	    'mp3' => $fileManagerService->getSongURL($userId, $value->getPath()),
	    'love' => $value->getLovecounter(),
	    'share' => $value->getSharecounter(),
	    'pathCover' => $fileManagerService->getPhotoPath($userId, $_POST['pathCover'])
	));

	if ($value->getDuration() >= 3600)
	    $hoursminsandsecs = date('H:i:s', $value->getDuration());
	else
	    $hoursminsandsecs = date('i:s', $value->getDuration());
	?>
	<div class="row  track" id="<?php echo $value->getId(); ?>">
	    <!------------------ DETTAGLIO TRACCIA ------------------------------------>			
	    <div class="small-12 columns ">	

		<div class="row">
		    <div class="small-9 columns">					
			<a class="ico-label _play-large text breakOffTest jpPlay" onclick="playSong('<?php echo $value->getId(); ?>', '<?php echo $pathCover ?>')"><?php echo $indice + 1; ?>. <span class="songTitle"><?php echo $value->getTitle(); ?></span></a>
			<input type="hidden" name="song" value="<?php echo $fileManagerService->getSongURL($userId, $value->getPath()); ?>" />
		    </div>					
		    <div class="small-3 columns track-propriety align-right" style="padding-right: 15px;">					
			<a class="icon-propriety _menu-small note orange <?php echo $css_addPlayList ?>" onclick='playlist(this, "add",<?php echo $song ?>)'> <?php echo $views['record']['addplaylist']; ?></a>
			<a class="icon-propriety _remove-small note orange <?php echo $css_removePlayList ?>" onclick='playlist(this, "remove",<?php echo $song; ?>)'> <?php echo $views['record']['removeplaylist']; ?></a>											
		    </div>
		    <div class="small-3 columns track-nopropriety align-right" style="padding-right: 15px;">
			<a class="icon-propriety "><?php echo $hoursminsandsecs ?></a>	
		    </div>		
		</div>
		<div class="row track-propriety" >
		    <div class="box-propriety album-single-propriety">
			<div class="small-6 columns ">
			    <a class="note white" onclick="love(this, 'Song', '<?php echo $value->getId(); ?>', '<?php echo $value->getFromuser(); ?>')"><?php echo $track_text_love; ?></a>
			    <!--a class="note white" onclick="share()"><?php echo $views['share']; ?></a-->
			</div>
			<div class="small-6 columns propriety ">					
			    <a class="icon-propriety <?php echo $track_css_love ?>" ><?php echo $value->getLovecounter(); ?></a>
			    <!--a class="icon-propriety _share" ><?php echo $value->getSharecounter(); ?></a-->
			</div>
		    </div>		
		</div>
		<!---------------------------------------- SHARE ------------------------------------------------->
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox">
		    <div class="hover_menu">
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
	$indice++;
    }
}else {
    ?>
    <div class="row" style="padding-left: 20px !important; padding-top: 20px !important;}">
        <div  class="large-12 columns"><p class="grey"><?php echo $views['recordDetail']['nodata'] ?></p></div>
    </div>
    <?php
}
?>