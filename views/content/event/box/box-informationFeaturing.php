<?php
/*
 * Contiene il box information featuring dell'utente
 * Il contenuto varia a seconda del tipo di utente:
 * spotter: abount
 * jammer: abount e member
 * venue: abount e map
 * 
 * box chiamato tramite load con:
 * data: array conente infomazoini di tipo userInfo, 
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'log.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'select.service.php';

$id = $_POST['id'];
$featurings = array();
$connectionService = new ConnectionService();
$featurings = getRelatedNodes($connectionService,'user', $id, 'event', 'featuring');
$featuringsCounter = count($featurings);

if ($featuringsCounter > 0) {
    ?>

    <p class="title" data-section-title><a href="#"><?php echo $views['media']['information']['content2']; ?></a></p>

    <div class="content" data-section-content>
        <div class="row">
	    <?php
	    $totalView = $featuringsCounter > 6 ? 6 : $featuringsCounter;
	    $i = 1;
	    foreach ($featurings as $key => $value) {
		switch ($value->getType()) {
		    case 'JAMMER':
			$defaultThum = DEFTHUMBJAMMER;
			break;
		    case 'VENUE':
			$defaultThum = DEFTHUMBVENUE;
			break;
		}
		?>
		<div  class="small-6 columns">
		    <div class="box-membre" onclick="location.href = 'profile.php?user=<?php echo $value->getId(); ?>'">
			<div class="row " id="featuring_<?php echo $value->getId(); ?>">
			    <div  class="small-3 columns ">
				<div class="icon-header">
				    <!-- THUMB USER-->
				    <?php
				    $fileManagerService = new FileManagerService();
				    $thumbPath = $fileManagerService->getPhotoPath($value->getId(), $value->getThumbnail());
				    ?>
				    <img src="<?php echo $thumbPath; ?>" onerror="this.src='<?php echo $defaultThum; ?>'" alt ="<?php echo $value->getUsername(); ?> ">
				</div>
			    </div>
			    <div  class="small-9 columns ">
				<div class="text white breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
				<small class="orange"><?php echo $value->getType(); ?></small>
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
		if ($i == $totalView)
		    break;
		$i++;
	    }
	    ?>
        </div>
    </div>

    <?php
}
?>