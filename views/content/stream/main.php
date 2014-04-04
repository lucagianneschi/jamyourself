<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once BOXES_DIR . 'userInfo.box.php';

$userPageId = $_SESSION['id'];
$userInfoBox = new UserInfoBox();
$userInfoBox->init($userPageId);

if (is_null($userInfoBox->error)) {	
   
	foreach ($userInfoBox->user as $key => $value) {
		$currentUser = $value;
	}	

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
                                        <img src="resources/images/stream/<?php echo $currentUser->getType(); ?>.png" alt="<?php echo $currentUser->getUsername(); ?>"/>
                                        <h3><?php echo $views['stream']['welcome']; ?> <?php echo $currentUser->getType(); ?>!</h3>
                                        <div id="box-post"></div>
                                        <script type="text/javascript">
                        function loadBoxPost() {
                            $.ajax({
                            type: "POST",
                            url: "content/stream/box/box-post.php",
                            beforeSend: function(xhr) {
                                console.log('Sono partito box-post');
                                //goSpinnerBox('#box-record', 'record');
                            }
                            }).done(function(message, status, xhr) {
                            $("#box-post").html(message);
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
                                    <h3 id="discover"><?php echo $views['stream']['looking_for']; ?></h3>
                                </div>	
                            </div>

                            <div id="search">

                                <!-- Search by Music -->
                                <div class="box" id="discoverMusic" style="display: none;">
                                    <div class="row formBlack">
                                        <div class="large-12 columns">
                                            <form action="javascript:return false;" method="POST" name="discoverMusic" id="" novalidate="novalidate">

                                                <div class="row">
                                                    <div class="large-12 columns" style="margin-bottom: 25px;">
                                                        <label for="location" class="error">
                                                            <input type="text" name="location" id="location" pattern="" data-invalid="">
                                <?php echo $views['stream']['search_city']; ?>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="small-12 columns">
                                                        <label style="padding-bottom: 0px !important;"><?php echo $views['stream']['select_genre']; ?></label>		
                                                        <div id="tag-music">
                                                            <input type="checkbox" name="tag-music0" id="tag-music0" value="acoustic" class="no-display"><label for="tag-music0"><?php echo $views['tag']['music']['acoustic']; ?></label>
                                                            <input type="checkbox" name="tag-music1" id="tag-music1" value="alternative" class="no-display"><label for="tag-music1"><?php echo $views['tag']['music']['alternative']; ?></label>
                                                            <input type="checkbox" name="tag-music2" id="tag-music2" value="ambient" class="no-display"><label for="tag-music2"><?php echo $views['tag']['music']['ambient']; ?></label>
                                                            <input type="checkbox" name="tag-music3" id="tag-music3" value="dance" class="no-display"><label for="tag-music3"><?php echo $views['tag']['music']['dance']; ?></label>
                                                            <input type="checkbox" name="tag-music4" id="tag-music4" value="dark" class="no-display"><label for="tag-music4"><?php echo $views['tag']['music']['dark']; ?></label>
                                                            <input type="checkbox" name="tag-music5" id="tag-music5" value="electronic" class="no-display"><label for="tag-music5"><?php echo $views['tag']['music']['electronic']; ?></label>
                                                            <input type="checkbox" name="tag-music6" id="tag-music6" value="experimental" class="no-display"><label for="tag-music6"><?php echo $views['tag']['music']['experimental']; ?></label>
                                                            <input type="checkbox" name="tag-music7" id="tag-music7" value="folk" class="no-display"><label for="tag-music7"><?php echo $views['tag']['music']['folk']; ?></label>
                                                            <input type="checkbox" name="tag-music8" id="tag-music8" value="funk" class="no-display"><label for="tag-music8"><?php echo $views['tag']['music']['funk']; ?></label>
                                                            <input type="checkbox" name="tag-music9" id="tag-music9" value="grunge" class="no-display"><label for="tag-music9"><?php echo $views['tag']['music']['grunge']; ?></label>
                                                            <input type="checkbox" name="tag-music10" id="tag-music10" value="hardcore" class="no-display"><label for="tag-music10"><?php echo $views['tag']['music']['hardcore']; ?></label>
                                                            <input type="checkbox" name="tag-music11" id="tag-music11" value="house" class="no-display"><label for="tag-music11"><?php echo $views['tag']['music']['house']; ?></label>
                                                            <input type="checkbox" name="tag-music12" id="tag-music12" value="indie_rock" class="no-display"><label for="tag-music12"><?php echo $views['tag']['music']['indie_rock']; ?></label>
                                                            <input type="checkbox" name="tag-music13" id="tag-music13" value="instrumental" class="no-display"><label for="tag-music13"><?php echo $views['tag']['music']['instrumental']; ?></label>
                                                            <input type="checkbox" name="tag-music14" id="tag-music14" value="jazz_blues" class="no-display"><label for="tag-music14"><?php echo $views['tag']['music']['jazz_blues']; ?></label>
                                                            <input type="checkbox" name="tag-music15" id="tag-music15" value="metal" class="no-display"><label for="tag-music15"><?php echo $views['tag']['music']['metal']; ?></label>
                                                            <input type="checkbox" name="tag-music16" id="tag-music16" value="pop" class="no-display"><label for="tag-music16"><?php echo $views['tag']['music']['pop']; ?></label>
                                                            <input type="checkbox" name="tag-music17" id="tag-music17" value="progressive" class="no-display"><label for="tag-music17"><?php echo $views['tag']['music']['progressive']; ?></label>
                                                            <input type="checkbox" name="tag-music18" id="tag-music18" value="punk" class="no-display"><label for="tag-music18"><?php echo $views['tag']['music']['punk']; ?></label>
                                                            <input type="checkbox" name="tag-music19" id="tag-music19" value="rap_hip_hop" class="no-display"><label for="tag-music19"><?php echo $views['tag']['music']['rap_hip_hop']; ?></label>
                                                            <input type="checkbox" name="tag-music20" id="tag-music20" value="rock" class="no-display"><label for="tag-music20"><?php echo $views['tag']['music']['rock']; ?></label>
                                                            <input type="checkbox" name="tag-music21" id="tag-music21" value="ska" class="no-display"><label for="tag-music21"><?php echo $views['tag']['music']['ska']; ?></label>
                                                            <input type="checkbox" name="tag-music22" id="tag-music22" value="songwriter" class="no-display"><label for="tag-music22"><?php echo $views['tag']['music']['songwriter']; ?></label>
                                                            <input type="checkbox" name="tag-music23" id="tag-music23" value="techno" class="no-display"><label for="tag-music23"><?php echo $views['tag']['music']['techno']; ?></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 25px;">
                                                    <div class="small-6 columns">
                                                        <!--<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>-->
                                                    </div>	
                                                    <div class="small-6 columns">
                                                        <input type="submit" name="" id="" class="buttonNext" value="<?php echo $views['stream']['search']; ?>" style="float: right;"
                                                               onclick="loadBoxResultRecord()" />
                                                    </div>	
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">
                        var json_data = {};
                        json_data.location = {};
                        var genres = new Array();

                        function loadBoxResultRecord() {
                            json_data.genre = getGenre();
                            json_data.latitude = json_data.location.latitude;
                            json_data.longitude = json_data.location.longitude;
                            json_data.city = json_data.location.city;
                            json_data.country = json_data.location.country;
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
                                var elID = "#result";
                                $("#scroll-profile").mCustomScrollbar("scrollTo", elID);
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


                                </script>

                                <!-- Search by Event -->
                                <div class="box" id="discoverEvent" style="display: none;">
                                    <div class="row formBlack">
                                        <div class="large-12 columns">
                                            <form action="javascript:return false;" method="POST" name="discoverEvent" id="" novalidate="novalidate">

                                                <div class="row">
                                                    <div class="large-8 columns" style="margin-bottom: 25px;">
                                                        <label for="eventTitle" class="error">
                                                            <input type="text" name="eventTitle" id="eventTitle" pattern="" data-invalid="">
                                <?php echo $views['stream']['search_city']; ?>
                                                        </label>                                                    
                                                    </div>

                                                    <div class="large-4 columns">
                                                        <input type="text" name="date" id="date">
                                                        <label for="date"><?php echo $views['stream']['date']; ?></label>
                                                    </div>	

                                                </div>

                                                <div class="row">
                                                    <div class="small-12 columns">
                                                        <label style="padding-bottom: 0px !important;"><?php echo $views['stream']['select_genre']; ?></label>
                                                        <div id="tag-event">
                                                            <input type="checkbox" name="tag-event0" id="tag-event0" value="acoustic" class="no-display"><label for="tag-event0"><?php echo $views['tag']['music']['acoustic']; ?></label>
                                                            <input type="checkbox" name="tag-event1" id="tag-event1" value="alternative" class="no-display"><label for="tag-event1"><?php echo $views['tag']['music']['alternative']; ?></label>
                                                            <input type="checkbox" name="tag-event2" id="tag-event2" value="ambient" class="no-display"><label for="tag-event2"><?php echo $views['tag']['music']['ambient']; ?></label>
                                                            <input type="checkbox" name="tag-event3" id="tag-event3" value="dance" class="no-display"><label for="tag-event3"><?php echo $views['tag']['music']['dance']; ?></label>
                                                            <input type="checkbox" name="tag-event4" id="tag-event4" value="dark" class="no-display"><label for="tag-event4"><?php echo $views['tag']['music']['dark']; ?></label>
                                                            <input type="checkbox" name="tag-event5" id="tag-event5" value="electronic" class="no-display"><label for="tag-event5"><?php echo $views['tag']['music']['electronic']; ?></label>
                                                            <input type="checkbox" name="tag-event6" id="tag-event6" value="experimental" class="no-display"><label for="tag-event6"><?php echo $views['tag']['music']['experimental']; ?></label>
                                                            <input type="checkbox" name="tag-event7" id="tag-event7" value="folk" class="no-display"><label for="tag-event7"><?php echo $views['tag']['music']['folk']; ?></label>
                                                            <input type="checkbox" name="tag-event8" id="tag-event8" value="funk" class="no-display"><label for="tag-event8"><?php echo $views['tag']['music']['funk']; ?></label>
                                                            <input type="checkbox" name="tag-event9" id="tag-event9" value="grunge" class="no-display"><label for="tag-event9"><?php echo $views['tag']['music']['grunge']; ?></label>
                                                            <input type="checkbox" name="tag-event10" id="tag-event10" value="hardcore" class="no-display"><label for="tag-event10"><?php echo $views['tag']['music']['hardcore']; ?></label>
                                                            <input type="checkbox" name="tag-event11" id="tag-event11" value="house" class="no-display"><label for="tag-event11"><?php echo $views['tag']['music']['house']; ?></label>
                                                            <input type="checkbox" name="tag-event12" id="tag-event12" value="indie_rock" class="no-display"><label for="tag-event12"><?php echo $views['tag']['music']['indie_rock']; ?></label>
                                                            <input type="checkbox" name="tag-event13" id="tag-event13" value="instrumental" class="no-display"><label for="tag-event13"><?php echo $views['tag']['music']['instrumental']; ?></label>
                                                            <input type="checkbox" name="tag-event14" id="tag-event14" value="jazz_blues" class="no-display"><label for="tag-event14"><?php echo $views['tag']['music']['jazz_blues']; ?></label>
                                                            <input type="checkbox" name="tag-event15" id="tag-event15" value="metal" class="no-display"><label for="tag-event15"><?php echo $views['tag']['music']['metal']; ?></label>
                                                            <input type="checkbox" name="tag-event16" id="tag-event16" value="pop" class="no-display"><label for="tag-event16"><?php echo $views['tag']['music']['pop']; ?></label>
                                                            <input type="checkbox" name="tag-event17" id="tag-event17" value="progressive" class="no-display"><label for="tag-event17"><?php echo $views['tag']['music']['progressive']; ?></label>
                                                            <input type="checkbox" name="tag-event18" id="tag-event18" value="punk" class="no-display"><label for="tag-event18"><?php echo $views['tag']['music']['punk']; ?></label>
                                                            <input type="checkbox" name="tag-event19" id="tag-event19" value="rap_hip_hop" class="no-display"><label for="tag-event19"><?php echo $views['tag']['music']['rap_hip_hop']; ?></label>
                                                            <input type="checkbox" name="tag-event20" id="tag-event20" value="rock" class="no-display"><label for="tag-event20"><?php echo $views['tag']['music']['rock']; ?></label>
                                                            <input type="checkbox" name="tag-event21" id="tag-event21" value="ska" class="no-display"><label for="tag-event21"><?php echo $views['tag']['music']['ska']; ?></label>
                                                            <input type="checkbox" name="tag-event22" id="tag-event22" value="songwriter" class="no-display"><label for="tag-event22"><?php echo $views['tag']['music']['songwriter']; ?></label>
                                                            <input type="checkbox" name="tag-event23" id="tag-event23" value="techno" class="no-display"><label for="tag-event23"><?php echo $views['tag']['music']['techno']; ?></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-top: 25px;">
                                                    <div class="small-6 columns">
                                                        <!--<div class="note grey-light" style="padding-top: 50px;"><span class="orange">* </span> Mandatory fields</div>-->
                                                    </div>	
                                                    <div class="small-6 columns">
                                                        <input type="submit" name="" id="" class="buttonNext" value="<?php echo $views['stream']['search']; ?>" style="float: right;" onclick="loadBoxResultEvent()" />
                                                    </div>	
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="box">
                                    <div class="row">
                                        <div class="large-6 columns">
                                            <div class="discover-button" id="btn-music" onclick="discover('music')"><?php echo $views['stream']['music']; ?></div>
                                        </div>
                                        <div class="large-6 columns">
                                            <div class="discover-button" id="btn-event" onclick="discover('event')"><?php echo $views['stream']['events']; ?></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <script type="text/javascript">
                        var json_data = {};
                        json_data.location = {};
                        var genres = new Array();
                        function loadBoxResultEvent() {

                            json_data.tags = getTag();
                            json_data.latitude = json_data.location.latitude;
                            json_data.longitude = json_data.location.longitude;
                            json_data.city = json_data.location.city;
                            json_data.country = json_data.location.country;
                            json_data.eventDate = $('#date').val();

                            $.ajax({
                            type: "POST",
                            url: "content/stream/box/box-resultEvent.php",
                            data: json_data,
                            beforeSend: function(xhr) {
                                //spinner.show();
                                console.log('Sono partito box-resultEvent');
                                //goSpinnerBox('#box-record','record');
                                $("#result").slideToggle('slow');
                                $("#search").slideToggle('slow');
                                $("#discover").html('Here you are!');
                                var elID = "#result";
                                $("#scroll-profile").mCustomScrollbar("scrollTo", elID);
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

                        function getTag() {
                            tags = new Array();
                            try {
                            $.each($("#tag-event :checkbox"), function() {
                                if ($(this).is(":checked")) {
                                tags.push($(this).val());
                                }
                            });
                            return genres;
                            } catch (err) {
                            window.console.log("getTags | An error occurred - message : " + err.message);
                            }
                        }

                    </script>

                    <!-- RESULT -->

                    <div id="result" class="no-display" style="margin-bottom: 30px;"></div>

                    <script>


                /*
                 function result() {
                 $("#result").slideToggle('slow');
                 $("#search").slideToggle('slow');
                 $("#discover").html('Here you are!');
                 var elID="#result";
                 $("#scroll-profile").mCustomScrollbar("scrollTo",elID);
                 }
                 */


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
                    <script type="text/javascript">
                    function loadBoxOpinion(id, toUser, classBox, box, limit, skip) {
                        if ($(box).hasClass('no-display')) {
                            var json_data = {};
                            json_data.id = id;
                            json_data.toUser = toUser;
                            json_data.classBox = classBox;
                            json_data.box = box;
                            json_data.limit = limit;
                            json_data.skip = skip;
                            $.ajax({
                            type: "POST",
                            url: "content/stream/box/box-opinion.php",
                            data: json_data,
                            async: true,
                            beforeSend: function(xhr) {
                                //spinner.show();											
                                //goSpinnerBox(box, '');
                                console.log('Sono partito loadBoxOpinion(' + id + ', ' + toUser + ', ' + classBox + ', ' + box + ', ' + limit + ', ' + skip + ')');
                            }
                            })
                                .done(function(message, status, xhr) {
                            //spinner.hide();
                            $(box).html(message);
                            $(box).prev().addClass('box-commentSpace');
                            $(box).removeClass('no-display');
                            if (classBox == 'Image') {
                                $("#cboxLoadedContent").mCustomScrollbar("update");
                                //	hcento();
                            }

                            code = xhr.status;
                            //console.log("Code: " + code + " | Message: " + message);
                            console.log("Code: " + code + " | Message: <omitted because too large>");
                            })
                                .fail(function(xhr) {
                            //spinner.hide();
                            //console.log('ERRORE=>'+richiesta+' '+stato+' '+errori);
                            message = $.parseJSON(xhr.responseText).status;
                            code = xhr.status;
                            console.log("Code: " + code + " | Message: " + message);
                            });
                        } else {
                            $(box).prev().removeClass('box-commentSpace');
                            $(box).addClass('no-display');
                        }
                    }
                    </script>
                </div>			
            </div>
        </div>	
    </div>
    <?php
} else {
    header('Location: ' . VIEWS_DIR . '404.php');
}
?>