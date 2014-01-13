<?php
/* box status utente 
 * box chiamato tramite load con:
 * data: {data,typeCurrentUser}, 
 * 
 * 
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$currentUser = $_SESSION['currentUser'];

$level = $user->getLevel();
$levelValue = $user->getLevelValue();
$type = $user->getType();
$objectId = $user->getObjectId();
$currentUserType = $currentUser->getType();

#TODO
//achievement array
$status_achievement1 = '_target1';
$status_achievement2 = '_target2';
$status_achievement3 = '_target3';
?>

<!------------------------------------------- STATUS ----------------------------------->
<div class="row" id="social-status">
    <div class="small-9 columns status">			
	<h3><strong><?php echo $level; ?><span class="text">pt.</span></strong></h3>					
    </div>
    <div class="small-3 columns">			
	<div class="row">
	    <div  class="large-12 columns">
		<div class="text orange livel-status"><?php echo $levelValue; ?></div>
	    </div>
	</div>
	<div class="row">
	    <div  class="large-12 columns">
		<img src="./resources/images/status/popolarity.png"/> 	
	    </div>
	</div>		
    </div>
</div>
<div class="row">
    <div  class="large-12 columns"><div class="line"></div></div>
</div>
<!------------------------------------ ACHIEVEMENT ----------------------------------------->
<div class="row" id="social-badge">
    <div id="social_list_badge" class="touchcarousel grey-blue">
	<ul class="touchcarousel-container">
	    <li class="touchcarousel-item">
		<div data-tooltip class="item-block has-tip tip-left" title="Old School!"><img src="/media/images/badge/badgeOldSchool.png" /></div>
	    </li>
            <li class="touchcarousel-item">
		<div data-tooltip class="item-block has-tip tip-left" title="Welcome on Board!"><img src="/media/images/badge/badgeWelcome.png" /></div>
	    </li>
            <li class="touchcarousel-item">
		<div data-tooltip class="item-block has-tip tip-left" title="Metal Addicted"><img src="/media/images/badge/badgeMetal.png" /></div>
	    </li>
	    <li class="touchcarousel-item">
		<div class="item-block"><img src="/media/images/badge/badgeDefault.png" /></div>
	    </li>		
	    <li class="touchcarousel-item">
		<div class="item-block"><img src="/media/images/badge/badgeDefault.png" /></div>
	    </li>
            <li class="touchcarousel-item">
		<div class="item-block"><img src="/media/images/badge/badgeDefault.png"/></div>
	    </li>
            <li class="touchcarousel-item">
		<div class="item-block"><img src="/media/images/badge/badgeDefault.png"/></div>
	    </li>
            <li class="touchcarousel-item">
		<div class="item-block"><img src="/media/images/badge/badgeDefault.png"/></div>
	    </li>
            <li class="touchcarousel-item">
		<div class="item-block"><img src="/media/images/badge/badgeDefault.png"/></div>
	    </li>
            <li class="touchcarousel-item">
		<div class="item-block"><img src="/media/images/badge/badgeDefault.png"/></div>
	    </li>
	</ul>		
    </div>
</div>
<div class="row <?php echo $type . ' ' . $currentUserType ?>" >
    <div  class="large-12 columns"><div class="line"></div></div>
</div>
<?php if ($type == "SPOTTER" && $currentUserType == "SPOTTER") { ?>
    <div class="row ">
        <div  class="large-12 columns">
    	<div class="status-button">
    	    <a href="#" class="button bg-grey" onclick="location.href = 'message.php?user=<?php echo $objectId ?>'"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG']; ?></div></a>
    	    <a href="#" class="button bg-orange"><div class="icon-button _friend_status"><?php echo $views['status']['ADDFRIEND']; ?></div></a>
    	</div>
        </div>
    </div>
<?php } ?>
<?php if ($type == "JAMMER" && ($currentUserType == "JAMMER" || $currentUserType == "VENUE")) { ?>
    <div class="row ">
        <div  class="large-12 columns">
    	<div class="status-button">
    	    <a href="#" class="button bg-grey" onclick="location.href = 'message.php?user=<?php echo $objectId ?>'"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG']; ?></div></a>
    	    <a href="#" class="button bg-orange"><div class="icon-button _follower_status"><?php echo $views['status']['COLL']; ?></div></a>
    	</div>
        </div>
    </div>
<?php } ?>
<?php if ($type == "JAMMER" && ($currentUserType == "SPOTTER")) { ?>
    <div class="row ">
        <div  class="large-12 columns">
    	<div class="status-button">
    	    <a href="#" class="button bg-grey" onclick="location.href = 'message.php?user=<?php echo $objectId ?>'"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG']; ?></div></a>
    	    <a href="#" class="button bg-orange"><div class="icon-button _follower_status"><?php echo $views['status']['FOLL']; ?></div></a>
    	</div>
        </div>
    </div>
<?php } ?>
<?php if ($type == "VENUE" && ($currentUserType == "SPOTTER")) { ?>
    <div class="row ">
        <div  class="large-12 columns">
    	<div class="status-button">
    	    <a href="#" class="button bg-grey" onclick="location.href = 'message.php?user=<?php echo $objectId ?>'"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG']; ?></div></a>
    	    <a href="#" class="button bg-orange"><div class="icon-button _follower_status"><?php echo $views['status']['FOLL']; ?></div></a>
    	</div>
        </div>
    </div>
<?php } ?>
<?php if ($type == "VENUE" && ($currentUserType == "JAMMER")) { ?>
    <div class="row ">
        <div  class="large-12 columns">
    	<div class="status-button">
    	    <a href="#" class="button bg-grey" onclick="location.href = 'message.php?user=<?php echo $objectId ?>'"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG']; ?></div></a>
    	    <a href="#" class="button bg-orange"><div class="icon-button _follower_status"><?php echo $views['status']['COLL']; ?></div></a>
    	</div>
        </div>
    </div>

<?php } ?>