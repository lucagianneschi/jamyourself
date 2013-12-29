<?php
/* box followers
 * box chiamato tramite load con:
 * data: {data,typeuser}
 *
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
require_once BOXES_DIR . 'relation.box.php';

$followersCounter = $_POST['followersCounter'];

$followersBox = new FollowersBox();
$followersBox->init($_POST['objectId']);

if (is_null($followersBox->error)) {
	$followers = $followersBox->followersArray;
	?>
	<div class="row" id="social-followers">
		<div  class="large-12 columns">
			<h3><?php echo $views['followers']['TITLE'];?> <a data-reveal-id="viewVenueFoll"><span class="orange">[<?php echo $followersCounter ?>]</span></a></h3>
			<div class="row  ">
				<div  class="large-12 columns ">
					<div class="box">					
					<?php
					if ($followersCounter > 0 ) {
						?>
						<div class="row">
						<?php
						$totalView = $followersCounter > 4 ? 4 : $followersCounter;
						$i = 1;
						foreach ($followers as $key => $value) {
							switch ($value->getType()) {
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
								<div class="box-membre">
									<div class="row " id="followers_<?php echo $value->getObjectId(); ?>">
										<div  class="small-3 columns ">
											<div class="icon-header">
												<img src="../media/<?php echo $value->getProfileThumbnail(); ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
											</div>
										</div>
										<div  class="small-9 columns ">
											<div class="text grey-dark"><strong><?php echo $value->getUsername(); ?></strong></div>
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
							<!------------------ elenco $followers ------------------------->
						<div id="viewVenueFoll" class="reveal-modal">
							<div class="row">
						<?php
							$i = 1;
							foreach ($followers as $key => $value) { 
								switch ($value->getType()) {
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
										<div class="box-membre">
											<div class="row " id="collaborator_<?php echo $value->getObjectId(); ?>">
												<div  class="small-3 columns ">
													<div class="icon-header">
														<img src="../media/<?php echo $value->getProfileThumbnail(); ?>" onerror="this.src='<?php echo $defaultThum;?>'">
													</div>
												</div>
												<div  class="small-9 columns ">
													<div class="text grey-light breakOffTest"><strong><?php echo $value->getUsername(); ?></strong></div>
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
									
									$i++; 
							}
							
							?>
							</div>
						</div>
						<!------------------ fine elenco venu ------------------------->
						<?php
					} else {
						?>	
						<div class="row  ">
							<div  class="large-12 columns ">
								<p class="grey"><?php echo $views['followers']['NODATA'];?></p>
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