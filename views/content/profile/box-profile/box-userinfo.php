<?php
/*
 * box userinfo
 * chiamato tramite load con:
 * data: {data: data} 
 * @data: array contenente le informazioni relative al box userInfo.box
 * 
 * box per tutti gli utenti
 */

$data = $_POST['data'];

$userinfo_pin = $data['city'] == "" ? '' : '_pin';
$userinfo_note = $data['music'] == "" ? '' : '_note';


?>
<div class="row" id="profile-userInfo">
	<div class="large-12 columns">
		<h2><?php echo $data['username']?></h2>			
		<div class="row">
			<div class="small-12 columns">				
				<a class="ico-label <?php echo $userinfo_pin?>"><?php echo $data['city']?></a>
				<a class="ico-label <?php echo $userinfo_note?>"><?php echo $data['music']?></a>
			</div>				
		</div>		
	</div>
</div>
<div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
</div>	
			
<div class="row">
	<div class="large-12 columns">
		<img class="background" src="../media/<?php echo $data['backGround'] ?>"  onerror="this.src='../media/images/default/defaultBackground.jpg'" >
		<img class="picture" src="../media/<?php echo $data['profilePicture'] ?>" onerror="this.src='../media/images/default/defaultProfilepicture.jpg'" width="150" height="150">							
	</div>
</div> 
