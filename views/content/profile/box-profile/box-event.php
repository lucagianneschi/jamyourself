<?php

/* Box degli eventi, viene effettuata la chiamata a tale box solo se typeUser: jammer or venue
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId, typeUser: typeUser}, 
 * data-type: html,
 * type: POST o GET
 * 
 * Verrà chiamato l'oggetto di tipo event.box.php
 */
 
 $typeUser = "jammer";
 
 //------------- EVENT JAMMER --------------------------
 // Primo Evento - information
 $event1_photo = 'photo1.jpg';
 $event1_name = 'Nome venue locale';
 $event1_title = 'Titolo Evento - Happy Hour';
 $event1_featuring = 'Featuring Nome jammer';
 $event1_data = 'Sabato 18 maggio - ore 22.30';
 $event1_location = 'Torino TO - Via Roma, 224 / B';
 
 // Primo Evento - propriety
 $event1_love = '45';
 $event1_comment = '7';
 $event1_share = '2';
 $event1_review = '3'; 

?>
<!----------------------------------- Event -------------------------------------------------->
<div class="row">
	<div class="large-12 columns ">
		<h3>Event</h3>
		<!------------------------------------ LISTA Event --------------------------------------->
		<div class="box" id="event-list">
			<!----------------------------------- PRIMO Event ------------------------------------>
			<div class="row box-single-event">				
				<div class="small-12 columns box-coveralbum">
					<div class="small-4 columns event">
						<img class="eventcover" src="../media/images/eventcoverthumb/<?php echo $event1_photo ?>">
					</div>
					<div class="small-8 columns">
						<?php if($typeUser == "jammer"){ ?>						
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white "><?php echo $event1_name ?></div>
							</div>
						</div>
						<?php } ?>	
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle grey"><?php echo $event1_title ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white"><?php echo $event1_featuring ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<a class="ico-label _calendar inline text grey"><?php echo $event1_data ?> </a>
							</div>
						</div>
						<?php if($typeUser == "jammer"){ ?>		
						<div class="row">
							<div class="large-12 colums">
								<a class="ico-label _pin inline text grey"><?php echo $event1_location ?> </a>
							</div>
						</div>	
						<?php } ?>		
					</div>
				</div>
			</div>
			<div class="row album-single-propriety">
				<div class="box-propriety">					
					<div class="small-8 columns ">
						<a class="icon-propriety _menu-small note orange "> Add to Calendar</a>	
						<a class="note white">Love</a>
						<a class="note white">Comment</a>
						<a class="note white">Shere</a>
						<a class="note white">Review</a>	
					</div>
					<div class="small-4 columns propriety ">					
						<a class="icon-propriety _unlove grey"><?php echo $event1_love ?></a>
						<a class="icon-propriety _comment"><?php echo $event1_comment ?></a>
						<a class="icon-propriety _shere"><?php echo $event1_share ?></a>
						<a class="icon-propriety _review"><?php echo $event1_review ?></a>		
					</div>
				</div>		
			</div>
			<!------------------------------ SECONDO ESIBIZIONE --------------------------------->
			<div class="row box-single-event">				
				<div class="small-12 columns box-coveralbum">
					<div class="small-4 columns event">
						<img class="eventcover" src="../media/images/eventcoverthumb/<?php echo $event1_photo ?>">
					</div>
					<div class="small-8 columns">
						<?php if($typeUser == "jammer"){ ?>						
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white "><?php echo $event1_name ?></div>
							</div>
						</div>
						<?php } ?>	
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle grey"><?php echo $event1_title ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white"><?php echo $event1_featuring ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<a class="ico-label _calendar inline text grey"><?php echo $event1_data ?> </a>
							</div>
						</div>
						<?php if($typeUser == "jammer"){ ?>		
						<div class="row">
							<div class="large-12 colums">
								<a class="ico-label _pin inline text grey"><?php echo $event1_location ?> </a>
							</div>
						</div>	
						<?php } ?>		
					</div>
				</div>
			</div>
			<div class="row album-single-propriety">
				<div class="box-propriety">						
					<div class="small-8 columns ">
						<a class="icon-propriety _menu-small note orange "> Add to Calendar</a>	
						<a class="note white">Love</a>
						<a class="note white">Comment</a>
						<a class="note white">Shere</a>
						<a class="note white">Review</a>	
					</div>
					<div class="small-4 columns propriety ">					
						<a class="icon-propriety _unlove grey"><?php echo $event1_love ?></a>
						<a class="icon-propriety _comment"><?php echo $event1_comment ?></a>
						<a class="icon-propriety _shere"><?php echo $event1_share ?></a>
						<a class="icon-propriety _review"><?php echo $event1_review ?></a>		
					</div>
				</div>		
			</div>
			<!------------------------------------------- TERZA ESIBIZIONE ------------------------------------->
			<div class="row box-single-event">				
				<div class="small-12 columns box-coveralbum">
					<div class="small-4 columns event">
						<img class="eventcover" src="../media/images/eventcoverthumb/<?php echo $event1_photo ?>">
					</div>
					<div class="small-8 columns">
						<?php if($typeUser == "jammer"){ ?>						
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white "><?php echo $event1_name ?></div>
							</div>
						</div>
						<?php } ?>	
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle grey"><?php echo $event1_title ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white"><?php echo $event1_featuring ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<a class="ico-label _calendar inline text grey"><?php echo $event1_data ?> </a>
							</div>
						</div>
						<?php if($typeUser == "jammer"){ ?>		
						<div class="row">
							<div class="large-12 colums">
								<a class="ico-label _pin inline text grey"><?php echo $event1_location ?> </a>
							</div>
						</div>	
						<?php } ?>		
					</div>
				</div>
			</div>
			<div class="row album-single-propriety">
				<div class="box-propriety">						
					<div class="small-8 columns ">
						<a class="icon-propriety _menu-small note orange "> Add to Calendar</a>	
						<a class="note white love">Love</a>
						<a class="note white">Comment</a>
						<a class="note white">Shere</a>
						<a class="note white">Review</a>	
					</div>
					<div class="small-4 columns propriety ">					
						<a class="icon-propriety _unlove grey"><?php echo $event1_love ?></a>
						<a class="icon-propriety _comment"><?php echo $event1_comment ?></a>
						<a class="icon-propriety _shere"><?php echo $event1_share ?></a>
						<a class="icon-propriety _review"><?php echo $event1_review ?></a>		
					</div>
				</div>		
			</div>				
		</div>
	</div>
</div>			