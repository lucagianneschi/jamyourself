<div id="signup01-signup01" class="no-display">
	<div class="row">
		<div  class="large-12 columns signup-title">
			<h2 class="signup-no-spotter">Something about you...</h2>		
		</div>	
	</div>
	<div class="row" id="signup-fb1">							
		<div  class="large-12 columns align-center" >
			<input type="button" class="button signup-button-fb"  value="Connect with Facebook"/>
		</div>
	</div>	
	<div class="row" id="signup-fb2">							
		<div  class="large-12 columns align-center" >
			<h3>...or fill out this form!</h3>	
		</div>
	</div>		
	<div class="row">							
		<div  class="small-12 columns signup-body">
			<div class="row signup01-username-singup01">
				<div  class="small-5 small-centered columns">									
					<input type="text" name="signup01-username" id="signup01-username" />								
					<label for="signup01-username" id="signup01-username-spotter">Username <span class="orange">*</span><span class="no-display error red"> Please enter a valid Username</span></label>
					<label for="signup01-username" id="signup01-username-jammer">Artist / Group name <span class="orange">*</span><span class="no-display error red"> Please enter a valid name Artist</span></label>
					<label for="signup01-username" id="signup01-username-venue">Name of your venue <span class="orange">*</span><span class="no-display error red"> Please enter a valid name Venue</span></label>
				</div>							
			</div>								
			<div class="row signup01-mail-signup01">
				<div  class="small-5 small-centered columns">									
					<input type="text" name="signup01-mail" id="signup01-mail"/>
					<label for="signup01-mail" >Mail <span class="orange">*</span><span class="no-display error red"> Please enter a valid mail</span></label>
				</div>
							
			</div>
			<div class="row signup01-password-signup01">
				<div  class="small-5 small-centered  columns">									
					<input type="password" name="signup01-password" id="signup01-password"/>
			<label for="signup01-password" >Password <span class="orange">*</span><span class="no-display error red"> Please enter a valid password</span></label>
				</div>
								
			</div>
			<div class="row signup01-verifyPassword-signup01">
				<div  class="small-5 small-centered   columns">									
					<input type="password" name="signup01-verifyPassword" id="signup01-verifyPassword"/>
			<label for="signup01-verifyPassword" >Verify Password <span class="orange">*</span><span class="no-display error red"> Please enter a valid password</span></label>	
				</div>
								
			</div>
			<div  class="row">
				<div  class="small-5 small-centered   columns">
					<div id="signup01-captcha" >
						 
						<?php
							
							require_once UTILITY_DIR.'recaptcha.class.php';
							$captch = new Recaptcha();
							echo $captch->getRecaptchaHtml();
							  
						?>
					</div>									
				</div>	
			</div>
		</div>			
	</div>
	<div class="row">
		<div  class="small-3 small-offset-1 columns">
			<div class="note grey-light signup-note"><span class="orange">* </span> Mandatory fields</div>
		</div>	
		<div  class="small-7 small-offset-1 columns">
			<input type="button" name="spotter-signup01-next" id="spotter-signup01-next" class="signup-button" value="Next"/>
			<input type="button" name="jammer-signup01-next" id="jammer-signup01-next" class="signup-button" value="Next"/>
			<input type="button" name="venue-signup01-next" id="venue-signup01-next" class="signup-button" value="Next"/>
		</div>	
	</div>	
</div>