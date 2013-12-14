<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
?>
<div class="bg-double">	
	<div id='scroll-profile' class='hcento' style="width: 50%;float: left;">						
		<div id="profile" style="max-width:500px; float:right" class="row">
			<div class="large-12 columns">
			
<!---------------------------- CONTENT PROFILE--------------------------------------------->

				
				<div class="row">
					<div class="large-12 columns">
						
						<div class="row welcome-stream">
							<div class="small-12 columns">
								<div class="welcome-stream">
									<img src="resources/images/stream/spotter.png" />
									<h3>Welcome Spotter!</h3>
									<p>Your last post is...</p>
									<h5>Ops! You have not written anything yet!</h5>
								</div>
							</div>	
						</div>	
						
						<div class="row">
							<div class="small-12 columns">
								<h3 id="discover">What are you looking for?</h3>
							</div>	
						</div>	
						
						<div class="box" id="discoverMusic" style="display: none;">
							<div class="row formBlack">
								<div class="large-12 columns">
									<form action="" method="POST" name="discoverMusic" id="" data-abide="" novalidate="novalidate">
										
										<div class="row">
											<div class="large-12 columns" style="margin-bottom: 25px;">
												<label for="eventTitle" class="error">
													<input type="text" name="eventTitle" id="eventTitle" pattern="" required="" data-invalid="">
			        								Search by city
			        							</label>
			        						</div>
			        					</div>
			        					
			        					<div class="row">
			        						<div class="small-12 columns">
										        <label style="padding-bottom: 0px !important;">Select genre <span class="orange">*</span><small class="error"> Please enter a Genre</small></label>		
										        <div id="tag-music"><input type="checkbox" name="tag-music0" id="tag-music0" value="0" class="no-display"><label for="tag-music0">Acoustic</label><input type="checkbox" name="tag-music1" id="tag-music1" value="1" class="no-display"><label for="tag-music1">Alternative</label><input type="checkbox" name="tag-music2" id="tag-music2" value="2" class="no-display"><label for="tag-music2">Ambient</label><input type="checkbox" name="tag-music3" id="tag-music3" value="3" class="no-display"><label for="tag-music3">Dance</label><input type="checkbox" name="tag-music4" id="tag-music4" value="4" class="no-display"><label for="tag-music4">Dark</label><input type="checkbox" name="tag-music5" id="tag-music5" value="5" class="no-display"><label for="tag-music5">Electronic</label><input type="checkbox" name="tag-music6" id="tag-music6" value="6" class="no-display"><label for="tag-music6">Experimental</label><input type="checkbox" name="tag-music7" id="tag-music7" value="7" class="no-display"><label for="tag-music7">Folk</label><input type="checkbox" name="tag-music8" id="tag-music8" value="8" class="no-display"><label for="tag-music8">Funk</label><input type="checkbox" name="tag-music9" id="tag-music9" value="9" class="no-display"><label for="tag-music9">Grunge</label><input type="checkbox" name="tag-music10" id="tag-music10" value="10" class="no-display"><label for="tag-music10">Hardcore</label><input type="checkbox" name="tag-music11" id="tag-music11" value="11" class="no-display"><label for="tag-music11">House</label><input type="checkbox" name="tag-music12" id="tag-music12" value="12" class="no-display"><label for="tag-music12">Indie Rock</label><input type="checkbox" name="tag-music13" id="tag-music13" value="13" class="no-display"><label for="tag-music13">Instrumental</label><input type="checkbox" name="tag-music14" id="tag-music14" value="14" class="no-display"><label for="tag-music14">Jazz&amp;Blues</label><input type="checkbox" name="tag-music15" id="tag-music15" value="15" class="no-display"><label for="tag-music15">Metal</label><input type="checkbox" name="tag-music16" id="tag-music16" value="16" class="no-display"><label for="tag-music16">Pop</label><input type="checkbox" name="tag-music17" id="tag-music17" value="17" class="no-display"><label for="tag-music17">Progressive</label><input type="checkbox" name="tag-music18" id="tag-music18" value="18" class="no-display"><label for="tag-music18">Punk</label><input type="checkbox" name="tag-music19" id="tag-music19" value="19" class="no-display"><label for="tag-music19">Rap/Hip-Hop</label><input type="checkbox" name="tag-music20" id="tag-music20" value="20" class="no-display"><label for="tag-music20">Rock</label><input type="checkbox" name="tag-music21" id="tag-music21" value="21" class="no-display"><label for="tag-music21">Ska</label><input type="checkbox" name="tag-music22" id="tag-music22" value="22" class="no-display"><label for="tag-music22">Songwriter</label><input type="checkbox" name="tag-music23" id="tag-music23" value="23" class="no-display"><label for="tag-music23">Techno</label></div>
										    </div>
			        					</div>
			        					
			        					<div class="row" style="margin-top: 25px;">
										    <div class="small-6 columns">
										        <!--<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>-->
										    </div>	
										    <div class="small-6 columns">
										        <input type="submit" name="" id="" class="buttonNext" value="Search" style="float: right;">
										    </div>	
										</div>
			        					
        							</form>
								</div>
							</div>
						</div>
						
						<div class="box" id="discoverEvent" style="display: none;">
							<div class="row formBlack">
								<div class="large-12 columns">
									<form action="" method="POST" name="discoverEvent" id="" data-abide="" novalidate="novalidate">
										
										<div class="row">
											<div class="large-8 columns" style="margin-bottom: 25px;">
												<label for="eventTitle" class="error">
													<input type="text" name="eventTitle" id="eventTitle" pattern="" required="" data-invalid="">
			        								Search by city
			        							</label>
			        						</div>
			        						
			        						<div class="large-4 columns">
											 	<input type="text" name="date" id="date" required="" pattern="" class="hasDatepicker">
								        		<label for="date">Date</label>
											 </div>	
											 
			        					</div>
			        					
			        					<div class="row">
			        						<div class="small-12 columns">
										        <label style="padding-bottom: 0px !important;">Select genre</label>		
										        <div id="tag-music"><input type="checkbox" name="tag-event0" id="tag-event0" value="0" class="no-display"><label for="tag-music0">Acoustic</label><input type="checkbox" name="tag-event1" id="tag-event1" value="1" class="no-display"><label for="tag-music1">Alternative</label><input type="checkbox" name="tag-event1" id="tag-event1" value="2" class="no-display"><label for="tag-event1">Ambient</label><input type="checkbox" name="tag-music3" id="tag-music3" value="3" class="no-display"><label for="tag-music3">Dance</label><input type="checkbox" name="tag-music4" id="tag-music4" value="4" class="no-display"><label for="tag-music4">Dark</label><input type="checkbox" name="tag-music5" id="tag-music5" value="5" class="no-display"><label for="tag-music5">Electronic</label><input type="checkbox" name="tag-music6" id="tag-music6" value="6" class="no-display"><label for="tag-music6">Experimental</label><input type="checkbox" name="tag-music7" id="tag-music7" value="7" class="no-display"><label for="tag-music7">Folk</label><input type="checkbox" name="tag-music8" id="tag-music8" value="8" class="no-display"><label for="tag-music8">Funk</label><input type="checkbox" name="tag-music9" id="tag-music9" value="9" class="no-display"><label for="tag-music9">Grunge</label><input type="checkbox" name="tag-music10" id="tag-music10" value="10" class="no-display"><label for="tag-music10">Hardcore</label><input type="checkbox" name="tag-music11" id="tag-music11" value="11" class="no-display"><label for="tag-music11">House</label><input type="checkbox" name="tag-music12" id="tag-music12" value="12" class="no-display"><label for="tag-music12">Indie Rock</label><input type="checkbox" name="tag-music13" id="tag-music13" value="13" class="no-display"><label for="tag-music13">Instrumental</label><input type="checkbox" name="tag-music14" id="tag-music14" value="14" class="no-display"><label for="tag-music14">Jazz&amp;Blues</label><input type="checkbox" name="tag-music15" id="tag-music15" value="15" class="no-display"><label for="tag-music15">Metal</label><input type="checkbox" name="tag-music16" id="tag-music16" value="16" class="no-display"><label for="tag-music16">Pop</label><input type="checkbox" name="tag-music17" id="tag-music17" value="17" class="no-display"><label for="tag-music17">Progressive</label><input type="checkbox" name="tag-music18" id="tag-music18" value="18" class="no-display"><label for="tag-music18">Punk</label><input type="checkbox" name="tag-music19" id="tag-music19" value="19" class="no-display"><label for="tag-music19">Rap/Hip-Hop</label><input type="checkbox" name="tag-event10" id="tag-event10" value="20" class="no-display"><label for="tag-event10">Rock</label><input type="checkbox" name="tag-event11" id="tag-event11" value="21" class="no-display"><label for="tag-event11">Ska</label><input type="checkbox" name="tag-event12" id="tag-event12" value="22" class="no-display"><label for="tag-event12">Songwriter</label><input type="checkbox" name="tag-event13" id="tag-event13" value="23" class="no-display"><label for="tag-event13">Techno</label></div>
										    </div>
			        					</div>
			        					
			        					<div class="row" style="margin-top: 25px;">
										    <div class="small-6 columns">
										        <!--<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>-->
										    </div>	
										    <div class="small-6 columns">
										        <input type="submit" name="" id="" class="buttonNext" value="Search" style="float: right;">
										    </div>	
										</div>
			        					
        							</form>
								</div>
							</div>
						</div>
						
						<div class="box">
							<div class="row">
								<div class="large-6 columns">
									<div class="discover-button" id="btn-music" onclick="discover('music')">Music</div>
								</div>
								<div class="large-6 columns">
									<div class="discover-button" id="btn-event" onclick="discover('event')">Events</div>
								</div>
							</div>
						</div>
							
					</div>
				</div>
					
				<script>
				
					function discover(what) {
						$('.discover-button').removeClass('discover-button-active');
						switch(what)
						{
							case 'music':
								$("#discoverEvent").slideUp(function() {$("#discoverMusic").slideToggle('slow');});
								$("#discover").html('Discover new Music!');
								$('#btn-music').addClass('discover-button-active');
							break;
							case 'event':
								$("#discoverMusic").slideUp(function() {$("#discoverEvent").slideToggle('slow');});
								$("#discover").html('Discover Events!');
								$('#btn-event').addClass('discover-button-active');
							break;
						}
					}
				</script>	
			
