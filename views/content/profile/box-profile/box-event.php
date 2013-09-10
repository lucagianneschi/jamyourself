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
 $eventCounter = $data['eventCounter'];


?>
<!----------------------------------- Event -------------------------------------------------->

<div class="row" id='boxEvent'>
	<div class="large-12 columns ">		
		<div  class="large-9 columns">
			<h3>Event </h3>
		</div>	
		<div  class="large-3 columns align-right">
			<?php if($eventCounter > 0){ ?>
				<a class="icon-block _nextPage grey" onclick="royalSlideNext(this,'boxEvent')" style="top: 5px !important; margin-top: 15px !important"></a>
			<a class="icon-block _prevPage grey text" onclick="royalSlidePrev(this,'boxEvent')" style="top: 5px !important; margin-top: 15px !important; "><span class="indexBox">1</span>/<?php echo $eventCounter ?></a>
	 		
			<?php } ?>
		</div>	
		<!------------------------------------ LISTA Event --------------------------------------->
		<div class="box">
		<?php if($eventCounter > 0){?>
		<div class=" royalSlider rsMinW" id="event">
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
					if(count($data['event'.$index]['featuring'])>0){
						foreach ($data['event'.$index]['featuring'] as $key => $value) {
							$event_featuting = $event_featuting.' '.$value['username'];
						}
					}
					$event_eventDate_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['event'.$index]['eventDate']);
					$event_eventDate = $event_eventDate_DateTime->format('l j F Y - H:i');
					$event_location = 'Torino TO - Via Roma, 224 / B';  // DA VEDERE	
					$event_love = $data['event'.$index]['counters']['loveCounter'];
					$event_comment = $data['event'.$index]['counters']['commentCounter'];
					$event_review = $data['event'.$index]['counters']['reviewCounter'];
					$event_share = $data['event'.$index]['counters']['shareCounter'];
			?>
			<!----------------------------------- SINGLE Event ------------------------------------>
			<div class="row box-single-event" id='<?php echo  $event_objectId ?>'>				
				<div class="small-12 columns">
					<div class="small-4 columns event">
						<img class="eventcover" src="../media/<?php echo  $event_thumbnail?>">
					</div>
					<div class="small-8 columns">
						<?php if($typeUser == "jammer"){ ?>						
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white "><?php echo $event_locationName ?></div>
							</div>
						</div>
						<?php } ?>	
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle grey"><?php echo $event_title  ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white"><?php echo $event_featuting  ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<a class="ico-label _calendar inline text grey"><?php echo $event_eventDate ?> </a>
							</div>
						</div>
						<?php if($typeUser == "jammer"){ ?>		
						<div class="row">
							<div class="large-12 colums">
								<a class="ico-label _pin inline text grey"><?php echo $event_location ?> </a>
							</div>
						</div>	
						<?php } ?>		
					</div>
				</div>
			</div>
			<div class="row album-single-propriety">
				<div class="box-propriety">					
					<div class="small-7 columns ">
						<a class="icon-propriety _menu-small note orange "> Add to Calendar</a>	
						<a class="note white" onclick="setCounter(<?php echo  $event_objectId ?>,'event',this)">Love</a>
						<a class="note white" onclick="setCounter(this)">Comment</a>
						<a class="note white" onclick="setCounter(this)">Shere</a>
						<a class="note white" onclick="setCounter(this)">Review</a>	
					</div>
					<div class="small-5 columns propriety ">					
						<a class="icon-propriety _unlove grey"><?php echo $event_love ?></a>
						<a class="icon-propriety _comment"><?php echo $event_comment ?></a>
						<a class="icon-propriety _shere"><?php echo $event_share ?></a>
						<a class="icon-propriety _review"><?php echo $event_review ?></a>		
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
		