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
	    	<?php 
            	require_once BOXES_DIR . "record.box.php";
				$recordBox = new RecordBox();
				$recordBox->init($_SESSION['id'], 10, 0);
            	$recordList = array();
				$fileManager = new FileManagerService();
				if (is_null($recordBox->error) && count($recordBox->recordArray) > 0) {
				    foreach ($recordBox->recordArray as $record) {
						$thumbnail = file_exists($fileManager->getRecordPhotoURL($_SESSION['id'], $record->getThumbnail())) ? $fileManager->getRecordPhotoURL($_SESSION['id'], $record->getThumbnail()) : DEFRECORDTHUMB;
						$title = $record->getTitle();
						$songCounter = $record->getSongCounter();
						$recordId = $record->getId();
										
            	?>
            	<li class="touchcarousel-item">
				<div class="item-block uploadRecord-boxSingleRecord" id="<?php echo $recordId ?>">
					<div class="row">
					<div  class="small-6 columns ">
						<img class="coverRecord"  src="<?php echo $thumbnail ?>">
					</div>
					<div  class="small-6 columns title">
						<div class="sottotitle white"><?php echo $title ?></div>
						<div class="text white"><?php echo $songCounter ?> songs</div>
					</div>
					</div>
					</div>
				</li>
            	
            	<?php 
			    	}
			    }
			    ?>	
	    </ul>		
	</div>

    </div>		
</div>
<div class="row">
    <div  class="large-12 columns formBlack-title">
	<a type="button" class="buttonOrange _add sottotitle" id="uploadRecord-new"><?php echo $views['uploadRecord']['create']; ?></a>									
    </div>	
</div>