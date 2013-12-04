<?php
$countAlbum = 10;

$thumbnailSrc = '';
$title = 'Photo Set Title';
$photoCounter = 10;
?>
<div class="row">
	<div  class="large-12 columns formBlack-title">
		<h2>Select a Photo Set</h2>										
	</div>	
</div>						
<div class="row formBlack-body" id="uploadAlbum-listAlbum">
	<div  class="large-12 columns ">
		<?php                 
        	if($countAlbum > 0){ 
        ?>
		<div  id="uploadAlbum-listAlbumTouch" class="touchcarousel grey-blue">
			<ul class="touchcarousel-container">		
				<?php 
                    for($i = 1; $i <= $countAlbum; $i++ ){
                  ?>
				<li class="touchcarousel-item">
					
					<div class="item-block uploadAlbum-boxSingleAlbum" id="<?php echo $i ?>">
						<div class="row uploadAlbum-rowSingleAlbum">
							<div  class="small-6 columns ">
								<img class="coverAlbum"  src="<?php echo $thumbnailSrc ?>" onerror="this.src='../media/<?php echo DEFALBUMTHUMB;?>'">  
							</div>
							<div  class="small-6 columns title">
								<div class="sottotitle white"><?php echo $title ?></div>
								<div class="text white"><?php echo $photoCounter ?> photos</div>								
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
		<a type="button" class="buttonOrange _add sottotitle" id="uploadAlbum-new">Create a new one</a>									
	</div>	
</div>