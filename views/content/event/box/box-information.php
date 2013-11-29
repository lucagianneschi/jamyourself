<?php
/*
 * Contiene il box information dell'utente
 * Il contenuto varia a seconda del tipo di utente:
 * spotter: abount
 * jammer: abount e member
 * venue: abount e map
 * 
 * box chiamato tramite load con:
 * data: array conente infomazoini di tipo userInfo, 
 * 
 * 
 */
if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'utilsBox.php';

$objectId = $_POST['objectId'];
$city = $_POST['city'];
$description = $_POST['description'];
$eventDate = $_POST['eventDate'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];
$fromUserObjectId = $_POST['fromUserObjectId'];
$fromUserThumbnail = $_POST['fromUserThumbnail'];
$fromUserUsername = $_POST['fromUserUsername'];

$content1_select = getRelatedUsers($objectId, 'featuring', 'Event', false, 10, 0);
#TODO
$content4_select = '';
$content5_select = '';

?>
<!--------- INFORMATION --------------------->
<div class="row" id="profile-information">
	<div class="large-12 columns">
	<h3><?php echo $views['information']['TITLE'];?></h3>		
		<div class="section-container accordion" data-section="accordion">
		  <section class="active" >
		  	<!--------------------------------- ABOUT ---------------------------------------------------->
		    <p class="title" data-section-title onclick="removeMap()"><a href="#"><?php echo $views['media']['Information']['CONTENT1_EVENT'] ?></a></p>
		    <div class="content" data-section-content>
		    	
				<div class="row " id="user_<?php echo $fromUserObjectId ?>">
					<div class="small-1 columns ">
						<div class="icon-header">
							<img src="<?php echo $fromUserThumbnail ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
						</div>
					</div>
					<div  class="small-11 columns ">
						<div class="text white breakOffTest"><strong><?php echo $fromUserUsername ?></strong></div>
					</div>		
				</div>
					
		    </div>	
		   <div class="content" data-section-content>
		    	<div class="row">
		    		<div class="small-12 columns">
		    			<div class="row">
		    				<div class="small-12 columns">				
								<a class="ico-label white breakOff <?php if ($city != '') echo '_pin-white' ?>"><?php echo $city ?></a>
								<a class="ico-label white breakOff <?php if ($eventDate != '') echo '_calendar' ?>"><?php echo $eventDate?></a>
							</div>
						</div>
		    		</div>
		    			
		    	</div>
		    </div>
		    <div class="content" data-section-content>
		    	<p class="text grey">
		    	<?php echo $description; ?>
		    	</p> 
		    </div>
			</section>
		    <!--------------------------------------- FEATURING - PERFORMED BY --------------------------------------->
		   	<?php
			if (count($content1_select) > 0) {
				?>
				<section>
				<p class="title" data-section-title><a href="#"><?php echo $views['media']['Information']['CONTENT2']; ?></a></p>
				
				<div class="content" data-section-content>
					<?php
					foreach ($content1_select as $key => $value) {
						?>
						<div class="row">
						<?php
						if ($key % 2 == 0) {
							?>
							<div  class="small-6 columns">
								<div class="box-membre">
									<div class="row " id="featuring_<?php echo $value->objectId; ?>">
										<div  class="small-3 columns ">
											<div class="icon-header">
												<img src="../media/<?php echo $value->thumbnail; ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
											</div>
										</div>
										<div  class="small-9 columns ">
											<div class="text white breakOffTest"><strong><?php echo $value->username; ?></strong></div>
											<small class="orange"><?php echo $value->type; ?></small>
										</div>		
									</div>
								</div>
							</div>
							<?php
						} else {
							?>
							<div  class="small-6 columns">
								<div class="box-membre">
									<div class="row " id="featuring_<?php echo $value->objectId; ?>">
										<div  class="small-3 columns ">
											<div class="icon-header">
												<img src="../media/<?php echo $value->thumbnail; ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
											</div>
										</div>
										<div  class="small-9 columns ">
											<div class="text white breakOffTest"><strong><?php echo $value->username; ?></strong></div>
											<small class="orange"><?php echo $value->type; ?></small>
										</div>		
									</div>
								</div>
							</div>
							<?php
						}
						?>
						</div>
						<?php
					}
					?>
				</div>
				</section>
				<?php
			}
			?>
			<section id="profile_map_venue" > 
				<p class="title" data-section-title onclick="viewMap('<?php echo $lat; ?>','<?php echo $lon; ?>')"><a href="#"><?php echo $views['information']['CONTENT3'];?></a></p>
				<div class="content" data-section-content>
					<div class="row">
						<div class="small-12 columns">     					  	
							<div  id="map_venue"></div>	
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns ">
							<a class="ico-label _pin white " onclick="getDirectionMap()"><?php echo $views['information']['CONTENT3_DIRECTION'];?></a> 
						</div>
					</div>				 	
				</div>
			</section>
			<!--------------------------------------- ATTENDING --------------------------------------->
			<?php
			if ($content4_select != '') {
				?>
				<section> 
				<p class="title" data-section-title><a href="#"><?php echo $views['media']['Information']['CONTENT4'];?></a></p>
				
				<div class="content" data-section-content>
				<?php
				foreach ($content4_select as $key => $value) {
					?>
					<div class="row">
					<?php
					if ($key % 2 == 0) {
						?>
						<div  class="small-6 columns">
							<div class="box-membre">
								<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
										<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
									</div>		
								</div>
							</div>
						</div>
						<?php
					} else {
						?>
						<div  class="small-6 columns">
							<div class="box-membre">
								<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
										<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
									</div>		
								</div>
							</div>
						</div>
						<?php
					}
					?>
					</div>
					<?php
				}
				?>
				</div>
				</section>
				<?php
			}
			?>
			<!--------------------------------------- INVITED --------------------------------------->
			<?php
			if ($content5_select != '') {
				?>
				<section > 
				<p class="title" data-section-title><a href="#"><?php echo $views['media']['Information']['CONTENT5'];?></a></p>
				
				<div class="content" data-section-content>
				<?php
				foreach ($content5_select as $key => $value) {
					?>
					<div class="row">
					<?php if ($key % 2 == 0) {
						?>
						<div  class="small-6 columns">
							<div class="box-membre">
								<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
										<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
									</div>		
								</div>
							</div>
						</div>
						<?php
					} else {
						?>
						<div  class="small-6 columns">
							<div class="box-membre">
								<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB'];?>'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
										<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
									</div>		
								</div>
							</div>
						</div>
						<?php
					}
					?>		
					</div>
					<?php
				}
				?>    			
				</div>
				</section>
				<?php
			}
			?>
		</div>
	</div>
</div>

