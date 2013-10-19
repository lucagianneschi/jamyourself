<?php
	
	$countRecord = 10;
	
?>
<div class="row" id="uploadRecord-listRecord">
	<div  class="large-12 columns ">
	
		<div  id="uploadRecord-listRecordTouch" class="touchcarousel grey-blue">
			
			<ul class="touchcarousel-container">		
				<?php for( $i = 0; $i < $countRecord; $i++ ){ ?>
				<li class="touchcarousel-item">
					
					<div class="item-block uploadRecord-boxSingleRecord">
						
					</div>
					
				</li>
				<?php } ?>		
			</ul>
		
		</div>
				
	</div>		
</div>