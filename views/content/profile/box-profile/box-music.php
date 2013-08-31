<?php
/* box per gli album musicali
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId},
 * data-type: html,
 * type: POST o GET
 *
 * box solo per jammer
 */

$album1_cover = "albumThumbnail.jpg";
$album1_objectId = "albumcover01";
$album1_title = "In The Belly Of A Shark";
$album1_info = "Informazioni su questo album";
$album1_data = "Recorded giugno 2012";
$album1_totPhoto = "6";

$album1_love = "5";
$album1_comment = "2";
$album1_shere = "0";
$album1_review = "2";
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
		<!---------------------------- PRIMO ALBUM ----------------------------------------------->
		<div id="<?php echo $album1_objectId ?>"> <!------------------ CODICE ALBUM: $album1_objectId - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
			<div class="row album box-album">
				<div class="small-4 columns">
					<img class="album-thumb album-select" src="../media/images/albumcoverthumb/<?php echo $album1_cover ?>">
				</div>
				<div class="small-8 columns">						
					<div class="row">
						<div class="large-12 colums">
							<div class="sottotitle white album-select" ><?php echo $album1_title ?></div>
						</div>
					</div>
					<div class="row">
						<div class="large-12 colums">
							<div class="note grey album-player-data"><?php echo $album1_data ?></div>
						</div>
					</div>
					<div class="row">
						<div class="large-12 colums">
							<div class="play_now"><a class="ico-label _play_white white" onclick="albumSelect('<?php echo $album1_objectId ?>')">Play Now</a></div>
						</div>
					</div>
					
					<div class="row propriety">
						<div class="large-12 colums">
							<a class="icon-propriety _love orange"><?php echo $album1_love ?></a>
							<a class="icon-propriety _comment"><?php echo $album1_comment ?></a>
							<a class="icon-propriety _shere"><?php echo $album1_shere ?></a>
							<a class="icon-propriety _review"><?php echo $album1_review ?></a>
						</div>
					</div>
				</div>
			</div>				
		</div>
		<!---------------------------- SECONDO ALBUM ----------------------------------------------->
		<div id="<?php echo $album1_objectId ?>"> <!------------------ CODICE ALBUM: $album1_objectId - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
			<div class="row album box-album">
				<div class="small-4 columns">
					<img class="album-thumb album-select" src="../media/images/albumcoverthumb/<?php echo $album1_cover ?>" >
				</div>
				<div class="small-8 columns">						
					<div class="row">
						<div class="large-12 colums">
							<div class="sottotitle white album-select"><?php echo $album1_title ?></div>
						</div>
					</div>
					
					<div class="row">
						<div class="large-12 colums">
							<div class="note grey album-player-data"><?php echo $album1_data ?></div>
						</div>
					</div>
					<div class="row">
						<div class="large-12 colums">
							<div class="play_now"><a class="ico-label _play_white white" onclick="albumSelect('<?php echo $album1_objectId ?>')">Play Now</a></div>
						</div>
					</div>
					<div class="row propriety">
						<div class="large-12 colums">
							<a class="icon-propriety _love orange"><?php echo $album1_love ?></a>
							<a class="icon-propriety _comment"><?php echo $album1_comment ?></a>
							<a class="icon-propriety _shere"><?php echo $album1_shere ?></a>
							<a class="icon-propriety _review"><?php echo $album1_review ?></a>
						</div>
					</div>
				</div>
			</div>				
		</div>
		<!---------------------------- TERZO ALBUM ----------------------------------------------->
		<div id="<?php echo $album1_objectId ?>"> <!------------------ CODICE ALBUM: $album1_objectId - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
			<div class="row album box-album">
				<div class="small-4 columns">
					<img class="album-thumb album-select" src="../media/images/albumcoverthumb/<?php echo $album1_cover ?>" >
				</div>
				<div class="small-8 columns">						
					<div class="row">
						<div class="large-12 colums">
							<div class="sottotitle white album-select" ><?php echo $album1_title ?></div>
						</div>
					</div>
					<div class="row">
						<div class="large-12 colums">
							<div class="note grey album-player-data"><?php echo $album1_data ?></div>
						</div>
					</div>
					<div class="row">
						<div class="large-12 colums">
							<div class="play_now"><a class="ico-label _play_white white" onclick="albumSelect('<?php echo $album1_objectId ?>')">Play Now</a></div>
						</div>
					</div>
					
					<div class="row propriety">
						<div class="large-12 colums">
							<a class="icon-propriety _love orange"><?php echo $album1_love ?></a>
							<a class="icon-propriety _comment"><?php echo $album1_comment ?></a>
							<a class="icon-propriety _shere"><?php echo $album1_shere ?></a>
							<a class="icon-propriety _review"><?php echo $album1_review ?></a>
						</div>
					</div>
				</div>
			</div>				
		</div>
		<div class="row album-other">
			<div class="large-12 colums">
				<div class="text">Other  4 Album</div>	
			</div>	
		</div>	
	</div>	
	
	<!---------------------------- ALBUM SINGOLO --------------------------------------------->
	<div class="box no-display" id="album-single">
		<div class="row box-album">
			<div class="large-12 columns">					
				<a class="ico-label _back_page text white">Back to Album List</a>
			</div>
		</div>
		<div class="row album box-album">
			<div class="small-4 columns">
				<img class="album-thumb album-select" src="../media/images/albumcoverthumb/albumThumbnail.jpg" onclick="albumSelect('album01')">
			</div>
			<div class="small-8 columns">						
				<div class="row">
					<div class="large-12 colums">
						<div class="sottotitle white album-select" onclick="albumSelect('album01')">In The Belly Of A Shark</div>
					</div>
				</div>
				<div class="row">
					<div class="large-12 colums">
						<div class="text grey album-player-info">Informazioni su questo album</div>
					</div>
				</div>
				<div class="row">
					<div class="large-12 colums">
						<div class="note grey album-player-data">Recorded giugno 2012</div>
					</div>
				</div>
				
				
			</div>
		</div>
		<div class="row track" id="track01"> <!------------------ CODICE TRACCIA: track01  ------------------------------------>
			<div class="small-12 columns ">
			
				<div class="row">
					<div class="small-9 columns ">					
						<a class="ico-label _play-large text ">01. Titolo traccia</a>
					</div>
					<div class="small-3 columns track-propriety align-right">					
						<a class="icon-propriety _menu-small note orange "> add to playlist</a>					
					</div>		
				</div>
				<div class="row track-propriety">
					<div class="box-propriety">
						<div class="small-5 columns ">
							<a class="note white">Unlove</a>
							<a class="note white">Shere</a>	
						</div>
						<div class="small-5 columns propriety ">					
							<a class="icon-propriety _love orange">32</a>
							<a class="icon-propriety _shere">15</a>			
						</div>
					</div>		
				</div>
			</div>
		</div>
		<div class="row track" id="track02">
			<div class="small-12 columns ">
			
				<div class="row">
					<div class="small-9 columns ">					
						<a class="ico-label _play-large text ">02. Titolo traccia</a>
					</div>
					<div class="small-3 columns track-propriety align-right">					
						<a class="icon-propriety _menu-small note orange "> add to playlist</a>					
					</div>		
				</div>
				<div class="row track-propriety">
					<div class="box-propriety">
						<div class="small-5 columns ">
							<a class="note white">Love</a>
							<a class="note white">Shere</a>	
						</div>
						<div class="small-5 columns propriety ">					
							<a class="icon-propriety _unlove grey">2</a>
							<a class="icon-propriety _shere">4</a>			
						</div>
					</div>		
				</div>
			</div>
		</div>
		<div class="row track" id="track03">
			<div class="small-12 columns ">
			
				<div class="row">
					<div class="small-9 columns ">					
						<a class="ico-label _play-large text ">03. Titolo traccia</a>
					</div>
					<div class="small-3 columns track-propriety align-right">					
						<a class="icon-propriety _menu-small note orange "> add to playlist</a>					
					</div>		
				</div>
				<div class="row track-propriety">
					<div class="box-propriety">
						<div class="small-5 columns ">
							<a class="note white">Unlove</a>
							<a class="note white">Shere</a>	
						</div>
						<div class="small-5 columns propriety ">					
							<a class="icon-propriety _love orange">10</a>
							<a class="icon-propriety _shere">5</a>			
						</div>
					</div>		
				</div>
			</div>
		</div>
		<div class="row album-single-propriety">
			<div class="box-propriety">
				<div class="small-6 columns ">
					<a class="note white">Love</a>
					<a class="note white">Comment</a>
					<a class="note white">Shere</a>
					<a class="note white">Review</a>	
				</div>
				<div class="small-6 columns propriety ">					
					<a class="icon-propriety _unlove grey">25</a>
					<a class="icon-propriety _comment">10</a>
					<a class="icon-propriety _shere">1</a>
					<a class="icon-propriety _review">0</a>	
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
	