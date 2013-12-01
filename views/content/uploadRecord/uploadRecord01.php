<?php
$countRecord = count($recordList);	
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
                    ?>
		<div  id="uploadRecord-listRecordTouch" class="touchcarousel grey-blue">
			<ul class="touchcarousel-container">		
				<?php 
                                foreach( $recordList as $record){ 
                                    $thumbnailSrc = $uploadRecordController->getRecordThumbnailURL($currentUser,$record->getThumbnailCover());  
                                    $title = $record->getTitle();
                                    $songCounter = 0;
                                    ($record->getSongCounter() > 0)? $songCounter = $record->getSongCounter() : $songCounter = 0;
                                    $recordId = $record->getObjectId();
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
                                } 
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