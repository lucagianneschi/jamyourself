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
	echo 'Playlist vuota';
} elseif (count($playlist->tracklist) == 0 && !is_null($playlist->error)) {
	echo $playlist->error;
} elseif (count($playlist->tracklist) > 0) {
	$_SESSION['playlist']['objectId'] = $playlist->objectId;
	$_SESSION['playlist']['songs'] = array();
	?>
	<script>
		var myPlaylist;
		$(document).ready(function(){
		   myPlaylist = getPlayer();
		});
	</script>
	<div class="row">
		<div  class="small-6 columns hide-for-small">
			<h3><?php echo $playlist->name; ?></h3>
			<div class="row">
				<div  class="large-6 columns">
					<div class="text white" style="margin-bottom: 15px;"><?php echo $views['header']['profile']['TITLE'] ?></div>
				</div>	
			</div>
		</div>	
	</div>

	
	<div id="jp_container_N" class="jp-video jp-video-270p">
			<div class="jp-type-playlist">
				<div id="jquery_jplayer_N" class="jp-jplayer"></div>
				<div class="jp-gui">
					<div class="jp-video-play">
						<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
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
								<li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
								<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								<li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
							</ul>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
							<ul class="jp-toggles">								
								<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
								<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
								<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
								<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="jp-playlist">
					<ul>
						
						<!-- The method Playlist.displayPlaylist() uses this unordered list -->
						<li></li>
					</ul>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>
		<div class="row">
		<div  class="small-12 columns">					
				<?php 
				if (count($playlist->tracklist) > 0) {
					
					foreach ($playlist->tracklist as $key => $value) {						
							$objectId = $value->getObjectId();						
							$author_name = $value->getFromUser()->getUsername();
							$author_objectId = $value->getFromUser()->getObjectId();
							$duration = $value->getDuration();
							$title = $value->getTitle();
							$loveCounter = $value->getLoveCounter();
							$shareCounter = $value->getShareCounter();
							array_push($_SESSION['playlist']['songs'], $objectId);
							
						?>				
						<script>
						$(document).ready(function(){
							myPlaylist.add({
								objectId: "<?php echo $objectId ?>",
								title:"<?php echo $title?>",
								artist:"<?php echo $author_name?>",
								mp3:"http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3" //ci va l'url dell'mp3
							});
						});
						</script>						
						<!--div class="row" id="<?php echo $objectId ?>"> 
                                <div class="small-12 columns">
                                	<div class="track">
                                        <div class="row">
                                                <div class="small-8 columns ">                                        
                                                        <a class="ico-label _play-large text breakOffTest"><?php echo $title.' - '.$author_name;?></a>                                                                
                                                </div>
                                                <div class="small-2 columns">
                                                        <p class="grey"><?php echo $duration ?></p>        
                                                </div>
                                                <div class="small-2 columns track-propriety align-right" style="padding-right: 15px;">                                        
                                                        <a class="icon-propriety _menu-small note orange "> <?php echo $views['record']['REMOVEPLAYLIST'];?></a>
                                                                                                                                                
                                                </div>
                                                                
                                        </div>
                                        <div class="row track-propriety" >
                                                <div class="box-propriety album-single-propriety" style="padding: 10px;">
                                                        <div class="small-5 columns ">
                                                                <a class="note white" onclick="love(this, 'Song', '<?php echo $objectId ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $views['LOVE'];?></a>
                                                                <a class="note white" onclick="setCounter(this, '<?php echo $objectId ?>','Song')"><?php echo $views['SHARE'];?></a>        
                                                        </div>
                                                        <div class="small-5 columns propriety ">                                        
                                                                <a class="icon-propriety _unlove grey" ><?php echo $loveCounter ?></a>
                                                                <a class="icon-propriety _share" ><?php echo $shareCounter ?></a>                        
                                                        </div>
                                                </div>                
                                        </div>
                                	</div>
                                </div>
                        </div-->
                        
				<?php
						
					}
				}
				?>
				
		</div>
	</div>
	<?php
}