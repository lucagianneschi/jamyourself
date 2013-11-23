<?php
	
 if (!defined('ROOT_DIR'))
define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
	
$countRecord = count($uploadRecordController->viewInfoList);
	
?>

<div class="row">
	<div  class="large-12 columns formBlack-title">
		<h2>Select an album</h2>										
	</div>	
</div>						
<div class="row formBlack-body" id="uploadRecord-listRecord">
	<div  class="large-12 columns ">
		<?php if($countRecord > 0){ 
                            $currentUser = $_SESSION['currentUser'];

                    ?>
		<div  id="uploadRecord-listRecordTouch" class="touchcarousel grey-blue">
			<ul class="touchcarousel-container">		
				<?php for( $i = 0; $i < $countRecord; $i++ ){ 
                                    $recordInfo = $uploadRecordController->viewInfoList[$i];
                                    $thumbnailSrc = $uploadRecordController->getRecordThumbnailURL($currentUser,$recordInfo->thumbnailCover);  
                                    $title = $recordInfo->title;
                                    ($recordInfo->songCounter > 0)? $songCounter = $recordInfo->songCounter : $songCounter = 0;
                                    $recordId = $recordInfo->recordId;

//                [{"songCounter":-1,"thumbnailCover":"4005a0db2299b6ad75ea280e850b6332.jpg","title":"YassassinJammer album d'esordio","recordId":"OoW5rEt94b"},
//                {"songCounter":-1,"thumbnailCover":"ba993cbdfb28487e7566dc3fa6cfba56.jpg","title":"YassassinJammer album d'esordio","recordId":"V6L7HMo8Uk"},
//                                    
//                                    ?>
				<li class="touchcarousel-item">
					
					<div class="item-block uploadRecord-boxSingleRecord" id="<?php echo $recordId ?>">
						<div class="row">
							<div  class="small-6 columns ">
								<img class="coverRecord"  src="<?php echo $thumbnailSrc ?>">  
							</div>
							<div  class="small-6 columns title">
								<div class="sottotitle white"><?php echo $title ?></div>
								<div class="text white"><?php echo $songCounter ?> songs</div>								
							</div>
						</div>
						
					</div>
					
				</li>
				<?php } ?>		
			</ul>
		
		</div>
		<?php } ?>		
	</div>		
</div>
<div class="row">
	<div  class="large-12 columns formBlack-title">
		<a type="button" class="buttonOrange _add sottotitle" id="uploadRecord-new">Create a new one</a>									
	</div>	
</div>