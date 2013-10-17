<?php
/*
 * Contiene il box information dell'utente
 * Il contenuto varia a seconda del tipo di utente:
 * spotter: abount
 * jammer: abount e member
 * venue: abount e map
 * 
 * box chiamato tramite load con:
 * data: array conente infomazoini di tipo userInfo, 
 * 
 * 
 */
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
 
$data = $_POST['data'];

$username = $data['username'];
$typeUser = $data['type'];
$information_description = $data['description'] != "" ? '<div class="content" data-section-content>' : '<div class="no-display">';
$information_pin = $data['city'] == "" ? '' : '_pin-white';
if($typeUser != 'VENUE')
	$information_note = $data['music'] == "" ? '' : '_note-white';
if($typeUser == 'VENUE'){
	$latitude = $data['lat'];
	$longitude = $data['lng'];
	
}

function noDisplay($dato){
	return $dato == "" ? 'no-display' : '';
}
?>
<!--------- INFORMATION --------------------->
<div class="row" id="profile-information">
	<div class="large-12 columns">
	<h3>Information</h3>		
		<div class="section-container accordion" data-section="accordion">
		  <section class="active" >
		  	<!--------------------------------- ABOUT ---------------------------------------------------->
		    <p class="title" data-section-title onclick="removeMap()"><a href="#">About</a></p>
		    <?php echo $information_description; ?>
		    	<p class="text grey"><?php echo $data['description'];?></p> 
		    </div>
		    <div class="content" data-section-content>
		    	<div class="row">
		    		<div class="small-6 columns">				
						<a class="ico-label white breakOff <?php echo noDisplay($data['city']); ?><?php echo $information_pin; ?>"><?php echo $data['city'];?></a>
		    			<a class="ico-label grey breakOff <?php echo noDisplay($data['address']); ?>" id="information-address"><?php echo $data['address'];?></a>
		    			<a class="ico-label white breakOff<?php echo $information_note; ?>"><?php echo $data['music']?></a>			    			
		    		</div>
		    		<div class="small-6 columns">
		    			<div class="row <?php echo noDisplay($data['facebook']); ?>">
		    				<div class="small-12 columns">
		    					<a class="ico-label _facebook breakOff"><?php echo $data['facebook'];?></a>
		    					
		    				</div>	
		    			</div>
		    			<div class="row <?php echo noDisplay($data['twitter']); ?>">
		    				<div class="small-12 columns">
		    					<a class="ico-label _twitter breakOff"><?php echo $data['twitter']; ?></a>
		    				</div>	
		    			</div>
		    			<div class="row  <?php echo noDisplay($data['google']); ?>">
		    				<div class="small-12 columns">
		    					<a class="ico-label _google breakOff"><?php echo $data['google']; ?></a>
		    				</div>	
		    			</div>
		    			<div class="row  <?php echo noDisplay($data['youtube']); ?>">
		    				<div class="small-12 columns">
		    					<a class="ico-label _youtube breakOff"><?php echo $data['youtube']; ?></a>
		    				</div>	
		    			</div>
		    			<div class="row  <?php echo noDisplay($data['web']); ?>">
		    				<div class="small-12 columns">
		    					<a href="<?php echo $data['web']; ?>" class="ico-label _web breakOff"><?php echo $data['web']; ?></a>
		    				</div>	
		    			</div>
		    		</div>		
		    	</div>
		    </div>			    
		  </section>
		  <?php 
		  	if($data['type'] == "JAMMER"){
		  ?>
		  <!--------------------------------------- MEMBRES --------------------------------------->
		  <?php if(is_array($data['membres'])){ ?>
		  <section>
		    <p class="title" data-section-title><a href="#">Membres</a></p>
		    <div class="content" data-section-content>
		    	
			     <div class="row">
    				<div class="small-6 columns">
    					<div class="box-membre">
    						<span class="text white"><?php echo $data['membres'] ?></span></br>
    						<span class="note grey"><?php echo $data['membres'] ?></span>
    					</div>
    				</div>
    				<div class="small-6 columns">
    					<div class="box-membre">
    						<span class="text white"><?php echo $data['membres'] ?></span></br>
    						<span class="note grey"><?php echo $data['membres'] ?></span>
    					</div>	
    				</div>		
    			</div>
    			    			
		    </div>
		  </section>
		   <?php 
		  	}}
			// su utente e' tipo venue allora viene mostrato il section del map
			if($data['type'] == "VENUE"){
		  ?>		  
		  <!--------------------------------------- MAP --------------------------------------->
		  <section id="profile_map_venue" > 
		  	<p class="title" data-section-title onclick="viewMap('<?php echo $latitude ?>','<?php echo $longitude ?>')"><a href="#">Map</a></p>
		  	<div class="content" data-section-content>
		  		<div class="row">
    				<div class="small-12 columns">     					  	
    					<div  id="map_venue"></div>	
    				</div>
    			</div>
    			<div class="row">
    				<div class="small-12 columns ">
    					<a class="ico-label _pin white " onclick="getDirectionMap()">Get direction</a> 
    				</div>
    			</div>				 	
			</div>
		  </section>
		  <?php
		  }
		  ?>	
		</div>
		
	</div>
</div>

