<?php
/* box per elenco following
 * box chiamato tramite ajax con:
 * data: {user: objectId}, 
 * data-type: html,
 * type: POST o GET
 * 
 * box solo per spotter
 */

 $data = $_POST['data'];
$typeUser = $_POST['typeUser'];


$followersCounter = $data['relation']['following']['followingCounter'];
$followingVenueCounter = $data['relation']['followingVenue']['followingVenueCounter'];
$followingJammerCounter = $data['relation']['followingVenue']['followingJammerCounter'];

?>
<!----------------------------------- FOLLOWING -------------------------------------------------->
<div class="row">
	<div class="large-12 columns ">
		<h3>Following</h3>	
		<div class="box" id="following-list">
			<?php if($followersCounter > 0 ){ ?>
			<div class="row">
				<div class="large-12 columns">
					<div class="text orange">Venue <span class="white">[<?php echo $followingVenueCounter;?>]</span></div>	
				</div>
			</div>
			<?php 
					$totalView = $followingVenueCounter > 4 ? 4 : $followingVenueCounter;
					for($i=0; $i<$totalView; $i=$i+2){
						
						?>	
					
					<div class="row">
						<div  class="small-6 columns">
							<div class="box-membre">
	    						<div class="row " id="collaborator_<?php echo $data['relation']['followingVenue'. $i]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['followingVenue'. $i]['thumbnail']?>" onerror="this.src='../media/images/default/defaultProfilepicturethumb.jpg'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark"><strong><?php echo $data['relation']['followingVenue'. $i]['username']?></strong></div>
									</div>		
								</div>	
	    					</div>
						</div>
						
						<div  class="small-6 columns ">
							<div class="box-membre">
	    						<div class="row " id="collaborator_<?php echo $data['relation']['followingVenue'. $i+1]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['followingVenue'. $i+1]['thumbnail']?>" onerror="this.src='../media/images/default/defaultProfilepicturethumb.jpg'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark"><strong><?php echo $data['relation']['followingVenue'. $i+1]['username']?></strong></div>
									</div>		
								</div>
	    					</div>
						</div>
						
					</div>
					<?php } ?>
			<div class="row">
				<div  class="large-12 columns"><div class="line"></div></div>
			</div>
			<!------------------------------------------ JAMMER ----------------------------------->
			<div class="row">
				<div class="large-12 columns">
					<div class="text orange">Jammer <span class="white">[<?php echo $followingJammerCounter;?>]</span></div>	
				</div>
			</div>
			<?php 
					$totalView = $followingVenueCounter > 4 ? 4 : $followingVenueCounter;
					for($i=0; $i<$totalView; $i=$i+2){
						
						?>	
					
					<div class="row">
						<div  class="small-6 columns">
							<div class="box-membre">
	    						<div class="row " id="collaborator_<?php echo $data['relation']['followingVenue'. $i]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['followingVenue'. $i]['thumbnail']?>" onerror="this.src='../media/images/default/defaultProfilepicturethumb.jpg'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark"><strong><?php echo $data['relation']['followingVenue'. $i]['username']?></strong></div>
									</div>		
								</div>	
	    					</div>
						</div>
						
						<div  class="small-6 columns ">
							<div class="box-membre">
	    						<div class="row " id="collaborator_<?php echo $data['relation']['followingVenue'. $i+1]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['followingVenue'. $i+1]['thumbnail']?>" onerror="this.src='../media/images/default/defaultProfilepicturethumb.jpg'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark"><strong><?php echo $data['relation']['followingVenue'. $i+1]['username']?></strong></div>
									</div>		
								</div>
	    					</div>
						</div>
						
					</div>
			<?php }}
 					else{?>	
						 <div class="row  ">
								<div  class="large-12 columns ">
									<p class="grey">There are no Following</p>
								</div>
						</div>
						 <?php } ?>			
		</div>
	</div>
</div>