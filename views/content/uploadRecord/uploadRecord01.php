<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div class="row">
    <div  class="large-12 columns formBlack-title">
	<h2><?php echo $views['uploadRecord']['select']; ?></h2>										
    </div>	
</div>						
<div class="row formBlack-body" id="uploadRecord-listRecord">
    <div  class="large-12 columns ">

	<div  id="uploadRecord-listRecordTouch" class="touchcarousel grey-blue">
	    <div id="records_spinner"></div>
	    <ul class="touchcarousel-container" id="recordList">
	    </ul>		
	</div>

    </div>		
</div>
<div class="row">
    <div  class="large-12 columns formBlack-title">
	<a type="button" class="buttonOrange _add sottotitle" id="uploadRecord-new"><?php echo $views['uploadRecord']['create']; ?></a>									
    </div>	
</div>