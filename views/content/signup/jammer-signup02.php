<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div id="jammer-signup02"  class="no-display">
    <div class="row">
        <div  class="large-12 columns signup-title">
            <h2><span id="signup02-jammer-name-artist"></span><?php echo $views['signup']['tell_us']; ?></h2>		
        </div>	
    </div>
    <div class="row signup-body">
        <div class="row ">
            <div  class="small-12 columns">
                <div  class="small-6 columns">					
                    <div class="row signup-box-image">
                        <div  class="small-3 columns signup-box-avatar">									
                            <div class="signup-image">
                                <div id="jammer_uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane"><img src="resources/images/avatar-signup/jammer.png" id="jammer_uploadImage_tumbnail" name="jammer_uploadImage_tumbnail"/></div>
                            </div>
                        </div>
                        <div  class="small-9 columns signup-box-avatar-text">							        						
                            <a data-reveal-id="jammer-uploadImage" class="text orange"><?php echo $views['signup']['upload_image']; ?></a>
                            <div id="progressbarJammer"  class="signupProgressBar"></div>
                            <div id="jammer-uploadImage" class="reveal-modal uploadImage-reveal">
                                <div class="uploadImage" >
                                    <div class="row">
                                        <div  class="large-12 columns signup-title">
                                            <h2><?php echo $views['signup']['upload_image']; ?></h2>		
                                        </div>	
                                    </div>
                                    <div class="row">							
                                        <div id="jammer_container" class="small-5 small-centered columns align-center">
                                            <div id="filelist"><?php echo $views['signup']['invalid_image_format']; ?></div>
                                            <br />
                                            <label class="uploadImage_file_label" for="jammer_uploadImage_file" id="jammer_uploadImage_file_label" style="width: 300px;"><?php echo $views['signup']['select_file']; ?></label>
                                        </div>
                                    </div>
                                    <div class="row">							
                                        <div  class="small-10 small-centered columns align-center jammer_uploadImage_box-preview">
                                            <div id="jammer_uploadImage_preview_box">
                                                <img src="" id="jammer_uploadImage_preview"/>
                                                <input type="hidden" id="jammer_x" name="jammer_x" value="0"/>
                                                <input type="hidden" id="jammer_y" name="jammer_y" value="0"/>
                                                <input type="hidden" id="jammer_w" name="jammer_w" value="100"/>
                                                <input type="hidden" id="jammer_h" name="jammer_h" value="100"/>
                                            </div>											   		
                                        </div>

                                    </div>

                                    <div class="row">							
                                        <div  class="small-3 small-offset-9 columns">
                                            <input type="button" id="jammer_uploadImage_save" name="jammer_uploadImage_save" class="signup-button no-display uploadImage_save" value="Save"/>
                                        </div>
                                    </div>
                                </div>
                            </div>							
                        </div>	
                    </div>
                </div>
                <div  class="small-6 columns">
                    <div class="row">
                        <div  class="small-4 columns">
                            <p id="jammer-typeArtist-label" class="text grey-light inline"><?php echo $views['signup']['signing_as']; ?> <span class="orange">*</span></small></p>					
                        </div>
                        <div  class="small-8 columns inline signup-radio">			
                            <input type="radio" name="jammer-typeArtist" id="jammer-typeArtist-musician" class="no-display inline" value ="musician" required><label for="jammer-typeArtist-musician" unchecked class="inline"><?php echo $views['signup']['musician']; ?></label>
                            <input type="radio" name="jammer-typeArtist" id="jammer-typeArtist-band" class="no-display inline" value="band" required><label for="jammer-typeArtist-band" unchecked class="inline"><?php echo $views['signup']['band']; ?></label>
                        </div>	
                    </div>

                    <div class="row jammer-city-singup02">
                        <div  class="small-12 columns">									
                            <input type="text" name="jammer-location" id="jammer-city" pattern="description" maxlength="50" required />					
                            <label for="jammer-city " class="inline"><?php echo $views['signup']['city']; ?><span class="orange">*</span><small class="error"><?php echo $views['signup']['valid_city']; ?></small></label>

                            <a href="#" data-reveal-id="jammer-myModal" class="location-reveal text grey"><?php echo $views['signup']['localization_question']; ?></a>
                            <div id="jammer-myModal" class="reveal-modal">
                                <h3>Why do you ask me?</h3>					 
                                <p class="grey"><?php echo $views['signup']['localization_answer']; ?></p>
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
                    <h3><?php echo $views['signup']['components']; ?></h3>
                </div>	
            </div>
            <div class="row ">
                <div  class="small-6 columns">
                    <div class="row jammer-componentName1-singup02">
                        <div  class="small-12 columns">									
                            <input type="text" name="jammer-componentName1" id="jammer-componentName1" pattern="username" maxlength="50"/>								
                            <label for="jammer-componentName1" ><?php echo $views['signup']['name']; ?><small class="error"><?php echo $views['signup']['valid_name']; ?></small></label>
                        </div>							
                    </div>
                    <div class="row jammer-componentName2-singup02">
                        <div  class="small-12 columns">									
                            <input type="text" name="jammer-componentName2" id="jammer-componentName2" pattern="username" maxlength="50"/>								
                            <label for="jammer-componentName2" ><?php echo $views['signup']['name']; ?><small class="error"><?php echo $views['signup']['valid_name']; ?></small></label>
                        </div>							
                    </div>
                    <div id="addComponentName">

                    </div>
                </div>
                <div  class="small-6 columns">
                    <div class="row jammer-componentInstrument1-singup02">
                        <div  class="small-12 columns">
                            <select id="jammer_componentInstrument1">
                            	<option name="jammer-componentInstrument1" id="jammer-componentInstrument1" value="Accordion">Accordion</option>
                            	<?php foreach ($views['tag']['instruments'] as $key => $value) { ?>
									<option name="jammer-componentInstrument1" id="jammer-componentInstrument1" value="<?php echo $key ?>"><?php echo $value ?></option>
								<?php } ?>																
                            </select>							
                            <label for="jammer-componentInstrument1" ><?php echo $views['signup']['instrument']; ?><small class="error"><?php echo $views['signup']['valid_instrument']; ?></small></label>
                        </div>							
                    </div>
                    <div class="row jammer-componentInstrument2-singup02" >
                        <div  class="small-12 columns">									
                            <select id="jammer_componentInstrument2">
                            	<?php foreach ($views['tag']['instruments'] as $key => $value) { ?>
									<option name="jammer-componentInstrument2" id="jammer-componentInstrument2" value="<?php echo $key ?>"><?php echo $value ?></option>
								<?php } ?>																
                            </select>								
                            <label for="jammer-componentInstrument2" ><?php echo $views['signup']['instrument']; ?><small class="error"><?php echo $views['signup']['valid_instrument']; ?></small></label>
                        </div>							
                    </div>
                    <div id="addComponentInstrument">
						
                    </div>
                </div>		
            </div>
            <div class="row">
                <div  class="small-3 small-centered columns">
                    <div class="text orange addComponents" onclick="addComponent()"><?php echo $views['signup']['add_components']; ?></div>
                </div>
            </div>
        </div>			
    </div>
    <div class="row">
        <div  class="small-3 small-offset-1 columns">
            <div class="note grey-light signup-note"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
        </div>	
        <div  class="small-8 columns">
            <input type="button" name="jammer-signup02-back" id="jammer-signup02-back" class="signup-button-back" value="Go Back"/>
            <input type="button" name="jammer-signup02-next" id="jammer-signup02-next" class="signup-button" value="Next"/>
        </div>	
    </div>
</div>