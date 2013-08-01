<div id="venue-signup02"  class="no-display">
	<div class="row">
		<div  class="large-12 columns signup-title">
			<h2>Tell us something about your Venue:</h2>		
		</div>	
	</div>
	<div class="row signup-body">
		<div  class="small-6 columns">
			
			<div class="row signup-box-image">
				<div  class="small-3 columns signup-box-avatar">									
				     <div class="signup-image">
				     	<div id="venue_uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane"><img src="resources/images/avatar-signup/venue.png" id="venue_uploadImage_tumbnail" name="venue_uploadImage_tumbnail"/></div>
				     </div>
				</div>
				<div  class="small-9 columns signup-box-avatar-text">							        						
					<a data-reveal-id="venue-uploadImage" class="text orange">Upload Image</a>
					<div id="venue-uploadImage" class="reveal-modal uploadImage-reveal">
						<div class="uploadImage" >
							<div class="row">
								<div  class="large-12 columns signup-title">
									<h2>Upload Image</h2>		
								</div>	
							</div>
							<div class="row">							
								<div  class="small-4 small-centered columns align-center" >
									<label class="uploadImage_file_label" for="venue_uploadImage_file">Select a file from your computer</label>
									<input type="file" id="venue_uploadImage_file" name="venue_uploadImage_file" accept="image/*"/>			
								</div>
							</div>
							<div class="row">							
								<div  class="small-10 small-centered columns align-center venue_uploadImage_box-preview">
									<div id="venue_uploadImage_preview_box">
										<img src="" id="venue_uploadImage_preview"/>
								    	<input type="hidden" id="venue_x" name="venue_x" value="0"/>
										<input type="hidden" id="venue_y" name="venue_y" value="0"/>
										<input type="hidden" id="venue_w" name="venue_w" value="100"/>
										<input type="hidden" id="venue_h" name="venue_h" value="100"/>
									</div>											   		
								</div>
								
							</div>
							
							<div class="row">							
								<div  class="small-3 small-offset-9 columns">
									<input type="button" id="venue_uploadImage_save" name="venue_uploadImage_save" class="signup-button no-display uploadImage_save" value="Save"/>
								</div>
							</div>
						</div>
					</div>							
				</div>	
			</div>
			
		</div>
		<div  class="small-6 columns">
			<div class="row venue-country-singup02">
				<div  class="small-12 columns">									
					<input type="text" name="venue-country" id="venue-country" pattern="username" required/>								
					<label for="venue-country" >Country <span class="orange">*</span><small class="error"> Please enter a valid Country</small></label>
				</div>							
			</div>
			<div class="row">
				<div  class="small-8 columns">	
					<div class="row venue-city-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="venue-city" id="venue-city" pattern="username" required/>								
							<label for="venue-city" >City <span class="orange">*</span><small class="error"> Please enter a valid City</small></label>
						</div>							
					</div>	
				</div>
				<div  class="small-4 columns">	
					<div class="row venue-province-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="venue-province" id="venue-province" pattern="username" required/>								
							<label for="venue-province" >Zip Code <span class="orange">*</span><small class="error"> Please enter a valid zip code</small></label>
						</div>							
					</div>	
				</div>
			</div>
			<div class="row">
				<div  class="small-9 columns">	
					<div class="row venue-adress-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="venue-adress" id="venue-adress" pattern="username" required/>								
							<label for="venue-adress" >Adress <span class="orange">*</span><small class="error"> Please enter a valid Adress</small></label>
						</div>							
					</div>	
				</div>
				<div  class="small-3 columns">	
					<div class="row venue-number-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="venue-number" id="venue-number" pattern="username" required/>								
							<label for="venue-number" >Number <span class="orange">*</span><small class="error"> Please enter a valid Number</small></label>
						</div>							
					</div>	
				</div>
			</div>		
		</div>
	</div>
	<div class="row">
		<div  class="small-3 small-offset-1 columns">
			<div class="note grey-light signup-note"><span class="orange">* </span> Mandatory fields</div>
		</div>	
		<div  class="small-8 columns">
			<input type="button" name="venue-signup02-back" id="venue-signup02-back" class="signup-button-back" value="Go Back"/>
			<input type="button" name="venue-signup02-next" id="venue-signup02-next" class="signup-button" value="Next"/>
		</div>	
	</div>
</div>