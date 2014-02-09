<?php
/* box per gli album musicali
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId},
 * data-type: html,
 * type: POST o GET
 *
 * box solo per jammer
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'utilsBox.php';
require_once CLASSES_DIR . 'userParse.class.php';
require_once SERVICES_DIR . 'fileManager.service.php';

if (session_id() == '')
    session_start();
$userId = $_POST['userId'];
$tracklist = tracklistGenerator($_POST['objectId']);
if (isset($_SESSION['currentUser']))
    $currentUser = $_SESSION['currentUser'];
?>
<!----------------------------------------- PLAYER ALBUM ----------------------------------------------->
<div class="row" id="profile-Record">
    <div class="large-12 columns">
        <div class="row">
            <div  class="small-12 columns"><h3><?php echo $views['media']['record']['tracklist'] ?></h3></div>        
        </div> 
        <!---------------------------- ALBUM SINGOLO --------------------------------------------->       
        <div class="box" style="padding: 0px !important;">                
            <?php
            if (count($tracklist) > 0) {
                foreach ($tracklist as $key => $value) {
                    $record_objectId = $value->getObjectId();
                    $record_title = $value->getTitle();
                    $record_duration = $value->getDuration();

                    if ($value->getDuration() >= 3600)
                        $hoursminsandsecs = date('H:i:s', $value->getDuration());
                    else
                        $hoursminsandsecs = date('i:s', $value->getDuration());

                    $css_addPlayList = "";
                    $css_removePlayList = "";
                    if (is_array($_SESSION['playlist']['songs']) && in_array($value->getObjectId(), $_SESSION['playlist']['songs'])) {
                        $css_addPlayList = 'no-display';
                    } else {
                        $css_removePlayList = 'no-display';
                    }
                    $fileManagerService = new FileManagerService();
                    $pathCoverRecord = $fileManagerService->getRecordPhotoPath($userId, $value->getRecord()->getThumbnailCover());
                    $pathSong = $fileManagerService->getSongPath($userId, $value->getFilePath());
                    $song = json_encode(array(
                        'objectId' => $value->getObjectId(),
                        'title' => $value->getTitle(),
                        'artist' => $_POST['username'],
                        'mp3' => $pathSong,
                        'love' => $value->getLoveCounter(),
                        'share' => $value->getShareCounter(),
                        'pathCover' => $pathCoverRecord
                    ));
                    ?>
                    <div class="row" id="<?php echo $value->getObjectId() ?>"> <!------------------ CODICE TRACCIA: track01  ------------------------------------>
                        <div class="small-12 columns ">
                            <div class="track">
                                <div class="row">
                                    <div class="small-9 columns ">                                        
                                        <a class="ico-label _play-large text breakOffTest jpPlay" onclick="playSong('<?php echo $value->getObjectId(); ?>', '<?php echo $pathCoverRecord ?>')"><span class="songTitle"><?php echo $record_title ?></span></a>
                                        <input type="hidden" name="song" value="<?php echo $pathSong . $value->getFilePath(); ?>" />
                                    </div>
                                    <div class="small-3 columns track-propriety align-right" style="padding-right: 20px;">                                        
                                        <a class="icon-propriety _menu-small note orange <?php echo $css_addPlayList ?>" onclick='playlist(this, "add",<?php echo $song ?>)'> <?php echo $views['record']['addplaylist']; ?></a>
                                        <a class="icon-propriety _remove-small note orange <?php echo $css_removePlayList ?>" onclick='playlist(this, "remove",<?php echo $song; ?>)'> <?php echo $views['record']['removeplaylist']; ?></a>
                                    </div>
                                    <div class="small-3 columns track-nopropriety align-right" style="padding-right: 20px;">
                                        <a class="icon-propriety "><?php echo $hoursminsandsecs ?></a>        
                                    </div>                
                                </div>
                                <div class="row track-propriety" >
                                    <div class="box-propriety album-single-propriety">
                                        <div class="small-5 columns ">
                                            <a class="note white" onclick="love(this, 'Song', '<?php echo $record_objectId ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $views['love']; ?></a>
                                            <!--a class="note white" onclick="setCounter(this, '<?php echo $record_objectId ?>', 'Song')"><?php echo $views['share']; ?></a-->        
                                        </div>
                                        <div class="small-5 columns propriety ">                                        
                                            <a class="icon-propriety _unlove grey" ><?php echo $value->getLoveCounter() ?></a>
                                            <!--a class="icon-propriety _share" ><?php echo $value->getShareCounter(); ?></a-->                        
                                        </div>
                                    </div>                
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                ?>        
                <div class="row">
                    <div  class="large-12 columns ">
                        <div class="box">                                                
                            <div class="row">
                                <div  class="large-12 columns"><p class="grey"><?php echo $views['record']['nodata']; ?></p></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="box-comment no-display"></div>

        </div>

        <?php // }    ?>

        <!---------------------------------------- comment ------------------------------------------------->
        <div class="box-comment no-display"></div>
    </div>
</div>