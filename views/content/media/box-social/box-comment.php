<?php
/* box comment
 * box chiamato tramite load con:
 * data: {data,typeuser}
 *
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
 
$data = $_POST['data'];

//print_r($data);
$objectIdMedia = $_POST['objectIdMedia'];
$fromUserInfo = $_POST['fromUserInfo'];

?>

<!------------------------------------- comment ------------------------------------>
<div class="row" id="social-Comment <?php echo $objectIdMedia ?>">
	<div  class="large-12 columns">
		<h3>Comment</h3>

		<div class="row ">
			<div  class="large-12 columns ">

				<div class="row  ">
					<div  class="large-12 columns ">
						<form action="" class="box-write">
							<div class="">
								<div class="row  ">
									<div  class="small-9 columns ">
										<input id="commentEvent_<?php echo $objectIdMedia; ?>" type="text" class="comment inline" placeholder="<?php echo $views['comment']['WRITE'];?>" />
									</div>
									<div  class="small-3 columns ">
										<input type="button" class="post-button inline" value="Comment" onclick="sendComment('<?php echo $objectIdUser; ?>', $('#comment<?php echo $classBox . '_' . $objectId; ?>').val(), '<?php echo $objectId; ?>', '<?php echo $classType; ?>', '<?php echo $classBox; ?>')"/>
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>
				
				<?php  
				$commentCounter = count($result['comment']['commentInfoArray']);
				$comment_3count = $commentCounter > 5 ? 5 : $commentCounter;
				$comment_other = $comment_3count > $commentCounter ? 0 : ($commentCounter - $comment_3count);
				if (count($result['comment']['commentInfoArray']) > 0) {
					foreach ($result['comment']['commentInfoArray'] as $key => $value) {
						$user_thumbnail = $value['user_thumbnail'];
						$user_username =  $value['user_username'];
						$user_type = $value['user_type'];
						
						$comment_objectId = $key;
						
						$comment_DateTime = DateTime::createFromFormat('d-m-Y H:i:s',  $value['createdAt']);
						$comment_createdAd = $review_DateTime->format('l j F Y - H:i');
						
						$comment_text =  $value['text'];
						?>				
						<div id='<?php echo  $comment_objectId; ?>'>
							
							<div class="box">
							
								<div class="row  line">
									<div  class="small-1 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $user_thumbnail; ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
										</div>
									</div>
									<div  class="small-5 columns">
										<div class="text grey" style="margin-bottom: 0px;">
											<strong><?php echo $user_username; ?></strong>
										</div>
										<div class="note orange">
											<strong><?php echo $user_type ?></strong>
										</div>
									</div>
									<div  class="small-6 columns propriety">
										<div class="note grey-light">
											<?php echo $comment_createdAd;?>
										</div>
									</div>
			
								</div>
								<div class="row  line">
									<div  class="small-12 columns ">
										<div class="row ">
											<div  class="small-12 columns ">
												<div class="text grey">
													<?php echo $comment_text;?>	
												</div>
											</div>
										</div>
			
									</div>
								</div>
								<div class="row">
									<div class="box-propriety">
										<div class="small-5 columns ">
											<a class="note grey " onclick="setCounter(this,'<?php echo $comment_objectId; ?>','comment')"><?php echo $views['LOVE'];?></a>
										</div>
										<div class="small-5 columns propriety ">
											<a class="icon-propriety _unlove grey"><?php echo $value['counters']['loveCounter']?></a>
										
										</div>
									</div>
								</div>
							
							
							</div> <!--------------- BOX -------------------->	
							
						</div>
						<?php
					}
				}
				if ($comment_other > 0) {
					?>
					<div class="row otherSet">
						<div class="large-12 colums">
							<div class="text">Other <?php echo $comment_other;?> Comment</div>	
						</div>	
					</div>
					<?php
				}
				if ($commentCounter == 0) {
					?>
					<div class="box">	
						<div class="row">
							<div  class="large-12 columns ">
								<p class="grey"><?php echo $views['comment']['NODATA'];?></p>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
