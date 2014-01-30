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
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'relation.box.php';

$followingCounter = $_POST['followingCounter'];

$followingsBox = new FollowingsBox();
$followingsBox->init($_POST['objectId']);

if (is_null($followingsBox->error)) {
    $venuesFollowings = $followingsBox->venueArray;
    $jammersFollowings = $followingsBox->jammerArray;

    $venuesFollowingsCounter = count($venuesFollowings);
    $jammersFollowingsCounter = count($jammersFollowings);
    $followingCounter = $venuesFollowingsCounter + $jammersFollowingsCounter;
    $totFollowings = $followingCounter;
    ?>
    <!----------------------------------- FOLLOWING -------------------------------------------------->
    <div class="row" id="profile-following">
        <div class="large-12 columns ">
    	<h3 style="cursor: pointer" onclick="loadBoxRelation('following', 21, 0,<?php echo $followingCounter; ?>)"><?php echo $views['following']['TITLE']; ?><span class="orange"> [<?php echo $followingCounter; ?>]</span></h3>
    	<div class="box" id="following-list">
		<?php
		if ($totFollowings > 0) {
		    if ($venuesFollowingsCounter > 0) {
			?>
	    	    <div class="row">
	    		<div class="large-12 columns" style="padding-bottom: 10px;">
	    		    <div class="text orange">Venue <span class="white">[<?php echo $venuesFollowingsCounter ?>]</span></div>
	    		</div>
	    	    </div>

			<?php
			$i = 0;
			foreach ($venuesFollowings as $key => $value) {
			    switch ($value->getType()) {
				case 'JAMMER':
				    $defaultThum = DEFTHUMBJAMMER;
				    break;
				case 'VENUE':
				    $defaultThum = DEFTHUMBVENUE;
				    break;
			    }
			    $pathPicture = USERS_DIR . $value->getObjectId() . '/images/profilepicturethumb/';
			    if ($i % 2 == 0) {
				?> <div class="row">  <?php }
			    ?>	
				<div  class="small-6 columns">
				    <a href="profile.php?user=<?php echo $value->getObjectId(); ?>">
					<div class="box-membre">
					    <div class="row " id="collaborator_<?php echo $value->getObjectId(); ?>">
						<div  class="small-3 columns ">
						    <div class="icon-header">
							<img src="<?php echo $pathPicture . $value->getProfileThumbnail(); ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
						    </div>
						</div>
						<div  class="small-9 columns ">
						    <div class="text grey-light breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
						</div>	
					    </div>
					</div>
				    </a>
				</div>
			    <?php if (($i + 1) % 2 == 0 || count($venuesFollowings) == ($i + 1)) { ?>  </div>  <?php
			    }
			    $i++;
			    if ($i == 4)
				break;
			}
			?>	
	    	    <div class="row">
	    		<div  class="large-12 columns"><div class="line"></div></div>
	    	    </div>
	    <?php
	}
	if ($jammersFollowingsCounter > 0) {
	    ?>

	    	    <!------------------------------------------ JAMMER ----------------------------------->
	    	    <div class="row">
	    		<div class="large-12 columns" style="padding-bottom: 10px;">
	    		    <div class="text orange">Jammer <span class="white">[<?php echo $jammersFollowingsCounter ?>]</span></div>
	    		</div>
	    	    </div>

			<?php
			$i = 0;
			foreach ($jammersFollowings as $key => $value) {
			    switch ($value->getType()) {
				case 'JAMMER':
				    $defaultThum = DEFTHUMBJAMMER;
				    break;
				case 'VENUE':
				    $defaultThum = DEFTHUMBVENUE;
				    break;
			    }
			    $pathPicture = USERS_DIR . $value->getObjectId() . '/images/profilepicturethumb/';
			    if ($i % 2 == 0) {
				?> <div class="row">  <?php } ?>

				<div  class="small-6 columns">
				    <a href="profile.php?user=<?php echo $value->getObjectId(); ?>">
					<div class="box-membre">
					    <div class="row " id="collaborator_<?php echo $value->getObjectId(); ?>">
						<div  class="small-3 columns ">
						    <div class="icon-header">
							<img src="<?php echo $pathPicture . $value->getProfileThumbnail(); ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
						    </div>
						</div>
						<div  class="small-9 columns ">
						    <div class="text grey-light breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
						</div>		
					    </div>	
					</div>
				    </a>
				</div>
			    <?php if (($i + 1) % 2 == 0 || count($jammersFollowings) == ($i + 1)) { ?>  </div>  <?php
			    }
			    $i++;
			    if ($i == 4)
				break;
			}
			?>


		    <?php
		    }
		} else {
		    ?>	
		    <div class="row  ">
			<div  class="large-12 columns ">
			    <p class="grey"><?php echo $views['following']['NODATA']; ?></p>
			</div>
		    </div>
	<?php
    }
    ?>
    	</div>
        </div>
    </div>
    <?php
}