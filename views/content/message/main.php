<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'message.box.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';

define('LIMITLISTMSG', 1);
define('SKIPLISTMSG', 0);

define('LIMITMSG', 5);
define('SKIPMSG', 0);

$messageBox = new MessageBox();
$messageBox->initForUserList(LIMITLISTMSG, SKIPLISTMSG);

$cssNewMessage = "no-display";
if (isset($user)) {
    $cssNewMessage = "";
}

if ($messageBox->error != ONLYIFLOGGEDIN) {
?>

<form class="formWhite" data-abide >
	<div class="row bg-white" style="padding-top: 3%;">
	    <div class="box-message large-12 columns">
		    <h3>Messages</h3>
		    <div class="box">    				
				<div class="row">
					<!---------------- BOX LISTA UTENTI ------------------------------->
				    <div class="large-4 columns">
						<div class="sidebar">
						    <div class="row ">							
								<div class="large-12 columns ">
								    <div class="sottotitle grey"><?php echo $views['message']['talked_to']; ?></div>
								</div>	
						    </div>
						    <div class="row">
								<div class="large-12 columns"><div class="line"></div></div>
						    </div>
						    <div class="row">
								<div class="large-12 columns ">	
									<!-------------------- box per far aprarire il box del nuovo messaggio ---------------->	
								    <div class="box-membre <?php echo $cssNewMessage ?>" id="newmessage" >
										<div class="box-msg" onClick="showNewMsg()">
										    <div class="row">
												<div class="small-2 columns ">
												    <div class="icon-header">
														<img src="./resources/images/icon/messages/newmessage.jpg">
												    </div>
												</div>
												<div class="small-10 columns" style="padding-top: 8px;">
												    <div class="text orange breakOffTest"><?php echo $views['message']['new_msg']; ?></div>
												</div>		
										    </div>
										</div>
								    </div>
								    <div id="box-listMsg">
										<!--------------------------- lista utenti --------------------------->
									    <?php require_once './content/message/box-listUsers.php'; ?> 
								    </div>                                        
								</div>
						    </div>                                              
						</div>
				    </div>
					<!------------------------------------ BOX PER INVIO MESSAGGI ------------------------------->
				    <div class="large-8 columns">
    					<div id="box-messageSingle">						
						    <div class="row">
								<div class="large-12 columns">
									<div id="spinner"></div>
								<?php if(!isset($user)){ ?>
								    <h5><?php echo $views['message']['write_message']; ?></h5>
								    <label for="to"><small class="error"><?php echo $views['message']['valid_user']; ?></small></label>
								    <input id="to" type="text" placeholder="<?php echo $views['message']['to'] ?>" required>											    
								<?php }else{ ?>
									<!--- messaggi utente ---->
									<div id="msgUser">
										<input type="hidden" id="user" value="<?php echo $user ?>"/>
										<input type="hidden" id="limit" value="<?php echo LIMITMSG ?>"/>
										<input type="hidden" id="skip" value="<?php echo SKIPMSG ?>"/>
									</div>																		
								<?php } ?>
									
									<div id="boxInvioMSG">	    
									    <textarea id="textNewMessage" placeholder="<?php echo $views['message']['message'] ?>"></textarea>
									    <br><br>
									    <div class="row">
										    <div class="large-12">
										    	<input type="button" class="buttonNext" value="<?php echo $views['message']['send'] ?>" id="sendMessage" onclick="btSendMessage('<?php echo $user ?>')">
										    </div>
										</div>
									</div>
								</div>
						    </div>	
    					</div>    					                                           
				    </div>
				    <!---------------------------------- FINE BOX INVIO MESSAGGGI ------------------------------>
				</div>
		    </div>
	    </div>
	</div>       
</form>
<?php
} else { ?>
<div class="row">
    <div class="large-12 columns">Error</div>
</div>
<?php } ?>