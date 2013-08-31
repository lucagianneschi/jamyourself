<?php
/* box per gli album fotografici
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId},
 * data-type: html,
 * type: POST o GET
 *
 * box uguale per tutti gli utenti
 */

$album1_cover = "albumcover.jpg";
$album1_objectId = "albumcover01";
$album1_title = "Titolo del set di fotografie";
$album1_totPhoto = "6";

$album1_love = "5";
$album1_comment = "2";
$album1_shere = "0";

$id_photo1 = "photo1";
$id_photo2 = "photo2";
$id_photo3 = "photo3";
$id_photo4 = "photo4";
$id_photo5 = "photo5";
$id_photo6 = "photo6";
$id_photo7 = "photo7";
$id_photo8 = "photo8";
$id_photo9 = "photo9";
?>
<!----------------------------------- Photography -------------------------------------------------->
<div class="row">
	<div class="large-12 columns ">
	<h3>Photography</h3>
	<!-------------------------------------- LIST ALBUM PHOTO -------------------------------->
	<div class="box" id="albumcover-list">
		<div class="row">				
			<div class="small-6 columns box-coveralbum">
				<img class="albumcover" src="../media/images/albumcover/<?php echo $album1_cover; ?>" onclick="albumcover('<?php echo $album1_objectId; ?>')">  <!----------- codice: albumcover01 ------------->
				<div class="text white"><?php echo $album1_title; ?></div>
				<div class="row">
					<div class="small-5 columns ">
						<a class="note grey"><?php echo $album1_totPhoto; ?> Foto</a>								
					</div>
					<div class="small-7 columns propriety ">					
						<a class="icon-propriety _love orange"><?php echo $album1_love; ?></a>
						<a class="icon-propriety _comment"><?php echo $album1_comment; ?></a>
						<a class="icon-propriety _shere"><?php echo $album1_shere; ?></a>	
					</div>		
				</div>
			</div>
			<div class="small-6 columns box-coveralbum">
				<img class="albumcover" src="../media/images/albumcover/<?php echo $album1_cover; ?>" onclick="albumcover('<?php echo $album1_objectId; ?>')">  <!----------- codice: albumcover01 ------------->
				<div class="text white"><?php echo $album1_title; ?></div>
				<div class="row">
					<div class="small-5 columns ">
						<a class="note grey"><?php echo $album1_totPhoto; ?> Foto</a>								
					</div>
					<div class="small-7 columns propriety ">					
						<a class="icon-propriety _love orange"><?php echo $album1_love; ?></a>
						<a class="icon-propriety _comment"><?php echo $album1_comment; ?></a>
						<a class="icon-propriety _shere"><?php echo $album1_shere; ?></a>	
					</div>		
				</div>
			</div>
		</div>
		<div class="row">
			<div class="small-6 columns box-coveralbum">
				<img class="albumcover" src="../media/images/albumcover/<?php echo $album1_cover; ?>" onclick="albumcover('<?php echo $album1_objectId; ?>')">  <!----------- codice: albumcover01 ------------->
				<div class="text white"><?php echo $album1_title; ?></div>
				<div class="row">
					<div class="small-5 columns ">
						<a class="note grey"><?php echo $album1_totPhoto; ?> Foto</a>								
					</div>
					<div class="small-7 columns propriety ">					
						<a class="icon-propriety _love orange"><?php echo $album1_love; ?></a>
						<a class="icon-propriety _comment"><?php echo $album1_comment; ?></a>
						<a class="icon-propriety _shere"><?php echo $album1_shere; ?></a>	
					</div>		
				</div>
			</div>
			<div class="small-6 columns box-coveralbum">
				<img class="albumcover" src="../media/images/albumcover/<?php echo $album1_cover; ?>" onclick="albumcover('<?php echo $album1_objectId; ?>')">  <!----------- codice: albumcover01 ------------->
				<div class="text white"><?php echo $album1_title; ?></div>
				<div class="row">
					<div class="small-5 columns ">
						<a class="note grey"><?php echo $album1_totPhoto; ?> Foto</a>								
					</div>
					<div class="small-7 columns propriety ">					
						<a class="icon-propriety _love orange"><?php echo $album1_love; ?></a>
						<a class="icon-propriety _comment"><?php echo $album1_comment; ?></a>
						<a class="icon-propriety _shere"><?php echo $album1_shere; ?></a>	
					</div>		
				</div>
			</div>
		</div>
		<div class="row album-other">
			<div class="large-12 colums">
				<div class="text">Other 2 Set</div>	
			</div>	
		</div>
	</div>
	
	<!----------------------------------------- ALBUM PHOTO SINGLE ------------------------------>
	<div class="box no-display" id="albumcover-single">
		<div class="row box-album">
			<div class="large-12 columns">					
				<a class="ico-label _back_page text white">Back to Set</a>
			</div>
		</div>
		<ul class="small-block-grid-3 small-block-grid-2 ">			
		  <li><img data-reveal-id='<?php echo $id_photo1; ?>' data-reveal-ajax="./content/profile/box-profile/box-photoslide.php" class=" photo" src="../media/images/image/photo4.jpg"></li>
		  <li><img data-reveal-id='<?php echo $id_photo2; ?>' class=" photo" src="../media/images/image/photo5.jpg"></li>
		  <li><img data-reveal-id='<?php echo $id_photo3; ?>' class=" photo" src="../media/images/image/photo6.jpg"></li>
		  <li><img data-reveal-id='<?php echo $id_photo4; ?>' class=" photo" src="../media/images/image/photo5.jpg"></li>
		  <li><img data-reveal-id='<?php echo $id_photo5; ?>' class=" photo" src="../media/images/image/photo6.jpg"></li>
		  <li><img data-reveal-id='<?php echo $id_photo6; ?>' class=" photo" src="../media/images/image/photo4.jpg"></li>
		  <li><img data-reveal-id='<?php echo $id_photo7; ?>' class=" photo" src="../media/images/image/photo6.jpg"></li>
		  <li><img data-reveal-id='<?php echo $id_photo8; ?>' class=" photo" src="../media/images/image/photo5.jpg"></li>
		  <li><img data-reveal-id='<?php echo $id_photo9; ?>' class=" photo" src="../media/images/image/photo4.jpg"></li>
		</ul>		
			
		<div class="row album-single-propriety">
			 <div class="box-propriety">
				<div class="small-6 columns ">
					<a class="note white">Love</a>
					<a class="note white">Comment</a>
					<a class="note white">Shere</a>	
				</div>
				<div class="small-6 columns propriety ">					
					<a class="icon-propriety _unlove grey">48</a>
					<a class="icon-propriety _comment">3</a>
					<a class="icon-propriety _shere">7</a>	
				</div>
			</div>		
		</div>	
	</div>
	<div class="box-comment no-display">
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
</div>