<!---------------------------- END CONTENT PROFILE--------------------------------------------->

				
			</div>
		</div>
	</div>
	<div id='scroll-social' class='hcento' style="width: 50%;float: right;">
		<div id="social" style="max-width:500px; float:left" class="row">
			<div class="large-12 columns">

<!---------------------------- CONTENT SOCIAL--------------------------------------------->


<!---------------- WRITE ----------------->

<h3>Write a post</h3>
<div class="row  ">
	<div class="large-12 columns ">
		<form action="" class="box-write" onsubmit="sendPost('', $('#post').val()); return false;">
			<div class="">
				<div class="row  ">
					<div class="small-9 columns ">
						<input id="post" type="text" class="post inline" placeholder="Spread the word about your interest!">
					</div>
					<div class="small-3 columns ">
						<input type="button" id="button-post" class="post-button inline" value="Post" onclick="sendPost('', $('#post').val())">
					</div>
				</div>
			</div>

		</form>
	</div>
</div>

<!---------------- STREAM ----------------->

<h3>Stream</h3>


<!---------------- BOX REVIEW ----------------->

<div id="tV0O3eGHqH">
	<div class="box ">
		
		<div class="row  line">
			<div class="small-1 columns ">
				<div class="icon-header">
					<img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='../media/images/default/defaultAvatarThumb.jpg'">
				</div>
			</div>
			<div class="small-5 columns">
				<div class="text grey" style="margin-bottom: 0px;">
					<strong>Nome Cognome</strong>
				</div>
				<div class="note orange">
					<strong>Jammer</strong>
				</div>
			</div>
			<div class="small-6 columns propriety">
				<div class="note grey-light">
					Monday 14 December 2013 - 17:48
				</div>
			</div>

		</div>
		<div class="row  line">
			<div class="small-12 columns ">
				<div class="row ">
					<div class="small-12 columns ">
						<div class="row  ">
							<div class="large-12 columns ">
								<div class="text orange">Album Review</div>
							</div>
						</div>
						<div class="row">
							<div class="small-2 columns ">
								<div class="coverThumb"><img src="../media/../../../../media/images/default/defaultEventThumb.jpg" onerror="this.src='../media/../../../../media/images/default/defaultEventThumb.jpg'"></div>						
							</div>
							<div class="small-8 columns ">
								<div class="row ">							
									<div class="small-12 columns ">
										<div class="sottotitle grey-dark">Recensione Evento/Album</div>
									</div>	
								</div>	
								<div class="row">						
									<div class="small-12 columns ">
										<div class="note grey">Rating</div>
									</div>
								</div>
								<div class="row ">						
									<div class="small-12 columns ">
										<a class="icon-propriety _star-orange"></a><a class="icon-propriety _star-grey"></a><a class="icon-propriety _star-grey"></a><a class="icon-propriety _star-grey"></a><a class="icon-propriety _star-grey"></a>										</div>
								</div>													
							</div>
							<div class="small-2 columns align-right viewAlbumReview">
								<a href="#" class="orange"><strong>Read</strong></a>
							</div>				
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="box-propriety">
				<div class="small-7 columns ">
					<a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')">Love</a>
					<a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')">Comment</a>
					<a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')">Share</a>
				</div>
				<div class="small-5 columns propriety ">					
					<a class="icon-propriety _unlove grey">72</a>
					<a class="icon-propriety _comment">0</a>
					<a class="icon-propriety _share">0</a>
				</div>
			</div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display">
			
	</div>
	
