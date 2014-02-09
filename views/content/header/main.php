<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');
require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';

$css_not = 'no-display';
$totNotification = '';

$playlistCurrentUser = array();
?>
<header>
    <!------------------------------------- HIDE HEADER ----------------------------->
    <div id="header-hide" class="no-display bg-black">
        <?php
        if (isset($_SESSION['currentUser'])) {
            $currentUser = $_SESSION['currentUser'];
            $userObjectId = $currentUser->getObjectId();
            $userType = $currentUser->getType();
            ?>
            <script>
                var myPlaylist;
                $(document).ready(function() {
                    myPlaylist = getPlayer();
                });
            </script>		
            <div  class="row hcento-hero" style="padding-bottom: 20px;">
                <div id="header-profile" class="small-6 columns" style="padding-bottom: 20px">
                    <?php require_once './content/header/box-profile.php'; ?>
                </div>
                <!-- TODO - ci devo mettere una chiamata ajax al box per parallelizzare il caricamento-->					
                <script type="text/javascript">
                    function loadBoxPlayList() {
                        var json_data = {};
                        json_data.objectId = '<?php ?>';
                        $.ajax({
                            type: "POST",
                            url: "content/header/box-profile.php",
                            data: json_data,
                            beforeSend: function(xhr) {
                                //spinner.show();
                                console.log('Sono partito header box-profile');
                                goSpinnerBox('#header-profile', '');
                            }
                        }).done(function(message, status, xhr) {
                            //spinner.hide();
                            $("#header-profile").html(message);
                            //plugin share
                            addthis.init();
                            addthis.toolbox(".addthis_toolbox");
                            //adatta pagina per scroll
                            hcento();
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
                </script>			
                <div id="header-social" class="small-6 columns" style="padding-bottom: 20px">				
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
                            <div id="player">	
                                <div class="icon-header" id='header-box-thum'>
                                    <img src="<?php echo DEFRECORDTHUMB; ?>"  onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" alt="<?php echo $currentUser->getUsername(); ?>">
                                </div>				

                                <!------------------------------------- PLAYER ----------------------------->
                                <div id="jquery_jplayer_N"></div>
                                <div id="header-box-player">
                                    <!---------- TITLE --------->
                                    <div class="title-player"></div>
                                    <!---------- TIME MUSIC  --------->
                                    <small id="time-player" class="inline grey">00:00</small>

                                    <!---------- CONTROL --------->
                                    <div id="controls-player" class="inline">
                                        <div id="bar-player"  class="inline"></div>	
                                        <div id="playhead-player"  class="inline"></div>			   	
                                        <div id="statusbar-player" class="inline"></div> 
                                    </div>
                                    <!---------- DURATION MUSIC  --------->
                                    <small id="duration-player"  class="inline grey">00:00</small>

                                    <div id="display">
                                        <!-- a id="back"  class="icon-player _back"></a-->
                                        <a id="pause" class="icon-player _pause play-pause jp-pause" style="display: none;"></a>
                                        <a id="play"  class="icon-player _play play-pause jp-play"></a>
                                        <!-- a id="next"  class="icon-player _next"></a-->					
                                        <span id="execution" ></span>
                                    </div>			
                                </div>
                            </div>		
                            <div class="no-display" id="noPlaylist"><?php echo $views['header']['song'] ?></div>
                        </div>			
                    </div>
                    <!------------------------------------- LOGO --------------------------------------------->
                    <div class="large-2 columns logo" id="header-box-logo">				
                        <div id="logo">
                            <a href="stream.php?user=<?php echo $currentUser->getObjectId(); ?>"><img src="resources/images/header/logo.png" border="0" alt="Jamyourself: Meritocratic Social Music Discovering"></a>
                        </div>					
                    </div>
                    <!------------------------------------- SWITCH -------------------------------------------->
                    <div class="small-5 columns no-display " id='header-box-switch'>
                        <div class="header">
                            <div class="switch round" onclick="getSwich()">
                                <input id="z" name="switch-z" type="radio" checked>
                                <label for="z"><?php echo $views['header']['radio']['profile']; ?></label>

                                <input id="z1" name="switch-z" type="radio">
                                <label for="z1"><?php echo $views['header']['radio']['social']; ?></label>

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
                                                <span><input id='header-btn-search' name='header-btn-search' type="search" class="search" placeholder="<?php echo $views['header']['search'] ?>"></span>
                                                <!-- <span><input type="search" class="search-small show-for-small" placeholder="Cerca "></span> -->
                                            </form>
                                        </div>	
                                    </div>
                                    <div class="large-4 columns hide-for-small " id="header-btn-notify">
                                        <div class="header inline" style="float: right;">
                                            <!--a class="ico-label _flag inline" onclick="headerShow()" ><span class="round alert label iconNotification <?php echo $css_not ?>"><?php echo $totNotification ?></span></a-->
                                             <a class="ico-label _flag inline" onclick="headerShow()" ></a>
                                             <a href="stream.php?user=<?php echo $currentUser->getObjectId(); ?>" class="ico-label _stream inline"></a>
                                            <a class="ico-label _setting inline"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="large-2 small-2 columns">
                                <a id="add-main-btn" class="add inline _add inline"></a>
                            </div>
                        </div>						
                    </div>			
                </div>	

                <div id="add" style="display: none;">
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="add-btn" onclick="location.href = 'uploadRecord.php'"><?php echo $views['header']['optadd1'] ?></div>
                            <div class="add-btn" onclick="location.href = 'uploadEvent.php'"><?php echo $views['header']['optadd2'] ?></div>
                            <div class="add-btn" onclick="location.href = 'uploadAlbum.php'"><?php echo $views['header']['optadd3'] ?></div>
                        </div>
                    </div>
                </div>

                <script>
                    var addState = 0;
                    $('#add-main-btn').click(function() {
                        $('#add').slideToggle();
                        if (addState == 0) {
                            $('._add').css('background-image', 'url(resources/images/icon/close.png)');
                            addState = 1;
                        } else {
                            $('._add').css('background-image', 'url(resources/images/icon/add.png)');
                            addState = 0;
                        }
                    });
                </script>

            </div>


        </div>
    </div>

</header>