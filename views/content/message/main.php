<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once BOXES_DIR . 'message.box.php';

define('LIMITLISTMSG', 5);
define('SKIPLISTMSG', 0);

define('LIMITMSG', 5);
define('SKIPMSG', 0);

$messageBox = new MessageBox();
$messageBox->initForUserList(LIMITLISTMSG, SKIPLISTMSG);

$cssNewMessage = "no-display";
if(isset($user)){
	$cssNewMessage = "";
	
}
if($messageBox->error != ONLYIFLOGGEDIN){
?>
<script type="text/javascript">
	function viewOtherListMsg(user,limit,skip){
		$.ajax({
			type: "POST",
			data:{
				user: user,
				limit: limit,
				skip: skip		
			},
			url: "./content/message/box-listMessages.php",
			beforeSend: function(xhr) {
				if(user != 'newmessage'){
					//$('#box-messageSingle').slideUp();
				}
				
			}
		}).done(function(message, status, xhr) {
			$('.box-other').addClass('no-display');			
			$(message).appendTo("#box-listMsg");
						
			//$('#box-messageSingle').slideDown();
			console.log('SUCCESS: box-message '+user);									
			if(user == 'newmessage'){
			//	autoComplete();
			}
		}).fail(function(xhr) {
			console.log("Error: " + $.parseJSON(xhr));
		}); 
		
		
	}									
	function loadBoxMessages(user,limit,skip){
		$.ajax({
			type: "POST",
			data:{
				user: user,
				limit: limit,
				skip: skip	
			},
			url: "./content/message/box-messages.php",
			beforeSend: function(xhr) {
				if(user != 'newmessage' && skip == 0){
					$('#box-messageSingle').slideUp();
					
				}
				
			}
		}).done(function(message, status, xhr) {			
			
			if(skip == 0){
				$("#box-messageSingle").html(message);
				$('#box-messageSingle').slideDown();
			}
			else{
				$('.otherMessage').addClass('no-display');
				$(message).prependTo("#box-messageSingle");
					
			}
						
			
			
			console.log('SUCCESS: box-message '+user);									
			if(user == 'newmessage'){
				autoComplete();
			}
		}).fail(function(xhr) {
			console.log("Error: " + $.parseJSON(xhr));
		});
	}
											
</script>
<div class="bg-white">
	<div class="row" style="padding-top: 3%;">
		<div class="large-12 columns">
			<div class="box-message">
				<h3>Messages</h3>
				<div class="row">
					<div class="large-12 columns">
						<div class="box">
							<div class="row box-upload-title">
								<div class="large-12 columns">
								</div>
							</div>
							<div class="row">
								<div class="large-4 columns">
									<div class="sidebar">
										<div class="row ">							
										    <div class="large-12 columns ">
										        <div class="sottotitle grey">You talked to...</div>
										    </div>	
										</div>
										<div class="row">
										    <div class="large-12 columns"><div class="line"></div></div>
										</div>
										<div class="row">
										    <div class="large-12 columns ">
										    	
										    	<div class="box-membre <?php echo $cssNewMessage?>" id="newmessage" >
										            <div class="box-msg" onClick="showNewMsg()">
										                <div class="row">
										                    <div class="small-2 columns ">
										                        <div class="icon-header">
										                            <img src="./resources/images/icon/messages/newmessage.jpg">
										                        </div>
										                    </div>
										                    <div class="small-10 columns" style="padding-top: 8px;">
										                        <div class="text orange breakOffTest">New message</div>
										                    </div>		
										                </div>
										            </div>
										        </div>
												<div id="box-listMsg">
													<?php require_once './content/message/box-listMessages.php'; ?> 
												</div>                                        
                                    	    </div>
                                    	</div>                                              
                                    </div>
                                    
                                </div>
								
								<div class="large-8 columns">
									 <div id="box-messageSingle">
									 	<?php if(isset($user)){ ?>
										<script type="text/javascript">									
										loadBoxMessages("<?php echo $user ?>",<?php echo LIMITMSG ?>, <?php echo SKIPMSG ?>);		
										</script>
										<?php } else{ ?>	
									 	<div class="row">
											<div class="large-12 columns ">
											    <h5>Write a new message</h5>	
											    <input id="to" type="text" placeholder="To:">
											    <textarea id="tomessage" placeholder="Message"></textarea>
											</div>
										</div> 
										<?php } ?>           
                                    	
                                    </div>	                                              
								</div>
                                
							</div>
                            
                          <br><br>
                            <div class="row">
                                <div class="large-12">
                                   <input type="button" class="buttonNext" value="Send">
                                </div>
                            </div>
                            
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
}
else{
	?>
	<div class="bg-white">
	<div class="row" style="padding-top: 3%;">
		<div class="large-12 columns">
			<div class="box-message">
			Errore: Utente non loggato
			</div>
		</div>
	</div>
	</div>
	<?php	
}
?>