<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div id="venue-signup03" class="no-display">
    <div class="row">
	<div  class="large-12 columns signup-title">
	    <h2><?php echo $views['signup']['venue_description']; ?></h2>		
	</div>	
    </div>
    <div class="row signup-body">
	<div  class="small-6 columns">
	    <div class="row signup-bottom">
		<div  class="small-12 columns">
		    <!------------------------------------------------ DESCRIPTION --------------------------------->
		    <label for="venue-description"><?php echo $views['signup']['description']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_description']; ?></small></label>			
		    <textarea name="venue-description" id="venue-description" pattern="description" maxlength="800" required></textarea>
		</div>
	    </div>
	    <div class="row">
		<div  class="small-12 columns">
		    <div class="row">
			<div  class="small-3 columns">
			    <p class="text grey-light inline"><?php echo $views['signup']['links']; ?></p>
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
			<input type="text" name="venue-facebook" id="venue-facebook" pattern="url" placeholder="http://"/>								
			<label for="venue-facebook" ><?php echo $views['signup']['facebook']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>
		    <div class="twitter-label no-display">
			<input type="text" name="venue-twitter" id="venue-twitter" pattern="url" placeholder="http://"/>								
			<label for="venue-twitter"><?php echo $views['signup']['twitter']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>
		    <div class="google-label no-display">
			<input type="text" name="venue-google" id="venue-google" pattern="url" placeholder="http://"/>								
			<label for="venue-google" ><?php echo $views['signup']['google_plus']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>	
		    <div class="youtube-label no-display">
			<input type="text" name="venue-youtube" id="venue-youtube" pattern="url" placeholder="http://"/>								
			<label for="venue-youtube"><?php echo $views['signup']['youtube']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>	
		    <div class="web-label no-display">
			<input type="text" name="venue-web" id="venue-web" pattern="url" placeholder="http://"/>								
			<label for="venue-web"><?php echo $views['signup']['website']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>	

		</div>	
	    </div>		
	</div>
	<div  class="small-6 columns">
	    <div class="row" style="padding-top: 30px">
		<div  class="small-12 columns">
		    <div class="label-signup-genre text grey-light"><?php echo $views['signup']['select_genre_venue']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['select_genre']; ?></small></div>
		</div>	
	    </div>
	    <div class="row" >
		<div  class="small-12 columns">
		    <div class="signup-genre">
				<?php 
					$index = 0;
					foreach ($views['tag']['localType'] as $key => $value) { ?>
						<input onclick="checkmax(this,5)" type="checkbox" name="venue-genre[<?php echo $index ?>]" id="venue-genre[<?php echo $index ?>]" value="<?php echo $key ?>" class="no-display">
						<label for="venue-genre[<?php echo $index ?>]"><?php echo $value ?></label>
					<?php 
					$index++;
					} ?>
		    </div>
		</div>	
	    </div>		
	</div>
    </div>
    <div class="row">
	<div  class="small-3 small-offset-1 columns">
	    <div class="note grey-light signup-note"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
	</div>	
	<div  class="small-8 columns">
	    <input type="button" name="venue-signup03-back" id="venue-signup03-back" class="signup-button-back" value="<?php echo $views['go_back']; ?>"/>
	    <input type="submit" name="venue-signup03-next" id="venue-signup03-next" class="signup-button" value="<?php echo $views['complete']; ?>"/>
	</div>	
    </div>
</div>