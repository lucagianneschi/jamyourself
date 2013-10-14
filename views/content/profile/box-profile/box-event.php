<?php

/* Box degli eventi, viene effettuata la chiamata a tale box solo se typeUser: jammer or venue
 * box chiamato tramite load con:
 * data: {data: data, typeUser: typeUser}
 * 
 * @data: array contenente tutti di dati relativi agli eventi
 * @typeUser: tipo utente (JAMMER, VENUE o SPOTTER)
 */
 
 $data = $_POST['data'];
 $typeUser = $_POST['typeUser'];
 
 $typeUser = "JAMMER";
 $eventCounter = $data['eventCounter'];


?>

<div class="row" id='profile-Event'>
	<div class="large-12 columns ">	
		<div class="row">
			<div  class="small-5 columns">
				<h3>Event </h3>
			</div>	
			<div  class="small-7 columns align-right">
				<?php if($eventCounter > 0){ ?>
					<div class="row">					
						<div  class="small-9 columns">
							<a class="slide-button-prev _prevPage" onclick="royalSlidePrev('event')">Previous </a>
						</div>
						<div  class="small-3 columns">
							<a class="slide-button-next _nextPage" onclick="royalSlideNext('event')">Next </a>
						</div>
					</div>
		 		<?php } ?>
			</div>
		</div>		
		<!------------------------------------ LISTA Event --------------------------------------->
		<div class="box">
		<?php if($eventCounter > 0){?>
		<div class="royalSlider rsMinW" id="eventSlide">
		<?php
			$index = 0;
			for ($i=0; $i < $eventCounter ; $i++) {
				if($i % 3 == 0){
			?>
			<div class="rsContent">
			<?php
			
			for($j=0; $j<3;  $j++){
				if($index < $eventCounter){
					$event_thumbnail = $data['event'.$index]['thumbnail'];
					$event_objectId = $data['event'.$index]['objectId'];					
					$event_locationName = $data['event'.$index]['locationName'];
					$event_title = $data['event'.$index]['title'];
					$event_featuting = "";
					if(is_array($data['event'.$index]['featuring']) && count($data['event'.$index]['featuring'])>0){
						foreach ($data['event'.$index]['featuring'] as $key => $value) {
							$event_featuting = $event_featuting.' '.$value['username'];
						}
					}
					$event_eventDate_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['event'.$index]['eventDate']);
					$event_eventDate = $event_eventDate_DateTime->format('l j F Y - H:i');
					$event_location = $data['event'.$index]['city']. ' - ' .$data['event'.$index]['address'];					
					
					$event_love = $data['event'.$index]['counters']['loveCounter'];
					$event_comment = $data['event'.$index]['counters']['commentCounter'];
					$event_review = $data['event'.$index]['counters']['reviewCounter'];
					$event_share = $data['event'.$index]['counters']['shareCounter'];
			?>
			<!----------------------------------- SINGLE Event ------------------------------------>
			<div class="box-element" id='<?php echo  $event_objectId ?>'>
				<div class="row">				
					<div class="small-12 columns">
						<div class="small-4 columns event">
							<img class="eventcover" src="../media/<?php echo  $event_thumbnail?>" onError="this.src='../media/images/default/defaultEventcoverthumb.jpg'">
						</div>
						<div class="small-8 columns">
							<?php if($typeUser == "JAMMER"){ ?>						
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle white breakOffTest"><?php echo $event_locationName ?></div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle grey breakOffTest"><?php echo $event_title  ?></div>
								</div>
							</div>
							<?php } else{?>	
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle white breakOffTest"><?php echo $event_title  ?></div>
								</div>
							</div>
							<?php } ?>
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle white breakOffTest"><?php echo $event_featuting  ?></div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<a class="ico-label _calendar inline text grey breakOff"><?php echo $event_eventDate ?></a>
								</div>
							</div>
							<?php if($typeUser == "JAMMER"){ ?>		
							<div class="row">
								<div class="large-12 colums">
									<a class="ico-label _pin inline text grey breakOff"><?php echo $event_location ?></a>
								</div>
							</div>	
							<?php } ?>		
						</div>
					</div>
				</div>
				<div class="row album-single-propriety">
					<div class="box-propriety ">					
						<div class="small-7 columns no-display">
							<a class="icon-propriety _menu-small note orange "> Add to Calendar</a>	
							<a class="note grey " onclick="setCounter(this,'<?php echo $event_objectId; ?>','Event')">Love</a>
							<a class="note grey" onclick="setCounter(this,'<?php echo $event_objectId; ?>','Event')">Comment</a>
							<a class="note grey" onclick="setCounter(this,'<?php echo $event_objectId; ?>','Event')">Share</a>
							<a class="note grey" onclick="setCounter(this,'<?php echo $event_objectId; ?>','Event')">Review</a>	
						</div>
						<div class="small-5 columns propriety ">					
							<a class="icon-propriety _unlove grey"><?php echo $event_love ?></a>
							<a class="icon-propriety _comment"><?php echo $event_comment ?></a>
							<a class="icon-propriety _share"><?php echo $event_share ?></a>
							<a class="icon-propriety _review"><?php echo $event_review ?></a>		
						</div>
					</div>		
				</div>	
			</div>					
		
		<?php 
			$index++;
		//chiusura for e if	
		}} ?>
		<!--------------------------- FINE ------------------------------------------------>	
		</div>
		
		<?php 
			//chiusura primo if
			}
		//chiusura primo for
		} 
		
		?>
		</div>
		<?php }else{
			
			?>
			<div class="row">
						<div  class="large-12 columns"><p class="grey">There are no Event</p></div>
					</div>
			<?php
		}?>
		</div>
	</div>
</div>	
		