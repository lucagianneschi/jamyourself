<?php
/* box le activity
 * box chiamato tramite ajax con:
 * data: {currentUser: id},
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
$activityRecordBox->init($_POST['id']);
if (is_null($activityRecordBox->error)) {
    $activitiesRecord = $activityRecordBox->recordArray;
}

$activityAlbumBox = ActivityAlbumBox();
$activityAlbumBox->init($_POST['id']);
if (is_null($activityAlbumBox->error)) {
    $albums = $activityAlbumBox->albumArray;
}

$activityEventBox = ActivityEventBox();
$activityEventBox->init($_POST['id']);
if (is_null($activityEventBox->error)) {
    $activitiesEvent = $activityEventBox->eventArray;
}

$data = $_POST['data'];
//$typeUser = $_POST['typeUser'];

$recordCounter = $data['recordCounter'];

$dataActivityRecord = $_POST['dataActivity']['record'];
$dataActivityEvent = $_POST['dataActivity']['event'];
$dataActivityRelation = $_POST['dataActivity']['relation'];

$titleLastALbum = $type == 'JAMMER' ? 'Last album updated' : 'Last listening';

$location = '';

if (isset($dataActivityEvent['id']) && $dataActivityEvent['id'] != '') {
    if ($type == 'JAMMER')
	$location = $dataActivityEvent['locationName'] . ' ';

    if (isset($dataActivityEvent['city']) && $dataActivityEvent['city'] != '')
	$location = $location . $dataActivityEvent['city'] . ' ';

    if (isset($dataActivityEvent['address']) && $dataActivityEvent['address'] != '')
	$location = $location . $dataActivityEvent['address'] . ' ';

    $event_eventDate_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $dataActivityEvent['eventDate']);
    $event_eventDate = $event_eventDate_DateTime->format('l j F - H:i');
}

if (isset($data['eventInfo']['id']) && $data['eventInfo']['id'] != '') {
    if (isset($data['eventInfo']['city']) && $data['eventInfo']['city'] != '')
	$location = $location . $data['eventInfo']['city'] . ' ';

    if (isset($data['eventInfo']['address']) && $data['eventInfo']['address'] != '')
	$location = $location . $data['eventInfo']['address'] . ' ';

    $event_eventDate_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['eventInfo']['eventDate']);
    $event_eventDate = $event_eventDate_DateTime->format('l j F - H:i');
}
?>
<!------------------------------------- Activities ------------------------------------>
<div class="row" id="social-activity">
    <div  class="large-12 columns">
	<h3><?php echo $views['activity']['title']; ?></h3>
	<div class="row  ">
	    <div  class="large-12 columns ">
		<div class="box">
		    <!------------------------- LAST RECORD -------------------------------->									
		    <?php
		    if ($type == 'JAMMER') {
			?>	
    		    <div class="row box-singleActivity">
    			<div  class="large-12 columns ">
    			    <div class="text orange"><?php echo $views['activity']['lastalbum']; ?></div>
				<?php
				if (isset($dataActivityRecord['id']) && $dataActivityRecord['id'] != '') {
				    ?>	
				    <div class="row " id="activity_<?php $dataActivityRecord['id'] ?>">								
					<div  class="small-3 columns ">
					    <img class="album-thumb" src="../media/<?php echo $dataActivityRecord['thumbnailCover'] ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'">
					</div>
					<div  class="small-9 columns box-info">
					    <div class="sottotitle grey-dark"><?php echo $dataActivityRecord['title'] ?></div>
					    <div class="text grey"><?php echo $views['activity']['recorded']; ?> <?php echo $dataActivityRecord['year'] ?></div>
					    <a class="ico-label _play-large text "><?php echo $views['activity']['viewalbum']; ?></a>									
					</div>									
				    </div>
				    <?php
				} else {
				    ?>
				    <div class="row">
					<div  class="small-12 columns ">
					    <div class="text grey-dark"><?php echo $views['activity']['norecord']; ?></div>	
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
    			    <div class="text orange"><?php echo $views['activity']['lastevent']; ?></div>
				<?php
				if (isset($dataActivityEvent['id']) && $dataActivityEvent['id'] != '') {
				    ?>
				    <div class="row " id="activity_<?php $dataActivityEvent['id'] ?>">
					<div  class="small-3 columns ">
					    <img class="album-thumb" src="../media/<?php echo $dataActivityEvent['thumbnail'] ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'">
					</div>
					<div  class="small-9 columns box-info">
					    <div class="sottotitle grey-dark"><?php echo $dataActivityEvent['title'] ?></div>
					    <div class="text grey"><?php echo $location ?></div>
					    <a class="ico-label _calendar inline text grey"><?php echo $event_eventDate; ?></a>								
					</div>	
				    </div>
				    <?php
				} else {
				    ?>
				    <div class="row">
					<div  class="small-12 columns ">
					    <div class="text grey-dark"><?php echo $views['activity']['noevent']; ?></div>	
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
		    <?php }
		    ?>
		    <!------------------ BOX SPOTTER LAST LISTERING AND ATTENGING EVENT ------------>
		    <?php
		    if ($type == 'SPOTTER') {
			?>
    		    <div class="row box-singleActivity">
    			<div  class="large-12 columns ">
    			    <div class="text orange"><?php echo $views['activity']['lastlistening']; ?></div>
				<?php
				if (count($activitiesRecord) > 0) {
				    foreach ($activitiesRecord as $key => $value) {
					?>
	    			    <div class="row " id="activity_<?php $value->getId(); ?>">								
	    				<div  class="small-3 columns ">
	    				    <img class="album-thumb" src="../media/<?php echo $value->getRecord()->getThumbnail(); ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'">
	    				</div>
	    				<div  class="small-9 columns box-info">
	    				    <div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
	    				    <div class="text grey"><?php echo $views['activity']['recorded']; ?> <?php echo $value->getSong()->getTitle(); ?></div>
	    				    <a class="ico-label _play-large text "><?php echo $views['activity']['viewalbum']; ?></a>			
	    				</div>									
	    			    </div>
					<?php
				    }
				} else {
				    ?>
				    <div class="row">
					<div  class="small-12 columns ">
					    <div class="text grey-dark"><?php echo $views['activity']['norecord']; ?></div>	
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
    			    <div class="text orange"><?php echo $views['activity']['attevent']; ?></div>
				<?php
				if (count($activitiesEvent) > 0) {
				    foreach ($activitiesEvent as $key => $value) {
					?>
	    			    <div class="row " id="activity_<?php $value->getId(); ?>">
	    				<div  class="small-3 columns ">
	    				    <img class="album-thumb" src="../media/<?php echo $value->getEvent()->getThumbnail(); ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'">
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
					    <div class="text grey-dark"><?php echo $views['activity']['noevent']; ?></div>	
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
			    <div class="text orange"><?php echo $views['activity']['lastphoto']; ?></div>
			    <?php
			    if (count($albums) > 0) {
				foreach ($albums as $key => $value) {
				    ?>
				    <div class="row " style="margin-bottom: 10px;">
					<div  class="small-12 columns ">
					    <span class="text grey-dark" style="cursor:pointer"><?php echo $value->getTitle(); ?></span>
					    <span class="text grey"> - <?php echo $value->getImagecounter(); ?> <?php echo $views['activity']['photos']; ?> </span>
					</div>
				    </div>
				    <div class="row ">
					<div  class="small-12 columns ">
					    <ul class="small-block-grid-4">
						<?php
						#TODO
						//questa è una relazione, quindi la devo includere con una whereRelatedTo
						/*
						  $counterPhoto = $value->getImagecounter() > 4 ? 4 : $value->getImagecounter();
						  for ($i = 1; $i < $counterPhoto; $i++) {
						  ?>
						  <li><img src="../media/<?php echo $data['albumInfo']['imageArray'][$i]?>" onerror="this.src='<?php echo DEFIMAGE; ?>'"></li>
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
    				    <div class="text grey-dark"><?php echo $views['activity']['nophoto']; ?></div>	
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
    			    <div class="text orange"><?php echo $views['activity']['lastjammer']; ?></div>
				<?php
				if (isset($dataActivityRelation['jammersCollaborators' . '0']) && $dataActivityRelation['jammersCollaborators' . '0'] != NULL) {
				    ?>
				    <div class="row">
					<?php
					if (isset($dataActivityRelation['jammersCollaborators' . '0']['id']) && isset($dataActivityRelation['jammersCollaborators' . '0']['id']) != '') {
					    switch ($dataActivityRelation['jammersCollaborators' . '0']['type']) {
						case 'JAMMER':
						    $defaultThum = DEFTHUMBJAMMER;
						    break;
						case 'VENUE':
						    $defaultThum = DEFTHUMBVENUE;
						    break;
						case 'SPOTTER':
						    $defaultThum = DEFTHUMBSPOTTER;
						    break;
					    }
					    ?>
	    				<div  class="small-6 columns">
	    				    <div class="box-membre" id='jammersCollaborators_<?php echo $dataActivityRelation['jammersCollaborators' . '0']['id'] ?>'>
	    					<div class="row ">
	    					    <div  class="small-3 columns ">
	    						<div class="icon-header">
	    						    <img src="../media/<?php echo $dataActivityRelation['jammersCollaborators' . '0']['thumbnail'] ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
	    						</div>
	    					    </div>
	    					    <div  class="small-9 columns ">
	    						<div class="text grey-dark breakOffTest"><?php echo $dataActivityRelation['jammersCollaborators' . '0']['username'] ?></div>

	    					    </div>		
	    					</div>	
	    				    </div>
	    				</div>
					    <?php
					}
					if (isset($dataActivityRelation['jammersCollaborators' . '1']['id']) && isset($dataActivityRelation['jammersCollaborators' . '1']['id']) != '') {
					    switch ($dataActivityRelation['jammersCollaborators' . '1']['type']) {
						case 'JAMMER':
						    $defaultThum = DEFTHUMBJAMMER;
						    break;
						case 'VENUE':
						    $defaultThum = DEFTHUMBVENUE;
						    break;
						case 'SPOTTER':
						    $defaultThum = DEFTHUMBSPOTTER;
						    break;
					    }
					    ?>
	    				<div  class="small-6 columns">
	    				    <div class="box-membre" id='jammersCollaborators_<?php echo $dataActivityRelation['jammersCollaborators' . '1']['id'] ?>'>
	    					<div class="row ">
	    					    <div  class="small-3 columns ">
	    						<div class="icon-header">
	    						    <img src="../media/<?php echo $dataActivityRelation['jammersCollaborators' . '1']['thumbnail'] ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
	    						</div>
	    					    </div>
	    					    <div  class="small-9 columns ">
	    						<div class="text grey-dark breakOffTest"><?php echo $dataActivityRelation['jammersCollaborators' . '1']['username'] ?></div>

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
					    <div class="text grey-dark"><?php echo $views['activity']['nocoll']; ?></div>	
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
    			    <div class="text orange"><?php echo $views['activity']['lastvenue']; ?></div>
				<?php
				if (isset($dataActivityRelation['venuesCollaborators' . '0']) && $dataActivityRelation['venuesCollaborators' . '0'] != NULL) {
				    ?>
				    <div class="row">
					<?php
					if (isset($dataActivityRelation['venuesCollaborators' . '0']['id']) && isset($dataActivityRelation['venuesCollaborators' . '0']['id']) != '') {
					    switch ($dataActivityRelation['venuesCollaborators' . '0']['type']) {
						case 'JAMMER':
						    $defaultThum = DEFTHUMBJAMMER;
						    break;
						case 'VENUE':
						    $defaultThum = DEFTHUMBVENUE;
						    break;
						case 'SPOTTER':
						    $defaultThum = DEFTHUMBSPOTTER;
						    break;
					    }
					    ?>
	    				<div  class="small-6 columns">
	    				    <div class="box-membre" id='venuesCollaborators_<?php echo $dataActivityRelation['venuesCollaborators' . '0']['id'] ?>'>
	    					<div class="row ">
	    					    <div  class="small-3 columns ">
	    						<div class="icon-header">
	    						    <img src="../media/<?php echo $dataActivityRelation['venuesCollaborators' . '0']['thumbnail'] ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
	    						</div>
	    					    </div>
	    					    <div  class="small-9 columns ">
	    						<div class="text grey-dark"><?php echo $dataActivityRelation['venuesCollaborators' . '0']['username'] ?></div>

	    					    </div>		
	    					</div>	
	    				    </div>
	    				</div>
					    <?php
					}
					if (isset($dataActivityRelation['venuesCollaborators' . '1']['id']) && isset($dataActivityRelation['venuesCollaborators' . '1']['id']) != '') {
					    switch ($dataActivityRelation['venuesCollaborators' . '1']['type']) {
						case 'JAMMER':
						    $defaultThum = DEFTHUMBJAMMER;
						    break;
						case 'VENUE':
						    $defaultThum = DEFTHUMBVENUE;
						    break;
						case 'SPOTTER':
						    $defaultThum = DEFTHUMBSPOTTER;
						    break;
					    }
					    ?>
	    				<div  class="small-6 columns">
	    				    <div class="box-membre" id='venuesCollaborators_<?php echo $dataActivityRelation['venuesCollaborators' . '1']['id'] ?>'>
	    					<div class="row ">
	    					    <div  class="small-3 columns ">
	    						<div class="icon-header">
	    						    <img src="../media/<?php echo $dataActivityRelation['venuesCollaborators' . '1']['thumbnail'] ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
	    						</div>
	    					    </div>
	    					    <div  class="small-9 columns ">
	    						<div class="text grey-dark"><?php echo $dataActivityRelation['venuesCollaborators' . '1']['username'] ?></div>

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
					    <div class="text grey-dark"><?php echo $views['activity']['nocoll']; ?></div>	
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
    			    <div class="text orange"><?php echo $views['activity']['lastfriends']; ?></div>
				<?php
				if (isset($dataActivityRelation['friendship' . '0']) && $dataActivityRelation['friendship' . '0'] != NULL) {
				    ?>
				    <div class="row">
					<?php
					if (isset($dataActivityRelation['friendship' . '0']['id']) && isset($dataActivityRelation['friendship' . '0']['id']) != '') {
					    switch ($dataActivityRelation['friendship' . '0']['type']) {
						case 'JAMMER':
						    $defaultThum = DEFTHUMBJAMMER;
						    break;
						case 'VENUE':
						    $defaultThum = DEFTHUMBVENUE;
						    break;
						case 'SPOTTER':
						    $defaultThum = DEFTHUMBSPOTTER;
						    break;
					    }
					    ?>
	    				<div  class="small-6 columns">
	    				    <div class="box-membre" id='friendship_<?php echo $dataActivityRelation['friendship' . '0']['id'] ?>'>
	    					<div class="row ">
	    					    <div  class="small-3 columns ">
	    						<div class="icon-header">
	    						    <img src="../media/<?php echo $dataActivityRelation['friendship' . '0']['thumbnail'] ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
	    						</div>
	    					    </div>
	    					    <div  class="small-9 columns ">
	    						<div class="text grey-dark"><?php echo $dataActivityRelation['friendship' . '0']['username'] ?></div>
	    					    </div>		
	    					</div>	
	    				    </div>
	    				</div>
					    <?php
					}
					if (isset($dataActivityRelation['friendship' . '1']['id']) && isset($dataActivityRelation['friendship' . '1']['id']) != '') {
					    switch ($dataActivityRelation['friendship' . '1']['type']) {
						case 'JAMMER':
						    $defaultThum = DEFTHUMBJAMMER;
						    break;
						case 'VENUE':
						    $defaultThum = DEFTHUMBVENUE;
						    break;
						case 'SPOTTER':
						    $defaultThum = DEFTHUMBSPOTTER;
						    break;
					    }
					    ?>
	    				<div  class="small-6 columns">
	    				    <div class="box-membre" id='friendship_<?php echo $dataActivityRelation['friendship' . '1']['id'] ?>'>
	    					<div class="row ">
	    					    <div  class="small-3 columns ">
	    						<div class="icon-header">
	    						    <img src="../media/<?php echo $dataActivityRelation['friendship' . '1']['thumbnail'] ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
	    						</div>
	    					    </div>
	    					    <div  class="small-9 columns ">
	    						<div class="text grey-dark"><?php echo $dataActivityRelation['friendship' . '1']['username'] ?></div>
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
					    <div class="text grey-dark"><?php echo $views['activity']['nofriends']; ?></div>	
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
    			    <div class="text orange"><?php echo $views['activity']['nofoll']; ?></div>
				<?php
				if (isset($dataActivityRelation['following' . '0']) && $dataActivityRelation['following' . '0'] != NULL) {
				    ?>
				    <div class="row">
					<?php
					if (isset($dataActivityRelation['following' . '0']['id']) && isset($dataActivityRelation['following' . '0']['id']) != '') {
					    switch ($dataActivityRelation['following' . '0']['type']) {
						case 'JAMMER':
						    $defaultThum = DEFTHUMBJAMMER;
						    break;
						case 'VENUE':
						    $defaultThum = DEFTHUMBVENUE;
						    break;
						case 'SPOTTER':
						    $defaultThum = DEFTHUMBSPOTTER;
						    break;
					    }
					    ?>
	    				<div  class="small-6 columns">
	    				    <div class="box-membre" id='following_<?php echo $dataActivityRelation['following' . '0']['id'] ?>'>
	    					<div class="row ">
	    					    <div  class="small-3 columns ">
	    						<div class="icon-header">
	    						    <img src="../media/<?php echo $dataActivityRelation['following' . '0']['thumbnail'] ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
	    						</div>
	    					    </div>
	    					    <div  class="small-9 columns ">
	    						<div class="text grey-dark"><?php echo $dataActivityRelation['following' . '0']['username'] ?></div>
	    						<div class="note grey"><?php echo $dataActivityRelation['following' . '0']['type'] ?></div>
	    					    </div>		
	    					</div>	
	    				    </div>
	    				</div>
					    <?php
					}
					if (isset($dataActivityRelation['following' . '1']['id']) && isset($dataActivityRelation['following' . '1']['id']) != '') {
					    switch ($dataActivityRelation['following' . '1']['type']) {
						case 'JAMMER':
						    $defaultThum = DEFTHUMBJAMMER;
						    break;
						case 'VENUE':
						    $defaultThum = DEFTHUMBVENUE;
						    break;
						case 'SPOTTER':
						    $defaultThum = DEFTHUMBSPOTTER;
						    break;
					    }
					    ?>
	    				<div  class="small-6 columns">
	    				    <div class="box-membre" id='following_<?php echo $dataActivityRelation['following' . '1']['id'] ?>'>
	    					<div class="row ">
	    					    <div  class="small-3 columns ">
	    						<div class="icon-header">
	    						    <img src="../media/<?php echo $dataActivityRelation['following' . '1']['thumbnail'] ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
	    						</div>
	    					    </div>
	    					    <div  class="small-9 columns ">
	    						<div class="text grey-dark"><?php echo $dataActivityRelation['following' . '1']['username'] ?></div>
	    						<div class="note grey"><?php echo $dataActivityRelation['following' . '0']['type'] ?></div>
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
					    <div class="text grey-dark"><?php echo $views['activity']['nofoll']; ?></div>	
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