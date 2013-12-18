<?php
/* box post
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

$objectIdUser  = $_POST['objectIdUser'];
$typeUser = $_POST['typeUser'];

$postCounter = $data['postCounter'];


?>

<!------------------------------------- Post ------------------------------------>
<div class="row" id="social-Post" style='margin-bottom: 40px;'>
	<div  class="large-12 columns">
		<h3><?php echo $views['post']['TITLE']?></h3>

		<div class="row ">
			<div  class="large-12 columns ">

				<div class="row  ">
					<div  class="large-12 columns ">
						<form action="" class="box-write" onsubmit="sendPost('<?php echo $objectIdUser; ?>', $('#post').val()); return false;">
							<div class="">
								<div class="row  ">
									<div class="small-9 columns ">
										<input id="post" type="text" class="post inline" placeholder="<?php echo $views['post']['WRITE'];?>" />
									</div>
									<div class="small-3 columns ">
										<input type="button" id="button-post" class="post-button inline" value="Post" onclick="sendPost('<?php echo $objectIdUser; ?>', $('#post').val())" />
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>
				<div class="row  ">
					<div  class="large-12 columns ">
						<div id="post-error" onClick="postError()"><img src="./resources/images/error/error-post.png" /></div>
					</div>
				</div>
				<?php 
					if($postCounter > 0) {
						for($i = 0; $i < $postCounter; $i++){
							$post_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['post' . $i]['createdAt']);
							$post_createdAd = $post_DateTime->format('l j F Y - H:i');
							$love = $data['post' . $i]['showLove'] == false ? '_unlove grey' : '_love orange';
							if($data['post' . $i]['showLove'] == 'true'){
								$css_love = '_unlove grey';
								$text_love = $views['LOVE'];
							}
							elseif($data['post' . $i]['showLove'] == 'false'){
								$css_love = '_love orange';
								$text_love = $views['UNLOVE'];
							}
							?>
							<div id='<?php echo  $data['post' . $i]['objectId'];?>'>
								<div class="box <?php echo $data['post' . $i]['showLove'] ?>">
								
								<div class="row  line">
									<div  class="small-1 columns ">
										<div class="icon-header">
											<img src="../media/<?php echo $data['post' . $i]['user_thumbnail'];?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
										</div>
									</div>
									<div  class="small-5 columns">
										<div class="text grey" style="margin-bottom: 0px;">
											<strong><?php echo $data['post' . $i]['user_username'];?></strong>
										</div>
										<div class="note orange">
											<strong><?php echo $data['post' . $i]['user_type'];?></strong>
										</div>
									</div>
									<div  class="small-6 columns propriety">
										<div class="note grey-light">
											<?php echo $post_createdAd;?>
										</div>
									</div>

								</div>
								<div class="row  line">
									<div  class="small-12 columns ">
										<div class="row ">
											<div  class="small-12 columns ">
												<div class="text grey">
													<?php echo $data['post' . $i]['text'];?>	
												</div>
											</div>
										</div>

									</div>
								</div>
								<div class="row">
									<div class="box-propriety">
										<div class="small-5 columns ">
											<a class="note grey " onclick="love(this, 'Comment', '<?php echo $data['post' . $i]['objectId']; ?>', '<?php echo $objectIdUser; ?>')"><?php echo $text_love;?></a>
											<a class="note grey" onclick="setCounter(this,'<?php echo $data['post' . $i]['objectId']; ?>','Post')"><?php echo $views['COMM'];?></a>
										</div>
										<div class="small-5 columns propriety ">
											<a class="icon-propriety <?php echo $css_love ?>"><?php echo$data['post' . $i]['counters']['loveCounter']; ?></a>
											<a class="icon-propriety _comment"><?php echo $data['post' . $i]['counters']['commentCounter']; ?></a>
										
										</div>
									</div>
								</div>
								
								
								</div> <!--------------- BOX -------------------->	
								<!---------------------------------------- COMMENT ------------------------------------------------->
								<div class="box-comment no-display" ></div>
							</div>
							<?php
						}
					} else {
						?>
						<div class="box">
							<div class="row">
								<div  class="large-12 columns ">
									<p class="grey"><?php echo $views['post']['NODATA'];?></p>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				
				
		</div>
	</div>
</div>
