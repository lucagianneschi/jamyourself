<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
?>
<div class="bg-grey-dark">
    <div class="row formBlack" id="uploadAlbum">

	<div  class="large-12 columns">
	    <div class="row">
		<div  class="large-12 columns">
		    <h3><?php echo $views['uploadAlbum']['upload']; ?></h3>
		</div>				
	    </div>
	    <div class="row">
		<div  class="large-12 columns formBlack-box">

		    <form action="" method="POST" name="form-uploadAlbum" id="form-uploadAlbum" data-abide>
			<div id="uploadAlbum01" class="">
			    <?php require_once VIEWS_DIR . 'content/uploadAlbum/uploadAlbum01.php'; ?>
			</div>
			<div id="uploadAlbum02" class="no-display">
			    <?php require_once VIEWS_DIR . 'content/uploadAlbum/uploadAlbum02.php'; ?>
			</div>
			<div id="uploadAlbum03" class="no-display">
			    <?php require_once VIEWS_DIR . 'content/uploadAlbum/uploadAlbum03.php'; ?>
			</div>			
		    </form>

		</div>
	    </div>
	</div>

    </div>	
</div>