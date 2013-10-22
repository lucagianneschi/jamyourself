<?php
	
 if (!defined('ROOT_DIR'))
define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
	
$countRecord = 10;
	
?>

<div class="row">
	<div  class="large-12 columns formBlack-title">
		<h2>Select an album</h2>										
	</div>	
</div>						
<div class="row formBlack-body" id="uploadRecord-listRecord">
	<div  class="large-12 columns ">
		<?php if($countRecord > 0){ ?>
		<div  id="uploadRecord-listRecordTouch" class="touchcarousel grey-blue">
			
			<ul class="touchcarousel-container">		
				<?php for( $i = 0; $i < $countRecord; $i++ ){ ?>
				<li class="touchcarousel-item">
					
					<div class="item-block uploadRecord-boxSingleRecord">
						<div class="row">
							<div  class="small-6 columns ">
								<img class="coverRecord" src="../media/" onerror="this.src='../media/<?php echo $default_img['DEFRECORDTHUMB'];?>'">  
							</div>
							<div  class="small-6 columns title">
								<div class="sottotitle white">In The Belly Of A Shark</div>
								<div class="text white"><?php echo $i+1 ?> songs</div>								
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