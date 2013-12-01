<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once CONTROLLERS_DIR . 'uploadRecord.controller.php';
session_start();
$currentUser = $_SESSION['currentUser'];
$currentUserId = $currentUser->getObjectId();
$uploadRecordController = new uploadRecordController();
$uploadRecordController->init();
$recordList = $uploadRecordController->viewRecordList;
if (count($recordList) > 0) {
    $recordIdList = array();
    foreach ($recordList as $record) {
        $recordIdList[] = $record->getObjectId();
    }
} else {
}
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" ><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en" ><!--<![endif]-->

    <head>

        <title>Jamyourself</title>
        <!-------------------------- METADATI --------------------------->
        <?php
        require_once(VIEWS_DIR . "content/general/meta.php");
        ?>

    </head>

    <body>

        <!-------------------------- HEADER --------------------------->
        <?php
        require_once(VIEWS_DIR . 'content/header/main.php');
        ?>

        <!-------------------------- BODY --------------------------->
        <div class="body-content">
            <?php
            require_once(VIEWS_DIR . 'content/uploadRecord/main.php');
            ?>
        </div>
        <!-------------------------- FOOTER --------------------------->
        <?php
        require_once(VIEWS_DIR . 'content/general/footer.php');
        ?>	

        <!-------------------------- SCRIPT --------------------------->
<?php
require_once(VIEWS_DIR . "content/general/script.php");
?>
    </body>

</html>