</div>



<!---------------- BOX POST ----------------->

<div id="tV0O3eGHqH">
	<div class="box ">
		
		<div class="row  line">
			<div class="small-1 columns ">
				<div class="icon-header">
					<img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='../media/images/default/defaultAvatarThumb.jpg'">
				</div>
			</div>
			<div class="small-5 columns">
				<div class="text grey" style="margin-bottom: 0px;">
					<strong>Nome Cognome</strong>
				</div>
				<div class="note orange">
					<strong>Jammer</strong>
				</div>
			</div>
			<div class="small-6 columns propriety">
				<div class="note grey-light">
					Monday 18 November 2013 - 16:51
				</div>
			</div>

		</div>
		<div class="row  line">
			<div class="small-12 columns ">
				<div class="row ">
					<div class="small-12 columns ">
						<div class="text grey">
							Questo è un post natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.	
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="box-propriety">
				<div class="small-7 columns ">
					<a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')">Love</a>
					<a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')">Comment</a>
					<a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')">Share</a>
				</div>
				<div class="small-5 columns propriety ">					
					<a class="icon-propriety _unlove grey">72</a>
					<a class="icon-propriety _comment">0</a>
					<a class="icon-propriety _share">0</a>
				</div>
			</div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display">
			
	</div>
	
