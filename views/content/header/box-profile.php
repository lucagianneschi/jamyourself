<?php

$data = $_POST['data'];
$titlePlayList =  $data['playlist']['name'];
$tracklist = $data['playlist']['tracklist'];
?>
<div class="row">
	<div  class="small-6 columns hide-for-small">
		<h3><?php echo $titlePlayList ?></h3>									
	</div>
	<div  class="small-6 columns hide-for-small">
		<h3>Temporaney</h3>
		<div class="row">
			<div  class="large-6 columns">
				<div class="text white" style="margin-bottom: 15px;">Now Playing</div>
			</div>	
		</div>
	</div>	
</div>

<div class="row">
	<div  class="small-12 columns">
		<!------------ HEADER HIDE PROFILE ------------------------------------>
		<div class="row">
			<!------------ PLAYLIST ------------------------------------>
			<div  class="small-6 columns">				
			<?php 
			if(count($tracklist) > 0){
			foreach ($tracklist as $key => $value) { 
				$author_name = $value['author']['username'];
				$author_objectId = $value['author']['objectId'];
				$thumbnail = $value['thumbnail'];
				$title = $value['title'];
				?>				
				<div class="row">
					<div  class="large-2 columns hide-for-small">
						<div class="icon-header">
							<img src="../media/<?php echo $thumbnail ?>" onerror="this.src='../media/images/default/defaultAlbumcoverthumb.jpg'">
						</div>
					</div>
					<div  class="large-10 columns ">
						<label class="text grey inline"><?php echo ($key+1).'. '.$title.' - '.$author_name; ?></label>									
					</div>
				</div>
				<div class="row">
					<div  class="large-12 columns"><div class="line"></div></div>
				</div>
			<?php }} ?>				
			</div>
			<!------------ FINE PLAYLIST ------------------------------------>
			<!------------ PLAYLIST TEMPORANEY ------------------------------------>
			<div  class="small-6 columns">
				<div class="row">
					<div  class="large-2 columns hide-for-small">
						<div class="icon-header">
							<img src="../media/images/albumcoverthumb/albumThumbnail.jpg">
						</div>
					</div>
					<div  class="large-10 columns">
						<label class="text grey inline">01. Titolo Traccia - Gallows</label>									
					</div>
				</div>
				<div class="row">
					<div  class="large-12 columns"><div class="line"></div></div>
				</div>
				<div class="row">
					<div  class="large-2 columns hide-for-small">
						<div class="icon-header">
							<img src="../media/images/albumcoverthumb/albumThumbnail2.jpg">
						</div>
					</div>
					<div  class="large-10 columns">
						<label class="text grey inline">02. Titolo Traccia - Gallows</label>									
					</div>
				</div>
				<div class="row">
					<div  class="large-12 columns"><div class="line"></div></div>
				</div>		
			</div>
			<!------------ FINE PLAYLIST TEMPORANEY ------------------------------------>
		</div>
	</div>
</div>	
