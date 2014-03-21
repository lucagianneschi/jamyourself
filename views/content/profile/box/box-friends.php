<?php
/* box friends
 * box chiamato tramite load con:
 * data: {data,typeuser}
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'relation.box.php';
require_once SERVICES_DIR . 'fileManager.service.php';

$friendshipCounter = $_POST['friendshipCounter'];
$friendsBox = new FriendsBox();
$friendsBox->init($_POST['id'],4,0);

if (is_null($friendsBox->error)) {
    $friends = $friendsBox->friendsArray;
    ?>
    <div class="row" id="profile-friends">
        <div  class="large-12 columns">
    	<h3 style="cursor: pointer" onclick="loadBoxRelation('friendship', 21, 0,<?php echo $friendshipCounter; ?>)"><?php echo $views['friends']['title']; ?> <span class="orange">[<?php echo $friendshipCounter; ?>]</span> </h3>
    	<div class="row">
    	    <div  class="large-12 columns ">
    		<div class="box">					
			<?php
			if ($friendshipCounter > 0 && count($friends) > 0) {
			    $i = 0;
			    foreach ($friends as $key => $value) {
				switch ($value->getType()) {
				    case 'JAMMER':
					$defaultThum = DEFTHUMBJAMMER;
					break;
				    case 'VENUE':
					$defaultThum = DEFTHUMBVENUE;
					break;
				    case 'SPOTTER':
					$defaultThum = DEFTHUMBSPOTTER;
					break;
				}
				$fileManagerService = new FileManagerService();
				$pathPicture = $fileManagerService->getPhotoPath($value->getId(), $value->getThumbnail());
				if ($i % 2 == 0) {
				    ?> <div class="row">  <?php } ?>

	    			<div  class="small-6 columns">
	    			    <a href="profile.php?user=<?php echo $value->getId(); ?>">
	    				<div class="box-membre">
	    				    <div class="row " id="collaborator_<?php echo $value->getId(); ?>">
	    					<div  class="small-3 columns ">
	    					    <div class="icon-header">
	    						<img src="<?php echo $pathPicture; ?>" onerror="this.src='<?php echo $defaultThum; ?>'" alt="<?php echo $value->getUsername(); ?>">
	    					    </div>
	    					</div>
	    					<div  class="small-9 columns ">
	    					    <div class="text grey-light breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
	    					</div>		
	    				    </div>	
	    				</div>
	    			    </a>
	    			</div>
				    <?php if (($i + 1) % 2 == 0 || count($friends) == ($i + 1)) { ?>  </div>  <?php
				}
				$i++;
			    }
			} else {
			    ?>	
			    <div class="row  ">
				<div  class="large-12 columns ">
				    <p class="grey"><?php echo $views['friends']['nodata']; ?></p>
				</div>
			    </div>
			<?php } ?>
    		</div>	
    	    </div>
    	</div>
        </div>
    </div>
    <?php
}