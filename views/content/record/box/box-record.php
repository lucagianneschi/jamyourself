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
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$currentUser = $_SESSION['currentUser'];
$data = $_POST['data'];

$tracklist = $data['classinfo']['tracklist'] == $boxes['NOTRACK'] ? array() : $data['classinfo']['tracklist'];

?>
<!----------------------------------------- PLAYER ALBUM ----------------------------------------------->
<div class="row" id="profile-Record">
        <div class="large-12 columns">
        <div class="row">
                        <div  class="small-12 columns">
                                <h3>Tracklist</h3>
                        </div>        
                        
                </div>        
        
        
        <!---------------------------- ALBUM SINGOLO --------------------------------------------->
        <?php //for($i=0; $i<$recordCounter;  $i++){ 
                        
                ?>
        <div class="box" style="padding: 0px !important;">                
                        <?php if(count($tracklist) > 0){  
                                        foreach ($tracklist as $key => $value) {                                                 
                                                $record_objectId = $value['objectId'];
                                                $record_title = $value['title'];
                                                $record_duration = $value['duration'];
                                                $record_counters = $value['counters'];
                                                
                                                
                                                ?>
                        <div class="row  " id="<?php echo $value['objectId'] ?>"> <!------------------ CODICE TRACCIA: track01  ------------------------------------>
                                <div class="small-12 columns ">
                                <div class="track">
                                        <div class="row">
                                                <div class="small-9 columns ">                                        
                                                        <a class="ico-label _play-large text breakOffTest"><?php echo $record_title?></a>
                                                                
                                                </div>
                                                <div class="small-3 columns track-propriety align-right" style="padding-right: 15px;">                                        
                                                        <a class="icon-propriety _menu-small note orange "> <?php echo $views['record']['ADDPLAYLIST'];?></a>
                                                                                                                                                
                                                </div>
                                                <div class="small-3 columns track-nopropriety align-right" style="padding-right: 15px;">
                                                        <a class="icon-propriety "><?php echo $record_duration ?></a>        
                                                </div>                
                                        </div>
                                        <div class="row track-propriety" >
                                                <div class="box-propriety album-single-propriety">
                                                        <div class="small-5 columns ">
                                                                <a class="note white" onclick="love(this, 'Song', '<?php echo $value['objectId'] ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $views['LOVE'];?></a>
                                                                <a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $views['SHARE'];?></a>        
                                                        </div>
                                                        <div class="small-5 columns propriety ">                                        
                                                                <a class="icon-propriety _unlove grey" ><?php echo $record_counters['loveCounter'] ?></a>
                                                                <a class="icon-propriety _share" ><?php echo $record_counters['shareCounter'] ?></a>                        
                                                        </div>
                                                </div>                
                                        </div>
                                </div>
                                </div>
                        </div>
                        
                        <?php } } else{ ?>        
                        <div class="row">
                                <div  class="large-12 columns ">
                                        <div class="box">                                                
                                                <div class="row">
                                                        <div  class="large-12 columns"><p class="grey"><?php echo $views['record']['NODATA'];?></p></div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                        <?php } ?>
                        <div class="box-comment no-display"></div>
                                
        </div>
                        
        <?php // } ?>
        
        <!---------------------------------------- comment ------------------------------------------------->
        <div class="box-comment no-display"></div>
        </div>
</div>