<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'message.box.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';

if (isset($_POST['user']) && $_POST['user'] == 'newmessage') {
    $user = $_POST['user'];
 //   $type = $_POST['type'];
    ?>    
    <div id="newMsg">    	
        <h5><?php echo $views['message']['write_message']; ?></h5>
        <label for="to"><small class="error"><?php echo $views['message']['valid_user']; ?></small></label>
        <input id="to" type="text" placeholder="<?php echo $views['message']['to'] ?>" required>
        <textarea id="textNewMessage" placeholder="<?php echo $views['message']['message'] ?>"></textarea>
        <br><br>
        <div class="row">
    	<div class="large-12">
    	    <input type="button" class="buttonNext" value="<?php echo $views['message']['send'] ?>" id="sendMessage" onclick="btSendNewMessage('newMsg', '<?php echo $user ?>', null)">
    	</div>
        </div>
    </div>
    <?php
} else {
    $limit = (int) $_POST['limit'];
    $skip = (int) $_POST['skip'];

    $messageBox = new MessageBox();

    if (isset($_POST['user'])) {
	$user = $_POST['user'];
	$messageBox->initForMessageList($user, $limit, $skip);
	if ($messageBox->error != ONLYIFLOGGEDIN) {
	    $dataPrec = '';
	    if (count($messageBox->messageArray) > 0) {
		?>		
		<div id="userMsg" >
		    <div class="row">
			<div class="large-12 columns ">
			    <div id="chat">
				<div class="row">
				    <div class="large-12 columns ">
					<?php if (count($messageBox->messageArray) == $limit) { ?>
		    			<div class="row">
		    			    <div class="large-12 columns">
		    				<div class="line-date otherMessage" onclick="loadBoxMessages('<?php echo $user ?>',<?php echo $limit ?>,<?php echo $limit + $skip ?>)"><small><?php echo $views['message']['other_messages']; ?></small></div>
		    			    </div>
		    			</div>
					    <?php
					}
					$risultato = array_reverse($messageBox->messageArray);
					foreach ($risultato as $key => $value) {
					    $data = $value->createdat->format('d F Y');
					    $dataFormato = $value->createdat->format('j n Y');
					    $time = $value->createdat->format('H:i');
					    $time = ucwords(strftime("%H:%M", $value->createdat->getTimestamp()));
					    if ($data != $dataPrec) {
						?>		
						<div class="row">
						    <div class="large-12 columns">
							<div class="line-date"><small><?php echo $data ?></small></div>
							<input type="hidden" value="<?php echo $dataFormato ?>" name="data"/>
						    </div>
						</div>
						<?php
					    }
					    if ($value->send == 'S') {
						?>		
						<div class="row" >
						    <div class="large-8 large-offset-2 columns msg msg-mine">
							<p><?php echo $value->text ?></p>
						    </div>
						    <div class="large-2 hide-for-small columns">
							<div class="date-mine">
							    <small><?php echo $time ?></small>
							</div>
						    </div>
						</div>
					    <?php } else { ?>
						<div class="row <?php echo $value->read ?>">
						    <div class="large-2 hide-for-small columns">
							<div class="date-yours">
							    <small><?php echo $time ?></small>
							</div>
						    </div>
						    <div class="large-8 end columns msg msg-yours">
							<p><?php echo $value->text ?></p>
						    </div>
						</div>	                
						<?php
					    }
					    $dataPrec = $data;
					    if (!$value->read) {
						?>
						<script>
			readMessage('<?php echo $value->activityId ?>');
						</script>
						<?php
					    }
					}
					if (count($messageBox->messageArray) == 0) {
					    ?>
		    			<div class="row">
		    			    <div class="large-2 hide-for-small columns">
		    				<div class="date-yours">
		    				    <small></small>
		    				</div>
		    			    </div>	                	
		    			    <div class="small-8 columns msg msg-yours">
		    				<p><?php echo $views['message']['no_messages']; ?></p>
		    			    </div>
		    			    <div class="large-2 hide-for-small columns">
		    				<div class="date-yours">
		    				    <small></small>
		    				</div>
		    			    </div>
		    			</div>	
					<?php } ?>
					<div id="msgTmp"></div>
				    </div>
				</div>
			    </div>			
			</div>
		    </div>
		    <?php if ($skip == 0) { ?>
		        <textarea id="textNewMessage" placeholder="<?php echo $views['message']['message'] ?>"></textarea>
		        <br><br>
		        <div class="row">
		    	<div class="large-12">		    	
		    	    <input type="button" class="buttonNext" value="<?php echo $views['message']['send'] ?>" id="sendMessage" onclick="btSendMessage('userMsg', '<?php echo $user ?>', null)">
		    	</div>
		        </div>
		    <?php } ?>
		</div>
		<?php
	    } else {
		// ARRAY LISTA MESSAGGI VUOTO -> DEVO INVIARE UN MESS DA UN NUOVO UTENTE 
		require_once BOXES_DIR . 'userInfo.box.php';
		$user = $_POST['user'];
		$userInfoBox = new UserInfoBox();
		$userInfoBox->init($user);
		if (is_null($userInfoBox->error)) {
		    $touser = $userInfoBox->user;
		    $toUsername = $touser->getUsername();
		    $toType = $touser->getType();
		    if (session_id() == '')
			session_start();
		    $currentUserId = $_SESSION['id'];
		    $fromType = $_SESSION['type'];

//			if($fromType == 'SPOTTER' || ($fromType != 'SPOTTER' && $toType != 'SPOTTER')){
		    if (!is_null($toType)) {
			?>
			<div id="newMsgUser" >
			    <h5><?php echo $views['message']['write_message']; ?></h5>	
			    <input id="to" type="text" placeholder="<?php echo $views['message']['to'] ?>" value="<?php echo $toUsername ?>" disabled>
			    <textarea id="textNewMessage" placeholder="<?php echo $views['message']['message'] ?>"></textarea>
			    <br><br>
			    <div class="row">
				<div class="large-12">
				    <input type="button" class="buttonNext" value="<?php echo $views['message']['send'] ?>" id="sendMessage" onclick="btSendNewMessage('newMsgUser', '<?php echo $user ?>', '<?php echo $toType ?>')">
				</div>
			    </div>
			</div>
		    <?php } else { ?>

			<div class="row">
			    <div class="large-12 columns">
				<div class="line-date"><small><?php echo $views['message']['error2'] ?></small></div>
			    </div>
			</div>	
			<?php
		    }
		} else {
		    ?>

		    <div class="row">
		        <div class="large-12 columns">
		    	<div class="line-date"><small><?php echo $views['message']['error1'] ?></small></div>
		        </div>
		    </div>
		    <?php
		}
	    }
	}
    }
}
?>