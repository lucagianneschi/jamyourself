<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'playlist.box.php';

//session_start();

$playlist = new PlaylistBox();
$playlist->init();

$currentUser = $_SESSION['currentUser'];

#TODO
//decidere come gestire i possibili errori
if (count($playlist->tracklist) == 0 && is_null($playlist->error)) {
   // echo 'Playlist vuota';
} elseif (!is_null($playlist->error)) {
    echo $playlist->error;
} 
    $_SESSION['playlist']['objectId'] = $playlist->objectId;
    $_SESSION['playlist']['songs'] = array();
    ?>
    
    <div class="row">
        <div  class="small-6 columns hide-for-small">
    	<h3><?php echo $playlist->name; ?></h3>
    	<div class="row">
    	    <div  class="large-6 columns">
    			<!--div class="text white" style="margin-bottom: 15px;"><?php echo $views['header']['profile']['TITLE'] ?></div-->    		
    	    </div>	
    	</div>
        </div>	
    </div>

	
    <!--div id="jp_container_N" class="jp-video jp-video-270p">
        <div class="jp-type-playlist">
    	<div id="jquery_jplayer_N" class="jp-jplayer"></div>
    	<div class="jp-gui">
    	    <div class="jp-video-play">
    		<a href="javascript:;" class="jp-video-play-icon" tabindex="1"><?php echo $views['header']['player']['play']; ?></a>
    	    </div>
    	    <div class="jp-interface">
    		<div class="jp-progress">
    		    <div class="jp-seek-bar">
    			<div class="jp-play-bar"></div>
    		    </div>
    		</div>
    		<div class="jp-current-time"></div>
    		<div class="jp-duration"></div>
    		<div class="jp-title">
    		    <ul>
    			<li></li>
    		    </ul>
    		</div>
    		<div class="jp-controls-holder">
    		    <ul class="jp-controls">
    			<li><a href="javascript:;" class="jp-previous" tabindex="1"><?php echo $views['header']['player']['previous']; ?></a></li>
    			<li><a href="javascript:;" class="jp-play" tabindex="1"><?php echo $views['header']['player']['play']; ?></a></li>
    			<li><a href="javascript:;" class="jp-pause" tabindex="1"><?php echo $views['header']['player']['pause']; ?></a></li>
    			<li><a href="javascript:;" class="jp-next" tabindex="1"><?php echo $views['header']['player']['next']; ?></a></li>
    			<li><a href="javascript:;" class="jp-stop" tabindex="1"><?php echo $views['header']['player']['stop']; ?></a></li>
    			<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><?php echo $views['header']['player']['mute']; ?></a></li>
    			<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><?php echo $views['header']['player']['unmute']; ?></a></li>
    			<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume"><?php echo $views['header']['player']['max volume']; ?></a></li>
    		    </ul>
    		    <div class="jp-volume-bar">
    			<div class="jp-volume-bar-value"></div>
    		    </div>
    		    <ul class="jp-toggles">								
    			<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle"><?php echo $views['header']['player']['shuffle']; ?></a></li>
    			<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off"><?php echo $views['header']['player']['shuffle off']; ?></a></li>
    			<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><?php echo $views['header']['player']['repeat']; ?></a></li>
    			<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><?php echo $views['header']['player']['repeat off']; ?></a></li>
    		    </ul>
    		</div>
    	    </div>
    	</div>
    	<div class="jp-playlist">
    	    <ul>

    		
    		<li></li>
    	    </ul>
    	</div>
    	<div class="jp-no-solution">
    	    <span><?php echo $views['header']['player']['update']; ?></span>
	    <?php echo $views['header']['player']['update_message']; ?>
    	</div>
        </div>
    </div-->
    <!-- The method Playlist.displayPlaylist() uses this unordered list -->

    <div class="row">
        <div  class="small-12 columns">					
	    <?php
	    if (count($playlist->tracklist) > 0) {
		$index = 0;
		foreach ($playlist->tracklist as $key => $value) {
		    $objectId = $value->getObjectId();
		    $author_name = $value->getFromUser()->getUsername();
		    $author_objectId = $value->getFromUser()->getObjectId();
		   
		    $title = $value->getTitle();
		    $loveCounter = $value->getLoveCounter();
		    $shareCounter = $value->getShareCounter();
			$recordObjectId = $value->getRecord()->getObjectId();
			$pathCover = USERS_DIR . $author_objectId . '/images/recordcoverthumb/';
			$pathSong= USERS_DIR . $author_objectId . '/songs/'.$recordObjectId.'/';
		    array_push($_SESSION['playlist']['songs'], $objectId);
			if ($value->getDuration() >= 3600)
			    $hoursminsandsecs = date('H:i:s', $value->getDuration());
			else
			    $hoursminsandsecs = date('i:s', $value->getDuration());
			$song = json_encode(array(
			    'objectId' => $value->getObjectId(),
			    'title' => $value->getTitle(),
			    'artist' => $author_name,
			    'mp3' => $pathSong.$value->getFilePath(),
			    'love' => $value->getLoveCounter(),
			    'share' => $value->getShareCounter(),
			    'pathCover' => $pathCover.$value->getRecord()->getThumbnailCover()
			));
			if (isset($_SESSION['currentUser']) && is_array($value->getLovers()) && in_array($currentUser->getObjectId(), $value->getLovers())) {
			    $track_css_love = '_love orange';
			    $track_text_love = $views['UNLOVE'];
			} else {
			    $track_css_love = '_unlove grey';
			    $track_text_love = $views['LOVE'];
			}
			
			
		    ?>				
	    	<script>
	    	    $(document).ready(function() {
		    		myPlaylist.add({
		    		    objectId: "<?php echo $objectId ?>",
		    		    title: "<?php echo $title ?>",
		    		    artist: "<?php echo $author_name ?>",
		    		    mp3: "<?php echo $pathSong.$value->getFilePath() ?>" //ci va l'url dell'mp3
		    		});
	    	    });
	    	</script>						
	    	<div class="row" id="pl_<?php echo $objectId ?>"> 
		        <div class="small-12 columns">
			        <div class="track">
				        <div class="row">
						    <div class="small-9 columns ">					
								<a style="padding: 0 0px 0 15px !important;" class="ico-label text breakOffTest jpPlay" onclick='playSongPlayList(<?php echo $song; ?>,true)'><span class="songTitle"><?php echo $value->getTitle(); ?></span><span class="note">&nbsp;&nbsp;&nbsp;by <?php echo $author_name?></span></a>
								<!--input type="hidden" name="song" value="<?php echo $pathSong.$value->getFilePath() ?>" /-->
								<input type="hidden" name="song" value="<?php echo $pathSong.$value->getFilePath() ?>" />
								<input type="hidden" name="index" value="<?php echo $index ?>" />
						    </div>					
						    <div class="small-3 columns track-propriety align-right" style="padding-right: 15px;">	
								<a class="icon-propriety _remove-small note orange" onclick='playlist(this, "remove",<?php echo $song; ?>)'> <?php echo $views['record']['REMOVEPLAYLIST']; ?></a>											
						    </div>
						    <div class="small-3 columns track-nopropriety align-right" style="padding-right: 15px;">
								<a class="icon-propriety "><?php echo $hoursminsandsecs ?></a>	
						    </div>		
						</div>
						<div class="row track-propriety" >
						    <div class="box-propriety album-single-propriety">
								<div class="small-6 columns ">
								    <a class="note white" onclick="love(this, 'Song', '<?php echo $value->getObjectId(); ?>', '<?php echo $value->getFromUser(); ?>')"><?php echo $track_text_love; ?></a>
								    <!--a class="note white" onclick="share()"><?php echo $views['SHARE']; ?></a-->
								</div>
								<div class="small-6 columns propriety ">					
								    <a class="icon-propriety <?php echo $track_css_love ?>" ><?php echo $value->getLoveCounter(); ?></a>
								    <!--a class="icon-propriety _share" ><?php echo $value->getShareCounter(); ?></a-->
								</div>
						    </div>		
						</div>
			        </div>
		        </div>
	        </div>

		    <?php
		    $index++;
		}
	    }
	    ?>
		
        </div>
    </div>
<?php 
if (count($playlist->tracklist) == 0 && is_null($playlist->error)) { ?>
    <div class="row">
        <div  class="small-12 columns hide-for-small">
    	<div class="text grey"><?php echo $views['recordDetail']['NODATA'] ?></div>    	
        </div>	
    </div>
<?php } ?>