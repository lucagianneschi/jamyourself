<?php
/* box per elenco relation
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'utilsBox.php';
require_once SERVICES_DIR . 'fileManager.service.php';

$objectId = $_POST['objectId'];
$relation = $_POST['relation'];
$limit = intval($_POST['limit']);
$skip = intval($_POST['skip']);
$tot = intval($_POST['tot']);

$arrayRelation = getRelatedUsers($objectId, $relation, '_User', false, $limit, $skip);

if ($relation == 'friendship')
    $rel = 'friends';
else
    $rel = $relation;

if ($arrayRelation instanceof Error) {
    ?>

    <h3 class="red">Error</h3>

<?php } elseif (is_null($arrayRelation) || count($arrayRelation) == 0) {
    ?>

    <div class="grey "><?php echo $views[$rel]['NODATA'] ?></div>

<?php
} else {
    $count = count($arrayRelation);
    $index = 0;
    foreach ($arrayRelation as $value) {
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
	$pathPicture = $fileManagerService->getPhotoPath($value->getObjectId(), $value->getProfileThumbnail());
	if ($index % 3 == 0) {
	    ?> <div class="row">	<?php } ?>
	    <div class="small-4 columns">
		<a href="profile.php?user=<?php echo $value->getObjectId(); ?>">
		    <div class="box-membre">
			<div class="row">
			    <div  class="small-3 columns hide-for-medium-down">
				<div class="icon-header">
				    <img src="<?php echo $pathPicture . $value->getProfileThumbnail(); ?>" onerror="this.src='<?php echo $defaultThum; ?>'" alt="<?php echo $value->getUsername(); ?>">
				</div>
			    </div>
			    <div  class="small-9 columns">
				<div class="text grey-light breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
				<div class="note orange breakOffTest" style="margin-top: 8px;"><?php echo $value->getType(); ?></div>
			    </div>		
			</div>	
		    </div>
		</a>
	    </div>		
	<?php if (($index + 1) % 3 == 0 || $count == $index + 1) { ?> </div> <?php
	}

	$index++;
    }
    $css_prev = 'no-display';
    $css_next = 'no-display';
    if ($skip != 0) {
	$css_prev = '';
    }
    if ($tot > ($limit + $skip)) {
	$css_next = '';
    }
    ?>
    <div class="row">

        <div class="small-6 columns">
    	<div class="row">
    	    <div class="small-12 columns">
    		<a class="text orange <?php echo $css_prev ?> " style="float: left !important;" onclick="loadBoxRelation('<?php echo $relation ?>', 21,<?php echo ($skip - $limit) ?>,<?php echo $tot ?>)" style="padding-bottom: 15px;float: right;"><?php echo $views['PREV'] ?></a>	
    	    </div>
    	</div>
        </div>


        <div class="small-6 columns">
    	<div class="row">
    	    <div class="small-12 columns">
    		<a class="text orange <?php echo $css_next ?>" onclick="loadBoxRelation('<?php echo $relation ?>', 21,<?php echo ($limit + $skip) ?>,<?php echo $tot ?>)" style="padding-bottom: 15px;float: right;"><?php echo $views['NEXT'] ?></a>	
    	    </div>
    	</div>
        </div>

    </div>
    <?php
}
?>
