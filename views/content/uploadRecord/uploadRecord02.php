<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once SERVICES_DIR . 'utils.service.php';
?>
<div class="row">
    <div  class="large-12 columns formBlack-title">
        <h2><?php echo $views['uploadRecord']['create_record']; ?></h2>												
    </div>	
</div>
<div class="row formBlack-body">
    <div  class="small-6 columns">
        <div>
	    <input type="text" name="recordTitle" id="recordTitle" pattern="general" required />
	    <label for="recordTitle"><?php echo $views['uploadRecord']['title']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadRecord']['valid_title']; ?></small></label>
	</div>

	<!--------------------------- UPLOAD IMAGE -------------------------------->
	<div class="row upload-box">
            <div  class="small-3 columns" id="tumbnail-pane">
		<div class="signup-image">
		    <div id="uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane">
                        <img id="uploadImage_tumbnail" name="uploadImage_tumbnail" alt/>
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
				<img src="" id="spotter_uploadImage_preview" alt/>
				<input type="hidden" id="spotter_x" name="crop_x" value="0" />
				<input type="hidden" id="spotter_y" name="crop_y" value="0" />
				<input type="hidden" id="spotter_w" name="crop_w" value="100" />
				<input type="hidden" id="spotter_h" name="crop_h" value="100" />
			    </div>
                        </div>

                    </div>

                    <div class="row">							
                        <div  class="small-3 small-offset-9 columns">
                            <input type="button" id="uploadImage_save" name="uploadImage_save" class="buttonNext no-display" value="<?php echo $views['save']; ?>"/>
                        </div>
                    </div>

                </div>							
            </div>	
        </div>
	<!--------------------------- FINE UPLOAD IMAGE -------------------------------->
	<div>
	    <input type="text" name="label" id="label" pattern="general"/>
	    <label for="label"><?php echo $views['uploadRecord']['label']; ?></label>
	</div>
	<div>
	    <input type="text" name="urlBuy" id="urlBuy" pattern="url" placeholder="http://"/>
	    <label for="urlBuy"><?php echo $views['uploadRecord']['buy']; ?><small class="error"><?php echo $views['uploadRecord']['valid_buy']; ?></small></label>
	</div>
	<div>
		<script>
			/*
			 * select2 e' il plugin per le featuring con id featuring
			 */
			$(document).ready(function() {				
	   			getFeaturing('#albumFeaturing');
			});
			function getFeaturing(box){
				$(box).select2({
				    multiple: true,
				    minimumInputLength: 1,
				    width: "100%",
				    data:[
				    <?php 
				    $arrayFeaturing = getFeaturingArray();
				    foreach ($arrayFeaturing as  $value) {				    	
				    		echo '{id:'.$value['id'].',text:"'.$value['text'].'"},';										
					 }  ?>			   
				    ]
				});

			}
		</script>
	    <input type="text" name="albumFeaturing" id="albumFeaturing">
	    <label for="albumFeaturing"><?php echo $views['uploadRecord']['feat']; ?></label>
	</div>
        <div>
	    <input type="text" name="year" id="year" pattern="year"/>
	    <label for="year"><?php echo $views['uploadRecord']['year']; ?><small class="error"><?php echo $views['uploadRecord']['valid_year']; ?></small></label>
	</div>
	<div>	
	    <input type="text" name="city" id="city" pattern="general"/>
	    <label for="city"><?php echo $views['uploadRecord']['city']; ?><small class="error"><?php echo $views['uploadRecord']['valid_city']; ?></small></label>
	</div>
    </div>

    <div  class="small-6 columns">
	<div>
	    <label for="description"><?php echo $views['uploadRecord']['description']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadRecord']['valid_description']; ?></small></label>			
	    <textarea name="description" id="description" pattern="general" maxlength="200" rows="100" required style="height: 155px; margin-bottom: 30px !important;"></textarea>	
	</div>
	<div>
	    <label id="labelTag" style="padding-bottom: 0px !important;"><?php echo $views['uploadRecord']['select_genre']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadRecord']['enter_genre']; ?></small></label>		
	    <div id="tag-music">
		<?php
		$index = 0;
		foreach ($views['tag']['music'] as $key => $value) {
		    ?>
    		<input type="checkbox" name="tag-music<?php echo $index ?>" id="tag-music<?php echo $index ?>" value="<?php echo $key ?>" class="no-display">
    		<label for="tag-music<?php echo $index ?>"><?php echo $value ?></label>	
		    <?php
		    $index++;
		}
		?>
	    </div>
	</div>
    </div>

</div>
<div class="row">
    <div  class="small-2 columns">
        <div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
    </div>	
    <div  class="small-10 columns" >
	<input type="button" name="uploadRecord02-back" id="uploadRecord02-back" class="buttonBlack" value="<?php echo $views['go_back']; ?>"/>
        <input type="button" name="uploadRecord02-next" id="uploadRecord02-next" class="buttonNext" value="<?php echo $views['next']; ?>" style="float: right;"/>
    </div>	
</div>