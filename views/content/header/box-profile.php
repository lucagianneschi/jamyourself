<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'playlist.box.php';

$plBox = new PlaylistBox();
$playlist = $plBox->init();

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
			<!------------ HEADER HIDE PROFILE ------------------------------------>
			<div class="row">
				<!------------ START PLAYLIST ------------------------------------>
				<div  class="small-6 columns">				
				<?php 
				if (count($playlist->tracklist) > 0) {
					foreach ($playlist->tracklist as $key => $value) {
						$author_name = $value->author->username;
						$author_objectId = $value->author->objectId;
						$thumbnail = $value->thumbnail;
						$title = $value->title;
						?>				
						<div class="row">
							<div  class="large-2 columns hide-for-small">
								<div class="icon-header">							
									<img src="../media/<?php echo $thumbnail ?>" onerror="this.src='../media/<?php echo $default_img['DEFALBUMTHUMB'];?>'">  
								</div>
							</div>
							<div  class="large-10 columns ">
								<label class="text grey inline"><?php echo ($key+1).'. '.$title.' - '.$author_name; ?></label>									
							</div>
						</div>
						<div class="row">
							<div  class="large-12 columns"><div class="line"></div></div>
						</div>
						<?php
					}
				}
				?>
				</div>
				<!------------ END PLAYLIST ------------------------------------>
			</div>
		</div>
	</div>	
	<?php
}