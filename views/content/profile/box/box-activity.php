﻿<?php
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
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
 
$data = $_POST['data'];
$typeUser = $_POST['typeUser'];

$recordCounter = $data['recordCounter'];

$dataActivityRecord = $_POST['dataActivity']['record'];
$dataActivityEvent = $_POST['dataActivity']['event'];
$dataActivityRelation = $_POST['dataActivity']['relation'];

$titleLastALbum =  $typeUser == 'JAMMER' ? 'Last album updated' : 'Last listening';

$location = '';

if(isset($dataActivityEvent['objectId']) && $dataActivityEvent['objectId'] != ''){
	if($typeUser == 'JAMMER') 
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
					if ($typeUser == 'JAMMER') {
						?>	
						<div class="row box-singleActivity">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['LASTALBUM'];?></div>
								<?php
								if (isset($dataActivityRecord['objectId']) && $dataActivityRecord['objectId'] != '') {
									?>	
									<div class="row " id="activity_<?php $dataActivityRecord['objectId']?>">								
										<div  class="small-3 columns ">
											<img class="album-thumb" src="../media/<?php echo $dataActivityRecord['thumbnailCover']?>" onerror="this.src='../media/<?php echo $default_img['DEFRECORDTHUMB']; ?>'">
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
					if ($typeUser != 'SPOTTER') {
						?>
						<div class="row box-singleActivity">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['LASTEVENT'];?></div>
								<?php
								if (isset($dataActivityEvent['objectId']) && $dataActivityEvent['objectId'] != '') {
									?>
									<div class="row " id="activity_<?php $dataActivityEvent['objectId']?>">
										<div  class="small-3 columns ">
											<img class="album-thumb" src="../media/<?php echo $dataActivityEvent['thumbnail']?>" onerror="this.src='../media/<?php echo $default_img['DEFEVENTTHUMB']; ?>'">
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
					if ($typeUser == 'SPOTTER') {
						?>
						<div class="row box-singleActivity">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['LASTLISTERING'];?></div>
								<?php
								if (isset($data['recordInfo']['objectId']) && $data['recordInfo']['objectId'] != '') {
									?>
									<div class="row " id="activity_<?php $data['recordInfo']['objectId']?>">								
										<div  class="small-3 columns ">
											<img class="album-thumb" src="../media/<?php echo $data['recordInfo']['thumbnailCover']?>" onerror="this.src='../media/<?php echo $default_img['DEFRECORDTHUMB']; ?>'">
										</div>
										<div  class="small-9 columns box-info">
											<div class="sottotitle grey-dark"><?php echo $data['recordInfo']['title']?></div>
											<div class="text grey"><?php echo $views['activity']['RECORDED'];?> <?php echo $data['recordInfo']['songTitle']?></div>
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
						<!--------------------------------------- event ---------------------------------------->
						<div class="row box-singleActivity">
							<div  class="large-12 columns ">
								<div class="text orange"><?php echo $views['activity']['ATTEVENT'];?></div>
								<?php
								if (isset($data['eventInfo']['objectId']) && $data['eventInfo']['objectId'] != '') {
									?>
									<div class="row " id="activity_<?php $data['eventInfo']['objectId']?>">
										<div  class="small-3 columns ">
											<img class="album-thumb" src="../media/<?php echo $data['eventInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo $default_img['DEFEVENTTHUMB']; ?>'">
										</div>
										<div  class="small-9 columns box-info">
											<div class="sottotitle grey-dark"><?php echo $data['eventInfo']['title']?></div>
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
					}
					?>
					<!--------------------------------- LAST PHOTO --------------------->					
					<div class="row  ">
						<div  class="large-12 columns ">
							<div class="text orange"><?php echo $views['activity']['LASTPHOTO'];?></div>
							<?php
							if (isset($data['albumInfo']['objectId']) && $data['albumInfo']['objectId'] != '') {
								?>
								<div class="row " style="margin-bottom: 10px;">
									<div  class="small-12 columns ">
										<span class="text grey-dark" style="cursor:pointer"><?php echo $data['albumInfo']['title'];?></span>
										<span class="text grey"> - <?php echo $data['albumInfo']['imageCounter'];?> <?php echo $views['activity']['PHOTOS'];?> </span>							
									</div>
								</div>
								<div class="row ">
									<div  class="small-12 columns ">
										<ul class="small-block-grid-4">
											<?php 
											$counterPhoto = $data['albumInfo']['imageCounter'] > 4 ? 4 : $data['albumInfo']['imageCounter'];
											for($i=0;$i<$counterPhoto; $i++){ ?>
												<li><img src="../media/<?php echo $data['albumInfo']['imageArray'][$i]?>" onerror="this.src='../media/<?php echo $default_img['DEFIMAGE']; ?>'"></li>
											<?php } ?>
										</ul>
									</div>
								</div>
								<?php
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
					if ($typeUser != 'SPOTTER') {
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
																<img src="../media/<?php echo $dataActivityRelation['jammersCollaborators'.'0']['thumbnail'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
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
																<img src="../media/<?php echo $dataActivityRelation['jammersCollaborators'.'1']['thumbnail'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
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
																<img src="../media/<?php echo $dataActivityRelation['venuesCollaborators'.'0']['thumbnail'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
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
																<img src="../media/<?php echo $dataActivityRelation['venuesCollaborators'.'1']['thumbnail'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
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
					if ($typeUser == 'SPOTTER') {
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
																<img src="../media/<?php echo $dataActivityRelation['friendship'.'0']['thumbnail'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
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
																<img src="../media/<?php echo $dataActivityRelation['friendship'.'1']['thumbnail'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
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
																<img src="../media/<?php echo $dataActivityRelation['following'.'0']['thumbnail'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
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
																<img src="../media/<?php echo $dataActivityRelation['following'.'1']['thumbnail'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
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