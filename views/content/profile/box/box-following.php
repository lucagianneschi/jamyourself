<?php
/* box per elenco following
 * box chiamato tramite ajax con:
 * data: {user: objectId}, 
 * data-type: html,
 * type: POST o GET
 * 
 * box solo per spotter
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
require_once BOXES_DIR . 'utilsBox.php';

$followingsJ = array();
$followingsV = array();
$followings = getRelatedUsers($_POST['objectId'], 'following', '_User', true, 4, 0);
foreach ($followings as $key => $value) {
	if ($value->getType() == 'JAMMER') {
		$followingsJ[$key] = $value;
	} elseif ($value->getType() == 'VENUE') {
		$followingsV[$key] = $value;
	}
}

$followersCounter = count($followings);
$followingCounterJ = count($followingsJ);
$followingCounterV = count($followingsV);

?>
<!----------------------------------- FOLLOWING -------------------------------------------------->
<div class="row" id="profile-following">
	<div class="large-12 columns ">
		<h3><?php echo $views['following']['TITLE'];?></h3>	
		<div class="box" id="following-list">
			<?php
			if ($followersCounter > 0 ) {
				?>
				<div class="row">
					<div class="large-12 columns">
						<div class="text orange">Venue <span class="white">[<?php echo $followingCounterV;?>]</span></div>	
					</div>
				</div>
				<?php 
				$totalView = $followingCounterV > 4 ? 4 : $followingCounterV;
				?>
				<div class="row">
				<?php
				$i = 1;
				foreach ($followingsV as $key => $value) {
				//for ($i=0; $i<$totalView; $i=$i+2) {
					?>	
					<div  class="small-6 columns">
						<div class="box-membre">
							<div class="row " id="collaborator_<?php echo $value->getObjectId(); ?>">
								<div  class="small-3 columns ">
									<div class="icon-header">
										<img src="../media/<?php echo $value->getProfileThumbnail(); ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
									</div>
								</div>
								<div  class="small-9 columns ">
									<div class="text grey-dark breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
								</div>		
							</div>	
						</div>
					</div>
					<?php
					if ($i % 2 == 0) {
						?>
						</div>
						<div class="row">
						<?php
					}
					$i++;
				}
				?>
				</div>
				<div class="row">
					<div  class="large-12 columns"><div class="line"></div></div>
				</div>
				<!------------------------------------------ JAMMER ----------------------------------->
				<div class="row">
					<div class="large-12 columns">
						<div class="text orange">Jammer <span class="white">[<?php echo $followingCounterJ;?>]</span></div>	
					</div>
				</div>
				<?php 
				$totalView = $followingCounterJ > 4 ? 4 : $followingCounterJ;
				?>
				<div class="row">
				<?php
				$i = 1;
				foreach ($followingsJ as $key => $value) {
				//for ($i=0; $i<$totalView; $i=$i+2) {
					?>	
					<div  class="small-6 columns">
						<div class="box-membre">
							<div class="row " id="collaborator_<?php echo $value->getObjectId(); ?>">
								<div  class="small-3 columns ">
									<div class="icon-header">
										<img src="../media/<?php echo $value->getProfileThumbnail(); ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
									</div>
								</div>
								<div  class="small-9 columns ">
									<div class="text grey-dark breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
								</div>		
							</div>	
						</div>
					</div>
					<?php
					if ($i % 2 == 0) {
						?>
						</div>
						<div class="row">
						<?php
					}
					$i++;
				}
				?>
				</div>
				<?php
			} else {
				?>	
				<div class="row  ">
					<div  class="large-12 columns ">
						<p class="grey"><?php echo $views['following']['NODATA'];?></p>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>