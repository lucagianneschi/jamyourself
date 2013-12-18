<?php
/* box collaboration
 * box chiamato tramite load con:
 * data: {data,typeuser}
 */

 if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'relation.box.php';

$collaborationCounter = $_POST['collaborationCounter'];

$collaboratorsBox = new CollaboratorsBox();
$collaboratorsBox->init($_POST['objectId']);

if (is_null($collaboratorsBox->error)) {
	$venuesCollaborators = $collaboratorsBox->venueArray;
	$jammersCollaborators = $collaboratorsBox->jammerArray;
	
	$venuesCollaboratorsCounter = count($venuesCollaborators);
	$jammersCollaboratorsCounter = count($jammersCollaborators);
	$totCollaborators = $collaborationCounter;
	?>
	<!------------------------------------- Collaboration ------------------------------------>
		<div class="row" id="social-collaboration">
			<div  class="large-12 columns">
			<h3><?php echo $views['collaboration']['TITLE'];?> <span class="orange">[<?php echo $totCollaborators ?>]</span></h3>
			<div class="row  ">
				<div  class="large-12 columns ">
					<div class="box">
						<?php
						if ($totCollaborators > 0) {
							?>
							<div class="row  ">
								<div  class="large-12 columns ">
									<div class="text orange">Venue <span class="grey">[<?php echo $venuesCollaboratorsCounter ?>]</span></div>
								</div>
							</div>
							<div class="row">
							<?php
							$totalView = $venuesCollaboratorsCounter > 4 ? 4 : $venuesCollaboratorsCounter;
							$i = 1;
							foreach ($venuesCollaborators as $key => $value) {
								?>
								<div  class="small-6 columns">
									<div class="box-membre">
										<div class="row " id="collaborator_<?php echo $value->getObjectId(); ?>">
											<div  class="small-3 columns ">
												<div class="icon-header">
													<img src="../media/<?php echo $value->getProfileThumbnail(); ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
												</div>
											</div>
											<div  class="small-9 columns ">
												<div class="text grey-dark breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
											</div>		
										</div>	
									</div>
								</div>
								<?php
								if ($i % 2 == 0) {
									?>
									</div>
									<div class="row">
									<?php
								}
								if ($i == $totalView) break;
								$i++;
							}
							?>
							</div>
							<!-------------------------- FINE venue ---------------------------------->
							<div class="row">
								<div  class="large-12 columns"><div class="line"></div></div>
							</div>
							<div class="row  ">
								<div  class="large-12 columns ">
									<div class="text orange">Jammer <span class="grey">[<?php echo $jammersCollaboratorsCounter ?>]</span></div>
								</div>
							</div>
							<div class="row">
							<?php
							$totalView = $jammersCollaboratorsCounter > 4 ? 4 : $jammersCollaboratorsCounter;
							$i = 1;
							foreach ($jammersCollaborators as $key => $value) {
								?>
								<div  class="small-6 columns">
									<div class="box-membre">
										<div class="row " id="collaborator_<?php echo $value->getObjectId(); ?>">
											<div  class="small-3 columns ">
												<div class="icon-header">
													<img src="../media/<?php echo $value->getProfileThumbnail(); ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
												</div>
											</div>
											<div  class="small-9 columns ">
												<div class="text grey-dark breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
											</div>		
										</div>	
									</div>
								</div>
								<?php
								if ($i % 2 == 0) {
									?>
									</div>
									<div class="row">
									<?php
								}
								if ($i == $totalView) break;
								$i++;
							}
							?>
							</div>
							<?php
						} else{
							?>	
							<div class="row  ">
								<div  class="large-12 columns ">
									<p class="grey"><?php echo $views['collaboration']['NODATA'];?></p>
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
	<?php
}