<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'playlist.box.php';

$playlist = new PlaylistBox();
$playlist->init();

#TODO
//decidere come gestire i possibili errori
if (count($playlist->tracklist) == 0 && is_null($playlist->error)) {
	echo 'Playlist vuota';
} elseif (count($playlist->tracklist) == 0 && !is_null($playlist->error)) {
	echo $playlist->error;
} elseif (count($playlist->tracklist) > 0) {
	
	?>
	
	<div class="row">
		<div  class="small-6 columns hide-for-small">
			<h3><?php echo $playlist->name; ?></h3>
			<div class="row">
				<div  class="large-6 columns">
					<div class="text white" style="margin-bottom: 15px;">Now Playing</div>
				</div>	
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
						?>				
												
						<div class="row" id="<?php echo $objectId ?>"> 
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
                        </div>
                        
				<?php
						
					}
				}
				?>
				
		</div>
	</div>	
	<?php
}