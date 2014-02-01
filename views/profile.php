<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mantainance.service.php';
require_once SERVICES_DIR . 'session.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'userInfo.box.php';

$currentUser = $_SESSION['currentUser'];
$userObjectId = $currentUser->getObjectId();
    
if(isset($_GET['user'])){
    $userObjectId = $_GET['user'];
}

$userInfoBox = new UserInfoBox();
$userInfoBox->init($userObjectId);

if (is_null($userInfoBox->error)) {
    $user = $userInfoBox->user;
    ?>
    <!DOCTYPE html>
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
    <!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->
        <head>
            <title>Jamyourself</title>
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
                <?php	if($user->getType() == 'JAMMER'){ ?>
                loadBoxRecord();
                <?php } ?>		
                loadBoxAlbum();
                loadBoxRecordReview();
                loadBoxEventReview();
                //loadBoxActivity();
                loadBoxPost();
                <?php
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