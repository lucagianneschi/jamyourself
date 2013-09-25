<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';

//esempio: objectId dell'utente collegato 
$correntUser = "GuUAj83MGH";
$correntUserType = 'SPOTTER';
//esempio: objectId dell'utente a cui si vuole vedere il profilo 
$profileUser = "8zqS8mjacf";


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
        <div class="body-content">
            <?php require_once(VIEWS_DIR . 'content/profile/main.php'); ?>
        </div>
        <!-------------------------- FOOTER --------------------------->
        <?php require_once(VIEWS_DIR . 'content/general/footer.php'); ?>	

        <!-------------------------- SCRIPT --------------------------->
        <?php require_once(VIEWS_DIR . "content/general/script.php"); ?>
        
        <script type="text/javascript">
        	//carica i box partendo da userInfo        	
    		callBox.objectId = '<?php echo $profileUser; ?>';
    		callBox.objectIdCurrentUser = '<?php echo $correntUser; ?>';
			callBox.typeCurrentUser = '<?php echo $correntUserType; ?>';			
			callBox.load('userinfo');
			callBox.load('header');
        </script>
        
    </body>

</html>
