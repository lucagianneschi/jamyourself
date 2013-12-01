<?php
debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - start");
$countRecord = count($recordList);	
debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - countRecord => " . $countRecord);

?>

<div class="row">
	<div  class="large-12 columns formBlack-title">
		<h2>Select an album</h2>										
	</div>	
</div>						
<div class="row formBlack-body" id="uploadRecord-listRecord">
	<div  class="large-12 columns ">
		<?php 
                
                if($countRecord > 0){ 
                    debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - inside IF");

                    ?>
		<div  id="uploadRecord-listRecordTouch" class="touchcarousel grey-blue">
			<ul class="touchcarousel-container">		
				<?php 
                            debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - before FOREACH");
                                foreach( $recordList as $record){ 
debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - inside FOREACH");
                                    $thumbnailSrc = $uploadRecordController->getRecordThumbnailURL($currentUser,$record->getThumbnailCover());  
debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - inside FOREACH - getTile");                                   
                                    $title = $record->getTitle();

                                    $songCounter = 0;
debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - inside FOREACH - getSongCounter");                                                                       
                                    ($record->getSongCounter() > 0)? $songCounter = $record->getSongCounter() : $songCounter = 0;
debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - inside FOREACH - getObjectId");                                                                                                           
                                    $recordId = $record->getObjectId();
debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - recordId => " . $recordId." - thumbnailSrc => ".$thumbnailSrc." - title => ".$title." - songCounter => ".$songCounter);                                    
                                 ?>
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
				<?php 
        debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - inside FOREACH - GET NEXT!");                                                                       

                                
                                } 
                    debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/uploadRecord01.php - after FOREACH");
                                ?>		
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