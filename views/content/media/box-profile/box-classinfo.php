<?php
/*
 * box userinfo
 * chiamato tramite load con:
 * data: {data: data} 
 * @data: array contenente le informazioni relative al box userInfo.box
 * 
 * box per tutti gli utenti
 */
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  


$data = $_POST['data'];
$classMedia = $_POST['classMedia'];

$title = $data['classinfo']['title'];
if($classMedia == 'record'){
	$genre = $data['classinfo']['genre'];
	$image = '../media/images/'.$data['classinfo']['cover'];
}
	
else {
	$genre = '';
	$space = '';
	if($data['classinfo']['tags'] != $boxes['NOTAG']){
		foreach ($data['classinfo']['tags'] as $key => $value) {
			$genre = $genre.$space.$value;
			$space = ', ';
		}
	}
	$image = '../media/images/'.$data['classinfo']['image'];
}


?>
<div class="row" id="profile-userInfo">
	<div class="large-12 columns">
		<h2><?php echo $title ?></h2>			
		<div class="row">
			<div class="small-12 columns">				
				<a class="ico-label _tag"><?php echo $genre ?></a>
			</div>				
		</div>		
	</div>
</div>
<div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
</div>	
			
<div class="row">
	<div class="large-12 columns">
		<img class="background" src="../media/<?php echo $data['backGround'] ?>"  onerror="this.src='../media/<?php echo $default_img['DEFBGD']; ?>'" >						
	</div>
</div> 
