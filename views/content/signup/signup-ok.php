<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div id="signup-ok" class="no-display">
	<div class="row">
		<div  class="large-12 columns signup-title">
			<h2>Ok, let’s play!</h2>		
		</div>	
	</div>
	<div class="row">
		<div  class="large-12 columns signup-title">
			<div class="text grey-light">We sent you a verification link to the email address you used to create the account. <br>
								Click the link in that email to verify that you own this address.
			</div>		
		</div>	
	</div>
	<div class="" >
		<div class="row signup-ok">
			<div  class="small-4 columns">							
				<label for="signup-ok-explore">
					<input name="signup-ok-explore" type="radio" id="signup-ok-explore" class="no-display">
					<span class="custom radio">
                                            <img src="resources/images/avatar-signup/explore.png" class="img-grey "/>
						<img src="resources/images/avatar-signup/explore-select.png" class="img-white no-display"/>	
						<h3>Explore functionality</h3>
					</span> 
				</label>
			</div>
			<div  class="small-4 columns">
				<label for="signup-ok-checkout">
					<input name="signup-ok-checkout" type="radio" id="signup-ok-checkout" class="no-display"><span class="custom radio"></span>
					<img src="resources/images/avatar-signup/checkout.png" class="img-grey"/>
					<img src="resources/images/avatar-signup/checkout-select.png" class="no-display img-white"/>	 
					<h3>Check out the FAQ</h3>
				</label>		
			</div>
			<div  class="small-4 columns">
				<label for="signup-ok-event">
					<input name="signup-ok-event" type="radio" id="signup-ok-event" class="no-display"><span class="custom radio"></span>
					<img src="resources/images/avatar-signup/event.png" class="img-grey"/> 
					<img src="resources/images/avatar-signup/event-select.png" class="no-display img-white"/>
					<h3>Start create an event</h3>
				</label>		
			</div>	
		</div>
	</div>
</div>