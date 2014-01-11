<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div id="spotter-signup03" class="no-display">
    <div class="row">
	<div  class="large-12 columns signup-title">
	    <h2><?php echo $views['signup']['more_info']; ?></h2>		
	</div>	
    </div>
    <div class="row signup-body">
	<div  class="small-6 columns">
	    <div class="row signup-bottom">
		<div  class="small-12 columns">
		    <!------------------------------------------------ DESCRIPTION --------------------------------->
		    <label for="spotter-description"><?php echo $views['signup']['description']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_description']; ?></small></label>			
		    <textarea name="spotter-description" id="spotter-description" pattern="description" maxlength="200" required></textarea>
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
			<input type="text" name="spotter-facebook" id="spotter-facebook" pattern="url" placeholder="http://"/>								
			<label for="spotter-facebook" ><?php echo $views['signup']['facebook']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>
		    <div class="twitter-label no-display">
			<input type="text" name="spotter-twitter" id="spotter-twitter" pattern="url" placeholder="http://"/>								
			<label for="spotter-twitter"><?php echo $views['signup']['twitter']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>
		    <div  class="google-label no-display">
			<input type="text" name="spotter-google" id="spotter-google" pattern="url" placeholder="http://"/>								
			<label for="spotter-google" ><?php echo $views['signup']['google_plus']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>	
		    <div class="youtube-label no-display">
			<input type="text" name="spotter-youtube" id="spotter-youtube" pattern="url" placeholder="http://"/>								
			<label for="spotter-youtube"><?php echo $views['signup']['youtube']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>	
		    <div class="web-label no-display">
			<input type="text" name="spotter-web" id="spotter-web" pattern="url" placeholder="http://"/>								
			<label for="spotter-web"><?php echo $views['signup']['website']; ?><small class="error"><?php echo $views['signup']['valid_url']; ?></small></label>
		    </div>	

		</div>	
	    </div>		
	</div>
	<div  class="small-6 columns">
	    <div class="row signup-bottom">
		<div  class="small-1 columns">
		    <p class="text grey-light inline"><?php echo $views['signup']['sex']; ?></p>					
		</div>
		<div  class="small-11 columns inline signup-radio">			
		    <input type="radio" name="spotter-sex" id="spotter-sex-m" class="no-display inline" value="M"><label for="spotter-sex-m" class="inline">M</label>
		    <input type="radio" name="spotter-sex" id="spotter-sex-f" class="no-display inline" value="F"><label for="spotter-sex-f" class="inline">F</label>
		    <input type="radio" name="spotter-sex" id="spotter-sex-none" class="no-display inline" value="ND" checked><label for="spotter-sex-none" class="inline" ><?php echo $views['signup']['nd_sex']; ?></label>
		</div>	
	    </div>

	    <div class="row spotter-birthday">
		<div  class="small-3 columns">
		    <select name="spotter-birth-day" id="spotter-birth-day" class="styled-select">
			<option ><?php echo $views['signup']['day']; ?></option>						 
			<?php
			for ($i = 1; $i <= 31; $i++) {
			    echo '<option value=' . $i . '>' . $i . '</option>';
			}
			?>
		    </select>
		</div>
		<div  class="small-6 columns">	
		    <select name="spotter-birth-month" id="spotter-birth-month">
			<option ><?php echo $views['signup']['month']; ?></option>
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
			<option><?php echo $views['signup']['year']; ?></option>
			<?php
			for ($i = 1920; $i <= 2015; $i++) {
			    echo '<option value=' . $i . '>' . $i . '</option>';
			}
			?>
		    </select>							

		</div>
	    </div>
	    <div class="row">
		<div  class="small-12 columns">
		    <label for="spotter-birthday"><?php echo $views['signup']['birth_date']; ?></label>
		</div>		
	    </div>			
	</div>
    </div>
    <div class="row">
	<div  class="small-3 small-offset-1 columns">
	    <div class="note grey-light signup-note"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
	</div>	
	<div  class="small-8 columns">
	    <input type="button" name="spotter-signup03-back" id="spotter-signup03-back" class="signup-button-back" value="Go Back"/>
	    <input type="submit" name="spotter-signup03-next" id="spotter-signup03-next" class="signup-button" value="Complete"/>
	</div>	
    </div>		
</div>