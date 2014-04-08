<?php

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'mantainance.service.php';
require_once SERVICES_DIR . 'session.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'log.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'userInfo.box.php';

$userPageId = $_SESSION['id'];
if (isset($_GET['user'])) {
    $userPageId = $_GET['user'];
}
$userInfoBox = new UserInfoBox();
$userInfoBox->init($userPageId);

if (is_null($userInfoBox->error)) {	
   
	foreach ($userInfoBox->user as $key => $value) {
		$user = $value;
	}	
    ?>
    <!DOCTYPE html>
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
    <!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->
        <head>
	<title><?php echo $views['metatag']['profile']['title'] . $user->getUsername() ?></title>
	<meta name="description" content="<?php echo $views['metatag']['profile']['description'] ?>">
	<meta name="keywords" content="<?php echo $views['metatag']['profile']['keywords'] ?>">
	<link rel="icon" href="<?php echo VIEWS_DIR . "resources/images/icon/favicon.ico"; ?>" sizes="16x16"></link>
    	<!-------------------------- METADATI --------------------------->
	    <?php require_once(VIEWS_DIR . "content/general/meta.php"); ?>
        </head>
        <body>
    	<!-------------------------- HEADER --------------------------->
	    <?php require_once(VIEWS_DIR . 'content/header/main.php'); ?>
    	<!-------------------------- BODY --------------------------->
	    <?php require_once(VIEWS_DIR . 'content/profile/main.php'); ?>
    	<!-------------------------- FOOTER --------------------------->
	    <?php require_once(VIEWS_DIR . 'content/general/footer.php'); ?>	
    	<!-------------------------- SCRIPT --------------------------->
	    <?php require_once(VIEWS_DIR . "content/general/script.php"); ?>
    	
    	
    	<script>   	
    	    loadBoxAlbum();
    	    loadBoxRecordReview();
    	    loadBoxEventReview();
    	    //loadBoxActivity();
    	    loadBoxPost();
    		
    		<?php
    		
    		if ($user->getType() == 'JAMMER') { ?>
    			loadBoxRecord();
    		<?php } 
    		if ($user->getType() == 'JAMMER' || $user->getType() == 'VENUE') {
			?>
			    loadBoxEvent();
			    loadBoxCollaboration();
			    loadBoxFollowers(); 
			<?php
    		} elseif ($user->getType() == 'SPOTTER') {
			?>
			    loadBoxFriends();
			    loadBoxFollowing();
			<?php
		    } 
		    ?>
    	</script>
        </body>
    </html>
    <?php
} else {
    header('Location: ' . VIEWS_DIR . '404.php');
}
?>
