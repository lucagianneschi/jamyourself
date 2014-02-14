<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once CLASSES_DIR . 'userParse.class.php';
if (session_id() == '')
    session_start();

$userObjectId = $_POST['userObjectId'];
$userType = $_POST['userType'];
$typeNotification = $_POST['typeNotification'];

if (!isset($userObjectId)) {
    if (isset($_SESSION['currentUser'])) {
	$userType = $currentUser->getType();
	$userObjectId = $currentUser->getId();
	$typeNotification = 'notification';
    }
}

if (isset($userObjectId)) {

    require_once BOXES_DIR . 'notification.box.php';
    $detailNotification = new NotificationBox();
    //$detailNotification->initForCounter($userType);

    $invited = $_SESSION['invitationCounter'] != ONLYIFLOGGEDIN ? $_SESSION['invitationCounter'] : 0;
    $message = $_SESSION['messageCounter'] != ONLYIFLOGGEDIN ? $_SESSION['messageCounter'] : 0;
    $relation = $_SESSION['relationCounter'] != ONLYIFLOGGEDIN ? $_SESSION['relationCounter'] : 0;

    $totNotification = $invited + $message + $relation;

    $css_not = 'no-display';
    $css_inv = 'no-display';
    $css_msg = 'no-display';
    $css_rel = 'no-display';
    if ($totNotification === 0)
	$css_not = 'no-display';
    else
	$css_not = '';
    if ($invited == 0)
	$css_inv = 'no-display';
    else
	$css_inv = '';
    if ($message == 0)
	$css_msg = 'no-display';
    else
	$css_msg = '';
    if ($relation == 0)
	$css_rel = 'no-display';
    else
	$css_rel = '';

    try {
	switch ($typeNotification) {
	    case 'notification':
		$detailNotification->initForDetailedList($userType);
		$numNot = $totNotification;
		$other = '';
		break;
	    case 'message':
		$detailNotification->initForMessageList();
		$numNot = $message;
		$other = $views['header']['social']['message_msg'];
		break;
	    case 'event':
		$detailNotification->initForEventList();
		$numNot = $invited;
		$other = $views['header']['social']['message_event'];
		break;
	    case 'relation':
		$detailNotification->initForRelationList($userType);
		$numNot = $relation;
		$other = $views['header']['social']['message_relation'];
		break;
	    default:
		break;
	}
    } catch (Exception $e) {
	
    }
    ?>
    <!---------------------------------------- HEADER HIDE SOCIAL ----------------------------------->
    <script>
        var rsi_not;
        $(document).ready(function() {
    	rsi_not = slideReview('box-notification');

        });
    </script>
    <div class="row">
        <div  class="large-12 columns" style="margin-bottom: 29px">
    	<div class="row">
    	    <div  class="large-4 columns hide-for-small">	
    		<h3 class="inline"><?php echo $views['header']['social']['title'] ?></h3>
    	    </div>	
    	    <div  class="large-4 columns" style="margin-top: 10px">
    		<!--a class="ico-label _flag inline" onclick="loadBoxSocial('notification', '<?php echo $userObjectId ?>', '<?php echo $userType ?>')" >
    		    <span class="round alert label iconNotification <?php echo $css_not ?>"><?php echo $totNotification ?></span>
    		</a-->
    		<a class="ico-label _message inline" onclick="loadBoxSocial('message', '<?php echo $userObjectId ?>', '<?php echo $userType ?>')" ><span class="round alert label iconNotification <?php echo $css_msg ?>"><?php echo $message ?></span></a>
    		<a class="ico-label _calendar inline" onclick="loadBoxSocial('event', '<?php echo $userObjectId ?>', '<?php echo $userType ?>')" ><span class="round alert label iconNotification <?php echo $css_inv ?>"><?php echo $invited ?></span></a>
    		<a class="ico-label _friend inline"  onclick="loadBoxSocial('relation', '<?php echo $userObjectId ?>', '<?php echo $userType ?>')" ><span class="round alert label iconNotification <?php echo $css_rel ?>"><?php echo $relation ?></span></a>
    	    </div>
    	    <div  class="large-4 columns">
		    <?php if ($numNot > 4) { ?>
			<div class="row align-right">					
			    <div  class="small-9 columns">
				<a class="slide-button-prev _prevPage slide-button-prev-disabled" onclick="slidePrev(this, rsi_not)"></a>
			    </div>
			    <div  class="small-3 columns">
				<a class="slide-button-next _nextPage" onclick="slideNext(this, rsi_not)"></a>
			    </div>
			</div>
		    <?php } ?>
    	    </div>	

    	</div>											
        </div>					
    </div>

    <div class="royalSlider contentSlider rsDefault" id="box-notification">		
        <!------------------------------------ notification ------------------------------------------->
	<?php
	$index = 0;
	if (count($detailNotification->notificationArray) > 0) {
	    foreach ($detailNotification->notificationArray as $key => $value) {
		if ($index % 4 == 0) {
		    ?><div class="rsContent">	<?php
		}
		$createdAd = $value->createdAt->format('d/m/Y H:i');
		$user_objectId = $value->fromUserInfo->id;
		$user_thumb = $value->fromUserInfo->thumbnail;
		$user_username = $value->fromUserInfo->username;
		switch ($value->fromUserInfo->type) {
		    case 'JAMMER':
			$defaultThum = DEFTHUMBJAMMER;
			break;
		    case 'VENUE':
			$defaultThum = DEFTHUMBVENUE;
			break;
		    case 'SPOTTER':
			$defaultThum = DEFTHUMBSPOTTER;
			break;
		}

		$text = $value->text;
		$id = $value->id;
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
		if ($value->type == 'M') {
		    ?>
			<div class="notification-item" onclick="location.href = 'message.php?user=<?php echo $user_objectId ?>'" style="cursor: pointer">
			<?php } ?>	
	    	    <div class="row">
	    		<div  class="large-1 columns hide-for-small">
	    		    <div class="icon-header">
	    			<!-- THUMB USER-->
				    <?php
				    $fileManagerService = new FileManagerService();
				    $thumbPath = $fileManagerService->getPhotoPath($value->getId(), $value->getThumbnail());
				    ?>
	    			<img src="<?php echo $thumbPath ?>" onerror="this.src='<?php echo $defaultThum; ?>'" alt ="<?php echo $user_username; ?>">
	    		    </div>
	    		</div>
	    		<div  class="large-11 columns">
	    		    <div class="row">
	    			<div  class="large-7 columns" style="padding-right: 0px;">
	    			    <a class="icon-small <?php echo $css_icon ?> text grey inline"></a><strong id="<?php echo $user_objectId ?>"><?php echo $user_username ?></strong><span id="<?php echo $id ?>"> <?php echo $text ?></span>
	    			    <br>									
	    			    <span class="note grey-light inline notification-note"><?php echo $createdAd ?></span>
	    			</div>

	    			<div  class="large-5 columns " style="text-align: right;">
	    			    <a class="btn-confirm decline" onclick="declineRelation('<?php echo $id; ?>', '<?php echo $user_objectId; ?>');"><?php echo $views['header']['decline'] ?></a>
	    			    <a class="btn-confirm accept" onclick="acceptRelation('<?php echo $id; ?>', '<?php echo $user_objectId; ?>');"><?php echo $views['header']['accept'] ?></a>&nbsp;&nbsp;
	    			</div>	
	    		    </div>
	    		</div>
	    	    </div>
			<?php if ($value->type == 'M') { ?>
			</div>	
		    <?php } ?>


		    <?php if (($index + 1) % 4 == 0 || count($detailNotification->notificationArray) == ($index + 1)) { ?> </div> <?php
		}
		$index++;
	    }
	    ?>
	    <!------------------------------------ fine notification ------------------------------------------->

	<?php }
	?>

    </div>	

    <?php if (count($detailNotification->notificationArray) == 0) { ?>
	<div class"row">
	     <div  class="large-12 columns"><?php echo $views['header']['social']['nodata'] ?></div>
	</div>	

	<?php
    } else {
	?>
	<div class"row">
	     <div  class="large-6 columns" style="padding: 0px;"><a href="#" class="note orange"><strong><?php echo $views['header']['social']['message_mark'] ?></strong> </a></div>
	    <div  class="large-6 columns" style="text-align: right;padding: 0px;"><a href="#" class="note orange"><strong><?php echo $other ?></strong> </a></div>			
	</div>
	<script>
	//	rsi_not.updateSliderSize(true);
	</script>

	<?php
    }
}
?>