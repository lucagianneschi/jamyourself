<?php
/* Contiene informazioni principali dell'utente: username, city, music, background e profilePicture
 * box chiamato tramite ajax con:
 * data: {username, city, music, background e profilePicture}, 
 * data-type: html,
 * type: POST o GET
 * 
 * Verrà chiamato l'oggetto di tipo userInfo.box.php
 */


  

if($userType == "jammer"){
	
$username = "Nome Jammer";

$city = "Saluzzo (CN)";

//genere musicale è  un array
$music = "Hard Rock";

$backGround = "backGround.jpg";

$profilePicture = "profilePicture.jpg"; 
}
if($userType == "spotter"){
	$username = "Nome Spotter";

	$city = "Saluzzo (CN)";
	
	//genere musicale è  un array
	$music = "Hard Rock";
	
	$backGround = "backGround-spotter.jpg";
	
	$profilePicture = "profilePicture-spotter.jpg"; 
}
if($userType == "venue"){
	$username = "Nome Venue";

	$city = "Saluzzo (CN)";
	
	//genere musicale è  un array
	$music = "Hard Rock";
	
	$backGround = "backGround-venue.jpg";
	
	$profilePicture = "profilePicture-venue.jpg"; 
}


?>
<div class="row">
	<div class="large-12 columns">
		<h2><?php echo $username;?></h2>			
		<div class="row">
			<div class="small-12 columns">				
				<a class="ico-label _pin"><?php echo $city;?></a>
				<a class="ico-label _note"><?php echo $music;?></a>
			</div>				
		</div>		
	</div>
</div>
<div class="row">
	<div  class="large-12 columns"><div class="line"></div></div>
</div>	
			
<div class="row">
	<div class="large-12 columns">
		<img class="avatar" src="../media/images/background/<?php echo $backGround;?>">
		<img class="picture" src="../media/images/profilepicture/<?php echo $profilePicture;?>" width="150" height="150">							
	</div>
</div> 
