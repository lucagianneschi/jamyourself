
<div id="profile" class="large-6 columns hcento">
	<!---------  NAME USER  --------------------->
	<div class="row">
		<div class="large-12 columns">
			<h2>Jammer</h2>			
			<div class="row">
				<div class="small-12 columns">
					<a class="ico-label _note">Hard Rock</a>
					<a class="ico-label _pin">Saluzzo (CN)</a>
				</div>				
			</div>		
		</div>
	</div>
	<div class="row">
		<div  class="large-12 columns"><div class="line"></div></div>
	</div>	
	<!--PROFILO COPERTINA -->				
	<div class="row">
		<div class="large-12 columns">
			<img class="avatar" src="images/avatar/avatar.png">
		</div>
	</div> 
	<!--fine profilo copertina-->
	
	<!--------- INFORMATION --------------------->
	<div class="row">
		<div class="large-12 columns">
		<h3>Information</h3>		
			<div class="section-container accordion" data-section="accordion">
			  <section class="active">
			  	<!--------------------------------- ABOUT ---------------------------------------------------->
			    <p class="title" data-section-title><a href="#">About</a></p>
			    <div class="content" data-section-content>
			      <p id="text grey">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus eu est dui. Etiam eu elit at lacus eleifend consectetur. Curabitur dolor diam, fringilla quis dignissim eget, tempus et lectus. Quisque sollicitudin laoreet tincidunt. In pretium massa quis diam dignissim dapibus. Donec sed mi mauris, a mollis nibh. Mauris et arcu eu quam mollis convallis ultricies id lacus. Donec dignissim sollicitudin nunc ultrices consectetur. </p>
			    </div>
			    <div class="content" data-section-content>
			    	<div class="row">
			    		<div class="small-6 columns">
			    			<div class="row">
			    				<div class="small-12 columns">
			    					<a class="ico-label _note white">Hard Rock - Indie Rock - Dub</a>
			    				</div>	
			    			</div>
			    			<div class="row">
			    				<div class="small-12 columns">
			    					<a class="ico-label _pin white">Torino (CN)</a>
			    				</div>	
			    			</div>
			    			
			    		</div>
			    		<div class="small-6 columns">
			    			<div class="row">
			    				<div class="small-12 columns">
			    					<a class="ico-label _facebook">fb.com/jammer</a>
			    				</div>	
			    			</div>
			    			<div class="row">
			    				<div class="small-12 columns">
			    					<a class="ico-label _twitter">@jammer</a>
			    				</div>	
			    			</div>
			    			<div class="row">
			    				<div class="small-12 columns">
			    					<a class="ico-label _google">jammer</a>
			    				</div>	
			    			</div>
			    			<div class="row">
			    				<div class="small-12 columns">
			    					<a class="ico-label _youtube">nome jammer</a>
			    				</div>	
			    			</div>
			    			<div class="row">
			    				<div class="small-12 columns">
			    					<a class="ico-label _web">www.jammer.com</a>
			    				</div>	
			    			</div>
			    		</div>		
			    	</div>
			    </div>			    
			  </section>
			  <!--------------------------------------- MEMBRES --------------------------------------->
			  <section>
			    <p class="title" data-section-title><a href="#">Membres</a></p>
			    <div class="content" data-section-content>
				     <div class="row">
	    				<div class="small-6 columns">
	    					<div class="box-membre">
	    						<span class="text white">Member name</span></br>
	    						<span class="note grey">Drummer</span>
	    					</div>
	    					<div class="box-membre">
	    						<span class="text white">Member name</span></br>
	    						<span class="note grey">Guitarist</span>
	    					</div>
	    					<div class="box-membre">
	    						<span class="text white">Member name</span></br>
	    						<span class="note grey">Sax</span>
	    					</div>
	    				</div>
	    				<div class="small-6 columns">
	    					<div class="box-membre">
	    						<span class="text white">Member name</span></br>
	    						<span class="note grey">Singer</span>
	    					</div>
	    					<div class="box-membre">
	    						<span class="text white">Member name</span></br>
	    						<span class="note grey">Percussionist</span>
	    					</div>
	    					
	    				</div>		
	    			</div>	    			
			    </div>
			  </section>
			</div>
		</div>
	</div>
	
	<!----------------------------------------- PLAYER ALBUM ----------------------------------------------->
	<div class="row">
		<div class="large-12 columns">
		<h3>Player</h3>
		<!---------------------------- LISTA ALBUM --------------------------------------------->
		<div class="box" id="album-list">
			<div class="row box-album">
				<div class="large-12 columns">
					<div class="text white">Album List</div>
				</div>
			</div>
			<!---------------------------- PRIMO ALBUM ----------------------------------------------->
			<div id="album01"> <!------------------ CODICE ALBUM: album01 - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
				<div class="row album box-album">
					<div class="small-4 columns">
						<img class="album-thumb album-select" src="images/albumcoverthumb/albumThumbnail.jpg" onclick="albumSelect('album01')">
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
						
						<div class="row propriety">
							<div class="large-12 colums">
								<a class="icon-propriety _love orange">32</a>
								<a class="icon-propriety _comment">372</a>
								<a class="icon-propriety _shere">15</a>
								<a class="icon-propriety _review">5</a>
							</div>
						</div>
					</div>
				</div>				
			</div>
			<!---------------------------- SECONDO ALBUM ----------------------------------------------->
			<div id="album02"> <!------------------ CODICE ALBUM: album02 - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
				<div class="row album box-album">
					<div class="small-4 columns">
						<img class="album-thumb album-select" src="images/albumcoverthumb/albumThumbnail2.jpg" onclick="albumSelect('album02')">
					</div>
					<div class="small-8 columns">						
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white album-select" onclick="albumSelect('album02')">Lads Who Lunch Talk</div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="text grey album-player-info">Informazioni su questo album</div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="note grey album-player-data">Recorded giugno 2011</div>
							</div>
						</div>
						
						<div class="row propriety">
							<div class="large-12 colums">
								<a class="icon-propriety _love orange">1142</a>
								<a class="icon-propriety _comment">452</a>
								<a class="icon-propriety _shere">40</a>
								<a class="icon-propriety _review">1</a>
							</div>
						</div>
					</div>
				</div>				
			</div>
			<!---------------------------- TERZO ALBUM ----------------------------------------------->
			<div id="album03"> <!------------------ CODICE ALBUM: album03 - inserire anche nel paramatro della funzione albumSelect ------------------------------------>
				<div class="row album box-album">
					<div class="small-4 columns">
						<img class="album-thumb album-select" src="images/albumcoverthumb/albumThumbnail3.jpg" onclick="albumSelect('album03')">
					</div>
					<div class="small-8 columns">						
						<div class="row">
							<div class="large-12 colums">
								<div class="sottotitle white album-select" onclick="albumSelect('album03')">Not For Sale</div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="text grey album-player-info">Informazioni su questo album</div>
							</div>
						</div>
						<div class="row">
							<div class="large-12 colums">
								<div class="note grey album-player-data">Recorded giugno 2010</div>
							</div>
						</div>
						
						<div class="row propriety">
							<div class="large-12 colums">
								<a class="icon-propriety _love orange">1000</a>
								<a class="icon-propriety _comment">14</a>
								<a class="icon-propriety _shere">74</a>
								<a class="icon-propriety _review">3</a>
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
					<img class="album-thumb album-select" src="images/albumcoverthumb/albumThumbnail.jpg" onclick="albumSelect('album01')">
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
						<div class="small-3 columns track-propriety">					
							<a class="icon-propriety _menu-small note orange "> add to playlist</a>					
						</div>		
					</div>
					<div class="row track-propriety">
						<div class="small-5 columns ">
							<a class="note white">Love</a>
							<a class="note white">Shere</a>	
						</div>
						<div class="small-5 columns propriety ">					
							<a class="icon-propriety _love orange">32</a>
							<a class="icon-propriety _shere">15</a>			
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
						<div class="small-3 columns track-propriety">					
							<a class="icon-propriety _menu-small note orange "> add to playlist</a>					
						</div>		
					</div>
					<div class="row track-propriety">
						<div class="small-5 columns ">
							<a class="note white">Love</a>
							<a class="note white">Shere</a>	
						</div>
						<div class="small-5 columns propriety ">					
							<a class="icon-propriety _love orange">2</a>
							<a class="icon-propriety _shere">4</a>			
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
						<div class="small-3 columns track-propriety">					
							<a class="icon-propriety _menu-small note orange "> add to playlist</a>					
						</div>		
					</div>
					<div class="row track-propriety">
						<div class="small-5 columns ">
							<a class="note white">Love</a>
							<a class="note white">Shere</a>	
						</div>
						<div class="small-5 columns propriety ">					
							<a class="icon-propriety _love orange">10</a>
							<a class="icon-propriety _shere">5</a>			
						</div>		
					</div>
				</div>
			</div>
			<div class="row album-single-propriety">
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
	</div>
	
	<!----------------------------------- EXIBITIONS -------------------------------------------------->
	<div class="row">
		<div class="large-12 columns ">
			<h3>Exibitions</h3>
			<!------------------------------------ LISTA ESIBIZIONI --------------------------------------->
			<div class="box" id="exibitions-list">
				<!----------------------------------- PRIMA ESIBIZIONE ------------------------------------>
				<div class="row">				
					<div class="small-12 columns box-coveralbum">
						<div class="small-4 columns event">
							<img class="eventcover" src="images/image/photo4.jpg">
						</div>
						<div class="small-8 columns">						
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle white ">Nome venue locale</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle grey ">Titolo Evento - Happy Hour</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle white ">Featuring Nome jammer</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<a class="ico-label _calendar inline text grey">Sabato 18 maggio - ore 22.30 </a>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<a class="ico-label _pin inline text grey">Torino TO - Via Roma, 224 / B </a>
								</div>
							</div>		
						</div>
					</div>
				</div>
				<div class="row album-single-propriety">					
					<div class="small-7 columns ">
						<a class="icon-propriety _menu-small note orange "> Add to Calendar</a>	
						<a class="note white">Love</a>
						<a class="note white">Comment</a>
						<a class="note white">Shere</a>
						<a class="note white">Review</a>	
					</div>
					<div class="small-5 columns propriety ">					
						<a class="icon-propriety _unlove grey">25</a>
						<a class="icon-propriety _comment">10</a>
						<a class="icon-propriety _shere">1</a>
						<a class="icon-propriety _review">0</a>		
					</div>		
				</div>
				<!------------------------------ SECONDO ESIBIZIONE --------------------------------->
				<div class="row">				
					<div class="small-12 columns box-coveralbum">
						<div class="small-4 columns event">
							<img class="eventcover" src="images/image/photo5.jpg">
						</div>
						<div class="small-8 columns">						
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle white ">Nome venue locale</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle grey ">Titolo Evento - Happy Hour</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle white ">Featuring Nome jammer</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<a class="ico-label _calendar inline text grey">Sabato 18 maggio - ore 22.30 </a>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<a class="ico-label _pin inline text grey">Torino TO - Via Roma, 224 / B </a>
								</div>
							</div>		
						</div>
					</div>
				</div>
				<div class="row album-single-propriety">					
					<div class="small-7 columns ">
						<a class="icon-propriety _menu-small note orange "> Add to Calendar</a>	
						<a class="note white">Love</a>
						<a class="note white">Comment</a>
						<a class="note white">Shere</a>
						<a class="note white">Review</a>	
					</div>
					<div class="small-5 columns propriety ">					
						<a class="icon-propriety _unlove grey">25</a>
						<a class="icon-propriety _comment">10</a>
						<a class="icon-propriety _shere">1</a>
						<a class="icon-propriety _review">0</a>		
					</div>		
				</div>
				<!------------------------------------------- TERZA ESIBIZIONE ------------------------------------->
				<div class="row">				
					<div class="small-12 columns box-coveralbum">
						<div class="small-4 columns event">
							<img class="eventcover" src="images/image/photo6.jpg">
						</div>
						<div class="small-8 columns">						
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle white ">Nome venue locale</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle grey ">Titolo Evento - Happy Hour</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<div class="sottotitle white ">Featuring Nome jammer</div>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<a class="ico-label _calendar inline text grey">Sabato 18 maggio - ore 22.30 </a>
								</div>
							</div>
							<div class="row">
								<div class="large-12 colums">
									<a class="ico-label _pin inline text grey">Torino TO - Via Roma, 224 / B </a>
								</div>
							</div>		
						</div>
					</div>
				</div>
				<div class="row album-single-propriety">					
					<div class="small-7 columns ">
						<a class="icon-propriety _menu-small note orange "> Add to Calendar</a>	
						<a class="note white">Love</a>
						<a class="note white">Comment</a>
						<a class="note white">Shere</a>
						<a class="note white">Review</a>	
					</div>
					<div class="small-5 columns propriety ">					
						<a class="icon-propriety _unlove grey">25</a>
						<a class="icon-propriety _comment">10</a>
						<a class="icon-propriety _shere">1</a>
						<a class="icon-propriety _review">0</a>		
					</div>		
				</div>				
			</div>
		</div>
	</div>			
	<!----------------------------------- Photography -------------------------------------------------->
	<div class="row">
		<div class="large-12 columns ">
		<h3>Photography</h3>
		<!-------------------------------------- LIST ALBUM PHOTO -------------------------------->
		<div class="box" id="albumcover-list">
			<div class="row">				
				<div class="small-6 columns box-coveralbum">
					<img class="albumcover" src="images/albumcover/albumcover.jpg" onclick="albumcover('albumcover01')">  <!----------- codice: albumcover01 ------------->
					<div class="text white">Titolo del set di fotografie</div>
					<div class="row">
						<div class="small-5 columns ">
							<a class="note grey">16 Foto</a>								
						</div>
						<div class="small-7 columns propriety ">					
							<a class="icon-propriety _love orange">25</a>
							<a class="icon-propriety _comment">10</a>
							<a class="icon-propriety _shere">1</a>	
						</div>		
					</div>
				</div>
				<div class="small-6 columns box-coveralbum">
					<img class="albumcover" src="images/albumcover/albumcover2.jpg" onclick="albumcover('albumcover02')">
					<div class="text white">Titolo del set di fotografie</div>
					<div class="row">
						<div class="small-5 columns ">
							<a class="note grey">16 Foto</a>								
						</div>
						<div class="small-7 columns propriety ">					
							<a class="icon-propriety _unlove grey">45</a>
							<a class="icon-propriety _comment">25</a>
							<a class="icon-propriety _shere">5</a>	
						</div>		
					</div>
				</div>
			</div>
			<div class="row">
				<div class="small-6 columns box-coveralbum">
					<img class="albumcover" src="images/albumcover/albumcover2.jpg" onclick="albumcover('albumcover03')">
					<div class="text white">Titolo del set di fotografie</div>
					<div class="row">
						<div class="small-5 columns ">
							<a class="note grey">16 Foto</a>								
						</div>
						<div class="small-7 columns propriety ">					
							<a class="icon-propriety _unlove grey">2</a>
							<a class="icon-propriety _comment">1</a>
							<a class="icon-propriety _shere">0</a>	
						</div>		
					</div>
				</div>
				<div class="small-6 columns box-coveralbum">
					<img class="albumcover" src="images/albumcover/albumcover3.jpg" onclick="albumcover('albumcover04')">
					<div class="text white">Titolo del set di fotografie</div>
					<div class="row">
						<div class="small-5 columns ">
							<a class="note grey">16 Foto</a>								
						</div>
						<div class="small-7 columns propriety ">					
							<a class="icon-propriety _love orange">245</a>
							<a class="icon-propriety _comment">201</a>
							<a class="icon-propriety _shere">54</a>	
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
			<ul class="small-block-grid-3 clearing-thumbs" data-clearing>
			  <li><img class="photo" src="images/image/photo4.jpg"></li>
			  <li><img class="photo" src="images/image/photo5.jpg"></li>
			  <li><img class="photo" src="images/image/photo6.jpg"></li>
			  <li><img class="photo" src="images/image/photo5.jpg"></li>
			  <li><img class="photo" src="images/image/photo6.jpg"></li>
			  <li><img class="photo" src="images/image/photo4.jpg"></li>
			  <li><img class="photo" src="images/image/photo6.jpg"></li>
			  <li><img class="photo" src="images/image/photo5.jpg"></li>
			  <li><img class="photo" src="images/image/photo4.jpg"></li>
			</ul>		
			 
			<div class="row album-single-propriety">
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
