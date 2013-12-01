<div class="bg-grey-dark">
	<div class="row formBlack" id="uploadRecord">
		<div  class="large-12 columns">
			<div class="row">
				<div  class="large-12 columns">
					<h3>Upload Media</h3>
				</div>				
			</div>
			<div class="row">
				<div  class="large-12 columns formBlack-box">
					<form action="" method="POST" name="form-uploadRecord" id="form-uploadRecord" data-abide>
						<div id="uploadRecord01" class="">
							<?php 
                                                        
                                                    debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/main.php - loading ".VIEWS_DIR.'content/uploadRecord/uploadRecord01.php');
                                                    require_once VIEWS_DIR.'content/uploadRecord/uploadRecord01.php'; ?>
						</div>
						<div id="uploadRecord02" class="no-display">
							<?php 
                                                    debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/main.php - loading ".VIEWS_DIR.'content/uploadRecord/uploadRecord02.php');                                                        
                                                    require_once VIEWS_DIR.'content/uploadRecord/uploadRecord02.php'; ?>
						</div>
						<div id="uploadRecord03" class="no-display">
							<?php 
                                                    debug(DEBUG_DIR, "uploadRecord.log", "content/uploadRecord/main.php - loading ".VIEWS_DIR.'content/uploadRecord/uploadRecord03.php');    
                                                    require_once VIEWS_DIR.'content/uploadRecord/uploadRecord03.php'; ?>
						</div>			
					</form>
				</div>
			</div>
		</div>
	</div>	
</div>