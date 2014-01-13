<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';

$box = $_POST['box'];
$boxArray = array();

$boxArray = explode(" ", $box);

$title = array(); 

foreach ($boxArray as $key => $value) {
	if(count($title) == 0) $title = $views[$value];
	else{
		$title = $title[$value];
	}
}


if ($box != 'comment') {
    ?>

    <div class="row">
        <div  class="large-12 columns" >
    	<h3><?php echo $title["TITLE"]; ?></h3>
    	<div class="row" >
    	    <div class="large-12 columns ">
    		<div class="box box-spinner">
    		    <div class="spinner"></div>
    		</div>
    	    </div>
    	</div>
        </div>
    </div>
    <?php
} else {
    ?>        
    <div class="row">
        <div  class="large-12 columns">                
    	<div class="box box-spinner" style="background-color: #fff; margin-bottom: 5px !important;">
    	    <div class="spinner"></div>
    	</div>                        
        </div>
    </div>



    <?php
}
?>