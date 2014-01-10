<div id="spotter-signup03" class="no-display">
	<div class="row">
		<div  class="large-12 columns signup-title">
			<h2>Want to tell us more about you?</h2>		
		</div>	
	</div>
	<div class="row signup-body">
		<div  class="small-6 columns">
			<div class="row signup-bottom">
				<div  class="small-12 columns">
					<!------------------------------------------------ DESCRIPTION --------------------------------->
					<label for="spotter-description">Description <span class="orange">*</span><small class="error"> Please enter a valid Description</small></label>			
					<textarea name="spotter-description" id="spotter-description" pattern="description" maxlength="200" required></textarea>
				</div>
			</div>
			<div class="row">
				<div  class="small-12 columns">
					<div class="row">
						<div  class="small-3 columns">
							<p class="text grey-light inline">I’m also on</p>
						</div>
						<div  class="small-9 columns signup-social-button">
							<a class="signup-icon-social-focus _facebook-double"></a>
							<a class="signup-icon-social _twitter-double"></a>
							<a class="signup-icon-social _google-double"></a>
							<a class="signup-icon-social _youtube-double"></a>
							<a class="signup-icon-social _web-double"></a>
						</div>		
					</div>
				</div>
			</div>
			<!------------------------------------------------ SOCIAL --------------------------------->
			<div class="row signup-social">
				<div  class="small-12 columns">
					<div class="facebook-label">
						<input type="text" name="spotter-facebook" id="spotter-facebook" pattern="url" placeholder="http://"/>								
						<label for="spotter-facebook" >Url of your Facebook profile<small class="error"> Please enter a valid url</small></label>
					</div>
					<div class="twitter-label no-display">
						<input type="text" name="spotter-twitter" id="spotter-twitter" pattern="url" placeholder="http://"/>								
						<label for="spotter-twitter">Url of your Twitter profile<small class="error"> Please enter a valid url</small></label>
					</div>
					<div  class="google-label no-display">
						<input type="text" name="spotter-google" id="spotter-google" pattern="url" placeholder="http://"/>								
						<label for="spotter-google" >Url of your Google Plus profile<small class="error"> Please enter a valid url</small></label>
					</div>	
					<div class="youtube-label no-display">
						<input type="text" name="spotter-youtube" id="spotter-youtube" pattern="url" placeholder="http://"/>								
						<label for="spotter-youtube">Url of your Youtube channel<small class="error"> Please enter a valid url</small></label>
					</div>	
					<div class="web-label no-display">
						<input type="text" name="spotter-web" id="spotter-web" pattern="url" placeholder="http://"/>								
						<label for="spotter-web">Url of your Website<small class="error"> Please enter a valid url</small></label>
					</div>	
					
				</div>	
			</div>		
		</div>
		<div  class="small-6 columns">
			<div class="row signup-bottom">
				<div  class="small-1 columns">
					<p class="text grey-light inline">I’m </p>					
				</div>
				<div  class="small-11 columns inline signup-radio">			
					<input type="radio" name="spotter-sex" id="spotter-sex-m" class="no-display inline" value="M"><label for="spotter-sex-m" class="inline">M</label>
					<input type="radio" name="spotter-sex" id="spotter-sex-f" class="no-display inline" value="F"><label for="spotter-sex-f" class="inline">F</label>
					<input type="radio" name="spotter-sex" id="spotter-sex-none" class="no-display inline" value="ND" checked><label for="spotter-sex-none" class="inline" >Don't want to declare</label>
				</div>	
			</div>
			
			<div class="row spotter-birthday">
				<div  class="small-3 columns">
					<select name="spotter-birth-day" id="spotter-birth-day" class="styled-select">
						<option >- Day -</option>						 
						<?php
							for($i=1;$i<=31;$i++){
	    						echo '<option value='.$i.'>'.$i.'</option>';
							}
						?>
					</select>
				</div>
				<div  class="small-6 columns">	
					<select name="spotter-birth-month" id="spotter-birth-month">
						<option >- Month -</option>
						<option value="January">1</option>
						<option value="February">2</option>
						<option value="Mars">3</option>
						<option value="April">4</option>
						<option value="May">5</option>
						<option value="June">6</option>
						<option value="July">7</option>
						<option value="August">8</option>
						<option value="September">9</option>
						<option value="October">10</option>
						<option value="November">11</option>
						<option value="December">12</option>
					</select>
				</div>
				<div  class="small-3 columns">	
					<select name="spotter-birth-year" id="spotter-birth-year">
						<option>- Year -</option>
					<?php
						for($i=1920;$i<=2015;$i++){
	    					echo '<option value='.$i.'>'.$i.'</option>';
						}
					?>
					</select>							
					
				</div>
			</div>
			<div class="row">
				<div  class="small-12 columns">
					<label for="spotter-birthday">Date of birth</label>
				</div>		
			</div>			
		</div>
	</div>
	<div class="row">
		<div  class="small-3 small-offset-1 columns">
			<div class="note grey-light signup-note"><span class="orange">* </span> Mandatory fields</div>
		</div>	
		<div  class="small-8 columns">
			<input type="button" name="spotter-signup03-back" id="spotter-signup03-back" class="signup-button-back" value="Go Back"/>
			<input type="submit" name="spotter-signup03-next" id="spotter-signup03-next" class="signup-button" value="Complete"/>
		</div>	
	</div>		
</div>