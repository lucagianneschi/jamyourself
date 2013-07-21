<div id='captcha-none' class="no-display">
	
</div>
<div class="bg-grey-dark">
<div class="row" id="signup">
	<div  class="large-12 columns">
		<div class="row">
			<div  class="small-7 columns">
				<h3>Enrollment</h3>
			</div>
			<div  class="small-5 columns">
				<div class="signup-labelStep no-display" id="signup-labelStep-step3">STEP 3</div>
				<div class="signup-labelStep no-display" id="signup-labelStep-step2">STEP 2</div>
				<div class="signup-labelStep no-display" id="signup-labelStep-step1">STEP 1</div>
			</div>
		</div>	
	
	<div class="row">
		<div  class="large-12 columns ">
			<div class="signup-box" >
				
				<form action="" method="POST" name="form-signup" id="form-signup">
					<div id="signup01">
						<div class="row">
							<div  class="large-12 columns signup-title">
								<h2>Sign up as...</h2>		
							</div>	
						</div>
						<div class="row">
							<div  class="small-4 columns">							
								<label for="signup-typeUser-spotter">
									<input name="signup-typeUser" type="radio" id="signup-typeUser-spotter" class="no-display">
									<span class="custom radio">
										<img src="resources/images/avatar-signup/spotter.png" class="img-grey "/>
										<img src="resources/images/avatar-signup/spotter-select.png" class="img-white no-display"/>	
										<h3>Spotter</h3>
										<div class="text">I’m a music lover</div>
									</span> 
								</label>
							</div>
							<div  class="small-4 columns">
								<label for="signup-typeUser-jammer">
	     	 						<input name="signup-typeUser" type="radio" id="signup-typeUser-jammer" class="no-display"><span class="custom radio"></span>
	     	 						<img src="resources/images/avatar-signup/jammer.png" class="img-grey"/>
	     	 						<img src="resources/images/avatar-signup/jammer-select.png" class="no-display img-white"/>	 
									<h3>Jammer</h3>
									<div class="text">I’m an artist / I play a band</div>
								</label>		
							</div>
							<div  class="small-4 columns">
								<label for="signup-typeUser-venue">
	      							<input name="signup-typeUser" type="radio" id="signup-typeUser-venue" class="no-display"><span class="custom radio"></span>
	      							<img src="resources/images/avatar-signup/venue.png" class="img-grey"/> 
	      							<img src="resources/images/avatar-signup/venue-select.png" class="no-display img-white"/>
	      							<h3>Venue</h3>
	      							<div class="text">I own a music club / a place for gigs and events</div>
	      						</label>		
							</div>	
						</div>
					</div>
					<!--------------------------------------- SPOTTER signup01 ------------------------------------------------>					
					<?php require_once(VIEWS_DIR.'content/signup/signup-signup01.php');?>
					<!--------------------------------------- SPOTTER signup02 ------------------------------------------------>
					<?php require_once(VIEWS_DIR.'content/signup/spotter-signup02.php');?>
					<!--------------------------------------- SPOTTER signup03 ------------------------------------------------>
					<?php require_once(VIEWS_DIR.'content/signup/spotter-signup03.php');?>
					<!--------------------------------------- JAMMER signup02 ------------------------------------------------>
					<?php require_once(VIEWS_DIR.'content/signup/jammer-signup02.php');?>
					<!--------------------------------------- JAMMER signup03 ------------------------------------------------>
					<?php require_once(VIEWS_DIR.'content/signup/jammer-signup03.php');?>
					<!--------------------------------------- VENUE signup02 ------------------------------------------------>
					<?php require_once(VIEWS_DIR.'content/signup/venue-signup02.php');?>
					<!--------------------------------------- VENUE signup03 ------------------------------------------------>	
					<?php require_once(VIEWS_DIR.'content/signup/venue-signup03.php');?>	
					
					
								
				</form>	
				<!--------------------------------------- SIGNUP OK ------------------------------------------------>	
					<?php require_once(VIEWS_DIR.'content/signup/signup-ok.php');?>	
			</div>
		</div>
	</div>
	</div> 
</div>
</div>