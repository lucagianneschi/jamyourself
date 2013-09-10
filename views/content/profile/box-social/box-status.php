<?php
/* box status utente 
 * box chiamato tramite load con:
 * data: {data,typeCurrentUser}, 
 * 
 * 
 */

 $data = $_POST['data'];
 $currentUserType = $_POST['typeCurrentUser'];

 $status_level = $data['level'];
 $status_namelevel = $data['levelValue'];
 $userType = $data['type'];

 //achievement array -------- DA DEFINIRE -----------------
 $status_achievement1 = '_target1';
 $status_achievement2 = '_target2';
 $status_achievement3 = '_target3';
?>
<!------------------------------------------- STATUS ----------------------------------->
<div class="row">
	<div class="small-9 columns status">			
		<h3><strong><?php echo $status_level; ?><span class="text">pt.</span></strong></h3>					
	</div>
	<div class="small-3 columns">			
		<div class="row">
			<div  class="large-12 columns">
				<div class="text orange livel-status"><?php echo $status_namelevel; ?></div>
			</div>
		</div>
		<div class="row">
			<div  class="large-12 columns">
				<img src="./resources/images/status/popolarity.png"/> 	
			</div>
		</div>		
	</div>
</div>
<div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
</div>
<!------------------------------------ ACHIEVEMENT ----------------------------------------->
<div class="row">
	<div id="social_list_achievement" class="touchcarousel grey-blue">
		<ul class="touchcarousel-container">
			<li class="touchcarousel-item">  
				<div class="item-block achievement achievement-target <?php echo $status_achievement1; ?>"></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement achievement-target <?php echo $status_achievement2; ?>"></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement achievement-target <?php echo $status_achievement3; ?>"></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>		
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
			<li class="touchcarousel-item">
				<div class="item-block achievement "></div>
			</li>
		</ul>		
	</div>
</div>
<div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
</div>
<?php if($userType == "SPOTTER" && $currentUserType == "SPOTTER"){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> Send Message</div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status">Add Friend</div></a>
	</div>
	</div>
</div>
<?php }?>
<?php if($userType == "JAMMER" && ($currentUserType == "JAMMER" || $currentUserType == "VENUE")){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> Send Message</div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status">Collaborate</div></a>
	</div>
	</div>
</div>
<?php }?>
<?php if($userType == "JAMMER" && ($currentUserType == "SPOTTER")){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> Send Message</div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status">Follow</div></a>
	</div>
	</div>
</div>
<?php }?>
<?php if($userType == "VENUE" && ($currentUserType == "SPOTTER")){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> Send Message</div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status">Follow</div></a>
	</div>
	</div>
</div>
<?php }?>
<?php if($userType == "VENUE" && ($currentUserType == "JAMMER")){?>
<div class="row ">
	<div  class="large-12 columns">
	<div class="status-button">
		<a href="#" class="button bg-grey"><div class="icon-button _message_status"> Send Message</div></a>
		<a href="#" class="button bg-orange"><div class="icon-button _follower_status">Collaborate</div></a>
	</div>
	</div>
</div>
<?php } ?>