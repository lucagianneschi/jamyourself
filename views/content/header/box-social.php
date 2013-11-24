<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php'; 

$userObjectId = $_POST['userObjectId'];
$userType 	  = $_POST['userType'];
$typeNotification = $_POST['typeNotification'];

if (isset($userObjectId)) {
	
	require_once BOXES_DIR . 'notification.box.php';
	$notificationBox = new NotificationBox();
	$counterNotification = $notificationBox->initForCounter($userObjectId, $userType);
	$invited = $counterNotification->invitationCounter != $boxes['ONLYIFLOGGEDIN'] ? $counterNotification->invitationCounter : 0;
	$message = $counterNotification->messageCounter != $boxes['ONLYIFLOGGEDIN'] ? $counterNotification->messageCounter : 0;
	$relation = $counterNotification->relationCounter != $boxes['ONLYIFLOGGEDIN'] ? $counterNotification->relationCounter : 0;
	$totNotification = $invited + $message + $relation;
		
	try{
		
		switch ($typeNotification) {
			case 'notification':				
				
				$detailNotification = $notificationBox->initForDetailedList($userObjectId, $userType);
				$detailNotification->notificationArray;				
				break;
			
			case 'message':
				$counterNotification = $notificationBox->initForMessageList($userObjectId);
				
				
				break;
			default:
				
				break;
		}
		
		
		
		
		
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
				<a class="ico-label _flag inline" onclick="getNotificationTot()" title="<?php echo $totNotification ?>"></a>
				<a class="ico-label _message inline" onclick="getNotificationMsg()" title="<?php echo $message ?>"></a>
				<a class="ico-label _calendar inline" onclick="getNotificationEvent()" title="<?php echo $invited ?>"></a>
				<a class="ico-label _friend inline"  onclick="getNotificationRelation()" title="<?php echo $relation ?>"></a>
			</div>
		</div>											
	</div>					
</div>

<!------------------------------------ notification ------------------------------------------->
<?php 
if($detailNotification->notificationArray != $boxes['NDB']){
foreach ($detailNotification->notificationArray as $key => $value) {
		$createdAd = $value->createdAt->format('d/m/Y H:i');
		$user_objectId = $value->fromUserInfo->objectId;
		$user_thumb = $value->fromUserInfo->thumbnail;
		$user_username = $value->fromUserInfo->username;
		$text = $value->text;
		$objectId = $value->objectId;
		switch ($value->type) {
			case 'M':
				$css_icon = '_message-small';				
				break;
			case 'E':
				$css_icon = '_calendar-small';
				break;
			case 'R':
				$css_icon = '_user-small';
				break;
			default:
				
				break;
		}
	
	?>
<div class="row">
	<div  class="large-1 columns hide-for-small">
		<div class="icon-header">
			<img src="../media/<?php echo $default_img['DEFAVATARTHUMB']?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
		</div>
	</div>
	<div  class="large-11 columns">
		<div class="row">
			<div  class="large-8 columns" style="padding-right: 0px;">
				<label class="text grey inline"><a class="icon-small <?php echo $css_icon ?> inline"></a><strong id="<?php echo $user_objectId?>"><?php echo $user_username?></strong><span id="<?php echo $objectId ?>"> <?php echo $text?></span></label>									
			</div>
			<div  class="large-4 columns " style="padding-left: 0px;">
				<label class="text grey-light inline" style="float: right !important"><?php echo $createdAd ?></label>
			</div>	
		</div>
	</div>
</div>
<div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
</div>
<?php } ?>
<!------------------------------------ fine notification ------------------------------------------->
<?php if($value->type == 'M'){ ?>
<div class"row">
	<div  class="large-12 large-offset-9 columns"><a href="#" class="note orange"><strong>vedi tutti i messaggi</strong> </a></div>
</div>	

<?php
}}}
?>	
