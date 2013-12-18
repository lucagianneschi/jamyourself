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
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
 
$data 		= $_POST['data'];
$classMedia = $_POST['classMedia'];


//user
$user_objectId = $data['classinfo']['fromUserInfo']['objectId'];
$user_username = $data['classinfo']['fromUserInfo']['username'];
$user_thumbnail = '../media/'.$data['classinfo']['fromUserInfo']['thumbnail'];



if($classMedia == 'record'){
	$location = $data['classinfo']['city'];
	$label = $data['classinfo']['label'];
	$buylink = $data['classinfo']['buylink'];
	$dataTime = $data['classinfo']['year'];	
	$content1_select = $data['classinfo']['featuring'] != $boxes['NOFEATRECORD'] ? $data['classinfo']['featuring'] : '';
	
}
elseif ($classMedia == 'event'){
	$location = $data['classinfo']['city'].' '.$data['classinfo']['address'];
	$event_eventDate_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['classinfo']['eventDate']);
	$dataTime = $event_eventDate_DateTime->format('l j F Y - H:i');
	$content1_select = $data['classinfo']['featuring'] != $boxes['NOFEATEVE'] ? $data['classinfo']['featuring'] : '';
	$content4_select = $data['classinfo']['attendee'] != $boxes['NOATTENDEE'] ? $data['classinfo']['attendee'] : '';
	$content5_select = $data['classinfo']['invited'] != $boxes['NOINVITED'] ? $data['classinfo']['invited'] : '';	
}

