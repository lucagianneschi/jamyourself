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
		<ul class=" large-block-grid-3 small-block-grid-2 clearing-thumbs" data-clearing>
		  <li><img class="photo" src="../media/images/image/photo4.jpg"></li>
		  <li><img class="photo" src="../media/images/image/photo5.jpg"></li>
		  <li><img class="photo" src="../media/images/image/photo6.jpg"></li>
		  <li><img class="photo" src="../media/images/image/photo5.jpg"></li>
		  <li><img class="photo" src="../media/images/image/photo6.jpg"></li>
		  <li><img class="photo" src="../media/images/image/photo4.jpg"></li>
		  <li><img class="photo" src="../media/images/image/photo6.jpg"></li>
		  <li><img class="photo" src="../media/images/image/photo5.jpg"></li>
		  <li><img class="photo" src="../media/images/image/photo4.jpg"></li>
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
	
	</div>	
</div>