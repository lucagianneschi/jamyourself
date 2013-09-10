<?php
/* box per gli album musicali
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId},
 * data-type: html,
 * type: POST o GET
 *
 * box solo per jammer
 */

$data = $_POST['data'];
$typeUser = $_POST['typeUser'];
$recordCounter = $data['recordCounter'];
?>
<!----------------------------------------- PLAYER ALBUM ----------------------------------------------->
<div class="row">
	<div class="large-12 columns">
	<h3>Music</h3>
	<!---------------------------- LISTA ALBUM --------------------------------------------->
	<div class="box" id="album-list">
		<div class="row box-album">
			<div class="large-12 columns">
				<div class="text white">Album List</div>
			</div>
		</div>
		<div id="record" class="royalSlider rsMinW  ">
		<!---------------------------- PRIMO ALBUM ----------------------------------------------->
		<?php 
		$index = 0;
		for ($i=0; $i < $recordCounter ; $i++) {
			if($i % 3 == 0){
			?>
		<div class="rsContent">
			<?php
			
			for($j=0; $j<3;  $j++){
				if($index < $recordCounter){
					$record_thumbnailCover = $data['record'.$index]['thumbnailCover'];
					$record_objectId = $data['record'.$index]['objectId'];
					$record_title = $data['record'.$index]['title'];
					$record_data = $data['record'.$index]['year'];
					$record_songCounter = $data['record'.$index]['songCounter'];
					
					$record_love = $data['record'.$index]['counters']['loveCounter'];
					$record_comment = $data['record'.$index]['counters']['commentCounter'];
					$record_shere = $data['record'.$index]['counters']['shareCounter'];
					$record_review = $data['record'.$index]['counters']['reviewCounter'];			
			
		 ?>
			<div  id="<?php echo $record_objectId ?>" class="<?php echo 'record'.$index ?>"> <!------------------ CODICE ALBUM: $record_objectId - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
				<div class="row album box-album">
					<div class="small-4 columns">
						<img class="album-thumb album-select" src="../media/<?php echo $record_thumbnailCover ?>">
					</div>
					<div class="small-8 columns">						
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white album-select" ><?php echo $record_title ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="note grey album-player-data">Recorded <?php echo $record_data ?></div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="play_now"><a class="ico-label _play_white white" onclick="albumSelect('<?php echo $record_objectId ?>')">Play Now</a></div>
							</div>
						</div>
						
						<div class="row propriety">
							<div class="large-12 colums">
								<a class="icon-propriety _unlove grey"><?php echo $record_love ?></a>
								<a class="icon-propriety _comment" ><?php echo $record_comment ?></a>
								<a class="icon-propriety _shere" ><?php echo $record_shere ?></a>
								<a class="icon-propriety _review"><?php echo $record_review ?></a>
							</div>
						</div>
					</div>
				</div>				
			</div>
						
			<?php 
			$index++;
			}} ?>
			
		</div>
		
		<?php }} 
		
		?>
		</div>	
	</div>	
	
	<!---------------------------- ALBUM SINGOLO --------------------------------------------->
	<?php for($i=0; $i<$recordCounter;  $i++){ 
			$recordSingle_thumbnailCover = $data['record'.$i]['thumbnailCover'];
			$recordSingle_objectId = $data['record'.$i]['objectId'];
			$recordSingle_title = $data['record'.$i]['title'];
			$recordSingle_data = $data['record'.$i]['year'];
			$recordSingle_detail = $data['record'.$i]['recordDetail']['tracklist'];
			$recordSingle_love = $data['record'.$i]['counters']['loveCounter'];
			$recordSingle_comment = $data['record'.$i]['counters']['commentCounter'];
			$recordSingle_shere = $data['record'.$i]['counters']['shareCounter'];
			$recordSingle_review = $data['record'.$i]['counters']['reviewCounter'];	
		?>
	<div class="box no-display <?php echo $recordSingle_objectId ?>" >
		<div class="row box-album" onclick="albumSelectNext('<?php echo $recordSingle_objectId ?>')">
			<div class="large-12 columns">					
				<a class="ico-label _back_page text white">Back to Album List</a>
			</div>
		</div>
		<div class="row album box-album">
			<div class="small-4 columns">
				<img class="album-thumb album-select" src="../media/<?php echo $recordSingle_thumbnailCover ?>">
			</div>
			<div class="small-8 columns">						
				<div class="row">
					<div class="large-12 colums">
						<div class="sottotitle white album-select"><?php echo $recordSingle_title ?></div>
					</div>
				</div>				
				<div class="row">
					<div class="large-12 colums">
						<div class="note grey album-player-data">Recorded <?php echo $recordSingle_data ?></div>
					</div>
				</div>
				
				
			</div>
		</div>
		<?php if(count($recordSingle_detail)>0){ 
				foreach ($recordSingle_detail as $key => $value) {
					
				
		?>
		<div class="row track" id="<?php echo $value['objectId'] ?>"> <!------------------ CODICE TRACCIA: track01  ------------------------------------>
			<div class="small-12 columns ">
			
				<div class="row">
					<div class="small-9 columns ">					
						<a class="ico-label _play-large text "><?php echo $key+1 ?>. <?php echo $value['title'] ?></a>
					</div>
					<div class="small-3 columns track-propriety align-right">					
						<a class="icon-propriety _menu-small note orange "> add to playlist</a>	
						<a class="icon-propriety"> <?php echo $value['duration'] ?></a>					
					</div>		
				</div>
				<div class="row track-propriety" >
					<div class="box-propriety">
						<div class="small-5 columns ">
							<a class="note white" onclick="setCounter(this)">Love</a>
							<a class="note white" onclick="setCounter(this)">Shere</a>	
						</div>
						<div class="small-5 columns propriety ">					
							<a class="icon-propriety _unlove grey" ><?php echo $value['counters']['loveCounter'] ?></a>
							<a class="icon-propriety _shere" ><?php echo $value['counters']['shareCounter'] ?></a>			
						</div>
					</div>		
				</div>
			</div>
		</div>
		<?php }} ?>
		<div class="row album-single-propriety">
			<div class="box-propriety">
				<div class="small-6 columns ">
					<a class="note white" onclick="setCounter(this)">Love</a>
					<a class="note white" onclick="setCounter(this)">Comment</a>
					<a class="note white" onclick="setCounter(this)">Shere</a>
					<a class="note white" onclick="setCounter(this)">Review</a>	
				</div>
				<div class="small-6 columns propriety ">					
					<a class="icon-propriety _unlove grey" ><?php echo $recordSingle_love ?></a>
					<a class="icon-propriety _comment" ><?php echo $recordSingle_comment ?></a>
					<a class="icon-propriety _shere" ><?php echo $recordSingle_shere ?></a>
					<a class="icon-propriety _review"><?php echo $recordSingle_review ?></a>
				</div>	
			</div>		
		</div>	
	</div>
			
	<?php } ?>
	
	<!---------------------------------------- comment ------------------------------------------------->
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
	