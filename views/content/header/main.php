<header>
	<!------------------------------------- HIDE HEADER ----------------------------->
	<div id="header-hide" class="no-display">		
		<div  class="row hcento-hero">
			<div id="header-profile" class="small-6 columns"></div>			
			<div id="header-social" class="small-6 columns"></div>
		</div>	
	</div>
	
	<!------------------------------------- HEADER ----------------------------->
	<div id="header">
	<div  class="row">
		<div  class="large-12 columns">		
			<div class="row">				
				<div class="large-5 small-1 columns">
					<div class="header">
						<!------------------------------------- MENU ----------------------------->
						<div class="icon-header _menu" onClick="headerShow()"></div>
						<!------------------------------------- thumbnail album ----------------------------->			
						<div class="icon-header  hide-for-small">
							<img src="../media/images/albumcoverthumb/albumThumbnail.jpg">
						</div>				
					
						<!------------------------------------- PLAYER ----------------------------->
						<div id="player " class=" hide-for-small">
							<!---------- TITLE --------->
							<div class="title-player">In The Belly Of A Shark</div>
							<!---------- TIME MUSIC  --------->
							<small id="time-player" class="inline">0:58</small>
							
							<!---------- CONTROL --------->
							<div id="controls-player" class="inline">
								<div id="bar-player"  class="inline"></div>	
							   	<div id="playhead-player"  class="inline"></div>			   	
							    <div id="statusbar-player" class="inline"></div> 
							</div>
							<!---------- DURATION MUSIC  --------->
						    <small id="duration-player"  class="inline">2:30</small>
							
							<div id="display">
								<a id="back"  class="icon-player _back"></a>
								<a id="pause" class="icon-player _pause play-pause"></a>
								<a id="play"  class="icon-player _play play-pause" style="display: none;"></a>
								<a id="next"  class="icon-player _next"></a>					
								<span id="execution" ></span>
							</div>			
						</div>
						
					</div>			
				</div>
				<!------------------------------------- LOGO --------------------------------------------->
				<div class="small-2 columns hide-for-small logo">				
					<div id="logo">
						 <img src="resources/images/logo.png">						
					</div>					
				</div>
				<!------------------------------------- SWITCH -------------------------------------------->
				<div class="small-3 columns show-for-small ">
					<div class="header">
						<div class="switch round" onclick="jamswitch()">
						  <input id="z" name="switch-z" type="radio" checked>
						  <label for="z">Profilo</label>
						
						  <input id="z1" name="switch-z" type="radio">
						  <label for="z1">Social</label>
						
						  <span></span>
						</div>
					</div>
				</div>	
				<div class="large-5 small-8 columns">
					<div class="header inline">
						<!---------------------------- SEARCH ------------------------------------>						
						<form class="inline" action="">
							<span><input type="search" class="search show-for-large" placeholder="Cerca persone, musica o eventi"></span>
							<span><input type="search" class="search-small show-for-small" placeholder="Cerca "></span>
	  					</form>	
	  					<a class="ico-label _notify inline"></a>
	  					<a class="ico-label _friend inline"></a>
	  					<a class="ico-label _setting inline"></a>	  								
					</div>
					<a class="add inline _add inline"></a>						
				</div>			
			</div>		
		
		</div>
		
	</div>
</div>
</header>
