<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div class="row">
    <div  class="large-12 columns formBlack-title">
        <h2><?php echo $views['uploadRecord']['create_record']; ?></h2>												
    </div>	
</div>
<div class="row formBlack-body">
    <div  class="small-6 columns">
        <input type="text" name="recordTitle" id="recordTitle" pattern="" required/>
        <label for="recordTitle"><?php echo $views['uploadRecord']['title']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadRecord']['valid_title']; ?></small></label>


	<!--------------------------- UPLOAD IMAGE -------------------------------->
        <div class="row upload-box">
            <div  class="small-3 columns" id="tumbnail-pane">
		<div class="signup-image">
		    <div id="uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane">
			<img id="uploadImage_tumbnail" name="uploadImage_tumbnail"/>
		    </div>
		</div>
            </div>
            <div  class="small-9 columns">							        						
                <a  class="text orange" data-reveal-id="upload"><?php echo $views['uploadRecord']['upload_image']; ?></a>

                <div id="upload" class="reveal-modal upload-reveal">

                    <div class="row">
                        <div  class="large-12 columns formBlack-title">
                            <h2><?php echo $views['uploadRecord']['upload_image']; ?></h2>		
                        </div>	
                    </div>
                    <div class="row">							
                        <div  class="large-12 columns formBlack-title">                                                                                                           	
                            <a class="buttonOrange _add sottotitle" id="uploader_img_button"><?php echo $views['uploadRecord']['select_file']; ?></a>			
                        </div>

                    </div>
                    <div class="row">							
                        <div  class="small-10 small-centered columns align-center">
			    <div id="uploadImage_preview_box">
				<img src="" id="spotter_uploadImage_preview"/>
				<input type="hidden" id="spotter_x" name="crop_x" value="0"/>
				<input type="hidden" id="spotter_y" name="crop_y" value="0"/>
				<input type="hidden" id="spotter_w" name="crop_w" value="100"/>
				<input type="hidden" id="spotter_h" name="crop_h" value="100"/>
			    </div>
                        </div>

                    </div>

                    <div class="row">							
                        <div  class="small-3 small-offset-9 columns">
                            <input type="button" id="uploadImage_save" name="uploadImage_save" class="buttonNext no-display" value="Save"/>
                        </div>
                    </div>

                </div>							
            </div>	
        </div>
	<!--------------------------- FINE UPLOAD IMAGE -------------------------------->

        <input type="text" name="label" id="label" pattern=""/>
        <label for="label"><?php echo $views['uploadRecord']['label']; ?></label>

        <input type="text" name="urlBuy" id="urlBuy" pattern="" placeholder="http://"/>
        <label for="urlBuy"><?php echo $views['uploadRecord']['buy']; ?></label>

        <input type="text" name="albumFeaturing" id="albumFeaturing" pattern="">
        <label for="albumFeaturing"><?php echo $views['uploadRecord']['feat']; ?></label>

        <input type="text" name="year" id="year" pattern=""/>
        <label for="year"><?php echo $views['uploadRecord']['year']; ?></label>

        <input type="text" name="city" id="city" pattern=""/>
        <label for="city"><?php echo $views['uploadRecord']['city']; ?></label>

    </div>

    <div  class="small-6 columns">

        <label for="description"><?php echo $views['uploadRecord']['description']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadRecord']['valid_description']; ?></small>		
	    <textarea name="description" id="description" pattern="description" maxlength="200" rows="100" required style="height: 155px; margin-bottom: 30px !important;"></textarea></label>		

        <label style="padding-bottom: 0px !important;"><?php echo $views['uploadRecord']['select_genre']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadRecord']['enter_genre']; ?></small></label>		
        <div id="tag-music"></div>

    </div>

</div>
<div class="row">
    <div  class="small-6 columns">
        <div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
    </div>	
    <div  class="small-6 columns" >
        <input type="button" name="uploadRecord02-next" id="uploadRecord02-next" class="buttonNext" value="Next" style="float: right;"/>
    </div>	
</div>