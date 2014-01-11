<?php
$limit = LIMITLISTMSG;
$skip = SKIPLISTMSG;

if (!isset($messageBox)) {
    if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../');

    ini_set('display_errors', '1');
    require_once ROOT_DIR . 'config.php';
    require_once BOXES_DIR . 'message.box.php';
    require_once SERVICES_DIR . 'lang.service.php';
    require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
    $limit = (int) $_POST['limit'];
    $skip = (int) $_POST['skip'];
    echo $skip;
    $messageBox = new MessageBox();
    $messageBox->initForUserList($limit, $skip);


    $cssNewMessage = "no-display";
}

foreach ($messageBox->userInfoArray as $key => $value) {
    $tumb = "";
    switch ($value->userInfo->type) {

	case 'SPOTTER':
	    $tumb = DEFTHUMBSPOTTER;
	    break;
	case 'JAMMER':
	    $tumb = DEFTHUMBJAMMER;
	    break;
	case 'VENUE':
	    $tumb = DEFTHUMBVENUE;
	    break;
	default:

	    break;
    }
    $readCss = '';
    $activeCss = '';
    //controlla se il messaggio e' segnato come letto oppure se 
    //l'utente e' lo stesso del messaggio che vogliamo visualizzare
    if ($value->read == true || (isset($user) && $user == $key))
	$readCss = 'no-display';
    if (isset($user) && $user == $key)
	$activeCss = 'active';
    ?>		

    <div class="box-membre <?php echo $activeCss ?> <?php echo count($messageBox->userInfoArray); ?>" id="<?php echo $key ?>">
        <div class="unread <?php echo $readCss ?>"></div>
        <div class="delete" onClick="deleteMsg('<?php echo $key ?>')"></div>
        <div class="box-msg" onClick="showMsg('<?php echo $key ?>')">
    	<div class="row">
    	    <div class="small-2 columns ">
    		<div class="icon-header">
    		    <img src="<?php echo $value->userInfo->thumbnail ?>" onerror="this.src='<?php echo $tumb ?>'">
    		</div>
    	    </div>
    	    <div class="small-10 columns" style="padding-top: 8px;">
    		<div id="a1to" class="text grey-dark breakOffTest"><?php echo $value->userInfo->username ?></div>
    	    </div>		
    	</div>
        </div>
    </div>

<?php
}

if (count($messageBox->userInfoArray) >= LIMITLISTMSG && count($messageBox->userInfoArray) > 0) {
    ?>  

    <div class="box-other" onclick="viewOtherListMsg('<?php echo $user ?>',<?php echo $limit ?>,<?php echo ($limit + $skip) ?>)">
        <a><?php echo $views['message']['view_other']; ?></a>
    </div>
    <?php
}
?>