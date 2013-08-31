<?php
/* box per elenco friend
 * box chiamato tramite ajax con:
 * data: {user: objectId}, 
 * data-type: html,
 * type: POST o GET
 * 
 * box 
 */
 
$albumReview_authorName = 'Nome Cognome';
$albumReview_authorImg = 'photo1.jpg';

$albumReview_albumImg = 'albumThumbnail.jpg';
$albumReview_albumTitle = 'Review Title';


?>

<!------------------------------------- Reviews ------------------------------------>
<div class="row" id="albumreviews">
	<div  class="large-12 columns">
	<h3>Album Reviews</h3>
	<div class="row  ">
		<div  class="large-12 columns ">
			<div class="box">
				<?php if($userType != "spotter"){ ?>
				<div class="row ">
					<div class="">						
						<div  class="small-1 columns ">
							<div class="userThumb">
								<img src="../media/images/profilepicturethumb/<?php echo $albumReview_authorImg?>">
							</div>
						</div>
						<div  class="small-11 columns">
							<div class="text grey" style="margin-left: 10px;"><strong><?php echo $albumReview_authorName?></strong></div>
						</div>	
					</div>
				</div>
				<div class="row">
					<div  class="large-12 columns"><div class="line"></div></div>
				</div>
				<?php }?>
				<div class="row">
					<div  class="small-2 columns ">
						<div class="coverThumb"><img src="../media/images/albumcoverthumb/<?php echo $albumReview_albumImg?>"></div>						
					</div>
					<div  class="small-8 columns ">
						<div class="row ">							
							<div  class="small-12 columns ">
								<div class="sottotitle grey-dark"><?php echo $albumReview_albumTitle?></div>
							</div>	
						</div>	
						<div class="row">						
							<div  class="small-12 columns ">
								<div class="note grey">Rating</div>
							</div>
						</div>
						<div class="row ">						
							<div  class="small-12 columns ">
								<a class="icon-propriety _star-orange"></a>
								<a class="icon-propriety _star-orange"></a>
								<a class="icon-propriety _star-orange"></a>
								<a class="icon-propriety _star-grey"></a>
								<a class="icon-propriety _star-grey"></a>
							</div>
						</div>													
					</div>
					<div  class="small-2 columns align-right viewAlbumReview">
						<a href="#" class="orange"> <strong>Read</strong></a>
					</div>				
				</div>
				
				<div class="textAlbumReview no-display">
					<div class="row ">						
						<div  class="small-12 columns ">
							<div class="text grey" id="">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu est dui. Etiam eu elit at lacus eleifend consectetur. Curabitur dolor diam, fringilla quis dignissim eget, tempus et lectus. Quisque sollicitudin laoreet tincidunt. In pretium massa quis diam dignissim dapibus. Donec sed mi mauris, a mollis nibh. Mauris et arcu eu quam mollis convallis ultricies id lacus. Donec dignissim sollicitudin nunc ultrices consectetur. Quisque eu mauris nisl, sed accumsan dolor. Duis mauris odio, semper eget convallis vel, tristique sit amet elit. Vestibulum id est velit. Nulla gravida, eros eu feugiat mollis, ante dui mollis augue, eu ullamcorper elit leo luctus augue. Donec quis tellus a ante rhoncus interdum non sed justo. Pellentesque suscipit pretium fringilla.
							</div>
						</div>
					</div>					
				</div>
				<div class="row">
					<div  class="large-12 columns"><div class="line"></div></div>
				</div>
				<div class="row">
					<div class="box-propriety">
					<div class="small-5 columns ">
						<a class="note grey">Unlove</a>
						<a class="note grey">Comment</a>
						<a class="note grey">Shere</a>	
					</div>
					<div class="small-5 columns propriety ">					
						<a class="icon-propriety _love orange">32</a>
						<a class="icon-propriety _comment ">32</a>
						<a class="icon-propriety _shere">15</a>			
					</div>
					</div>		
				</div>
				
			</div>	
		</div>
	</div>
	</div>
</div>	