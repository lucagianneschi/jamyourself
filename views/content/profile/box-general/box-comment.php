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
 
//objectId dell'oggetto relativo al comment
$objectId = $_POST['objectId'];
?>

<div class="row">
	<div  class="small-12 columns">
		
			<?php
			if(isset($data['comment']['commentCounter'])) {
				$commentCounter = $data['comment']['commentCounter'];
				if($commentCounter > 0) {
					for($i=0 ; $i<$commentCounter; $i++){
						$comment_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['comment' . $i]['createdAt']);
						$comment_createdAd = $comment_DateTime->format('l j F Y - H:i');
						?>		
						<div class="box-singole-comment">
							<div class='line'>
								<div class="row">
									<div  class="small-1 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['comment'.$i]['user_thumbnail'] ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
										</div>
									</div>
									<div  class="small-5 columns">
										<div class="text grey" style="margin-bottom: 0p">
											<strong><?php echo $data['comment'.$i]['user_username'] ?></strong>
										</div>
										
									</div>
									<div  class="small-6 columns align-right">
										<div class="note grey-light">
											<?php echo $comment_createdAd  ?>
										</div>
									</div>
								</div>
							</div>

							<div class="row ">
								<div  class="small-12 columns ">
									<div class="row ">
										<div  class="small-12 columns ">
											<div class="text grey">
												<?php echo $data['comment'.$i]['text'] ; ?>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
						<?php
					}
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
					<form action="" class="box-write" onsubmit="sendComment(objectIdToUser, comment, objectIdClass, classType); return false;">
						<div class="">
							<div class="row  ">
								<div  class="small-9 columns ">
									<input id="comment" type="text" class="post inline" placeholder="<?php echo $views['comment']['WRITE'];?>" />
								</div>
								<div  class="small-3 columns ">
									<input type="button" class="comment-button inline" value="Comment" onclick="sendComment('iovioSH5mq', $('#comment').val(), '53ZW8ukLKB', 'Comment')" />
								</div>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
	
