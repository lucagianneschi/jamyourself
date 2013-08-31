<?php
/*
 * Contiene il box information dell'utente
 * Il contenuto varia a seconda del tipo di utente:
 * spotter: abount
 * jammer: abount e member
 * venue: abount e map
 * 
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId, typeUser: typeUser}, 
 * data-type: html,
 * type: POST o GET
 * 
 * 
 */

 
 $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu est dui. Etiam eu elit at lacus eleifend consectetur. Curabitur dolor diam, fringilla quis dignissim eget, tempus et lectus. Quisque sollicitudin laoreet tincidunt. In pretium massa quis diam dignissim dapibus. Donec sed mi mauris, a mollis nibh. Mauris et arcu eu quam mollis convallis ultricies id lacus. Donec dignissim sollicitudin nunc ultrices consectetur. ";
 $music = "Hard Rock - Indie Rock - Dub";
 $city = "Torino (CN)";
 
 //address per venue
 $address = "Via Roma, 224 / B";

 
 $facebook = "fb.com/jammer";
 $twitter = "@jammer";
 $google = "jammer";
 $youtube = "nome jammer";
 $web = "www.jammer.com";
 
 
 //--- membre se typeuser== jammer
 $membre1_name = 'Member name';
 $membre1_instrument = "Drummer";
 
 $membre2_name = 'Member name';
 $membre2_instrument = "Guitarist";
 
 $membre3_name = 'Member name';
 $membre3_instrument = "Sax";
 
?>
<!--------- INFORMATION --------------------->
<div class="row">
	<div class="large-12 columns">
	<h3>Information</h3>		
		<div class="section-container accordion" data-section="accordion">
		  <section class="active" >
		  	<!--------------------------------- ABOUT ---------------------------------------------------->
		    <p class="title" data-section-title><a href="#">About</a></p>
		    <div class="content" data-section-content>
		    	<p id="text grey"><?php echo $description;?></p> 
		    </div>
		    <div class="content" data-section-content>
		    	<div class="row">
		    		<div class="small-6 columns">
		    			
						<a class="ico-label _note white"><?php echo $music;?></a>		    				
				
						<a class="ico-label _pin white"><?php echo $city;?></br><div class="grey"><?php if($userType == "venue") echo $address;?></div></a>
		    				
		    			
		    		</div>
		    		<div class="small-6 columns">
		    			<div class="row">
		    				<div class="small-12 columns">
		    					<a class="ico-label _facebook"><?php echo $facebook;?></a>
		    					
		    				</div>	
		    			</div>
		    			<div class="row">
		    				<div class="small-12 columns">
		    					<a class="ico-label _twitter"><?php echo $twitter; ?></a>
		    				</div>	
		    			</div>
		    			<div class="row">
		    				<div class="small-12 columns">
		    					<a class="ico-label _google"><?php echo $google; ?></a>
		    				</div>	
		    			</div>
		    			<div class="row">
		    				<div class="small-12 columns">
		    					<a class="ico-label _youtube"><?php echo $youtube; ?></a>
		    				</div>	
		    			</div>
		    			<div class="row">
		    				<div class="small-12 columns">
		    					<a class="ico-label _web"><?php echo $web; ?></a>
		    				</div>	
		    			</div>
		    		</div>		
		    	</div>
		    </div>			    
		  </section>
		  <?php 
		  	if($userType == "jammer"){
		  ?>
		  <!--------------------------------------- MEMBRES --------------------------------------->
		  <section>
		    <p class="title" data-section-title><a href="#">Membres</a></p>
		    <div class="content" data-section-content>
			     <div class="row">
    				<div class="small-6 columns">
    					<div class="box-membre">
    						<span class="text white"><?php echo $membre1_name ?></span></br>
    						<span class="note grey"><?php echo $membre1_instrument ?></span>
    					</div>
    					<div class="box-membre">
    						<span class="text white"><?php echo $membre2_name ?></span></br>
    						<span class="note grey"><?php echo $membre2_instrument ?></span>
    					</div>
    					<div class="box-membre">
    						<span class="text white"><?php echo $membre3_name ?></span></br>
    						<span class="note grey"><?php echo $membre3_instrument ?></span>
    					</div>
    				</div>
    				<div class="small-6 columns">
    					<div class="box-membre">
    						<span class="text white"><?php echo $membre3_name ?></span></br>
    						<span class="note grey"><?php echo $membre3_instrument ?></span>
    					</div>
    					<div class="box-membre">
    						<span class="text white"><?php echo $membre3_name ?></span></br>
    						<span class="note grey"><?php echo $membre3_instrument ?></span>
    					</div>
    					
    				</div>		
    			</div>	    			
		    </div>
		  </section>
		   <?php 
		  	}
			// su utente e' tipo venue allora viene mostrato il section del map
			if($userType == "venue"){
		  ?>		  
		  <!--------------------------------------- MAP --------------------------------------->
		  <section id="profile_map_venue" > 
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

