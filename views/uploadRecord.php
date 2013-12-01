<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'debug.service.php';
debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - loading ".CONTROLLERS_DIR . 'uploadRecord.controller.php');
require_once CONTROLLERS_DIR . 'uploadRecord.controller.php';
debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - starting session...");
session_start();
$currentUser = $_SESSION['currentUser'];
$currentUserId = $currentUser->getObjectId();
debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - session started: userid =>" . $currentUserId);
debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - create new controller...");
$uploadRecordController = new uploadRecordController();
debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - invoking controller->init()...");
$uploadRecordController->init();
debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - getting user record list...");
$recordList = $uploadRecordController->viewRecordList;
if (count($recordList) > 0) {
    $recordIdList = array();
    foreach ($recordList as $record) {
        $recordIdList[] = $record->getObjectId();
    }
    debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - user record list id => " . implode(",",$recordIdList));
} else {
    debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - user record list is empty");
}
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->

    <head>

        <title>Jamyourself</title>
        <!-------------------------- METADATI --------------------------->
        <?php
        debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - loading " . VIEWS_DIR . "content/general/meta.php");
        require_once(VIEWS_DIR . "content/general/meta.php");
        ?>

    </head>

    <body>

        <!-------------------------- HEADER --------------------------->
        <?php
        debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - loading " . VIEWS_DIR . "content/header/main.php");
        require_once(VIEWS_DIR . 'content/header/main.php');
        ?>

        <!-------------------------- BODY --------------------------->
        <div class="body-content">
            <?php
            debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - loading " . VIEWS_DIR . "content/uploadRecord/main.php");
            require_once(VIEWS_DIR . 'content/uploadRecord/main.php');
            ?>
        </div>
        <!-------------------------- FOOTER --------------------------->
        <?php
        debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - loading " . VIEWS_DIR . "content/general/footer.php");
        require_once(VIEWS_DIR . 'content/general/footer.php');
        ?>	

        <!-------------------------- SCRIPT --------------------------->
<?php
debug(DEBUG_DIR, "uploadRecord.log", "uploadRecord.php - loading " . VIEWS_DIR . "content/general/script.php");
require_once(VIEWS_DIR . "content/general/script.php");
?>
    </body>

</html>
