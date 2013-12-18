<?php
/* box le activity
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId},
 * data-type: html,
 * type: POST o GET
 *
 * box solo per jammer
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
require_once BOXES_DIR . 'activity.box.php';

$type = $_POST['type'];

$activityRecordBox = ActivityRecordBox();
$activityRecordBox->init($_POST['objectId']);
if (is_null($activityRecordBox->error)) {
	$activitiesRecord = $activityRecordBox->recordArray;
}

$activityAlbumBox = ActivityAlbumBox();
$activityAlbumBox->init($_POST['objectId']);
if (is_null($activityAlbumBox->error)) {
	$albums = $activityAlbumBox->albumArray;
}

$activityEventBox = ActivityEventBox();
$activityEventBox->init($_POST['objectId']);
if (is_null($activityEventBox->error)) {
	$activitiesEvent = $activityEventBox->eventArray;
}

$data = $_POST['data'];
//$typeUser = $_POST['typeUser'];

$recordCounter = $data['recordCounter'];

$dataActivityRecord = $_POST['dataActivity']['record'];
$dataActivityEvent = $_POST['dataActivity']['event'];
$dataActivityRelation = $_POST['dataActivity']['relation'];

$titleLastALbum =  $type == 'JAMMER' ? 'Last album updated' : 'Last listening';

$location = '';

if(isset($dataActivityEvent['objectId']) && $dataActivityEvent['objectId'] != ''){
	if($type == 'JAMMER') 
		$location =  $dataActivityEvent['locationName'].' ';
	
	if(isset($dataActivityEvent['city']) && $dataActivityEvent['city'] != '')
		$location = $location.$dataActivityEvent['city']. ' ';
	
	if(isset($dataActivityEvent['address']) && $dataActivityEvent['address'] != '')
		$location = $location.$dataActivityEvent['address']. ' ';
	
	$event_eventDate_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $dataActivityEvent['eventDate']);
	$event_eventDate = $event_eventDate_DateTime->format('l j F - H:i');
}

if(isset($data['eventInfo']['objectId']) && $data['eventInfo']['objectId'] != ''){
	if(isset($data['eventInfo']['city']) && $data['eventInfo']['city'] != '')
		$location = $location.$data['eventInfo']['city']. ' ';
	
	if(isset($data['eventInfo']['address']) && $data['eventInfo']['address'] != '')
		$location = $location.$data['eventInfo']['address']. ' ';
	
	$event_eventDate_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['eventInfo']['eventDate']);
	$event_eventDate = $event_eventDate_DateTime->format('l j F - H:i');
}
?>
<!------------------------------------- Activities ------------------------------------>
	<div class="row" id="social-activity">
		<div  class="large-12 columns">
		<h3><?php echo $views['activity']['TITLE'];?></h3>
		<div class="row  ">
			<div  class="large-12 columns ">
				<div class="box">
					<!------------------------- LAST RECORD -------------------------------->									
					<?php
					if ($type == 'JAMMER') {
						?>	
						<div class="row box-singleActivity">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['LASTALBUM'];?></div>
								<?php
								if (isset($dataActivityRecord['objectId']) && $dataActivityRecord['objectId'] != '') {
									?>	
									<div class="row " id="activity_<?php $dataActivityRecord['objectId']?>">								
										<div  class="small-3 columns ">
											<img class="album-thumb" src="../media/<?php echo $dataActivityRecord['thumbnailCover']?>" onerror="this.src='../media/<?php echo DEFRECORDTHUMB; ?>'">
										</div>
										<div  class="small-9 columns box-info">
											<div class="sottotitle grey-dark"><?php echo $dataActivityRecord['title']?></div>
											<div class="text grey"><?php echo $views['activity']['RECORDED'];?> <?php echo $dataActivityRecord['year']?></div>
											<a class="ico-label _play-large text "><?php echo $views['activity']['VIEWALBUM'];?></a>									
										</div>									
									</div>
									<?php
								} else {
									?>
									<div class="row">
										<div  class="small-12 columns ">
											<div class="text grey-dark"><?php echo $views['activity']['NORECORD'];?></div>	
										</div>	
									</div>						
									<?php
								}
								?>
							</div>	
						</div>
						<div class="row">
							<div  class="large-12 columns"><div class="line"></div></div>
						</div>
						<?php
					}
					?>
					<!-------------------------- LAST EVENT --------------------------------------------->						
					<?php
					if ($type != 'SPOTTER') {
						?>
						<div class="row box-singleActivity">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['LASTEVENT'];?></div>
								<?php
								if (isset($dataActivityEvent['objectId']) && $dataActivityEvent['objectId'] != '') {
									?>
									<div class="row " id="activity_<?php $dataActivityEvent['objectId']?>">
										<div  class="small-3 columns ">
											<img class="album-thumb" src="../media/<?php echo $dataActivityEvent['thumbnail']?>" onerror="this.src='../media/<?php echo DEFEVENTTHUMB; ?>'">
										</div>
										<div  class="small-9 columns box-info">
											<div class="sottotitle grey-dark"><?php echo $dataActivityEvent['title']?></div>
											<div class="text grey"><?php echo $location ?></div>
											<a class="ico-label _calendar inline text grey"><?php echo $event_eventDate; ?></a>								
										</div>	
									</div>
									<?php
								} else {
									?>
									<div class="row">
										<div  class="small-12 columns ">
											<div class="text grey-dark"><?php echo $views['activity']['NOEVENT'];?></div>	
										</div>	
									</div>		
									<?php
								}
								?>
							</div>
						</div>
						<div class="row">
							<div  class="large-12 columns"><div class="line"></div></div>
						</div>
						<?php
					} ?>
					<!------------------ BOX SPOTTER LAST LISTERING AND ATTENGING EVENT ------------>
					<?php
					if ($type == 'SPOTTER') {
						?>
						<div class="row box-singleActivity">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['LASTLISTERING'];?></div>
								<?php
								if (count($activitiesRecord) > 0) {
									foreach($activitiesRecord as $key => $value) {
										?>
										<div class="row " id="activity_<?php $value->getObjectId(); ?>">								
											<div  class="small-3 columns ">
												<img class="album-thumb" src="../media/<?php echo $value->getRecord()->getThumbnailCover(); ?>" onerror="this.src='../media/<?php echo DEFRECORDTHUMB; ?>'">
											</div>
											<div  class="small-9 columns box-info">
												<div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
												<div class="text grey"><?php echo $views['activity']['RECORDED'];?> <?php echo $value->getSong()->getTitle(); ?></div>
												<a class="ico-label _play-large text "><?php echo $views['activity']['VIEWALBUM'];?></a>			
											</div>									
										</div>
										<?php
									}
								} else {
									?>
									<div class="row">
										<div  class="small-12 columns ">
											<div class="text grey-dark"><?php echo $views['activity']['NORECORD'];?></div>	
										</div>	
									</div>						
									<?php
								}
								?>
							</div>	
						</div>
						<div class="row">
							<div  class="large-12 columns"><div class="line"></div></div>
						</div>
						<!--------------------------------------- event ---------------------------------------->
						<div class="row box-singleActivity">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['ATTEVENT'];?></div>
								<?php
								if (count($activitiesEvent) > 0) {
									foreach($activitiesEvent as $key => $value) {
										?>
										<div class="row " id="activity_<?php $value->getObjectId(); ?>">
											<div  class="small-3 columns ">
												<img class="album-thumb" src="../media/<?php echo $value->getEvent()->getThumbnail(); ?>" onerror="this.src='../media/<?php echo DEFEVENTTHUMB; ?>'">
											</div>
											<div  class="small-9 columns box-info">
												<div class="sottotitle grey-dark"><?php echo $value->getEvent()->getTitle(); ?></div>
												<div class="text grey"><?php echo $value->getEvent()->getCity() . ' ' . $value->getEvent()->getAddress(); ?></div>
												<a class="ico-label _calendar inline text grey"><?php echo $value->getEvent()->getEventDate()->format('l j F - H:i') ?></a>								
											</div>	
										</div>
										<?php
									}
								} else {
									?>
									<div class="row">
										<div  class="small-12 columns ">
											<div class="text grey-dark"><?php echo $views['activity']['NOEVENT'];?></div>	
										</div>	
									</div>		
									<?php
								}
								?>
							</div>	
						</div>
						<div class="row">
							<div  class="large-12 columns"><div class="line"></div></div>
						</div>
						<?php
					}
					?>
					<!--------------------------------- LAST PHOTO --------------------->					
					<div class="row  ">
						<div  class="large-12 columns ">
							<div class="text orange"><?php echo $views['activity']['LASTPHOTO'];?></div>
							<?php
							if (count($albums) > 0) {
								foreach ($albums as $key => $value) {
									?>
									<div class="row " style="margin-bottom: 10px;">
										<div  class="small-12 columns ">
											<span class="text grey-dark" style="cursor:pointer"><?php echo $value->getTitle(); ?></span>
											<span class="text grey"> - <?php echo $value->getImageCounter(); ?> <?php echo $views['activity']['PHOTOS'];?> </span>
										</div>
									</div>
									<div class="row ">
										<div  class="small-12 columns ">
											<ul class="small-block-grid-4">
												<?php 
												#TODO
												//questa è una relazione, quindi la devo includere con una whereRelatedTo
												/*
												$counterPhoto = $value->getImageCounter() > 4 ? 4 : $value->getImageCounter();
												for ($i = 1; $i < $counterPhoto; $i++) {
													?>
													<li><img src="../media/<?php echo $data['albumInfo']['imageArray'][$i]?>" onerror="this.src='../media/<?php echo DEFIMAGE; ?>'"></li>
													<?php
												}
												*/
												?>
											</ul>
										</div>
									</div>
									<?php
								}
							} else {
								?>
								<div class="row">
									<div  class="small-12 columns ">
										<div class="text grey-dark"><?php echo $views['activity']['NOPHOTO'];?></div>	
									</div>	
								</div>		
								<?php
							}
							?>
						</div>								
					</div>
					<div class="row">
						<div  class="large-12 columns"><div class="line"></div></div>
					</div>
					<!------------------------------ RELATION - COLLABORATION -------------------------------->
					<?php 
					if ($type != 'SPOTTER') {
						?>
						<!-------------------------- jammersCollaborators ------------------------->
						<div class="row ">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['LASTJAMMER'];?></div>
								<?php
								if (isset($dataActivityRelation['jammersCollaborators'.'0']) && $dataActivityRelation['jammersCollaborators'.'0'] != NULL) {
									?>
									<div class="row">
										<?php
										if (isset($dataActivityRelation['jammersCollaborators'.'0']['objectId']) && isset($dataActivityRelation['jammersCollaborators'.'0']['objectId']) != '' ) {
											?>
											<div  class="small-6 columns">
												<div class="box-membre" id='jammersCollaborators_<?php echo $dataActivityRelation['jammersCollaborators'.'0']['objectId'] ?>'>
													<div class="row ">
														<div  class="small-3 columns ">
															<div class="icon-header">
																<img src="../media/<?php echo $dataActivityRelation['jammersCollaborators'.'0']['thumbnail'] ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
															</div>
														</div>
														<div  class="small-9 columns ">
															<div class="text grey-dark breakOffTest"><?php echo $dataActivityRelation['jammersCollaborators'.'0']['username'] ?></div>
															
														</div>		
													</div>	
												</div>
											</div>
											<?php
										}
										if (isset($dataActivityRelation['jammersCollaborators'.'1']['objectId']) && isset($dataActivityRelation['jammersCollaborators'.'1']['objectId']) != '' ) {
											?>
											<div  class="small-6 columns">
												<div class="box-membre" id='jammersCollaborators_<?php echo $dataActivityRelation['jammersCollaborators'.'1']['objectId'] ?>'>
													<div class="row ">
														<div  class="small-3 columns ">
															<div class="icon-header">
																<img src="../media/<?php echo $dataActivityRelation['jammersCollaborators'.'1']['thumbnail'] ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
															</div>
														</div>
														<div  class="small-9 columns ">
															<div class="text grey-dark breakOffTest"><?php echo $dataActivityRelation['jammersCollaborators'.'1']['username'] ?></div>
															
														</div>		
													</div>	
												</div>
											</div>
											<?php
										}
										?>
									</div>	
									<?php
								} else {
									?>
									<div class="row">
										<div  class="small-12 columns ">
											<div class="text grey-dark"><?php echo $views['activity']['NOCOLL'];?></div>	
										</div>	
									</div>		
									<?php
								}
								?>
							</div>								
						</div>
						<!-------------------------- venuesCollaborators ------------------------->
						<div class="row ">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['LASTVENUE'];?></div>
								<?php
								if (isset($dataActivityRelation['venuesCollaborators'.'0']) && $dataActivityRelation['venuesCollaborators'.'0'] != NULL) {
									?>
									<div class="row">
										<?php
										if (isset($dataActivityRelation['venuesCollaborators'.'0']['objectId']) && isset($dataActivityRelation['venuesCollaborators'.'0']['objectId']) != '' ) {
											?>
											<div  class="small-6 columns">
												<div class="box-membre" id='venuesCollaborators_<?php echo $dataActivityRelation['venuesCollaborators'.'0']['objectId'] ?>'>
													<div class="row ">
														<div  class="small-3 columns ">
															<div class="icon-header">
																<img src="../media/<?php echo $dataActivityRelation['venuesCollaborators'.'0']['thumbnail'] ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
															</div>
														</div>
														<div  class="small-9 columns ">
															<div class="text grey-dark"><?php echo $dataActivityRelation['venuesCollaborators'.'0']['username'] ?></div>
															
														</div>		
													</div>	
												</div>
											</div>
											<?php
										}
										if (isset($dataActivityRelation['venuesCollaborators'.'1']['objectId']) && isset($dataActivityRelation['venuesCollaborators'.'1']['objectId']) != '' ) {
											?>
											<div  class="small-6 columns">
												<div class="box-membre" id='venuesCollaborators_<?php echo $dataActivityRelation['venuesCollaborators'.'1']['objectId'] ?>'>
													<div class="row ">
														<div  class="small-3 columns ">
															<div class="icon-header">
																<img src="../media/<?php echo $dataActivityRelation['venuesCollaborators'.'1']['thumbnail'] ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
															</div>
														</div>
														<div  class="small-9 columns ">
															<div class="text grey-dark"><?php echo $dataActivityRelation['venuesCollaborators'.'1']['username'] ?></div>
															
														</div>		
													</div>	
												</div>
											</div>
											<?php
										}
										?>
									</div>
									<?php
								} else {
									?>
									<div class="row">
										<div  class="small-12 columns ">
											<div class="text grey-dark"><?php echo $views['activity']['NOCOLL'];?></div>	
										</div>	
									</div>		
									<?php
								}
								?>
							</div>								
						</div>	
						<?php
					}  
					if ($type == 'SPOTTER') {
						?>
						<!-------------------------- friendship ------------------------->
						<div class="row ">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['LASTFRIENDS'];?></div>
								<?php
								if (isset($dataActivityRelation['friendship'.'0']) && $dataActivityRelation['friendship'.'0'] != NULL) {
									?>
									<div class="row">
										<?php
										if (isset($dataActivityRelation['friendship'.'0']['objectId']) && isset($dataActivityRelation['friendship'.'0']['objectId']) != '' ) {
											?>
											<div  class="small-6 columns">
												<div class="box-membre" id='friendship_<?php echo $dataActivityRelation['friendship'.'0']['objectId'] ?>'>
													<div class="row ">
														<div  class="small-3 columns ">
															<div class="icon-header">
																<img src="../media/<?php echo $dataActivityRelation['friendship'.'0']['thumbnail'] ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
															</div>
														</div>
														<div  class="small-9 columns ">
															<div class="text grey-dark"><?php echo $dataActivityRelation['friendship'.'0']['username'] ?></div>
														</div>		
													</div>	
												</div>
											</div>
											<?php
										}
										if (isset($dataActivityRelation['friendship'.'1']['objectId']) && isset($dataActivityRelation['friendship'.'1']['objectId']) != '' ) {
											?>
											<div  class="small-6 columns">
												<div class="box-membre" id='friendship_<?php echo $dataActivityRelation['friendship'.'1']['objectId'] ?>'>
													<div class="row ">
														<div  class="small-3 columns ">
															<div class="icon-header">
																<img src="../media/<?php echo $dataActivityRelation['friendship'.'1']['thumbnail'] ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
															</div>
														</div>
														<div  class="small-9 columns ">
															<div class="text grey-dark"><?php echo $dataActivityRelation['friendship'.'1']['username'] ?></div>
														</div>		
													</div>	
												</div>
											</div>
											<?php
										}
										?>
									</div>
									<?php
								} else {
									?>
									<div class="row">
										<div  class="small-12 columns ">
											<div class="text grey-dark"><?php echo $views['activity']['NOFRIENDS'];?></div>	
										</div>	
									</div>		
									<?php
								}
								?>
							</div>								
						</div>
						<!-------------------------- following ------------------------->
						<div class="row ">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['NOFOLL'];?></div>
								<?php
								if (isset($dataActivityRelation['following'.'0']) && $dataActivityRelation['following'.'0'] != NULL) {
									?>
									<div class="row">
										<?php
										if (isset($dataActivityRelation['following'.'0']['objectId']) && isset($dataActivityRelation['following'.'0']['objectId']) != '' ) {
											?>
											<div  class="small-6 columns">
												<div class="box-membre" id='following_<?php echo $dataActivityRelation['following'.'0']['objectId'] ?>'>
													<div class="row ">
														<div  class="small-3 columns ">
															<div class="icon-header">
																<img src="../media/<?php echo $dataActivityRelation['following'.'0']['thumbnail'] ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
															</div>
														</div>
														<div  class="small-9 columns ">
															<div class="text grey-dark"><?php echo $dataActivityRelation['following'.'0']['username'] ?></div>
															<div class="note grey"><?php echo $dataActivityRelation['following'.'0']['type'] ?></div>
														</div>		
													</div>	
												</div>
											</div>
											<?php
										}
										if (isset($dataActivityRelation['following'.'1']['objectId']) && isset($dataActivityRelation['following'.'1']['objectId']) != '' ) {
											?>
											<div  class="small-6 columns">
												<div class="box-membre" id='following_<?php echo $dataActivityRelation['following'.'1']['objectId'] ?>'>
													<div class="row ">
														<div  class="small-3 columns ">
															<div class="icon-header">
																<img src="../media/<?php echo $dataActivityRelation['following'.'1']['thumbnail'] ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
															</div>
														</div>
														<div  class="small-9 columns ">
															<div class="text grey-dark"><?php echo $dataActivityRelation['following'.'1']['username'] ?></div>
															<div class="note grey"><?php echo $dataActivityRelation['following'.'0']['type'] ?></div>
														</div>		
													</div>	
												</div>
											</div>
											<?php
										}
										?>
									</div>
									<?php
								} else {
									?>
									<div class="row">
										<div  class="small-12 columns ">
											<div class="text grey-dark"><?php echo $views['activity']['NOFOLL'];?></div>	
										</div>	
									</div>		
									<?php
								}
								?>
							</div>								
						</div>	
						<?php
					}
					?>			
				</div>
			</div>	
		</div>
		</div>	
	</div>