<?php

if (isset($_SESSION['currentUser'])) {
	$currentUser = $_SESSION['currentUser'];
	
	$userObjectId = $currentUser->getObjectId();
	$userType = $currentUser->getType();
	 
	require_once BOXES_DIR . 'notification.box.php';
		
	try{
		$notificationBox = new NotificationBox();
		$counterNotification = $notificationBox->initForCounter($userObjectId, $userType);
		$invited = $counterNotification->invitationCounter != $boxes['ONLYIFLOGGEDIN'] ? $counterNotification->invitationCounter : 0;
		$message = $counterNotification->messageCounter != $boxes['ONLYIFLOGGEDIN'] ? $counterNotification->messageCounter : 0;
		$relation = $counterNotification->relationCounter != $boxes['ONLYIFLOGGEDIN'] ? $counterNotification->relationCounter : 0;
		$totNotification = $invited + $message + $relation;
		
		$detailNotification = $notificationBox->initForDetailedList($userObjectId, $userType);
		$detailNotification->notificationArray;
		
	}catch(Exception $e){
		
	}

?>
<!---------------------------------------- HEADER HIDE SOCIAL ----------------------------------->
<div class="row">
	<div  class="large-12 columns" style="margin-bottom: 29px">
		<div class="row">
			<div  class="large-3 columns hide-for-small">	
				<h3 class="inline">Notifiche</h3>
			</div>	
			<div  class="large-9 columns" style="margin-top: 10px">
				<a class="ico-label _flag inline" title="<?php echo $totNotification ?>"></a>
				<a class="ico-label _message inline" title="<?php echo $message ?>"></a>
				<a class="ico-label _calendar inline" title="<?php echo $invited ?>"></a>
				<a class="ico-label _friend inline" title="<?php echo $relation ?>"></a>
			</div>
		</div>											
	</div>					
</div>

<!------------------------------------ notification ------------------------------------------->
<?php foreach ($detailNotification->notificationArray as $key => $value) { ?>
<div class="row">
	<div  class="large-1 columns hide-for-small">
		<div class="icon-header">
			<img src="../media/<?php echo $default_img['DEFAVATARTHUMB']?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
		</div>
	</div>
	<div  class="large-11 columns">
		<div class="row">
			<div  class="large-8 columns" style="padding-right: 0px;">
				<label class="text grey inline"><a class="icon-small _message-small inline"></a><strong>Nome Spotter</strong> ti ha scritto un messaggio</label>									
			</div>
			<div  class="large-4 columns " style="padding-left: 0px;">
				<label class="text grey-light inline" style="float: right !important">18:23</label>
			</div>	
		</div>
	</div>
</div>
<div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
</div>
<?php } ?>
<!------------------------------------ fine notification ------------------------------------------->
<div class"row">
	<div  class="large-12 large-offset-9 columns"><a href="#" class="note orange"><strong>vedi tutte le notifiche</strong> </a></div>
</div>	

<?php
}
?>	
