<?php

$userType = $_GET['userType'];
$currentUserType = $_GET['currentType'];

?>
<div class="bg-double">
	
<div  class="row">	

<div id="profile" class="large-6 columns hcento">
		<div id='box-userinfo' ></div>	
		<div id='box-information' ></div>
		<div id="box-record"></div>
		<div id='box-event' ></div>	
		<div id='box-friends' ></div>	
		<div id='box-following' ></div>	
		<div id='box-album' ></div>				
		<?php
		/*
		include ('box-profile/box-userinfo.php');
		include ('box-profile/box-information.php');
		if ($userType == "jammer")
			include ('box-profile/box-music.php');
		if ($userType == "jammer" || $userType == "venue")
			include ('box-profile/box-event.php');
		if ($userType == "spotter") {
			include ('box-profile/box-friends.php');
			include ('box-profile/box-following.php');
		}
		include ('box-profile/box-photografy.php');
		 */
		?>
		
	</div>
	<div id="social" class="large-6 columns hcento">
		<div id='box-status' ></div>
		<div id="box-recordReview"></div>	
		<div id="box-recordEvent"></div>	
		<div id="box-activity"></div>
		<div id="box-collaboration"></div>
		<div id="box-followers"></div>
		<div id="box-post"></div>
		<?php
		/*
		include ('box-social/box-status.php');
		if ($userType != "venue")
			include ('box-social/box-albumReview.php');
		include ('box-social/box-eventReview.php');
		include ('box-social/box-activities.php');
		if ($userType != "spotter") {
			include ('box-social/box-collaboration.php');
			include ('box-social/box-followers.php');
		}
		include ('box-social/box-post.php');
		 * */
		 
	?>
</div>
</div>

</div>