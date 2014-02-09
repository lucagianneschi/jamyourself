<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div id="spotter-signup02" class="no-display">
    <div class="row">
        <div  class="large-12 columns signup-title">
            <h2><?php echo $views['signup']['tell_us']; ?></h2>		
        </div>	
    </div>
    <div class="row signup-body">
        <div  class="small-6 columns">

            <div class="row signup-box-image">
                <div  class="small-3 columns signup-box-avatar">									
                    <div class="signup-image">
                        <div id="spotter_uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane">
                            <img src="resources/images/signup/spotter.png" id="spotter_uploadImage_tumbnail" name="spotter_uploadImage_tumbnail" alt/>
                        </div>
                    </div>
                </div>
                <div  class="small-9 columns signup-box-avatar-text">							        						
                    <a data-reveal-id="spotter-uploadImage" class="text orange"><?php echo $views['signup']['upload_image']; ?></a>
                    <div id="progressbarSpotter"  class="signupProgressBar"></div>
                    <div id="spotter-uploadImage" class="reveal-modal uploadImage-reveal">
                        <div class="uploadImage" >
                            <div class="row">
                                <div  class="large-12 columns signup-title">
                                    <h2><?php echo $views['signup']['upload_image']; ?></h2>		
                                </div>	
                            </div>
                            <div class="row">
                                <div id="spotter_container" class="small-5 small-centered columns align-center">
                                    <div id="filelist"></div>
                                    <br />
                                    <label class="uploadImage_file_label" for="spotter_uploadImage_file" id="spotter_uploadImage_file_label" style="width: 300px;"><?php echo $views['signup']['select_file']; ?></label>
                                </div>
                            </div>
                            <div class="row">							
                                <div  class="small-10 small-centered columns align-center spotter_uploadImage_box-preview">
                                    <div id="spotter_uploadImage_preview_box">
                                        <img src="" id="spotter_uploadImage_preview" alt/>
                                        <input type="hidden" id="spotter_x" name="spotter_x" value="0"/>
                                        <input type="hidden" id="spotter_y" name="spotter_y" value="0"/>
                                        <input type="hidden" id="spotter_w" name="spotter_w" value="100"/>
                                        <input type="hidden" id="spotter_h" name="spotter_h" value="100"/>
                                    </div>											   		
                                </div>

                            </div>

                            <div class="row">							
                                <div  class="small-3 small-offset-9 columns">
                                    <input type="button" id="spotter_uploadImage_save" name="spotter_uploadImage_save" class="signup-button no-display uploadImage_save" value="<?php echo $views['save']; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>							
                </div>	
            </div>
            <div class="row spotter-firstname-singup02">
                <div  class="small-12 columns">									
                    <input type="text" name="spotter-firstname" id="spotter-firstname" pattern="username" maxlength="50" />								
                    <label for="spotter-firstname" ><?php echo $views['signup']['first_name']; ?><small class="error"><?php echo $views['signup']['valid_first_name']; ?></small></label>
                </div>							
            </div>
            <div class="row spotter-lastname-singup02">
                <div  class="small-12 columns">									
                    <input type="text" name="spotter-lastname" id="spotter-lastname" pattern="username" maxlength="50" />								
                    <label for="spotter-lastname" ><?php echo $views['signup']['last_name']; ?><small class="error"><?php echo $views['signup']['valid_last_name']; ?></small></label>
                </div>							
            </div>

            <div class="row spotter-city-singup02">
                <div  class="small-12 columns">									
                    <input type="text" name="spotter-location" id="spotter-city" pattern="description" maxlength="50" required />					
                    <label for="spotter-city " class="inline"><?php echo $views['signup']['city']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_city']; ?></small></label>

                    <a href="#" data-reveal-id="spotter-myModal" class="location-reveal text grey"><?php echo $views['signup']['localization_question']; ?></a>
                    <div id="spotter-myModal" class="reveal-modal">
                        <h3><?php echo $views['signup']['localization_question']; ?></h3>					 
                        <p class="grey"><?php echo $views['signup']['localization_answer']; ?></p>
                        <a class="close-reveal-modal">&#215;</a>
                    </div>
                </div>							
            </div>

        </div>
        <div  class="small-6 columns">
            <h3><?php echo $views['signup']['music']; ?></h3>
            <div class="row" style="padding-top: 30px">
                <div  class="small-12 columns">
                    <div class="label-signup-genre text grey-light"><?php echo $views['signup']['select_music']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['select_genre']; ?></small></div>
                </div>	
            </div>
            <div class="row" >
                <div  class="small-12 columns">
                    <div class="signup-genre">
					<?php 
					$index = 0;
					foreach ($views['tag']['music'] as $key => $value) { ?>
						<input onclick="checkmax(this,10)" type="checkbox" name="spotter-genre[<?php echo $index ?>]" id="spotter-genre[<?php echo $index ?>]" value="<?php echo $key ?>" class="no-display">
						<label for="spotter-genre[<?php echo $index ?>]"><?php echo $value ?></label>
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
            <input type="button" name="spotter-signup02-back" id="spotter-signup02-back" class="signup-button-back" value="<?php echo $views['go_back']; ?>"/>
            <input type="button" name="spotter-signup02-next" id="spotter-signup02-next" class="signup-button" value="<?php echo $views['next']; ?>"/>
        </div>	
    </div>	

</div>