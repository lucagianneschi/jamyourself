<?php
/* box collaboration
 * box chiamato tramite load con:
 * data: {data,typeuser}
 */

 if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
 
$data = $_POST['data'];
$typeUser = $_POST['typeUser'];


$venuesCollaboratorsCounter = $data['relation']['venuesCollaborators']['venuesCollaboratorsCounter'];
$jammersCollaboratorsCounter = $data['relation']['jammersCollaborators']['jammersCollaboratorsCounter'];

$totCollaborators = $venuesCollaboratorsCounter + $jammersCollaboratorsCounter;

?>

<!------------------------------------- Collaboration ------------------------------------>
	<div class="row" id="social-collaboration">
		<div  class="large-12 columns">
		<h3><?php echo $views['collaboration']['TITLE'];?> <span class="orange">[<?php echo $totCollaborators ?>]</span></h3>
		<div class="row  ">
			<div  class="large-12 columns ">
				<div class="box">
					<?php if($totCollaborators > 0 ){ ?>
					<div class="row  ">
						<div  class="large-12 columns ">
							<div class="text orange">Venue <span class="grey">[<?php echo $venuesCollaboratorsCounter ?>]</span></div>
						</div>
					</div>
					<?php 
					$totalView = $venuesCollaboratorsCounter > 4 ? 4 : $venuesCollaboratorsCounter;
					for($i=0; $i<$totalView; $i=$i+2){
						
						?>	
					
					<div class="row">
						<?php if(isset( $data['relation']['venuesCollaborators'. $i]['objectId']) &&  $data['relation']['venuesCollaborators'. $i]['objectId'] != ''){ ?>
						<div  class="small-6 columns">
							<div class="box-membre">
	    						<div class="row " id="collaborator_<?php echo $data['relation']['venuesCollaborators'. $i]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['venuesCollaborators'. $i]['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark breakOffTest"><strong><?php echo $data['relation']['venuesCollaborators'. $i]['username']?></strong></div>
									</div>		
								</div>	
	    					</div>
						</div>
						<?php } 
						if(isset( $data['relation']['venuesCollaborators'. ($i+1)]['objectId']) &&  $data['relation']['venuesCollaborators'. ($i+1)]['objectId'] != ''){
						?>
						<div  class="small-6 columns ">
							<div class="box-membre">
	    						<div class="row " id="collaborator_<?php echo $data['relation']['venuesCollaborators'. ($i+1)]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['venuesCollaborators'. ($i+1)]['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark breakOffTest"><strong><?php echo $data['relation']['venuesCollaborators'. ($i+1)]['username']?></strong></div>
									</div>		
								</div>
	    					</div>
						</div>
						<?php } ?>
					</div>
					<?php }?>
					<!-------------------------- FINE venue ---------------------------------->
					<div class="row">
						<div  class="large-12 columns"><div class="line"></div></div>
					</div>
					<div class="row  ">
						<div  class="large-12 columns ">
							<div class="text orange">Jammer <span class="grey">[<?php echo $jammersCollaboratorsCounter ?>]</span></div>
						</div>
					</div>	
					<?php 
					$totalView = $jammersCollaboratorsCounter > 4 ? 4 : $jammersCollaboratorsCounter;
					for($i=0; $i<$totalView; $i=$i+2){
						
						?>	
					
					<div class="row">
						<?php if(isset($data['relation']['jammersCollaborators'. $i]['objectId']) && $data['relation']['jammersCollaborators'. $i]['objectId'] != ''){?>
						<div  class="small-6 columns">
							<div class="box-membre">
	    						<div class="row " id="collaborator_<?php echo $data['relation']['jammersCollaborators'. $i]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['jammersCollaborators'. $i]['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark breakOffTest"><strong><?php echo $data['relation']['jammersCollaborators'. $i]['username']?></strong></div>
									</div>		
								</div>	
	    					</div>
						</div>
						<?php } 
						if(isset($data['relation']['jammersCollaborators'. ($i+1)]['objectId']) && $data['relation']['jammersCollaborators'. ($i+1)]['objectId'] != ''){?>
						<div  class="small-6 columns ">
							<div class="box-membre">
	    						<div class="row " id="collaborator_<?php echo $data['relation']['jammersCollaborators'. ($i+1)]['objectId']?>">
									<div  class="small-3 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['relation']['jammersCollaborators'. ($i+1)]['thumbnail']?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
										</div>
									</div>
									<div  class="small-9 columns ">
										<div class="text grey-dark breakOffTest"><strong><?php echo $data['relation']['jammersCollaborators'. ($i+1)]['username']?></strong></div>
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
									<p class="grey"><?php echo $views['collaboration']['NODATA'];?></p>
								</div>
						</div>
						 <?php } ?>			
				</div>	
			</div>
		</div>
		</div>
	</div>