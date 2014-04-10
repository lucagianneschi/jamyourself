<?php
ini_set('display_errors', '1');

/* box le activity
 * box chiamato tramite ajax con:
 * data-type: html,
 * type: POST o GET
 *
 */

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'log.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'stream.box.php';
require_once CLASSES_DIR . 'user.class.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'connection.service.php';
require_once SERVICES_DIR . 'select.service.php';

if (session_id() == '')
    session_start();

$currentUserId = $_SESSION['id'];
$streamBox = new StreamBox();
$streamBox->init(10);
if (is_null($streamBox->error)) {
    $activities = $streamBox->activitiesArray;
    ?>
    <!---------------- POST ----------------->
    <h3><?php echo $views['stream']['write_post']; ?></h3>
    <div class="row  ">
        <div class="large-12 columns ">
            <form action="" class="box-write" onsubmit="sendPost('', $('#post').val());
                        return false;">
                <div class="">
                    <div class="row  ">
                        <div class="small-9 columns ">
                            <input id="post" type="text" class="post inline" placeholder="<?php echo $views['stream']['spread_world']; ?>">
                        </div>
                        <div class="small-3 columns ">
                            <input type="button" id="button-post" class="post-button inline" value="<?php echo $views['post_button']; ?>" onclick="sendPost('<?php echo $currentUserId; ?>', $('#post').val())">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!---------------- STREAM ----------------->
    <h3 style="margin-top:30px"><?php echo $views['stream']['stream']; ?></h3>
    <?php
    if (count($activities) == 0) {
        ?>
        Nessuna attivit&agrave; da visualizzare
        <?php
    }
    $connectionService = new ConnectionService();
    foreach ($activities as $activity) {
        $object = $activity['object'];
        $relObject = $activity['referredObject'];
        $type = $activity['type'];
        $love = $activity['love'];
        
        #DEBUG
        #print_r($activity);
        #echo 'Type => ' . $type;
        
        if ($type == 'COLLABORATIONREQUEST' ||
            $type == 'FOLLOWING' ||
            $type == 'FRIENDSHIPREQUEST') {
            $fromuser = $relObject;
        } else {
            $fromuser = $object->getFromuser();
            //Only in this case I have the counter
            $loveCounter = $object->getLovecounter();
            $commentCounter = $object->getCommentcounter();
            $shareCounter = $object->getSharecounter();
            if ($love > 0) {
                $css_love = '_love orange';
                $text_love = $views['unlove'];
            } else {
                $css_love = '_unlove grey';
                $text_love = $views['love'];
            }
        }
        
        ?>
        <div id="<?php echo $object->getId(); ?>">
            <div class="box">
                <a href="profile.php?user=<?php echo $fromuser->getId(); ?>">
                    <div class="row line">
                        <div class="small-1 columns ">
                            <div class="icon-header">
                                <?php
                                switch ($fromuser->getType()) {
                                    case 'JAMMER':
                                        $defaultThumb = DEFTHUMBJAMMER;
                                        break;
                                    case 'VENUE':
                                        $defaultThumb = DEFTHUMBVENUE;
                                        break;
                                    case 'SPOTTER':
                                        $defaultThumb = DEFTHUMBSPOTTER;
                                        break;
                                }
                                ?>
                                <!--THUMB FROMUSER-->
                                <?php
                                $fileManagerService = new FileManagerService();
                                $pathPictureThumbFromUser = $fileManagerService->getPhotoPath($fromuser->getId(), $fromuser->getThumbnail());
                                ?>
                                <img src="<?php echo $pathPictureThumbFromUser; ?>" onerror="this.src='<?php echo $defaultThumb; ?>'" alt="<?php echo $fromuser->getUsername(); ?>">
                            </div>
                        </div>
                        <div class="small-5 columns">
                            <div class="text grey" style="margin-bottom: 0px;">
                                <strong><?php echo $fromuser->getUsername(); ?></strong>
                            </div>
                            <div class="note orange">
                                <strong><?php echo $fromuser->getType(); ?></strong>
                            </div>
                        </div>
                        <div class="small-6 columns propriety">
                            <div class="note grey-light">
                                <?php echo ucwords(strftime("%A %d %B %Y - %H:%M", $object->getCreatedat()->getTimestamp())); ?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
                
                switch ($type) {
                    case 'ALBUMCREATED':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['new_photo']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $object->getTitle(); ?> - <?php echo $object->getImagecounter(); ?> <?php echo $views['stream']['photos']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL ALBUM -->
                                                        <?php
                                                        $fileManagerService = new FileManagerService();
                                                        $pathAlbumThumb = $fileManagerService->getPhotoPath($object->getFromuser()->getId(), $object->getThumbnail());
                                                        ?>
                                                        <li><a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathAlbumThumb; ?>" onerror="this.src='<?php echo DEFALBUMTHUMB; ?>'" alt></a></li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'COLLABORATIONREQUEST':
                        ?>
                        <div class="row">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['just_added']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-6 columns">
                                                <div class="box-membre">
                                                    <div class="row " id="collaborator_03VPczLItB">
                                                        <div class="small-3 columns ">
                                                            <div class="icon-header">
                                                                <?php
                                                                switch ($object->getType()) {
                                                                    case 'JAMMER':
                                                                        $defThumb = DEFTHUMBJAMMER;
                                                                        break;
                                                                    case 'VENUE':
                                                                        $defThumb = DEFTHUMBVENUE;
                                                                        break;
                                                                }
                                                                ?>
                                                                <?php
                                                                $fileManagerService = new FileManagerService();
                                                                $pathPictureThumbToUser = $fileManagerService->getPhotoPath($object->getId(), $object->getThumbnail());
                                                                ?>
                                                                <!--THUMB TOUSER-->
                                                                <img src="<?php echo $pathPictureThumbToUser; ?>" onerror="this.src='<?php echo $defThumb; ?>'" alt="<?php echo $object->getUsername(); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="small-9 columns ">
                                                            <div class="text grey-dark breakOffTest"><strong><?php echo $object->getUsername(); ?></strong></div>
                                                        </div>		
                                                    </div>	
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <?php
                        break;
                    case 'COMMENTEDONALBUM':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['comm_album']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $relObject->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <li>
                                                            <!-- THUMBNAIL ALBUM -->
                                                            <?php
                                                            $fileManagerService = new FileManagerService();
                                                            $pathAlbumThumb = $fileManagerService->getPhotoPath($relObject->getFromuser()->getId(), $relObject->getThumbnail());
                                                            ?>
                                                            <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathAlbumThumb; ?>" onerror="this.src='<?php echo DEFALBUMTHUMB; ?>'" alt="<?php echo $relObject->getTitle(); ?>"></a>
                                                        </li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'COMMENTEDONIMAGE':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['comm_img']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF THE CLASS -->
                                                        <li>
                                                            <!-- THUMBNAIL IMAGE -->
                                                            <?php
                                                            $fileManagerService = new FileManagerService();
                                                            $pathImageThumb = $fileManagerService->getPhotoPath($relObject->getFromuser()->getId(), $relObject->getThumbnail());
                                                            ?>
                                                            <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathImageThumb; ?>" onerror="this.src='<?php echo DEFIMAGETHUMB; ?>'" alt></a>
                                                        </li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'COMMENTEDONEVENT':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['comm_event']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $relObject->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <li>
                                                            <!-- THUMBNAIL EVENT -->
                                                            <?php
                                                            $fileManagerService = new FileManagerService();
                                                            $pathEventThumb = $fileManagerService->getEventPhotoPath($relObject->getFromuser()->getId(), $relObject->getThumbnail());
                                                            ?>
                                                            <a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $relObject->getId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'" alt="<?php echo $relObject->getTitle(); ?>"></a>
                                                        </li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'COMMENTEDONEVENTREVIEW':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['comm_event_rev']; ?></div>
                                                <div class="sottotitle grey-dark">
                                                    <?php
                                                    echo $object->getText();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <li>
                                                            <!-- THUMBNAIL EVENT -->
                                                            <?php
                                                            $fileManagerService = new FileManagerService();
                                                            $pathEventThumb = $fileManagerService->getEventPhotoPath($relObject->getFromuser()->getId(), $relObject->getThumbnail());
                                                            ?>
                                                            <a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $relObject->getId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'" alt="<?php echo $relObject->getTitle(); ?>"></a>
                                                        </li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;    
                    case 'COMMENTEDONPOST':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['comm_post']; ?></div>
                                                <div class="sottotitle grey-dark">
                                                    <?php
                                                    echo $relObject->getText();
                                                    ?>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'COMMENTEDONRECORD':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['comm_record']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $relObject->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <li>
                                                            <!-- THUMBNAIL RECORD -->
                                                            <?php
                                                            $fileManagerService = new FileManagerService();
                                                            $pathRecordThumb = $fileManagerService->getRecordPhotoPath($value->getFromuser()->getId(), $value->getRecord()->getThumbnail());
                                                            ?>
                                                            <a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $relObject->getId(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" alr="<?php echo $relObject->getTitle(); ?>"></a>
                                                        </li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'COMMENTEDONRECORDREVIEW':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['comm_record_rev']; ?></div>
                                                <div class="sottotitle grey-dark">
                                                    <?php
                                                    echo $object->getText();
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL RECORD -->
                                                        <?php
                                                        $fileManagerService = new FileManagerService();
                                                        $pathRecordThumb = $fileManagerService->getRecordPhotoPath($relObject->getFromuser()->getId(), $relObject->getThumbnail());
                                                        ?>
                                                        <li><a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $relObject->getRecord(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" alt="<?php echo $relObject->getTitle(); ?>"></a></li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'COMMENTEDONVIDEO':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['comm_video']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $relObject->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF THE CLASS -->
                                                        <li>
                                                            <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $relObject->getThumbnail(); ?>" onerror="this.src='<?php echo DEFVIDEOTHUMB; ?>'"></a>
                                                        </li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'EVENTCREATED':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['new_event']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $object->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL EVENT -->
                                                        <?php
                                                        $fileManagerService = new FileManagerService();
                                                        $pathEventThumb = $fileManagerService->getEventPhotoPath($object->getFromuser()->getId(), $object->getThumbnail());
                                                        ?>
                                                        <li><a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $object->getId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'" alt="<?php echo $object->getTitle(); ?>"></a></li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'FOLLOWING':
                        ?>
                        <div class="row">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['just_added']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-6 columns">
                                                <div class="box-membre">
                                                    <div class="row " id="collaborator_03VPczLItB">
                                                        <div class="small-3 columns ">
                                                            <div class="icon-header">
                                                                <!--THUMB TOUSER-->
                                                                <?php
                                                                $fileManagerService = new FileManagerService();
                                                                $pathPictureThumbToUser = $fileManagerService->getPhotoPath($object->getId(), $object->getThumbnail());
                                                                ?>
                                                                <img src="<?php echo $pathPictureThumbToUser; ?>" onerror="this.src='<?php echo $defThumb; ?>'" alt="<?php echo $object->getUsername(); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="small-9 columns ">
                                                            <div class="text grey-dark breakOffTest"><strong><?php echo $object->getUsername(); ?></strong></div>
                                                        </div>		
                                                    </div>	
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <?php
                        break;
                    case 'FRIENDSHIPREQUEST':
                        ?>
                        <div class="row">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['just_added']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-6 columns">
                                                <div class="box-membre">
                                                    <div class="row " id="collaborator_03VPczLItB">
                                                        <div class="small-3 columns ">
                                                            <div class="icon-header">
                                                                <!--THUMB TOUSER-->
                                                                <?php
                                                                $fileManagerService = new FileManagerService();
                                                                $pathPictureThumbToUser = $fileManagerService->getPhotoPath($object->getId(), $object->getThumbnail());
                                                                ?>
                                                                <img src="<?php echo $pathPictureThumbToUser; ?>" onerror="this.src='<?php echo $defThumb; ?>'" alt="<?php echo $object->getUsername(); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="small-9 columns ">
                                                            <div class="text grey-dark breakOffTest"><strong><?php echo $object->getUsername(); ?></strong></div>
                                                        </div>		
                                                    </div>	
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        <?php
                        break;
                    case 'IMAGEADDEDTOALBUM':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['add_img']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $object->getAlbum()->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <li>
                                                            <!--THUMB Image-->
                                                            <?php
                                                            $fileManagerService = new FileManagerService();
                                                            $pathImageThumb = $fileManagerService->getPhotoPath($object->getFromuser()->getId(), $object->getThumbnail());
                                                            ?>
                                                            <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathImageThumb; ?>" onerror="this.src='<?php echo DEFIMAGETHUMB; ?>'" alt></a>
                                                        </li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'NEWEVENTREVIEW':
                        ?>
                        <div class="row  line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['event_review']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-2 columns ">
                                                <!-- THUMBNAIL EVENT -->
                                                <?php
                                                $fileManagerService = new FileManagerService();
                                                $pathEventThumb = $fileManagerService->getEventPhotoPath($refObject->getFromuser()->getId(), $refObject->getThumbnail());
                                                ?>
                                                <div class="coverThumb"><a href="event.php?event=<?php echo $refObject->getId(); ?>"><img src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'" alt="<?php echo $refObject->getTitle(); ?>"></a></div>
                                            </div>
                                            <div class="small-10 columns ">
                                                <div class="row ">							
                                                    <div class="small-12 columns ">
                                                        <div class="sottotitle grey-dark">
                                                            <?php
                                                            echo $object->getText();
                                                            ?>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'NEWRECORDREVIEW':
                        ?>
                        <div class="row  line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['record_review']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-2 columns "
                                                 <!-- THUMBNAIL EVENT -->
                                                 <?php
                                                 $fileManagerService = new FileManagerService();
                                                 $pathRecordThumb = $fileManagerService->getRecordPhotoPath($refObject->getFromuser()->getId(), $refObject->getThumbnail());
                                                 ?>
                                                 <div class="coverThumb"><a href="record.php?record=<?php echo $pathRecordThumb; ?>"><img src="<?php echo $refObject->getThumbnail(); ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" alt="<?php echo $refObject->getTitle(); ?>"></a></div>
                                            </div>
                                            <div class="small-10 columns ">
                                                <div class="row ">							
                                                    <div class="small-12 columns ">
                                                        <div class="sottotitle grey-dark">
                                                            <?php
                                                            echo $object->getText();
                                                            ?>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'POSTED':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="text grey">
                                            <?php
                                            echo $object->getText();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="box-propriety">
                                <div class="small-7 columns ">
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'RECORDCREATED':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['record_created']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $object->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL RECORD -->
                                                        <?php
                                                        $fileManagerService = new FileManagerService();
                                                        $pathRecordThumb = $fileManagerService->getRecordPhotoPath($object->getFromuser()->getId(), $object->getThumbnail());
                                                        ?>
                                                        <li>
                                                            <a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $object->getId(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a>
                                                        </li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'SONGADDEDTORECORD':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['song_added']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $object->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL RECORD -->
                                                        <?php
                                                        $fileManagerService = new FileManagerService();
                                                        $pathRecordThumb = $fileManagerService->getRecordPhotoPath($object->getFromuser()->getId(), $object->getRecord()->getThumbnail());
                                                        ?>
                                                        <li><a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $object->getRecord()->getId(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a></li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                    case 'RECORDCREATED':
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['record_created']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $object->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL RECORD -->
                                                        <?php
                                                        $fileManagerService = new FileManagerService();
                                                        $pathRecordThumb = $fileManagerService->getRecordPhotoPath($object->getFromuser()->getId(), $object->getThumbnail());
                                                        ?>
                                                        <li>
                                                            <a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $object->getId(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a>
                                                        </li>
                                                    </ul>
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
                                    <a class="note grey" onclick=""><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['comm']; ?></a>
                                    <a class="note grey" onclick=""><?php echo $views['share']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $loveCounter; ?></a>
                                    <a class="icon-propriety _comment"><?php echo $commentCounter; ?></a>
                                    <a class="icon-propriety _share"><?php echo $shareCounter; ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-opinion no-display"></div>
                        </div>
                        <?php
                        break;
                }
    }
}
?>