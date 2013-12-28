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
                                    <h3>Welcome <?php echo $currentUser->getType(); ?>!</h3>
                                    <div id="box-lastPost"></div>
                                    <script type="text/javascript">
                                        function loadBoxLastPost() {
                                            $.ajax({
                                                type: "POST",
                                                url: "content/stream/box/box-lastPost.php",
                                                beforeSend: function(xhr) {
                                                    console.log('Sono partito box-lastPost');
                                                    //goSpinnerBox('#box-record', 'record');
                                                }
                                            }).done(function(message, status, xhr) {
                                                $("#box-lastPost").html(message);
                                                //plugin scorrimento box
                                                //rsi_record = slideReview('recordSlide');
                                                code = xhr.status;
                                                console.log("Code: " + code + " | Message: <omitted because too large>");
                                            }).fail(function(xhr) {
                                                console.log("Error: " + $.parseJSON(xhr));
                                            });
                                        }
                                    </script>
								</div>
							</div>	
						</div>
                        
                       
						
						<div class="row">
							<div class="small-12 columns">
								<h3 id="discover">What are you looking for?</h3>
							</div>	
						</div>
                        
                         <div id="search">
						
						<div class="box" id="discoverMusic" style="display: none;">
							<div class="row formBlack">
								<div class="large-12 columns">
									<form action="javascript:return false;" method="POST" name="discoverMusic" id="" novalidate="novalidate">
										
										<div class="row">
											<div class="large-12 columns" style="margin-bottom: 25px;">
												<label for="location" class="error">
													<input type="text" name="location" id="location" pattern="" data-invalid="">
			        								Search by city
			        							</label>
			        						</div>
			        					</div>
			        					
			        					<div class="row">
			        						<div class="small-12 columns">
										        <label style="padding-bottom: 0px !important;">Select genre <span class="orange">*</span><small class="error"> Please enter a Genre</small></label>		
										        <div id="tag-music">
                                                    <input type="checkbox" name="tag-music0" id="tag-music0" value="acoustic" class="no-display"><label for="tag-music0">Acoustic</label>
                                                    <input type="checkbox" name="tag-music1" id="tag-music1" value="alternative" class="no-display"><label for="tag-music1">Alternative</label>
                                                    <input type="checkbox" name="tag-music2" id="tag-music2" value="ambient" class="no-display"><label for="tag-music2">Ambient</label>
                                                    <input type="checkbox" name="tag-music3" id="tag-music3" value="dance" class="no-display"><label for="tag-music3">Dance</label>
                                                    <input type="checkbox" name="tag-music4" id="tag-music4" value="dark" class="no-display"><label for="tag-music4">Dark</label>
                                                    <input type="checkbox" name="tag-music5" id="tag-music5" value="electronic" class="no-display"><label for="tag-music5">Electronic</label>
                                                    <input type="checkbox" name="tag-music6" id="tag-music6" value="experimental" class="no-display"><label for="tag-music6">Experimental</label>
                                                    <input type="checkbox" name="tag-music7" id="tag-music7" value="folk" class="no-display"><label for="tag-music7">Folk</label>
                                                    <input type="checkbox" name="tag-music8" id="tag-music8" value="funk" class="no-display"><label for="tag-music8">Funk</label>
                                                    <input type="checkbox" name="tag-music9" id="tag-music9" value="grunge" class="no-display"><label for="tag-music9">Grunge</label>
                                                    <input type="checkbox" name="tag-music10" id="tag-music10" value="hardcore" class="no-display"><label for="tag-music10">Hardcore</label>
                                                    <input type="checkbox" name="tag-music11" id="tag-music11" value="house" class="no-display"><label for="tag-music11">House</label>
                                                    <input type="checkbox" name="tag-music12" id="tag-music12" value="indie_rock" class="no-display"><label for="tag-music12">Indie Rock</label>
                                                    <input type="checkbox" name="tag-music13" id="tag-music13" value="instrumental" class="no-display"><label for="tag-music13">Instrumental</label>
                                                    <input type="checkbox" name="tag-music14" id="tag-music14" value="jazz_blues" class="no-display"><label for="tag-music14">Jazz&amp;Blues</label>
                                                    <input type="checkbox" name="tag-music15" id="tag-music15" value="metal" class="no-display"><label for="tag-music15">Metal</label>
                                                    <input type="checkbox" name="tag-music16" id="tag-music16" value="pop" class="no-display"><label for="tag-music16">Pop</label>
                                                    <input type="checkbox" name="tag-music17" id="tag-music17" value="progressive" class="no-display"><label for="tag-music17">Progressive</label>
                                                    <input type="checkbox" name="tag-music18" id="tag-music18" value="punk" class="no-display"><label for="tag-music18">Punk</label>
                                                    <input type="checkbox" name="tag-music19" id="tag-music19" value="rap_hip_hop" class="no-display"><label for="tag-music19">Rap/Hip-Hop</label>
                                                    <input type="checkbox" name="tag-music20" id="tag-music20" value="rock" class="no-display"><label for="tag-music20">Rock</label>
                                                    <input type="checkbox" name="tag-music21" id="tag-music21" value="ska" class="no-display"><label for="tag-music21">Ska</label>
                                                    <input type="checkbox" name="tag-music22" id="tag-music22" value="songwriter" class="no-display"><label for="tag-music22">Songwriter</label>
                                                    <input type="checkbox" name="tag-music23" id="tag-music23" value="techno" class="no-display"><label for="tag-music23">Techno</label>
                                                </div>
										    </div>
			        					</div>
			        					
			        					<div class="row" style="margin-top: 25px;">
										    <div class="small-6 columns">
										        <!--<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>-->
										    </div>	
										    <div class="small-6 columns">
										        <input type="submit" name="" id="" class="buttonNext" value="Search" style="float: right;"
                                                onclick="loadBoxResultRecord()" />
										    </div>	
										</div>
			        					
        							</form>
								</div>
							</div>
						</div>
                        <script type="text/javascript">
                            var json_data = {};
                            var genres = new Array();
                            
                            function loadBoxResultRecord() {
                                getGenre();
                                json_data.latitude = json_data.location.latitude;
                                json_data.longitude = json_data.location.longitude;
                                json_data.genre = genres;
                                $.ajax({
									type: "POST",
									url: "content/stream/box/box-resultRecord.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito box-resultRecord');
										//goSpinnerBox('#box-record','record');
                                        $("#result").slideToggle('slow');
                                        $("#search").slideToggle('slow');
                                        $("#discover").html('Here you are!');
                                        var elID="#result";
                                        $("#scroll-profile").mCustomScrollbar("scrollTo",elID);
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
                                    $("#result").html(message);
									//plugin scorrimento box
									//rsi_record = slideReview('recordSlide');
									//plugin share
									//addthis.init();
									//addthis.toolbox(".addthis_toolbox");
									//adatta pagina per scroll
									//hcento();
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									console.log("Error: " + $.parseJSON(xhr));
									//message = $.parseJSON(xhr.responseText).status;
									//code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
								});
							}
                            
                            function getGenre() {
                                genres = new Array();
                                try {
                                    $.each($("#tag-music :checkbox"), function() {
                                        if ($(this).is(":checked")) {
                                            genres.push($(this).val());
                                        }
                                    });
                                    return genres;
                                } catch (err) {
                                    window.console.log("getGenre | An error occurred - message : " + err.message);
                                }
                            }
                            
                            function initGeocomplete() {
                                try {
                                    $("#location").geocomplete()
                                            .bind("geocode:result", function(event, result) {
                                        json_data.location = prepareLocationObj(result);
                                        var complTest = getCompleteLocationInfo(json_data.location);
                                        console.log(complTest);
                                    })
                                            .bind("geocode:error", function(event, status) {
                                        json_data.location = null;
                                    })
                                            .bind("geocode:multiple", function(event, results) {
                                        json_data.location = prepareLocationObj(results[0]);
                                    });
                                } catch (err) {
                                    console.log("initGeocomplete | An error occurred - message : " + err.message);
                                }
                            }

                            $(document).ready(function() {
                                initGeocomplete();
                            });
                        </script>
						
						<div class="box" id="discoverEvent" style="display: none;">
							<div class="row formBlack">
								<div class="large-12 columns">
									<form action="" method="POST" name="discoverEvent" id="" novalidate="novalidate">
										
										<div class="row">
											<div class="large-8 columns" style="margin-bottom: 25px;">
												<label for="eventTitle" class="error">
													<input type="text" name="eventTitle" id="eventTitle" pattern="" data-invalid="">
			        								Search by city
			        							</label>
			        						</div>
			        						
			        						<div class="large-4 columns">
											 	<input type="text" name="date" id="date" pattern="" class="hasDatepicker">
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
										        <input type="submit" name="" id="" class="buttonNext" value="Search" style="float: right;" onclick="result()" />
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
                
                
                </div>
                
					
				<!-- RESULT -->                
                
                
                <div id="result" class="no-display">
                
                    <!-- END BOX RESULT -->
                    
                    <div class="row">
                        <div  class="large-5 columns">
                            <div class="" onclick="hideResult()"><h6>New search</h6></div>
                        </div>	
                        <div  class="large-7 columns align-right">
                            <div class="row">					
                                <div  class="small-9 columns">
                                    <a class="slide-button-prev _prevPage slide-button-prev-disabled" onclick=""><?php echo $views['PREV'];?> </a>
                                </div>
                                <div  class="small-3 columns">
                                    <a class="slide-button-next _nextPage" onclick=""><?php echo $views['NEXT'];?> </a>
                                </div>
                            </div>
                        </div>	
                    </div>
                
                </div>
                
                
                
                <script>
				
					function discover(what) {
						$('.discover-button').removeClass('discover-button-active');
						var elID="#search";
						$("#scroll-profile").mCustomScrollbar("scrollTo",elID);
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
					
					function result() {
						$("#result").slideToggle('slow');
						$("#search").slideToggle('slow');
						$("#discover").html('Here you are!');
						var elID="#result";
						$("#scroll-profile").mCustomScrollbar("scrollTo",elID);
					}
					
					function hideResult() {
						$("#result").slideToggle('slow');
						$("#search").slideToggle('slow');
						$("#discover").html('What are you looking for?');
						var elID="#search";
						$("#scroll-profile").mCustomScrollbar("scrollTo",elID);
						
					}
					
				</script>
                
                
                
			
<!---------------------------- END CONTENT PROFILE--------------------------------------------->

				
			</div>
		</div>
	</div>
	<div id='scroll-social' class='hcento' style="width: 50%;float: right;">
		<div id="social" style="max-width:500px; float:left" class="row">
			<div class="large-12 columns">

                <div id="box-activity"></div>
                <script type="text/javascript">
                    function loadBoxActivity() {
                        $.ajax({
                            type: "POST",
                            url: "content/stream/box/box-activity.php",
                            beforeSend: function(xhr) {
                                console.log('Sono partito box-activity');
                                //goSpinnerBox('#box-record', 'record');
                            }
                        }).done(function(message, status, xhr) {
                            $("#box-activity").html(message);
                            //plugin scorrimento box
                            //rsi_record = slideReview('recordSlide');
                            code = xhr.status;
                            console.log("Code: " + code + " | Message: <omitted because too large>");
                        }).fail(function(xhr) {
                            console.log("Error: " + $.parseJSON(xhr));
                        });
                    }
                </script>

			</div>			
		</div>
	</div>	
</div>
