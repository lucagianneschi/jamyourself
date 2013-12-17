<?php
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php'; 

require_once CLASSES_DIR . 'userParse.class.php';
if(session_id() == '')
	session_start();

$userObjectId = $_POST['userObjectId'];
$userType = $_POST['userType'];
$typeNotification = $_POST['typeNotification'];

if(!isset($userObjectId)){
	if (isset($_SESSION['currentUser'])) {		
		$userType = $currentUser->getType();
		$userObjectId = $currentUser->getObjectId();
		$typeNotification = 'notification';
	}
}

if (isset($userObjectId)) {
		
	require_once BOXES_DIR . 'notification.box.php';
	$detailNotification = new NotificationBox();
	//$detailNotification->initForCounter($userType);
	
	$invited = $_SESSION['invitationCounter'] != $boxes['ONLYIFLOGGEDIN'] ? $_SESSION['invitationCounter'] : 0;
	$message = $_SESSION['messageCounter'] != $boxes['ONLYIFLOGGEDIN'] ? $_SESSION['messageCounter'] : 0;
	$relation = $_SESSION['relationCounter'] != $boxes['ONLYIFLOGGEDIN'] ? $_SESSION['relationCounter'] : 0;
	
	$totNotification = $invited + $message + $relation;
		
	if($totNotification == 0) $css_not = 'no-display';
	if($invited == 0) $css_inv = 'no-display';
	if($message == 0) $css_msg = 'no-display';
	if($relation == 0) $css_rel = 'no-display';

	?>
	<!---------------------------------------- HEADER HIDE SOCIAL ----------------------------------->
	<div class="row">
		<div  class="large-12 columns" style="margin-bottom: 29px">
			<div class="row">
				<div  class="large-4 columns hide-for-small">	
					<h3 class="inline"><?php echo $views['header']['TITLE'] ?></h3>
				</div>	
				<div  class="large-8 columns" style="margin-top: 10px">
					<a class="ico-label _flag inline" onclick="loadBoxSocial('notification','<?php echo $userObjectId?>','<?php echo $userType  ?>')" title="<?php echo $totNotification ?>"><span class="round alert label iconNotification <?php echo $css_not ?>"><?php echo $totNotification ?></span></a>
					<a class="ico-label _message inline" onclick="loadBoxSocial('message','<?php echo $userObjectId?>','<?php echo $userType  ?>')" title="<?php echo $message ?>"><span class="round alert label iconNotification <?php echo $css_msg ?>"><?php echo $message ?></span></a>
					<a class="ico-label _calendar inline" onclick="loadBoxSocial('event','<?php echo $userObjectId?>','<?php echo $userType  ?>')" title="<?php echo $invited ?>"><span class="round alert label iconNotification <?php echo $css_inv ?>"><?php echo $invited ?></span></a>
					<a class="ico-label _friend inline"  onclick="loadBoxSocial('relation','<?php echo $userObjectId?>','<?php echo $userType  ?>')" title="<?php echo $relation ?>"><span class="round alert label iconNotification <?php echo $css_rel ?>"><?php echo $relation ?></span></a>
				</div>
			</div>											
		</div>					
	</div>
	<div id="box-notification">
	<!------------------------------------ notification ------------------------------------------->
	<?php
	try {
		switch ($typeNotification) {
			case 'notification':				
				$detailNotification ->initForDetailedList($userType);
				break;
			case 'message':
				$detailNotification ->initForMessageList();
				$other = 'vedi tutti i messaggi';	
				break;
			case 'event':
				$detailNotification ->initForEventList();
				$other = 'vedi tutti gli eventi';
				break;
			case 'relation':
				$detailNotification ->initForRelationList($userType);
				$other = 'vedi tutte le relazioni';
				break;
			default:
				break;
		}
	} catch(Exception $e) {
	} 
	if (count($detailNotification->notificationArray) > 0) {
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
			<?php
		}
		?>
		<!------------------------------------ fine notification ------------------------------------------->
		<div class"row">
			<div  class="large-12 large-offset-9 columns"><a href="#" class="note orange"><strong><?php echo $other?></strong> </a></div>
		</div>
		
		<?php
	}?>
	</div>
<?php	
}
?>
	