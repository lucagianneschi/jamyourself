<?php
/* box le activity
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId},
 * data-type: html,
 * type: POST o GET
 *
 * box solo per jammer
 */

$data = $_POST['data'];
$typeUser = $_POST['typeUser'];
$recordCounter = $data['recordCounter'];

$titleLastALbum =  $typeUser == 'JAMMER' ? 'Last album updated' : 'Last listening';

//$event_eventDate_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['eventInfo']['eventDate']);
//$event_eventDate = $event_eventDate_DateTime->format('l j F - H:i');

?>
<!------------------------------------- Activities ------------------------------------>
	<div class="row" id="activities">
		<div  class="large-12 columns">
		<h3>Activities</h3>
		<div class="row  ">
			<div  class="large-12 columns ">
				<div class="box">
					<?php if($typeUser != 'VENUE'){ 
						if(isset($data['recordInfo']['objectId']) && $data['recordInfo']['objectId'] != ''){
						?>
					
					<div class="row " id="activity_<?php $data['recordInfo']['objectId']?>">
						<div  class="large-12 columns ">
							<div class="text orange"><?php echo $titleLastALbum?></div>
							<div class="row ">
								<div  class="small-3 columns ">
									<img class="album-thumb" src="../media/<?php echo $data['recordInfo']['thumbnailCover']?>" onerror="this.src='../media/images/default/defaultRecordCoverThumb.jpg'">
								</div>
								<div  class="small-9 columns box-info">
									<div class="sottotitle grey-dark"><?php echo $data['recordInfo']['songTitle']?></div>
									<div class="text grey"><?php echo $data['recordInfo']['title']?></div>
									<a class="ico-label _play-large text ">View Album</a>									
								</div>	
							</div>
						</div>	
					</div>
					<div class="row">
						<div  class="large-12 columns"><div class="line"></div></div>
					</div>
					<?php }} 
					if(isset($data['eventInfo']['objectId']) && $data['eventInfo']['objectId'] != ''){
					?>
					<div class="row">
						<div  class="large-12 columns ">
							<div class="text orange">Last Event</div>
							<div class="row ">
								<div  class="small-3 columns ">
									<img class="album-thumb" src="../media/<?php echo $data['eventInfo']['thumbnail']?>" onerror="this.src='../media/images/default/defaultAlbumcoverthumb.jpg'">
								</div>
								<div  class="small-9 columns box-info">
									<div class="sottotitle grey-dark"><?php echo $data['eventInfo']['title']?></div>
									<div class="text grey"><?php echo $data['eventInfo']['address']?></div>
									<a class="ico-label _calendar inline text grey"><?php echo $data['eventInfo']['eventDate']; ?></a>								
								</div>	
							</div>
						</div>	
					</div>
					<div class="row">
						<div  class="large-12 columns"><div class="line"></div></div>
					</div>
					<?php } 
					if(isset($data['albumInfo']['objectId']) && $data['albumInfo']['objectId'] != ''){
					?>
					<div class="row  ">
						<div  class="large-12 columns ">
							<div class="text orange">Last photo set updated</div>
							<div class="row ">
								<div  class="small-12 columns ">
									<span class="text grey-dark"><?php echo $data['albumInfo']['tile'];?></span>
									<span class="text grey">- <?php echo $data['albumInfo']['imageCounter'];?> photos </span>							
								</div>
							</div>
							<ul class="small-block-grid-4">
								<?php for($i=0;$i<$data['albumInfo']['imageCounter']; $i++){ ?>
							  <li><img src="../media/<?php ?>"></li>
							  <?php } ?>
							</ul>
						</div>								
					</div>
					<div class="row">
						<div  class="large-12 columns"><div class="line"></div></div>
					</div>
					<?php } 
					if(isset($data['relation'])){
					?>
					<div class="row ">
						<div  class="large-12 columns ">
							<div class="text orange">Last collaboration</div>
							<div class="row">
								<div  class="small-6 columns">
									<div class="box-membre">
			    						<div class="row ">
											<div  class="small-3 columns ">
												<div class="icon-header">
													<img src="../media/">
												</div>
											</div>
											<div  class="small-9 columns ">
												<div class="text grey-dark">Member name</div>
												<div class="note grey">Jammer</div>
											</div>		
										</div>	
			    					</div>
								</div>
								<div  class="small-6 columns ">
									<div class="box-membre">
			    						<div class="row ">
											<div  class="small-3 columns ">
												<div class="icon-header">
													<img src="../media/images/profilepicturethumb/photo1.jpg">
												</div>
											</div>
											<div  class="small-9 columns ">
												<div class="text grey-dark">Member name</div>
												<div class="note grey">Jammer</div>
											</div>		
										</div>	
			    					</div>
								</div>
							</div>					
						</div>								
					</div>	
					<?php } ?>				
				</div>
				
				
			</div>	
		</div>
		</div>	
	</div>