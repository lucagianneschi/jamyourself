<?php

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  

$data = $_POST['data'];
$typeUser = $_POST['typeUser'];
$objectIdUser = $_POST['objectIdUser'];
$classBox = $_POST['classbox'];

switch ($classBox) {
	case 'Album':
		$classType = 'Album';
		break;
	case 'Comment':
		$classType = 'Comment';
		break;
	case 'EventReview':
		$classType = 'Comment';
		break;
	case 'Image':
		$classType = 'Image';
		break;
	case 'Post':
		$classType = 'Comment';
		break;
	case 'Record':
		$classType = 'Record';
		break;
	case 'RecordReview':
		$classType = 'Comment';
		break;
}
 
//objectId dell'oggetto relativo al comment
$objectId = $_POST['objectId'];
?>
<div class="row">
	<div  class="small-12 columns">
		
			<?php
			if(count($data['comment']['commentInfoArray']) > 0) {				
					foreach ($data['comment']['commentInfoArray'] as $key => $value) {	
						$comment_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $value['createdAt']);
						$comment_createdAd = $comment_DateTime->format('l j F Y - H:i');
						?>		
						<div class="box-singole-comment">
							<div class='line'>
								<div class="row">
									<div  class="small-1 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $value['user_thumbnail'] ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
										</div>
									</div>
									<div  class="small-5 columns">
										<div class="text grey" style="margin-bottom: 0p">
											<strong><?php echo $value['user_username'] ?></strong>
										</div>
										
									</div>
									<div  class="small-6 columns align-right">
										<div class="note grey-light">
											<?php echo $comment_createdAd ?>
										</div>
									</div>
								</div>
							</div>

							<div class="row ">
								<div  class="small-12 columns ">
									<div class="row ">
										<div  class="small-12 columns ">
											<div class="text grey">
												<?php echo $value['text'] ; ?>
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
					<form action="" class="box-write" onsubmit="sendComment('<?php echo $objectIdUser; ?>', $('#comment<?php echo $classBox . '_' . $objectId; ?>').val(), '<?php echo $objectId; ?>', '<?php echo $classType; ?>', '<?php echo $classBox; ?>'); return false;">
						<div class="">
							<div class="row  ">
								<div  class="small-9 columns ">
									<input id="comment<?php echo $classBox . '_' . $objectId; ?>" type="text" class="post inline" placeholder="<?php echo $views['comment']['WRITE'];?>" />
								</div>
								<div  class="small-3 columns ">
									<input type="button" class="comment-button inline comment-btn" value="Comment" onclick="sendComment('<?php echo $objectIdUser; ?>', $('#comment<?php echo $classBox . '_' . $objectId; ?>').val(), '<?php echo $objectId; ?>', '<?php echo $classType; ?>', '<?php echo $classBox; ?>')" />
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
	
