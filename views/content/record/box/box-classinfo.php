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
require_once SERVICES_DIR . 'log.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once SERVICES_DIR . 'fileManager.service.php';

$title = $record->getTitle();
$genre = $record->getGenre();
$fromUserObjectId = $record->getFromuser()->getId();
$fileManagerService = new FileManagerService();
$pathCoverRecord = $fileManagerService->getRecordPhotoPath($fromUserObjectId, $record->getCover());

foreach ($genre as $g) {
	foreach ($g as $key => $value) {
		if ($key == 0)
			$stringGenre = $views['tag']['music'][$value];
    	else
			$stringGenre = $stringGenre . ', ' . $views['tag']['music'][$value];
	}
    
}
//$stringGenre = $views['tag']['music'][$arrayGenre[0]];
?>
<div class="row" id="profile-userInfo">
    <div class="large-12 columns">
        <h2><?php echo $title ?></h2>			
        <div class="row">
            <div class="small-12 columns">				
                <a class="ico-label _tag"><?php echo $stringGenre ?></a>
            </div>				
        </div>		
    </div>
</div>
<div class="row">
    <div  class="large-12 columns"><div class="line"></div></div>
</div>	

<div class="row">
    <div class="large-12 columns">
        <img class="background" src="<?php echo $pathCoverRecord; ?>"  onerror="this.src='<?php echo DEFRECORDCOVER; ?>'" alt ="<?php echo $title; ?> " >						
    </div>
</div> 