$content1_title = $classMedia == 'record' ? $views['media']['Information']['CONTENT1_RECORD'] : $views['media']['Information']['CONTENT1_EVENT'];
$content1_data = $classMedia == 'record' ? 'Recorded in '.$dataTime : $dataTime;
$content1_user = $classMedia == 'record' ? $views['media']['Information']['CONTENT2'] : $views['media']['Information']['CONTENT1_RECORD'];


	
$description = 	$data['classinfo']['description'];
$latitude = '40';
$longitude = '40';
?>
<!--------- INFORMATION --------------------->
<div class="row" id="profile-information">
	<div class="large-12 columns">
	<h3><?php echo $views['information']['TITLE'];?></h3>		
		<div class="section-container accordion" data-section="accordion">
		  <section class="active" >
		  	<!--------------------------------- ABOUT ---------------------------------------------------->
		    <p class="title" data-section-title onclick="removeMap()"><a href="#"><?php echo $content1_title ?></a></p>
		    <div class="content" data-section-content>
		    	
				<div class="row " id="user_<?php echo $user_objectId?>">
					<div class="small-1 columns ">
						<div class="icon-header">
							<img src="<?php echo $user_thumbnail?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
						</div>
					</div>
					<div  class="small-11 columns ">
						<div class="text white breakOffTest"><strong><?php echo $user_username ?></strong></div>
					</div>		
				</div>
					
		    </div>	
		   <div class="content" data-section-content>
		    	<div class="row">
		    		<div class="small-12 columns">
		    			<div class="row">
		    				<div class="small-12 columns">				
								<a class="ico-label white breakOff <?php if($location != '') echo '_pin-white' ?>"><?php echo $location ?></a>
								<a class="ico-label white breakOff <?php if($content1_data != '') echo '_calendar' ?>"><?php echo $content1_data?></a>
							</div>
						</div>
						<?php if($classMedia == 'record'){ ?> 
						<div class="row">
		    				<div class="small-12 columns">
		    					<a class="ico-label white breakOff <?php if($label != '') echo '_tag' ?>"><?php echo $label ?></a>		    								    					
		    				</div>
						</div>
						<?php } ?>			    			
		    		</div>
		    			
		    	</div>
		    </div>
		    <?php if($classMedia == 'record'){ ?>
		    <div class="content" data-section-content>
		    	<div class="row">
    				<div class="small-12 columns">
    					<div class="text orange"><span class="white">Buy this album</span> <?php echo $buylink?></div>		    								    					
    				</div>
				</div> 
		    </div>
		    <?php } ?>
		    <div class="content" data-section-content>
		    	<p class="text grey">
		    	<?php echo $description; ?>
		    	</p> 
		    </div>
		   </section>
		    <!--------------------------------------- FEATURING - PERFORMED BY --------------------------------------->
		   	<?php if($content1_select != ''){ ?>
		    <section > 
		  	<p class="title" data-section-title><a href="#"><?php echo $content1_user;?></a></p>
		  	
		    <div class="content" data-section-content>
		    	<?php foreach ($content1_select as $key => $value) { ?>				
			     <div class="row">
			     	<?php if($key % 2 == 0){ ?>
    				<div  class="small-6 columns">
						<div class="box-membre">
    						<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
								<div  class="small-3 columns ">
									<div class="icon-header">
										<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
									</div>
								</div>
								<div  class="small-9 columns ">
									<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
									<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
								</div>		
							</div>
    					</div>
					</div>
					<?php }
					else { ?>
    				<div  class="small-6 columns">
						<div class="box-membre">
    						<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
								<div  class="small-3 columns ">
									<div class="icon-header">
										<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
									</div>
								</div>
								<div  class="small-9 columns ">
									<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
									<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
								</div>		
							</div>
    					</div>
					</div>
					<?php } ?>		
    			</div>
    			
    			<?php }  ?>    			
		    </div>
		    </section>
		    <?php  }
		    if($classMedia == 'event'){ ?>		    
		    <section id="profile_map_venue" > 
			  	<p class="title" data-section-title onclick="viewMap('<?php echo $data['classinfo']['location']['latitude'] ?>','<?php echo $data['location']['longitude'] ?>')"><a href="#"><?php echo $views['information']['CONTENT3'];?></a></p>
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
		   	<?php if($content4_select != ''){ ?>
		    <section > 
		  	<p class="title" data-section-title><a href="#"><?php echo $views['media']['Information']['CONTENT4'];?></a></p>
		  	
		    <div class="content" data-section-content>
		    	<?php foreach ($content4_select as $key => $value) { ?>				
			     <div class="row">
			     	<?php if($key % 2 == 0){ ?>
    				<div  class="small-6 columns">
						<div class="box-membre">
    						<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
								<div  class="small-3 columns ">
									<div class="icon-header">
										<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
									</div>
								</div>
								<div  class="small-9 columns ">
									<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
									<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
								</div>		
							</div>
    					</div>
					</div>
					<?php }
					else { ?>
    				<div  class="small-6 columns">
						<div class="box-membre">
    						<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
								<div  class="small-3 columns ">
									<div class="icon-header">
										<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
									</div>
								</div>
								<div  class="small-9 columns ">
									<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
									<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
								</div>		
							</div>
    					</div>
					</div>
					<?php } ?>		
    			</div>
    			
    			<?php }  ?>    			
		    </div>
		    </section>
		    <?php } ?>
		    <!--------------------------------------- INVITED --------------------------------------->
		   	<?php if($content5_select != ''){ ?>
		    <section > 
		  	<p class="title" data-section-title><a href="#"><?php echo $views['media']['Information']['CONTENT5'];?></a></p>
		  	
		    <div class="content" data-section-content>
		    	<?php foreach ($content5_select as $key => $value) { ?>				
			     <div class="row">
			     	<?php if($key % 2 == 0){ ?>
    				<div  class="small-6 columns">
						<div class="box-membre">
    						<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
								<div  class="small-3 columns ">
									<div class="icon-header">
										<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
									</div>
								</div>
								<div  class="small-9 columns ">
									<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
									<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
								</div>		
							</div>
    					</div>
					</div>
					<?php }
					else { ?>
    				<div  class="small-6 columns">
						<div class="box-membre">
    						<div class="row " id="featuring_<?php echo $value['$userInfo']['objectId'] ?>">
								<div  class="small-3 columns ">
									<div class="icon-header">
										<img src="../media/<?php echo $value['$userInfo']['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
									</div>
								</div>
								<div  class="small-9 columns ">
									<div class="text white breakOffTest"><strong><?php echo $value['$userInfo']['username'] ?></strong></div>
									<small class="orange"><?php echo $value['$userInfo']['type'] ?></small>
								</div>		
							</div>
    					</div>
					</div>
					<?php } ?>		
    			</div>
    			
    			<?php }  ?>    			
		    </div>
		    </section>
		    <?php } ?>
		    <?php }?>
		  	
		</div>
		
	</div>
</div>

