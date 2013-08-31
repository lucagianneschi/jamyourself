<?php
/* box per elenco following
 * box chiamato tramite ajax con:
 * data: {user: objectId}, 
 * data-type: html,
 * type: POST o GET
 * 
 * box solo per spotter
 */

$totVenue = "3"; 
 
//elenco following 
$venue1_photo = "photo3.jpg";
$venue1_username = "Venue name";
$venue1_type = "Venue";	



$totjammer = "45"; 
 
//elenco following 
$jammer1_photo = "photo1.jpg";
$jammer1_username = "Member name";
$jammer1_type = "Jammer";	
?>
<!----------------------------------- FOLLOWING -------------------------------------------------->
<div class="row">
	<div class="large-12 columns ">
		<h3>Following</h3>	
		<div class="box" id="following-list">
			<div class="row">
				<div class="large-12 columns">
					<div class="text orange">Venue <span class="white">[<?php echo $totVenue;?>]</span></div>	
				</div>
			</div>
			<div class="row ">
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $venue1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $venue1_username;?></div>
								<div class="note orange"><?php echo $venue1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $venue1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $venue1_username;?></div>
								<div class="note orange"><?php echo $venue1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
			</div>
			<div class="row ">
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $venue1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $venue1_username;?></div>
								<div class="note orange"><?php echo $venue1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
				
			</div>
			<div class="row">
				<div  class="large-12 columns"><div class="line"></div></div>
			</div>
			<!------------------------------------------ JAMMER ----------------------------------->
			<div class="row">
				<div class="large-12 columns">
					<div class="text orange">Jammer <span class="white">[<?php echo $totjammer;?>]</span></div>	
				</div>
			</div>
			<div class="row ">
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $jammer1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $jammer1_username;?></div>
								<div class="note orange"><?php echo $jammer1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $jammer1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $jammer1_username;?></div>
								<div class="note orange"><?php echo $jammer1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
			</div>
			<div class="row ">
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $jammer1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $jammer1_username;?></div>
								<div class="note orange"><?php echo $jammer1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $jammer1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $jammer1_username;?></div>
								<div class="note orange"><?php echo $jammer1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
			</div>
				
		</div>
	</div>
</div>