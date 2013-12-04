<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once BOXES_DIR . 'message.box.php';

$messageBox = new MessageBox();
$messageBox->initForUserList(5, 0);

if($messageBox->error != $boxes['ONLYIFLOGGEDIN']){
?>

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
                                    	<?php require_once './content/message/box-listMessages.php'; ?>                                               
                                    </div>
                                </div>
								
								<div class="large-8 columns">
									 <div id="box-messageSingle">
									 	<?php if(isset($user)){ ?>
										<script type="text/javascript">
										
										function loadBoxMessages(user){
											$.ajax({
												type: "POST",
												data:{
													user: user
												},
												url: "./content/message/box-messages.php",
												beforeSend: function(xhr) {
													console.log('START: box-message');
													if(user != 'newmessage')
													$('#box-messageSingle').slideUp();
												}
											}).done(function(message, status, xhr) {
												
												$("#box-messageSingle").html(message);
												$('#box-messageSingle').slideDown();
												console.log('SUCCESS: box-message');									
												
											}).fail(function(xhr) {
												console.log("Error: " + $.parseJSON(xhr));
											});
										}
										loadBoxMessages("<?php echo $user ?>");		
										</script>
										<?php } else{ ?>	
									 	<div class="row">
											<div class="large-12 columns ">
											    <h5>Write a new message</h5>
											    <input id="to" type="text" placeholder="To:">
											    <textarea placeholder="Message"></textarea>
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