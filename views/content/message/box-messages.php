<?php

if(isset($_POST['user']) && $_POST['user'] == 'newmessage'){
	?>
	<div class="row">
		<div class="large-12 columns ">
		    <h5>Write a new message</h5>	
		    <input id="to" type="text" placeholder="To:">
		    <textarea id="tomessage" placeholder="Message"></textarea>
		</div>
	</div>
	
	
	<?php
	
	
}else{


if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'message.box.php';

$limit = (int)$_POST['limit'];
$skip = (int)$_POST['skip'];

$messageBox = new MessageBox();

if(isset($_POST['user'])){
	$user = $_POST['user'];
	$messageBox->initForMessageList($user, $limit, $skip);
	if($messageBox->error != ONLYIFLOGGEDIN){
		
		$dataPrec = '';
		
		if(count($messageBox->messageArray) > 0){
?>



<div class="row">
	<div class="large-12 columns ">
	        
	    <div id="chat">
	        <div class="row">
	            <div class="large-12 columns ">
	            	<?php if(count($messageBox->messageArray) == $limit){ ?>
	            	<div class="row">
	                    <div class="large-12 columns">
	                    	<div class="line-date otherMessage" onclick="loadBoxMessages('<?php echo $user ?>',<?php echo $limit ?>,<?php echo $limit+$skip ?>)"><small>View Other Messages</small></div>
	                    </div>
	               </div>
	            	<?php 
					}
					$risultato = array_reverse($messageBox->messageArray);
	            	foreach ($risultato as $key => $value) {
	            								
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
	    <?php if($skip == 0){?>
	    <textarea placeholder="Message" id="textMessage"></textarea>
	    <?php } ?>
	</div>
</div>
	<?php }
		else{ ?>
		
		<div class="row">
            <div class="large-12 columns">
            	<div class="line-date otherMessage" onclick="loadBoxMessages('<?php echo $user ?>',<?php echo $limit ?>,<?php echo $limit+$skip ?>)"><small>No Messages</small></div>
            </div>
       </div>	
			
			
		
		<?php 	
			
		}
	}
					

}
}?>