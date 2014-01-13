<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div class="bg-grey-dark">
    <div class="row formBlack" id="uploadEvent">
	<div  class="large-12 columns">
	    <div class="row">
		<div  class="large-12 columns">
		    <h3><?php echo $views['uploadEvent']['upload']; ?></h3>
		</div>				
	    </div>
	    <div class="row">
		<div  class="large-12 columns formBlack-box">
		    <form action="javascript:creteEvent()" name="form-uploadEvent" id="form-uploadEvent" data-abide>
			<div id="uploadEvent01">
			    <?php require_once VIEWS_DIR . 'content/uploadEvent/uploadEvent01.php'; ?>
			</div>								
		    </form>
		</div>
	    </div>
	</div>
    </div>	
</div>