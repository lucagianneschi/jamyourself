<?php
/* box post
 * box chiamato tramite load con:
 * data: {data,typeuser}
 *
 */

$data = $_POST['data'];
$typeUser = $_POST['typeUser'];

$postCounter = $data['postCounter'];

?>

<!------------------------------------- Post ------------------------------------>
<div class="row" id="social-Post">
	<div  class="large-12 columns">
		<h3>Post</h3>

		<div class="row ">
			<div  class="large-12 columns ">

				<div class="row  ">
					<div  class="large-12 columns ">
						<form action="" class="box-write">
							<div class="">
								<div class="row  ">
									<div  class="small-9 columns ">
										<input type="text" class="post inline" placeholder="Write a post" />
									</div>
									<div  class="small-3 columns ">
										<input type="button" class="post-button inline" value="Post"/>
									</div>
								</div>
							</div>

						</form>
					</div>
				</div>
				<div class="box">
					
					<?php 
					if($postCounter > 0){
					for($i=0; $i< $postCounter; $i++){
						$post_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['post' . $i]['createdAt']);
						$post_createdAd = $post_DateTime->format('l j F Y - H:i');
									
					?>
					<div id='<?php echo  $data['post' . $i]['objectId'];?>'>
					<div class="row  line">
						<div  class="small-1 columns ">
							<div class="icon-header">
								<img src="../media/<?php echo $data['post' . $i]['user_thumbnail'];?>">
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
								<a class="note grey " onclick="setCounter(this,'<?php echo $data['post' . $i]['objectId']; ?>','Post')">Love</a>
								<a class="note grey" onclick="setCounter(this,'<?php echo $data['post' . $i]['objectId']; ?>','Post')">Comment</a>
							</div>
							<div class="small-5 columns propriety ">
								<a class="icon-propriety _unlove grey"><?php echo$data['post' . $i]['counters']['loveCounter']; ?></a>
								<a class="icon-propriety _comment"><?php echo $data['post' . $i]['counters']['commentCounter']; ?></a>
							
							</div>
						</div>
					</div>
					<!---------------------------------------- COMMENT ------------------------------------------------->
					<div class="box-comment no-display"></div>
					</div>	
					<?php }}
					else{
						?>
						<div class="row">
						<div  class="large-12 columns ">
							<p class="grey">There are no Post</p>
						</div>
						</div>
						<?php
					}
					 ?>
				</div> <!--------------- BOX -------------------->
				
		</div>
	</div>
</div>
