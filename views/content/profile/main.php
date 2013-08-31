<?php 
$userType = $_GET['userType'];
$currentUserType = $_GET['currentType'];

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'userInfo.box.php';
require_once PARSE_DIR . 'parse.php';

//Informazioni principali dell'utente
$objectId = '1oT7yYrpfZ';

$userInfo = new UserInfoBox();

$info = $userInfo->initForPersonalPage($objectId);

$username = $info->userName;

$city = $info->city;

//genere musicale è  un array
$music = $info->music;
  
$backGround = $info->backGround;

$profilePicture = $info->profilePicture;


?>
<div class="bg-double">
	
<div  class="row">	

	<div id="profile" class="large-6 columns hcento">		
		<?php 
		include('box-profile/box-info1.php');		

		include('box-profile/box-information.php');

		if($userType == "jammer")
		 include('box-profile/box-music.php');

		if($userType == "jammer" || $userType == "venue")
			include('box-profile/box-event.php');

		if($userType == "spotter"){
			include('box-profile/box-friends.php');
			include('box-profile/box-following.php');
		}	
		
		include('box-profile/box-photografy.php');
		?>
		
	</div>
	<div id="social" class="large-6 columns hcento">
		<?php 
		
		include('box-social/box-status.php');
		if($userType != "venue")
			include('box-social/box-albumReview.php');
		include('box-social/box-eventReview.php');
		include('box-social/box-activities.php');
		
		if($userType != "spotter"){
			include('box-social/box-collaboration.php');
			include('box-social/box-followers.php');
		 }
		
		include('box-social/box-post.php');?>
	</div>
</div>

</div>