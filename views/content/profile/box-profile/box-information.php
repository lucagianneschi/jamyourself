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

$data = $_POST['data'];

$username = $data['username'];
$information_description = $data['description'] != "" ? '<div class="content" data-section-content>' : '<div class="no-display">';
$information_pin = $data['city'] == "" ? '' : '_pin';
if($username != 'VENUE')
	$information_note = $data['music'] == "" ? '' : '_note';
if($username == 'VENUE'){
	$latitude = $data['geoCoding']['lat'];
	$longitude = $data['geoCoding']['long'];
	
}

function noDisplay($dato){
	return $dato == "" ? 'no-display' : '';
}
?>
<!--------- INFORMATION --------------------->
<div class="row">
	<div class="large-12 columns">
	<h3>Information</h3>		
		<div class="section-container accordion" data-section="accordion">
		  <section class="active" >
		  	<!--------------------------------- ABOUT ---------------------------------------------------->
		    <p class="title" data-section-title><a href="#">About</a></p>
		    <?php echo $information_description; ?>
		    	<p id="text grey"><?php echo $data['description'];?></p> 
		    </div>
		    <div class="content" data-section-content>
		    	<div class="row">
		    		<div class="small-6 columns">				
						<a class="ico-label <?php echo $information_pin; ?> white"><?php echo $data['city'];?></br><div class="grey" id="informatio-address"></div></a>
		    			<a class="ico-label <?php echo $information_note; ?> white"><?php echo $data['music'];?></a>			    			
		    		</div>
		    		<div class="small-6 columns">
		    			<div class="row <?php echo noDisplay($data['facebook']); ?>">
		    				<div class="small-12 columns">
		    					<a class="ico-label _facebook"><?php echo $data['facebook'];?></a>
		    					
		    				</div>	
		    			</div>
		    			<div class="row <?php echo noDisplay($data['twitter']); ?>">
		    				<div class="small-12 columns">
		    					<a class="ico-label _twitter"><?php echo $data['twitter']; ?></a>
		    				</div>	
		    			</div>
		    			<div class="row  <?php echo noDisplay($data['google']); ?>">
		    				<div class="small-12 columns">
		    					<a class="ico-label _google"><?php echo $data['google']; ?></a>
		    				</div>	
		    			</div>
		    			<div class="row  <?php echo noDisplay($data['youtube']); ?>">
		    				<div class="small-12 columns">
		    					<a class="ico-label _youtube"><?php echo $data['youtube']; ?></a>
		    				</div>	
		    			</div>
		    			<div class="row  <?php echo noDisplay($data['web']); ?>">
		    				<div class="small-12 columns">
		    					<a href="<?php echo $data['web']; ?>" class="ico-label _web"><?php echo $data['web']; ?></a>
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
		  <section>
		    <p class="title" data-section-title><a href="#">Membres</a></p>
		    <div class="content" data-section-content>
		    	<?php if(is_array($data['membres'])){ ?>
			     <div class="row">
    				<div class="small-6 columns">
    					<div class="box-membre">
    						<span class="text white"><?php echo $data['membres'] ?></span></br>
    						<span class="note grey"><?php echo $data['membres'] ?></span>
    					</div>
    					<div class="box-membre">
    						<span class="text white"><?php echo $data['membres'] ?></span></br>
    						<span class="note grey"><?php echo $data['membres'] ?></span>
    					</div>
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
    					<div class="box-membre">
    						<span class="text white"><?php echo $data['membres'] ?></span></br>
    						<span class="note grey"><?php echo $data['membres'] ?></span>
    					</div>
    					
    				</div>		
    			</div>
    			<?php }?>	    			
		    </div>
		  </section>
		   <?php 
		  	}
			// su utente e' tipo venue allora viene mostrato il section del map
			if($data['type'] == "VENUE"){
		  ?>		  
		  <!--------------------------------------- MAP --------------------------------------->
		  <section id="profile_map_venue" onclick="viewMap(<?php echo $latitude ?>,<?php echo $longitude ?>)"> 
		  	<p class="title" data-section-title><a href="#">Map</a></p>
		  	<div class="content" data-section-content>
		  		<div class="row">
    				<div class="small-12 columns">     					  	
    					<div  id="map_venue"></div>	
    				</div>
    			</div>
    			<div class="row">
    				<div class="small-4 small-offset-8  columns ">
    					<a class="ico-label _pin white ">Get direction</a> 
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

