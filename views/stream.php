<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once CLASSES_DIR . 'userParse.class.php';

if (session_id() == '') session_start();
    
if (!isset($_SESSION['currentUser'])) {
    header('Location: login.php');
} else {
    $currentUser = $_SESSION['currentUser'];
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
			<?php require_once(VIEWS_DIR . 'content/stream/main.php'); ?>
			<!-------------------------- FOOTER --------------------------->
			<?php require_once(VIEWS_DIR . 'content/general/footer.php'); ?>	
			<!-------------------------- SCRIPT --------------------------->
			<?php require_once(VIEWS_DIR . "content/general/script.php"); ?>
			<script>
				loadBoxLastPost();
                loadBoxActivity();
			</script>
		</body>
	</html>
	<?php
}