<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div id="signup01-signup01" class="no-display">
    <div class="row">
	<div  class="large-12 columns signup-title">
	    <h2 class="signup-no-spotter"><?php echo $views['signup']['tell_something']; ?></h2>		
	</div>	
    </div>
    <div class="row" id="signup-fb1">							
	<div  class="large-12 columns align-center" >
	    <input type="button" class="button signup-button-fb"  value="<?php echo $views['signup']['fb_connect']; ?>"/>
	</div>
    </div>	
    <div class="row" id="signup-fb2">							
	<div  class="large-12 columns align-center" >
	    <h3><?php echo $views['signup']['form']; ?></h3>	
	</div>
    </div>		
    <div class="row">							
	<div  class="small-12 columns signup-body">

	    <div class="row signup01-username-singup01">
		<div  class="small-5 small-centered columns input-wrapper">									
		    <input type="text" name="signup01-username" id="signup01-username" pattern="username" maxlength="50" required/>								
		    <label for="signup01-username" id="signup01-username-spotter"><?php echo $views['signup']['username']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_username']; ?></small></label>
		    <label for="signup01-username" id="signup01-username-jammer"><?php echo $views['signup']['artist_group']; ?><span class="orange">*</span><small class="error "><?php echo $views['signup']['valid_artist_group']; ?></small></label>
		    <label for="signup01-username" id="signup01-username-venue"><?php echo $views['signup']['venue_name']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_venue_name']; ?></small></label>
		</div>
	    </div>								

	    <div class="row signup01-mail-signup01">
		<div  class="small-5 small-centered columns">									
		    <input type="text" name="signup01-mail" id="signup01-mail" pattern="mail" maxlength="50" required />
		    <label for="signup01-mail" ><?php echo $views['signup']['mail']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_mail']; ?></small></label>
		</div>	
	    </div>

	    <div class="row signup01-password-signup01">
		<div  class="small-5 small-centered  columns">									
		    <input type="password" name="signup01-password" id="signup01-password" pattern="password" maxlength="50" required />
		    <label for="signup01-password" ><?php echo $views['signup']['password']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_password']; ?></small></label>
		</div>								
	    </div>

	    <div class="row signup01-verifyPassword-signup01">
		<div  class="small-5 small-centered   columns">									
		    <input type="password" name="signup01-verifyPassword" id="signup01-verifyPassword" pattern="password" maxlength="50" required />
		    <label for="signup01-verifyPassword" ><?php echo $views['signup']['verify_password']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_password']; ?></small></label>	
		</div>								
	    </div>

	    <div  class="row">
		<div  class="small-5 small-centered   columns">
		    <div id="signup01-captcha" >		 

		    </div>
		    <label for="signup01-captcha" id="valid-captcha"><small class="error"><?php echo $views['signup']['valid_captcha']; ?></small></label>		
		</div>	
	    </div>
	</div>			
    </div>
    <div class="row">
	<div  class="small-4 small-offset-1 columns">
	    <div class="note grey-light signup-note"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
	</div>	
	<div  class="small-8 small-offset-1 columns">
	    <input type="button" name="signup01-back" id="signup01-back" class="signup-button-back" value="<?php echo $views['go_back']; ?>"/>
	    <input type="button" name="spotter-signup01-next" id="spotter-signup01-next" class="signup-button" value="<?php echo $views['next']; ?>"/>
	    <input type="button" name="jammer-signup01-next" id="jammer-signup01-next" class="signup-button" value="<?php echo $views['next']; ?>"/>
	    <input type="button" name="venue-signup01-next" id="venue-signup01-next" class="signup-button" value="<?php echo $views['next']; ?>"/>

	</div>	
    </div>
    <!------------------- messaggi di errori sui campi --------------------->
    <input type="hidden" id="error_field1" value="<?php echo $views['signup']['error_field1'] ?>"/>
    <input type="hidden" id="error_field2" value="<?php echo $views['signup']['error_field2'] ?>"/>
    <input type="hidden" id="error_field3" value="<?php echo $views['signup']['error_field3'] ?>"/>		
</div>