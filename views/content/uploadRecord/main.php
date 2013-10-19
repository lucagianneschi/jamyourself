<div class="bg-grey-dark">
	<div class="row" id="uploadRecord">
		<div  class="large-12 columns">
			<div class="row">
				<div  class="small-7 columns">
					<h3>Upload Media</h3>
				</div>
				<div  class="small-5 columns">
					<div class="signup-labelStep no-display" id="signup-labelStep-step3">STEP 3</div>
					<div class="signup-labelStep no-display" id="signup-labelStep-step2">STEP 2</div>
					<div class="signup-labelStep no-display" id="signup-labelStep-step1">STEP 1</div>
				</div>
			</div>
			<div class="row">
				<div  class="large-12 columns uploadRecord-box">
					<form action="" method="POST" name="form-uploadRecord" id="form-uploadRecord" data-abide>							
						<div class="row">
							<div  class="large-12 columns uploadRecord-title">
								<h2>Select an album</h2>										
							</div>	
						</div>
						<?php require_once VIEWS_DIR.'content/uploadRecord/listRecord.php'; ?>
						<div class="row">
							<div  class="large-12 columns uploadRecord-title">
								<input type="button" value="Create a new one" />									
							</div>	
						</div>	
					</form>
				</div>
			</div>
		</div>
	</div>	
</div>