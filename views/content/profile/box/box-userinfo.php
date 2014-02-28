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
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once SERVICES_DIR . 'fileManager.service.php';

$city = $user->getCity();
switch ($user->getType()) {
    case 'JAMMER':
	$defaultImage = DEFAVATARJAMMER;
	break;
    case 'VENUE':
	$defaultImage = DEFAVATARVENUE;
	break;
    case 'SPOTTER':
	$defaultImage = DEFAVATARSPOTTER;
	break;
}
$music = '';
$space = '';

#TODO
/*
foreach ($user->getMusic() as $key => $value) {
    $music = $music . $space . $views['tag']['music'][$value];
    $space = ', ';
}
*/
$userinfo_pin = $city == '' ? '' : '_pin';
$userinfo_note = $music == '' ? '' : '_note';
$fileManagerService = new FileManagerService();
$pathPicture = $fileManagerService->getPhotoPath($user->getId(), $user->getAvatar());
$pathBackground = $fileManagerService->getPhotoPath($user->getId(), $user->getBackground());
?>
<div class="row" id="profile-userInfo">
    <div class="large-12 columns">
	<h2><?php echo $user->getUsername(); ?></h2>
	<div class="row">
	    <div class="small-12 columns">				
		<a class="ico-label <?php echo $userinfo_pin ?>"><?php echo $city; ?></a>
		<a class="ico-label <?php echo $userinfo_note ?>"><?php echo $music; ?></a>
	    </div>				
	</div>		
    </div>
</div>
<div class="row">
    <div  class="large-12 columns"><div class="line"></div></div>
</div>	

<div class="row">
    <div class="large-12 columns">
        <img class="background" src="<?php echo $pathBackground; ?>"  onerror="this.src='<?php echo DEFBGD; ?>'" alt="">
	<img class="picture" src="<?php echo $pathPicture; ?>" onerror="this.src='<?php echo $defaultImage; ?>'" width="150" height="150" alt="<?php echo $user->getUsername(); ?>">							
    </div>
</div> 