<?php
/* box followers
 * box chiamato tramite load con:
 * data: {data,typeuser}
 *
 */

$data = $_POST['data'];
$typeUser = $_POST['typeUser'];


$followersCounter = $data['relation']['followers']['followersCounter'];

?>
<div class="row" id="social-followers">
	<div  class="large-12 columns">
		<h3>Followers <span class="orange">[<?php echo $followersCounter ?>]</span></h3>
		<div class="row  ">
			<div  class="large-12 columns ">
				<div class="box">					
				<?php if($followersCounter > 0 ){ 
						$totalView = $followersCounter > 4 ? 4 : $followersCounter;
						for($i=0; $i<$totalView; $i=$i+2){
					
				?>					
					<div class="row">
						<?php if(isset($data['relation']['followers'. $i]['objectId']) && $data['relation']['followers'. $i]['objectId'] != ''){?>
						<div  class="small-6 columns">
							<div class="box-membre">
	    						<div class="row " id="followers_<?php echo $data['relation']['followers'. $i]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['followers'. $i]['thumbnail']?>" onerror="this.src='../media/images/default/defaultProfilepicturethumb.jpg'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark"><strong><?php echo $data['relation']['followers'. $i]['username']?></strong></div>
									</div>		
								</div>	
	    					</div>
						</div>
						<?php } 
						if(isset($data['relation']['followers'. ($i+1)]['objectId']) && $data['relation']['followers'. ($i+1)]['objectId'] != ''){?>
						<div  class="small-6 columns ">
							<div class="box-membre">
	    						<div class="row " id="followers_<?php echo $data['relation']['followers'. ($i+1)]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['followers'. ($i+1)]['thumbnail']?>" onerror="this.src='../media/images/default/defaultProfilepicturethumb.jpg'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark"><strong><?php echo $data['relation']['followers'. ($i+1)]['username']?></strong></div>
									</div>		
								</div>
	    					</div>
						</div>
						<?php } ?>
					</div>
					<?php }?>				
					 <?php }
						else{
						 ?>	
						 <div class="row  ">
								<div  class="large-12 columns ">
									<p class="grey">There are no Followers</p>
								</div>
						</div>
						<?php }?>		
					
						
				</div>	
			</div>
		</div>
	</div>
</div>