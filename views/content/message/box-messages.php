<?php

if(isset($_POST['user']) && $_POST['user'] == 'newmessage'){
	?>
	<div class="row">
		<div class="large-12 columns ">
		    <h5>Write a new message</h5>
		    <input id="to" type="text" placeholder="To:">
		    <textarea placeholder="Message"></textarea>
		</div>
	</div>
	
	
	<?php
	
	
}else{


if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once BOXES_DIR . 'message.box.php';

$messageBox = new MessageBox();

if(isset($_POST['user'])){
	$user = $_POST['user'];
	$messageBox->initForMessageList($user, 10, 0);
	if($messageBox->error != $boxes['ONLYIFLOGGEDIN']){
		
		$dataPrec = '';
?>



<div class="row">
	<div class="large-12 columns ">
	        
	    <div id="chat">
	        <div class="row">
	            <div class="large-12 columns ">
	            	
	            	<?php foreach ($messageBox->messageArray as $key => $value) {
	            								
						$data = $value->createdAt->format('d-F-Y');
						$time = $value->createdAt->format('H:i');
						if($data != $dataPrec){				
						//12-Jan-2013
					 ?>
	            	
	                <div class="row">
	                    <div class="large-12 columns">
	                    	<div class="line-date"><small><?php echo $data ?></small></div>
	                    </div>
	                </div>
	            	
	            	<?php } 
	            		if($value->send == 'S'){
	            	
	            	?>
	            	
	                <div class="row" >
	                	<div class="large-8 large-offset-2 columns msg msg-mine">
	                    	<p><?php echo $value->text ?></p>
	                    </div>
	                    <div class="large-2 hide-for-small columns">
	                    	<div class="date-mine">
	                    		<small><?php  echo $time ?></small>
	                        </div>
	                    </div>
	                </div>
	                <?php } else{ ?>
	                <div class="row">
	                	<div class="large-2 hide-for-small columns">
	                    	<div class="date-yours">
	                    		<small><?php  echo $time ?></small>
	                        </div>
	                    </div>
	                	<div class="large-8 end columns msg msg-yours">
	                    	<p><?php echo $value->text ?></p>
	                    </div>
	                </div>	                
	                <?php }
					$dataPrec = $data;
					} 
	                if(count($messageBox->messageArray) == 0){
	                ?>
	                <div class="row">
	                	<div class="large-2 hide-for-small columns">
	                    	<div class="date-yours">
	                    		<small></small>
	                        </div>
	                    </div>	                	
	                	<div class="small-8 columns msg msg-yours">
	                    	<p>Nessun Messaggio</p>
	                    </div>
	                    <div class="large-2 hide-for-small columns">
	                    	<div class="date-yours">
	                    		<small></small>
	                        </div>
	                    </div>
	                </div>	
	                <?php	
	                }
	                ?>
	            </div>
	        </div>
	    </div>
	    
	    <textarea placeholder="Message"></textarea>
	</div>
</div>
<?php }}}?>