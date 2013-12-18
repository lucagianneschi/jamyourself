<?php

$box = $_POST['box'];

 if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';   

?>

<div class="row">
	<div  class="large-12 columns">
		<h3><?php echo $views['media'][$box]["TITLE"];?></h3>
		<div class="row" >
			<div class="large-12 columns ">
				<div class="box box-spinner">
					<div class="spinner"></div>
				</div>
			</div>
		</div>
	</div>
</div>