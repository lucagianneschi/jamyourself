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
        <h2><?php echo $views['uploadAlbum']['create_album']; ?></h2>												
    </div>	
</div>
<div class="row formBlack-body">
    <div  class="small-6 columns">
        <input type="text" name="albumTitle" id="albumTitle" pattern="description" required/>
        <label for="albumTitle"><?php echo $views['uploadAlbum']['title']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadAlbum']['valid_title']; ?></small></label>
		<script>
			/*
			 * select2 e' il plugin per le featuring con id featuring
			 */
			$(document).ready(function() {
				
	   			getFeaturing('#featuring');
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
				    	if($value['type'] == 'JAMMER')
				    		echo '{id:'.$value['id'].',text:"'.$value['text'].'"},';										
					 }  ?>			   
				    ]
				});

			}
		</script>	
        <input type="text" name="featuring" id="featuring" pattern=""/>
        <label for="featuring"><?php echo $views['uploadAlbum']['feat']; ?></label>

        <input type="text" name="city" id="city" pattern=""/>
        <label for="city"><?php echo $views['uploadAlbum']['city']; ?></label>

    </div>

    <div  class="small-6 columns">
        <label for="description"><?php echo $views['uploadAlbum']['description']; ?><span class="orange">*</span><small class="error"><?php echo $views['uploadAlbum']['valid_description']; ?></small>		
	    <textarea name="description" id="description" pattern="description" maxlength="200" rows="100" required style="height: 155px; margin-bottom: 30px !important;"></textarea></label>		 
    </div>

</div>
<div class="row">
    <div  class="small-6 columns">
        <div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span><?php echo $views['mandatory_fields']; ?></div>
    </div>	
    <div  class="small-6 columns" >
        <input type="button" name="uploadAlbum02-next" id="uploadAlbum02-next" class="buttonNext" value="<?php echo $views['next']; ?>" style="float: right;"/>
    </div>	
</div>