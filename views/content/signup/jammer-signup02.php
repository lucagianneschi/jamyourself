<div id="jammer-signup02" class="no-display" >
	<div class="row">
		<div  class="large-12 columns signup-title">
			<h2><span id="signup02-jammer-name-artist"></span>tell us something about you:</h2>		
		</div>	
	</div>
	<div class="row signup-body">
		<div class="row ">
			<div  class="small-12 columns">
				<div  class="small-6 columns">
					
					<div class="row signup-box-image">
						<div  class="small-3 columns signup-box-avatar">
							<div class="signup-image"><img src="resources/images/avatar-signup/jammer.png" style="height: 99px;"/></div>
						</div>
						<div  class="small-9 columns signup-box-avatar-text">
							<div class="text grey-light">Drop here an image</div>
							<div class="text grey-light">or <span class="orange">Upload Image</span></div>
						</div>	
					</div>
				</div>
				<div  class="small-6 columns">
					<div class="row">
						<div  class="small-4 columns">
							<p id="jammer-typeArtist-label" class="text grey-light inline">I'm recording as <span class="orange">*</span><small class="error"> Please enter a type recording</small></p>					
						</div>
						<div  class="small-8 columns inline signup-radio">			
							<input type="radio" name="jammer-typeArtist" id="jammer-typeArtist-musician" class="no-display inline" required><label for="jammer-typeArtist-musician" unchecked class="inline">Musician</label>
							<input type="radio" name="jammer-typeArtist" id="jammer-typeArtist-band" class="no-display inline" required><label for="jammer-typeArtist-band" unchecked class="inline">Band</label>
						</div>	
					</div>
					<div class="row jammer-country-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="jammer-country" id="jammer-country" pattern="username" maxlength="50" required/>								
							<label for="jammer-country" >Country <span class="orange">*</span><small class="error"> Please enter a valid Country</small></label>
						</div>							
					</div>
					<div class="row jammer-city-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="jammer-location" id="jammer-city" pattern="username" maxlength="50" required />					
							<label for="jammer-city " class="inline">City <span class="orange">*</span><small class="error"> Please enter a valid City</small></label>
						
							<a href="#" data-reveal-id="jammer-myModal" class="location-reveal text grey">Why do you ask me?</a>
							<div id="jammer-myModal" class="reveal-modal">
								  <h3>Why do you ask me?</h3>					 
								  <p class="grey">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
								  <a class="close-reveal-modal">&#215;</a>
							</div>
						</div>							
					</div>
						
				</div>
			</div>
		</div>
		<div id="jammer-component-signup02" class="no-display">
			<div class="row ">
				<div  class="small-12 columns">
					<h3>Components</h3>
				</div>	
			</div>
			<div class="row ">
				<div  class="small-6 columns">
					<div class="row jammer-componentName1-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="jammer-componentName1" id="jammer-componentName1" pattern="username" maxlength="50"/>								
							<label for="jammer-componentName1" >Name<small class="error"> Please enter a valid Name</small></label>
						</div>							
					</div>
					<div class="row jammer-componentName2-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="jammer-componentName2" id="jammer-componentName2" pattern="username" maxlength="50"/>								
							<label for="jammer-componentName2" >Name<small class="error"> Please enter a valid Name</small></label>
						</div>							
					</div>
					<div id="addComponentName">
						
					</div>
				</div>
				<div  class="small-6 columns">
					<div class="row jammer-componentInstrument1-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="jammer-componentInstrument1" id="jammer-componentInstrument1" pattern="username" maxlength="50"/>								
							<label for="jammer-componentInstrument1" >Instrument<small class="error"> Please enter a valid Instrument</small></label>
						</div>							
					</div>
					<div class="row jammer-componentInstrument2-singup02">
						<div  class="small-12 columns">									
							<input type="text" name="jammer-componentInstrument2" id="jammer-componentInstrument2" pattern="username" maxlength="50"/>								
							<label for="jammer-componentInstrument2" >Instrument<small class="error"> Please enter a valid Instrument</small></label>
						</div>							
					</div>
					<div id="addComponentInstrument">
						
					</div>
				</div>		
			</div>
			<div class="row">
				<div  class="small-3 small-centered columns">
					<div class="text orange addComponents">Add more components</div>
				</div>
			</div>
		</div>			
	</div>
	<div class="row">
		<div  class="small-3 small-offset-1 columns">
			<div class="note grey-light signup-note"><span class="orange">* </span> Mandatory fields</div>
		</div>	
		<div  class="small-8 columns">
			<input type="button" name="jammer-signup02-back" id="jammer-signup02-back" class="signup-button-back" value="Go Back"/>
			<input type="button" name="jammer-signup02-next" id="jammer-signup02-next" class="signup-button" value="Next"/>
		</div>	
	</div>
</div>