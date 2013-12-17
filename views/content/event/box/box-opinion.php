<?php

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
require_once BOXES_DIR . 'comment.box.php';


$objectId = $_POST['objectId'];
$class = $_POST['classBox'];
$limit = $_POST['limit'];
$skip = $_POST['skip'];

$comment = new CommentBox();
$comment->init($objectId, $class, $limit, $skip);

/*
$typeUser = $_POST['typeUser'];
$objectIdUser = $_POST['objectIdUser'];
$classBox = $_POST['classBox'];
 //objectId dell'oggetto relativo al comment
$objectId = $_POST['objectId'];
$fromUserObjectId = $_POST['fromUserObjectId'];
*/
 
$countComment = count($comment->commentArray);
 
?>
<div class="row">
	<div  class="small-12 columns">
			
			<?php
			
			if($countComment > 0) {
					foreach ($comment->commentArray as $key => $value) {	
						$comment_data = $value->getCreatedAt()->format('l j F Y - H:i');
						
						switch ($value->getFromUser()->getType()) {
							case 'JAMMER':
								$defaultThum = DEFTHUMBJAMMER;
								break;
							case 'VENUE':
								$defaultThum = DEFTHUMBVENUE;
								break;
							case 'SPOTTER':
								$defaultThum = DEFTHUMBSPOTTER;
								break;
							default:
								
								break;
						}
						
						
			
						?>		
						<div class="box-singole-comment">
							<div class='line'>
								<div class="row">
									<div  class="small-1 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $value->fromUser()->getProfileThumbnail() ?>" onerror="this.src='../media/<?php echo $defaultThum ?>'">
										</div>
									</div>
									<div  class="small-5 columns">
										<div class="text grey" style="margin-bottom: 0p">
											<strong><?php echo $value->fromUser()->getUsername() ?></strong>
										</div>
										
									</div>
									<div  class="small-6 columns align-right">
										<div class="note grey-light">
											<?php echo $comment_data ?>
										</div>
									</div>
								</div>
							</div>

							<div class="row ">
								<div  class="small-12 columns ">
									<div class="row ">
										<div  class="small-12 columns ">
											<div class="text grey">
												<?php echo $value->getText() ; ?>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
						<?php
					}
				
			} else {
				?>
				<div class="box-singole-comment">
					<div class="row"><div  class="large-12 columns"><p class="grey"><?php echo $views['comment']['NODATA'];?></p></div></div>
				</div>	
					
				<?php
			}
			?>
			<div class="row  ">
				<div  class="large-12 columns ">
					<form action="" class="box-write" onsubmit="sendComment('<?php //echo $fromUserObjectId; ?>', $('#comment<?php //echo $classBox . '_' . $objectId; ?>').val(), '<?php //echo $objectId; ?>', '<?php //echo $classType; ?>', '<?php //echo $classBox; ?>'); return false;">
						<div class="">
							<div class="row  ">
								<div  class="small-9 columns ">
									<input id="comment<?php //echo $classBox . '_' . $objectId; ?>" type="text" class="post inline" placeholder="<?php echo $views['comment']['WRITE'];?>" />
								</div>
								<div  class="small-3 columns ">
									<input type="button" class="comment-button inline comment-btn" value="Comment" onclick="sendComment('<?php //echo $fromUserObjectId; ?>', $('#comment<?php //echo $classBox . '_' . $objectId; ?>').val(), '<?php //echo $objectId; ?>', '<?php //echo $classType; ?>', '<?php //echo $classBox; ?>')" />
								</div>
							</div>
						</div>

					</form>
				</div>
			</div>
			<div class="row">
				<div  class="large-12 columns ">
					<div class="comment-error" onClick="postError()"><img src="./resources/images/error/error-post.png" /></div>
				</div>
			</div>
		</div>
	</div>

	
