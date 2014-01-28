<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div id="venue-signup02"  class="no-display">
    <div class="row">
        <div  class="large-12 columns signup-title">
            <h2><?php echo $views['signup']['tell_us_venue']; ?></h2>		
        </div>	
    </div>
    <div class="row signup-body">
        <div  class="small-6 columns">

            <div class="row signup-box-image">
                <div  class="small-3 columns signup-box-avatar">									
                    <div class="signup-image">
                        <div id="venue_uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane"><img src="resources/images/signup/venue.png" id="venue_uploadImage_tumbnail" name="venue_uploadImage_tumbnail"/></div>
                    </div>
                </div>
                <div  class="small-9 columns signup-box-avatar-text">							        						
                    <a data-reveal-id="venue-uploadImage" class="text orange"><?php echo $views['signup']['upload_image']; ?></a>
                    <div id="progressbarVenue" class="signupProgressBar"></div>
                    <div id="venue-uploadImage" class="reveal-modal uploadImage-reveal">
                        <div class="uploadImage" >
                            <div class="row">
                                <div  class="large-12 columns signup-title">
                                    <h2><?php echo $views['signup']['upload_image']; ?></h2>		
                                </div>	
                            </div>
                            <div class="row">							
                                <div id="venue_container" class="small-5 small-centered columns align-center">
                                    <div id="filelist"><?php echo $views['signup']['invalid_image_format']; ?></div>
                                    <br />
                                    <label class="uploadImage_file_label" for="venue_uploadImage_file" id="venue_uploadImage_file_label" style="width: 300px;"><?php echo $views['signup']['select_file']; ?></label>
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
                                    <input type="button" id="venue_uploadImage_save" name="venue_uploadImage_save" class="signup-button no-display uploadImage_save" value="<?php echo $views['save']; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>							
                </div>	
            </div>

        </div>
        <div  class="small-6 columns">           
            <div class="row">
                <div  class="small-12 columns">	
                    <div class="row venue-city-singup02">
                        <div  class="small-12 columns">									
                            <input type="text" name="venue-city" id="venue-city" pattern="description" required/>								
                            <label for="venue-city" style="padding-bottom: 0px !important;"><?php echo $views['signup']['address']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_address']; ?></small></label>
                        	<a href="#" data-reveal-id="venue-myModal" class="location-reveal text grey"><?php echo $views['signup']['localization_question']; ?></a>
                    		<div id="venue-myModal" class="reveal-modal">
		                        <h3><?php echo $views['signup']['localization_question']; ?></h3>					 
		                        <p class="grey"><?php echo $views['signup']['localization_answer']; ?></p>
		                        <a class="close-reveal-modal">&#215;</a>
		                    </div>
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
            <input type="button" name="venue-signup02-back" id="venue-signup02-back" class="signup-button-back" value="<?php echo $views['go_back']; ?>"/>
            <input type="button" name="venue-signup02-next" id="venue-signup02-next" class="signup-button" value="<?php echo $views['NEXT']; ?>"/>
        </div>	
    </div>
</div>