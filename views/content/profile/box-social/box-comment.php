<?php
/*
$data = $_POST['data'];
$typeUser = $_POST['typeUser'];

$commentCounter = $data['comment']['commentCounter'];
 * */
 
?>
<!--
<div class="row">
	<div  class="small-12 columns ">
		
			<?php 
			if($commentCounter > 0){
			for($i=0 ; $i<$commentCounter; $i++){ 				
				$comment_DateTime = DateTime::createFromFormat('d-m-Y H:i:s', $data['comment'.$i]['createdAt']);
				$comment_Date = $comment_DateTime->format('l j F Y - H:i');
				?>		
			<div class="box-singole-comment">
				<div class='line'>
					<div class="row">
						<div  class="small-1 columns ">
							<div class="icon-header">
								<img src="../media/<?php echo $data['comment'.$i]['user_thumbnail'] ?>" onerror="this.src='../media/images/default/defaultProfilepicturethumb.jpg'">
							</div>
						</div>
						<div  class="small-5 columns">
							<div class="text grey" style="margin-bottom: 0p">
								<strong><?php echo $data['comment'.$i]['user_username'] ?></strong>
							</div>
							
						</div>
						<div  class="small-6 columns align-right">
							<div class="note grey-light">
								<?php echo $comment_Date ?>
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
			<?php } }
			else{ ?>
			<div class="box-singole-comment">
				<div class="row"><div  class="large-12 columns"><p class="grey">There are no Comment</p></div></div>
			</div>	
				
			<?php }?>
			<div class="row  ">
				<div  class="large-12 columns ">
					<form action="" class="box-write">
						<div class="">
							<div class="row  ">
								<div  class="small-9 columns ">
									<input type="text" class="post inline" placeholder="Write a comment" />
								</div>
								<div  class="small-3 columns ">
									<input type="button" class="comment-button inline" value="Comment"/>
								</div>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
	
-->
<div class="row">
	<div  class="small-12 columns ">
		
<div class="box-singole-comment">
				<div class='line'>
					<div class="row">
						<div  class="small-1 columns ">

							<div class="icon-header">
								<img src="../media/images/profilepicturethumb/photo1.jpg">
							</div>
						</div>
						<div  class="small-5 columns">
							<div class="text grey" style="margin-bottom: 0p">
								<strong>Nome Cognome</strong>
							</div>
						</div>
						<div  class="small-6 columns align-right">
							<div class="note grey-light">
								Venerdì 16 maggio - ore 10.15
							</div>
						</div>
					</div>
				</div>

				<div class="row ">
					<div  class="small-12 columns ">
						<div class="row ">
							<div  class="small-12 columns ">
								<div class="text grey">
									Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu est dui. Etiam eu elit at lacus eleifend consectetur. Curabitur dolor diam, fringilla quis dignissim eget, tempus et lectus.
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="box-singole-comment">
				<div class='line'>
					<div class="row">
						<div  class="small-1 columns ">

							<div class="icon-header">
								<img src="../media/images/profilepicturethumb/photo3.jpg">
							</div>
						</div>
						<div  class="small-5 columns">
							<div class="text grey" style="margin-bottom: 0p">
								<strong>Nome Cognome</strong>
							</div>
						</div>
						<div  class="small-6 columns align-right">
							<div class="note grey-light">
								Venerdì 16 maggio - ore 10.15
							</div>
						</div>
					</div>
				</div>

				<div class="row ">
					<div  class="small-12 columns ">
						<div class="row ">
							<div  class="small-12 columns ">
								<div class="text grey">
									Phasellus eu est dui. Etiam eu elit at lacus eleifend consectetur.
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="row  ">
				<div  class="large-12 columns ">
					<form action="" class="box-write">
						<div class="">
							<div class="row  ">
								<div  class="small-9 columns ">
									<input type="text" class="post inline" placeholder="Write a comment" />
								</div>
								<div  class="small-3 columns ">
									<input type="button" class="comment-button inline" value="Comment"/>
								</div>
							</div>
						</div>

					</form>
				</div>
			</div>
			</div>
			</div>