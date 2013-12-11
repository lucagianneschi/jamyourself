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
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$currentUser = $_SESSION['currentUser'];

$level = $user->getLevel();
$levelValue = $user->getLevelValue();
$type = $user->getType();
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
<div class="row" id="social-achievement">
	<div id="social_list_achievement" class="touchcarousel grey-blue">
		<ul class="touchcarousel-container">
			<li class="touchcarousel-item">  
				<div class="item-block achievement achievement-target <?php echo $status_achievement1; ?>"></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement achievement-target <?php echo $status_achievement2; ?>"></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement achievement-target <?php echo $status_achievement3; ?>"></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>		
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
		</ul>		
	</div>
</div>
<div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
</div>
<?php if($type == "SPOTTER" && $currentUserType == "SPOTTER"){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG'];?></div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status"><?php echo $views['status']['ADDFRIEND'];?></div></a>
	</div>
	</div>
</div>
<?php }?>
<?php if($type == "JAMMER" && ($currentUserType == "JAMMER" || $currentUserType == "VENUE")){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG'];?></div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status"><?php echo $views['status']['COLL'];?></div></a>
	</div>
	</div>
</div>
<?php }?>
<?php if($type == "JAMMER" && ($currentUserType == "SPOTTER")){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG'];?></div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status"><?php echo $views['status']['FOLL'];?></div></a>
	</div>
	</div>
</div>
<?php }?>
<?php if($type == "VENUE" && ($currentUserType == "SPOTTER")){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG'];?></div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status"><?php echo $views['status']['FOLL'];?></div></a>
	</div>
	</div>
</div>
<?php }?>
<?php if($type == "VENUE" && ($currentUserType == "JAMMER")){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> <?php echo $views['status']['SENDMSG'];?></div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status"><?php echo $views['status']['COLL'];?></div></a>
	</div>
	</div>
</div>
<?php } ?>