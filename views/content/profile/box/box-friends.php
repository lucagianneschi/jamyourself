<?php
/* box friends
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

$friendshipCounter = $_POST['friendshipCounter'];

$friendsBox = new FriendsBox();
$friendsBox->init($_POST['objectId']);

if (is_null($friendsBox->error)) {
	$friends = $friendsBox->friendsArray;
	?>
	<div class="row" id="profile-friends">
		<div  class="large-12 columns">
			<h3><?php echo $views['friends']['TITLE'];?> <a data-reveal-id="viewFriendRelation"><span class="orange">[<?php echo $friendshipCounter; ?>]</span></a> </h3>
			<div class="row  ">
				<div  class="large-12 columns ">
					<div class="box">					
						<?php
						if ($friendshipCounter > 0 ) {
							$totalView = $friendshipCounter > 4 ? 4 : $friendshipCounter;
							?>
							<div class="row">
							<?php
							$i = 1;
							foreach ($friends as $key => $value) {
								?>
								<div  class="small-6 columns">
									<div class="box-membre">
										<div class="row " id="collaborator_<?php echo $value->getObjectId(); ?>">
											<div  class="small-3 columns ">
												<div class="icon-header">
													<img src="../media/<?php echo $value->getProfileThumbnail(); ?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
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
								if ($i == $totalView) break;
								$i++;
							}
							?>							
							</div>
							<!------------------ elenco jammer ------------------------->
							<div id="viewFriendRelation" class="reveal-modal">
								<div class="row">
							<?php
								$i = 1;
								foreach ($friends as $key => $value) { ?>
													  
										<div  class="small-6 columns">
											<div class="box-membre">
												<div class="row " id="collaborator_<?php echo $value->getObjectId(); ?>">
													<div  class="small-3 columns ">
														<div class="icon-header">
															<img src="../media/<?php echo $value->getProfileThumbnail(); ?>" onerror="this.src='../media/<?php echo DEFTHUMB;?>'">
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
							<!------------------ fine elenco jammer ------------------------->
							<?php
						} else {
							?>	
							<div class="row  ">
								<div  class="large-12 columns ">
									<p class="grey"><?php echo $views['friends']['NODATA'];?></p>
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