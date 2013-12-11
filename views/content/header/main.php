<header>
	<!------------------------------------- HIDE HEADER ----------------------------->
	<div id="header-hide" class="no-display bg-double">
		<?php
				
		if (isset($_SESSION['currentUser'])) {
			$currentUser = $_SESSION['currentUser'];
			$userObjectId = $currentUser->getObjectId();
			$userType = $currentUser->getType();
			?>		
			<div  class="row hcento-hero" style="margin-bottom: 20px">
				<div id="header-profile" class="small-6 columns">
					<!-- TODO - ci devo mettere una chiamata ajax al box per parallelizzare il caricamento-->
					<?php require_once './content/header/box-profile.php'; ?>
				</div>			
				<div id="header-social" class="small-6 columns">				
					<!-- TODO - ci devo mettere una chiamata ajax al box per parallelizzare il caricamento-->
					<?php require_once './content/header/box-social.php'; ?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	
	<!------------------------------------- HEADER ----------------------------->
	<div id="header">
	<div  class="row">
		<div  class="large-12 columns">		
			<div class="row">				
				<div id="header-box-menu" class="large-5 small-1 columns">
					<div class="header">
						<!------------------------------------- MENU ----------------------------->
						<div class="icon-header _menu" onClick="headerShow()"></div>
						<!------------------------------------- thumbnail album ----------------------------->			
						<div class="icon-header" id='header-box-thum'>
							<img src="../media/<?php echo DEFRECORDTHUMB; ?>"  onerror="this.src='../media/<?php echo DEFRECORDTHUMB;?>'">
						</div>				
					
						<!------------------------------------- PLAYER ----------------------------->
						<div id="header-box-player">
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
				<div class="large-2 columns logo" id="header-box-logo">				
					<div id="logo">
						 <img src="resources/images/logo.png">						
					</div>					
				</div>
				<!------------------------------------- SWITCH -------------------------------------------->
				<div class="small-5 columns no-display " id='header-box-switch'>
					<div class="header">
						<div class="switch round" onclick="getSwich()">
						  <input id="z" name="switch-z" type="radio" checked>
						  <label for="z">Profilo</label>
						
						  <input id="z1" name="switch-z" type="radio">
						  <label for="z1">Social</label>
						
						  <span></span>
						</div>
					</div>
				</div>	
				<div class="large-5 small-6 columns" id="header-box-search">					
					<div class="row">
						<div class="large-10 small-10 columns">
							<div class="row">
								<div class="large-8 small-12 columns " style="padding: 0px;">
									<div class="header inline">
										<!---------------------------- SEARCH ------------------------------------>						
										<form class="inline" action="">
											<span><input id='header-btn-search' name='header-btn-search' type="search" class="search" placeholder="Cerca persone, musica o eventi"></span>
											<!-- <span><input type="search" class="search-small show-for-small" placeholder="Cerca "></span> -->
					  					</form>
				  					</div>	
				  				</div>
				  				<div class="large-4 columns hide-for-small " id="header-btn-notify">
				  					<div class="header inline" style="float: right;">
				  					<a class="ico-label _flag inline" onclick="headerShow()" ><span class="round alert label iconNotification"><?php echo $totNotification ?></span></a>
				  					<a class="ico-label _setting inline"></a>
				  					</div>
				  				</div>
			  				</div>
  						</div>
						<div class="large-2 small-2 columns">
							<a class="add inline _add inline"></a>
						</div>
					</div>						
				</div>			
			</div>		
		
		</div>
		
	</div>
</div>
</header>
