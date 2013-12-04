<?php
$cssNewMessage = "no-display";
if(isset($user)){
	$cssNewMessage = "";
	
}

?>


<div class="row ">							
    <div class="large-12 columns ">
        <div class="sottotitle grey">You talked to...</div>
    </div>	
</div>
<div class="row">
    <div class="large-12 columns"><div class="line"></div></div>
</div>

<div class="row">
    <div class="large-12 columns">
    	
    	<div class="box-membre <?php echo $cssNewMessage?>" id="newmessage">
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
		
		<?php foreach ($messageBox->userInfoArray as $key => $value) {
				$tumb = "";		 
				switch ($value->userInfo->type) {
					
					case 'SPOTTER':
						$tumb = DEFTHUMBSPOTTER;
						break;
					case 'JAMMER':
						$tumb = DEFTHUMBJAMMER;
						break;
					case 'VENUE':
						$tumb = DEFTHUMBVENUE;
						break;
					default:
						
						break;
				}
			   $readCss = '';
			   $activeCss = '';
			   //controlla se il messaggio e' segnato come letto oppure se 
			   //l'utente e' lo stesso del messaggio che vogliamo visualizzare
			   if($value->read == true || (isset($user) && $user == $key))
			   		$readCss = 'no-display';
			   if(isset($user) && $user == $key)
			   		$activeCss = 'active';
			?>		
				
				
		<div class="box-membre <?php echo $activeCss ?>" id="<?php echo $key ?>">
        	<div class="unread <?php echo $readCss ?>"></div>
            <div class="delete" onClick="deleteMsg('<?php echo $key ?>')"></div>
            <div class="box-msg" onClick="showMsg('<?php echo $key ?>')">
                <div class="row">
                    <div class="small-2 columns ">
                        <div class="icon-header">
                            <img src="<?php echo $value->userInfo->thumbnail ?>" onerror="this.src='<?php echo $tumb?>'">
                        </div>
                    </div>
                    <div class="small-10 columns" style="padding-top: 8px;">
                        <div id="a1to" class="text grey-dark breakOffTest"><?php echo $value->userInfo->username ?></div>
                    </div>		
                </div>
            </div>
        </div>
       
       <?php  } ?>  
    
    </div>								
</div>