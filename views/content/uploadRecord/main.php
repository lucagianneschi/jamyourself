<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div class="bg-grey-dark">
    <div class="row formBlack" id="uploadRecord">
	<div  class="large-12 columns">
	    <div class="row">
		<div  class="large-12 columns">
		    <h3><?php echo $views['uploadRecord']['upload_media']; ?></h3>
		</div>				
	    </div>
	    <div class="row">
		<div  class="large-12 columns formBlack-box">
		    <form action="" method="POST" name="form-uploadRecord" id="form-uploadRecord" data-abide>
			<div id="uploadRecord01" class="">
			    <?php require_once VIEWS_DIR . 'content/uploadRecord/uploadRecord01.php'; ?>
			</div>
			<div id="uploadRecord02" class="no-display">
			    <?php require_once VIEWS_DIR . 'content/uploadRecord/uploadRecord02.php'; ?>
			</div>
			<div id="uploadRecord03" class="no-display">
			    <?php require_once VIEWS_DIR . 'content/uploadRecord/uploadRecord03.php'; ?>
			</div>			
		    </form>
		</div>
	    </div>
	</div>
    </div>	
</div>