</div>



<!---------------- BOX POST ----------------->

<div id="tV0O3eGHqH">
	<div class="box ">
		
		<div class="row  line">
			<div class="small-1 columns ">
				<div class="icon-header">
					<img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='../media/images/default/defaultAvatarThumb.jpg'">
				</div>
			</div>
			<div class="small-5 columns">
				<div class="text grey" style="margin-bottom: 0px;">
					<strong>Nome Cognome</strong>
				</div>
				<div class="note orange">
					<strong>Jammer</strong>
				</div>
			</div>
			<div class="small-6 columns propriety">
				<div class="note grey-light">
					Monday 18 November 2013 - 16:51
				</div>
			</div>

		</div>
		<div class="row  line">
			<div class="small-12 columns ">
				<div class="row ">
					<div class="small-12 columns ">
						<div class="row  ">
							<div class="large-12 columns ">
								<div class="text orange">Just added</div>
							</div>
						</div>
						<div class="row">
							<div class="small-6 columns">
								<div class="box-membre">
									<div class="row " id="collaborator_03VPczLItB">
										<div class="small-3 columns ">
											<div class="icon-header">
												<img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='../media/images/default/defaultAvatarThumb.jpg'">
											</div>
										</div>
										<div class="small-9 columns ">
											<div class="text grey-dark breakOffTest"><strong>Elenaradio</strong></div>
										</div>		
									</div>	
								</div>
							</div>
															<div class="small-6 columns">
								<div class="box-membre">
									<div class="row " id="collaborator_06pkm6j7mg">
										<div class="small-3 columns ">
											<div class="icon-header">
												<img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='../media/images/default/defaultAvatarThumb.jpg'">
											</div>
										</div>
										<div class="small-9 columns ">
											<div class="text grey-dark breakOffTest"><strong>GothicAtmosphere</strong></div>
										</div>		
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="box-propriety">
				<div class="small-7 columns ">
					<a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')">Love</a>
					<a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')">Comment</a>
					<a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')">Share</a>
				</div>
				<div class="small-5 columns propriety ">					
					<a class="icon-propriety _unlove grey">72</a>
					<a class="icon-propriety _comment">0</a>
					<a class="icon-propriety _share">0</a>
				</div>
			</div>
		</div>
		</div>
		<!---- COMMENT ---->
		<div class="box-comment no-display">
			
	</div>
	
</div>

<!---------------------------- END CONTENT SOCIAL--------------------------------------------->


			</div>			
		</div>
	</div>	
</div>
