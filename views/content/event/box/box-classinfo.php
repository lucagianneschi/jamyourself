<?php
/*
 * box userinfo
 * chiamato tramite load con:
 * data: {data: data} 
 * @data: array contenente le informazioni relative al box userInfo.box
 * 
 * box per tutti gli utenti
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'log.service.php';

$title = $event->getTitle();
$genre = '';
$space = '';

foreach ($event->getGenre() as $g) {
	foreach ($g as $key => $value) {
		if ($key == 0)
			$genre = $views['tag']['localType'][$value];
    	else
			$genre = $genre . ', ' . $views['tag']['localType'][$value];
	}
    
}
$fileManagerService = new FileManagerService();
$pathImage = $fileManagerService->getEventPhotoPath($event->getFromuser()->getId(), $event->getCover());
?>
<div class="row" id="profile-userInfo">
    <div class="large-12 columns">
	<h2><?php echo $title ?></h2>			
	<div class="row">
	    <div class="small-12 columns">				
		<a class="ico-label _tag"><?php echo $genre ?></a>
	    </div>				
	</div>		
    </div>
</div>
<div class="row">
    <div  class="large-12 columns"><div class="line"></div></div>
</div>	

<div class="row">
    <div class="large-12 columns">
	<img class="background" src="<?php echo $pathImage; ?>"  onerror="this.src='<?php echo DEFEVENTIMAGE; ?>'" alt ="<?php echo $title; ?> " >						
    </div>
</div> 