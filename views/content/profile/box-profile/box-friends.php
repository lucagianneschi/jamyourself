<?php
/* box per elenco friend
 * box chiamato tramite ajax con:
 * data: {user: objectId}, 
 * data-type: html,
 * type: POST o GET
 * 
 * box solo per spotter
 */
 
$totFriends = "2.590";

//elenco friends 
$friend1_photo = "photo2.jpg";
$friend1_username = "Member name";
$friend1_type = "Jammer";	

?>
<!----------------------------------- FRIENDS -------------------------------------------------->
<div class="row">
	<div class="large-12 columns ">
		<h3>Friends <span class="orange">[<?php echo $totFriends;?>]</span></h3>	
		<div class="box" id="friends-list">
			<div class="row ">
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $friend1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $friend1_username;?></div>
								<div class="note orange"><?php echo $friend1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $friend1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $friend1_username;?></div>
								<div class="note orange"><?php echo $friend1_type;?></div>
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
									<img src="../media/images/profilepicturethumb/<?php echo $friend1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $friend1_username;?></div>
								<div class="note orange"><?php echo $friend1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
				<div class="large-6 columns">
					<div class="box-membre">
						<div class="row ">
							<div  class="small-3 columns ">
								<div class="userThumb">
									<img src="../media/images/profilepicturethumb/<?php echo $friend1_photo;?>">
								</div>
							</div>
							<div  class="small-9 columns ">
								<div class="text white"><?php echo $friend1_username;?></div>
								<div class="note orange"><?php echo $friend1_type;?></div>
							</div>		
						</div>	
					</div>					
				</div>
			</div>
				
		</div>
	</div>
</div>