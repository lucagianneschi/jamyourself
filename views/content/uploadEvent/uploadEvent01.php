<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div class="row" id="uploadEvent01">
    <div  class="large-12 columns formBlack-title">
        <h2><?php echo $views['uploadEvent']['create']; ?></h2>												
    </div>	
</div>

<div class="row formBlack-body">
    <div  class="small-6 columns">
        <label for="eventTitle"><input type="text" name="eventTitle" id="eventTitle" required pattern="general">
	    <?php echo $views['uploadEvent']['event_title']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadEvent']['valid_title']; ?></small></label>
	<!--------------------------- UPLOAD IMAGE -------------------------------->
        <div class="row upload-box">
            <div  class="small-3 columns" id="tumbnail-pane">
		<div class="thumbnail-box">
		    <div id="uploadImage_tumbnail-pane" class="uploadImage_tumbnail-pane">
			<img id="uploadImage_tumbnail" name="uploadImage_tumbnail" alt/>
		    </div>
		</div>
            </div>
            <div  class="small-9 columns">							        						
                <a  class="text orange" data-reveal-id="upload"><?php echo $views['uploadEvent']['upload_image_mandatory']; ?></a>

                <div id="upload" class="reveal-modal upload-reveal">

                    <div class="row">
                        <div  class="large-12 columns formBlack-title">
                            <h2><?php echo $views['uploadEvent']['upload_image']; ?></h2>		
                        </div>	
                    </div>
                    <div class="row">							
                        <div  class="large-12 columns formBlack-title">                                                                                                           	
                            <a class="buttonOrange _add sottotitle" id="uploader_img_button"><?php echo $views['uploadEvent']['select_file']; ?></a>			
                        </div>

                    </div>
                    <div class="row">							
                        <div  class="small-10 small-centered columns align-center">
			    <div id="uploadImage_preview_box">
				<img src="" id="spotter_uploadImage_preview" alt/>
				<input type="hidden" id="spotter_x" name="crop_x" value="0">
				<input type="hidden" id="spotter_y" name="crop_y" value="0">
				<input type="hidden" id="spotter_w" name="crop_w" value="100">
				<input type="hidden" id="spotter_h" name="crop_h" value="100">
			    </div>
                        </div>

                    </div>

                    <div class="row">							
                        <div  class="small-3 small-offset-9 columns">
                            <input type="button" id="uploadImage_save" name="uploadImage_save" class="buttonNext no-display" value="<?php echo $views['save']; ?>">
                        </div>
                    </div>

                </div>							
            </div>	
        </div>
	<!--------------------------- FINE UPLOAD IMAGE -------------------------------->
	<div class="row">
	    <div  class="small-8 columns">
		<input type="text" name="date" id="date" required>
		<label for="date"><?php echo $views['uploadEvent']['date']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadEvent']['valid_date']; ?></small></label>

	    </div>			
	    <div  class="small-4 columns">
		<select name="hours" id="hours">

		</select>
		<label for="hours"><?php echo $views['uploadEvent']['hours']; ?></label>
	    </div>
	</div>

        <label for="url"><input type="text" name="featuring" id="jammers" pattern="">
	    <?php echo $views['uploadEvent']['jammer_name']; ?><small class="error"><?php echo $views['uploadEvent']['valid_jammer']; ?></small></label>

	<label for="venueName"><input type="text" name="venueName" id="venueName" required pattern="general" >
	    <?php echo $views['uploadEvent']['venue_name']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadEvent']['valid_venue']; ?></small></label>

<!--		<label for="adress"><input type="text" name="adress" id="adress" required pattern="">
        Adress <span class="orange">*</span><small class="error"> Please enter a valid Adress</small></label>
	-->

        <label for="city"><input type="text" name="city" id="city" required pattern="general">
	    <?php echo $views['uploadEvent']['city']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadEvent']['valid_city']; ?></small></label>

    </div>

    <div  class="small-6 columns">
	<div class="row">
	    <label for="description"><?php echo $views['uploadEvent']['description']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadEvent']['valid_description']; ?></small>		
		<textarea name="description"  pattern="general" id="description"  maxlength="200" rows="100" required style="height: 155px; margin-bottom: 30px !important;"></textarea></label>		
	</div>
	<div class="row">
	    <label style="padding-bottom: 0px !important;" id="label-tag-localType"><?php echo $views['uploadEvent']['select_genre']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadEvent']['enter_genre']; ?></small></label>		
	    <div id="tag-localType">
		<?php
		$index = 0;
		foreach ($views['tag']['localType'] as $key => $value) {
		    ?>
    		<input onclick="checkmaxLocalType(this, 1)" type="checkbox" name="tag-localType<?php echo $index ?>" id="tag-localType<?php echo $index ?>" value="<?php echo $key ?>" class="no-display">
    		<label for="tag-localType<?php echo $index ?>"><?php echo $value ?></label>
		    <?php
		    $index++;
		}
		?>
	    </div>
        </div>
        <div class="row" style="margin-top: 30px">
	    <label style="padding-bottom: 0px !important;" id="label-tag-music"><?php echo $views['uploadEvent']['select_genre_music']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadEvent']['enter_genre_music']; ?></small></label>		
	    <div id="tag-music">
		<?php
		$index = 0;
		foreach ($views['tag']['music'] as $key => $value) {
		    ?>
    		<input onclick="checkmaxGenre(this, 1)" type="checkbox" name="tag-music<?php echo $index ?>" id="tag-music<?php echo $index ?>" value="<?php echo $key ?>" class="no-display">
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
    <div  class="small-6 columns">
        <div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
    </div>	
    <div  class="small-6 columns" >
        <input type="submit" name="uploadEvent01-next" id="uploadEvent01-next" class="buttonNext" value="<?php echo $views['create']; ?>" style="float: right;"/>
    </div>	
</div>