<?php
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

if (session_id() == '')
    session_start();

$currentUserId = $_SESSION['id'];
$streamBox = new StreamBox();
$streamBox->init(10);
if (is_null($streamBox->error)) {
    $activities = $streamBox->activitiesArray;
    $activityCounter = count($activities);
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
    foreach ($activities as $activity) {
        $value = $activity['object'];
        ?>
        <div id="<?php echo $value->getId(); ?>">
            <div class="box">
                <a href="profile.php?user=<?php echo $value->getFromuser()->getId(); ?>">
                    <div class="row line">
                        <div class="small-1 columns ">
                            <div class="icon-header">
                                <?php
                                switch ($value->getFromuser()->getType()) {
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
                                $pathPictureThumbFromUser = $fileManagerService->getPhotoPath($value->getFromuser()->getId(), $value->getFromuser()->getThumbnail());
                                ?>
                                <img src="<?php echo $pathPictureThumbFromUser; ?>" onerror="this.src='<?php echo $defaultThumb; ?>'" alt="<?php echo $value->getFromuser()->getUsername(); ?>">
                            </div>
                        </div>
                        <div class="small-5 columns">
                            <div class="text grey" style="margin-bottom: 0px;">
                                <strong><?php echo $value->getFromuser()->getUsername(); ?></strong>
                            </div>
                            <div class="note orange">
                                <strong><?php echo $value->getFromuser()->getType(); ?></strong>
                            </div>
                        </div>
                        <div class="small-6 columns propriety">
                            <div class="note grey-light">
                                <?php echo ucwords(strftime("%A %d %B %Y - %H:%M", $value->getCreatedat()->getTimestamp())); ?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
                /*
                switch ($value->getType()) {
                    case 'ALBUMCREATED':
                        if (is_array($value->getAlbum()->getLovers()) && in_array($currentUser->getId(), $value->getAlbum()->getLovers())) {
                            $css_love = '_love orange';
                            $text_love = $views['UNLOVE'];
                        } else {
                            $css_love = '_unlove grey';
                            $text_love = $views['LOVE'];
                        }
                        ?>
                        <div class="row line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange"><?php echo $views['stream']['new_photo']; ?></div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?> - <?php echo $value->getAlbum()->getImagecounter(); ?> <?php echo $views['stream']['photos']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL ALBUM -->
                                                        <?php
                                                        $fileManagerService = new FileManagerService();
                                                        $pathAlbumThumb = $fileManagerService->getPhotoPath($value->getFromuser()->getId(), $value->getAlbum()->getThumbnail());
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
                                    <a class="note grey" onclick="love(this, 'Album', '<?php echo $value->getAlbum()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                                    <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getAlbum()->getId(); ?>', '<?php echo $value->getAlbum()->getFromuser()->getId(); ?>', 'Album', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getAlbum()->getLovecounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getAlbum()->getCommentcounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getAlbum()->getSharecounter(); ?></a>
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
                                                        switch ($value->getTouser()->getType()) {
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
                                                        $pathPictureThumbToUser = $fileManagerService->getPhotoPath($value->getTouser()->getId(), $value->getFromuser()->getThumbnail());
                                                        ?>
                                                        <!--THUMB TOUSER-->
                                                        <img src="<?php echo $pathPictureThumbToUser; ?>" onerror="this.src='<?php echo $defThumb; ?>'" alt="<?php echo $value->getTouser()->getUsername(); ?>">
                                                    </div>
                                                </div>
                                                <div class="small-9 columns ">
                                                    <div class="text grey-dark breakOffTest"><strong><?php echo $value->getTouser()->getUsername(); ?></strong></div>
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
                if (is_array($value->getAlbum()->getLovers()) && in_array($currentUser->getId(), $value->getAlbum()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['comm_album']; ?></div>
                                        <div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?></div>
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
                                                    $pathAlbumThumb = $fileManagerService->getPhotoPath($value->getAlbum()->getFromuser()->getId(), $value->getAlbum()->getThumbnail());
                                                    ?>
                                                    <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathAlbumThumb; ?>" onerror="this.src='<?php echo DEFALBUMTHUMB; ?>'" alt="<?php echo $value->getAlbum()->getTitle(); ?>"></a>
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
                            <a class="note grey" onclick="love(this, 'Album', '<?php echo $value->getAlbum()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getAlbum()->getId(); ?>', '<?php echo $value->getAlbum()->getFromuser()->getId(); ?>', 'Album', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getAlbum()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getAlbum()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getAlbum()->getSharecounter(); ?></a>
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
                if (is_array($value->getImage()->getLovers()) && in_array($currentUser->getId(), $value->getImage()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
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
                                                    $pathImageThumb = $fileManagerService->getPhotoPath($value->getImage()->getFromuser()->getId(), $value->getImage()->getThumbnail());
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
                            <a class="note grey" onclick="love(this, 'Image', '<?php echo $value->getImage()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getImage()->getId(); ?>', '<?php echo $value->getImage()->getFromuser()->getId(); ?>', 'Image', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getImage()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getImage()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getImage()->getSharecounter(); ?></a>
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
                if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getId(), $value->getEvent()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['comm_event']; ?></div>
                                        <div class="sottotitle grey-dark"><?php echo $value->getEvent()->getTitle(); ?></div>
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
                                                    $pathEventThumb = $fileManagerService->getEventPhotoPath($value->getEvent()->getFromuser()->getId(), $value->getEvent()->getThumbnail());
                                                    ?>
                                                    <a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $value->getEvent()->getId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'" alt="<?php echo $value->getEvent()->getTitle(); ?>"></a>
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
                            <a class="note grey" onclick="love(this, 'Event', '<?php echo $value->getEvent()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getEvent()->getId(); ?>', '<?php echo $value->getEvent()->getFromuser()->getId(); ?>', 'Event', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getEvent()->getSharecounter(); ?></a>
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
                if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getId(), $value->getComment()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
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
                                            echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
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
                                                    $pathEventThumb = $fileManagerService->getEventPhotoPath($value->getEvent()->getFromuser()->getId(), $value->getEvent()->getThumbnail());
                                                    ?>
                                                    <a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $value->getEvent()->getId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'" alt="<?php echo $value->getEvent()->getTitle(); ?>"></a>
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
                            <a class="note grey" onclick="love(this, 'Comment', '<?php echo $value->getComment()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getComment()->getId(); ?>', '<?php echo $value->getComment()->getFromuser()->getId(); ?>', 'EventReview', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getComment()->getSharecounter(); ?></a>
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
                if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getId(), $value->getComment()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
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
                                            echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
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
                            <a class="note grey" onclick="love(this, 'Comment', '<?php echo $value->getComment()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getComment()->getId(); ?>', '<?php echo $value->getComment()->getFromuser()->getId(); ?>', 'Comment', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getComment()->getSharecounter(); ?></a>
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
                if (is_array($value->getRecord()->getLovers()) && in_array($currentUser->getId(), $value->getRecord()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['comm_record']; ?></div>
                                        <div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
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
                                                    <a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $value->getRecord()->getId(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" alr="<?php echo $value->getRecord()->getTitle(); ?>"></a>
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
                            <a class="note grey" onclick="love(this, 'Record', '<?php echo $value->getRecord()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getRecord()->getId(); ?>', '<?php echo $value->getRecord()->getFromuser()->getId(); ?>', 'Record', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getRecord()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getRecord()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getRecord()->getSharecounter(); ?></a>
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
                if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getId(), $value->getComment()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
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
                                            echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
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
                                                $pathRecordThumb = $fileManagerService->getRecordPhotoPath($value->getRecord()->getFromuser()->getId(), $value->getRecord()->getThumbnail());
                                                ?>
                                                <li><a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $value->getComment()->getRecord(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" alt="<?php echo $value->getRecord()->getTitle(); ?>"></a></li>
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
                            <a class="note grey" onclick="love(this, 'Comment', '<?php echo $value->getComment()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getComment()->getId(); ?>', '<?php echo $value->getComment()->getFromuser()->getId(); ?>', 'RecordReview', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getComment()->getSharecounter(); ?></a>
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
                if (is_array($value->getVideo()->getLovers()) && in_array($currentUser->getId(), $value->getVideo()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['comm_video']; ?></div>
                                        <div class="sottotitle grey-dark"><?php echo $value->getVideo()->getTitle(); ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 columns">
                                        <div id="box-albumDetail" style="margin-top: 10px;">
                                            <ul class="small-block-grid-3 small-block-grid-2 ">
                                                <!-- THUMBNAIL OF THE CLASS -->
                                                <li>
                                                    <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $value->getVideo()->getThumbnail(); ?>" onerror="this.src='<?php echo DEFVIDEOTHUMB; ?>'"></a>
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
                            <a class="note grey" onclick="love(this, 'Video', '<?php echo $value->getVideo()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getVideo()->getId(); ?>', '<?php echo $value->getVideo()->getFromuser()->getId(); ?>', 'Video', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getVideo()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getVideo()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getVideo()->getSharecounter(); ?></a>
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
                if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getId(), $value->getEvent()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['new_event']; ?></div>
                                        <div class="sottotitle grey-dark"><?php echo $value->getEvent()->getTitle(); ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 columns">
                                        <div id="box-albumDetail" style="margin-top: 10px;">
                                            <ul class="small-block-grid-3 small-block-grid-2 ">
                                                <!-- THUMBNAIL EVENT -->
                                                <?php
                                                $fileManagerService = new FileManagerService();
                                                $pathEventThumb = $fileManagerService->getEventPhotoPath($value->getFromuser()->getId(), $value->getEvent()->getThumbnail());
                                                ?>
                                                <li><a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $value->getEvent()->getId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'" alt="<?php echo $value->getEvent()->getTitle(); ?>"></a></li>
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
                            <a class="note grey" onclick="love(this, 'Event', '<?php echo $value->getEvent()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getEvent()->getId(); ?>', '<?php echo $value->getEvent()->getFromuser()->getId(); ?>', 'Event', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getEvent()->getSharecounter(); ?></a>
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
                                                        $pathPictureThumbToUser = $fileManagerService->getPhotoPath($value->getTouser()->getId(), $value->getTouser()->getThumbnail());
                                                        ?>
                                                        <img src="<?php echo $pathPictureThumbToUser; ?>" onerror="this.src='<?php echo $defThumb; ?>'" alt="<?php echo $value->getTouser()->getUsername(); ?>">
                                                    </div>
                                                </div>
                                                <div class="small-9 columns ">
                                                    <div class="text grey-dark breakOffTest"><strong><?php echo $value->getTouser()->getUsername(); ?></strong></div>
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
                                                        $pathPictureThumbToUser = $fileManagerService->getPhotoPath($value->getTouser()->getId(), $value->getTouser()->getThumbnail());
                                                        ?>
                                                        <img src="<?php echo $pathPictureThumbToUser; ?>" onerror="this.src='<?php echo $defThumb; ?>'" alt="<?php echo $value->getTouser()->getUsername(); ?>">
                                                    </div>
                                                </div>
                                                <div class="small-9 columns ">
                                                    <div class="text grey-dark breakOffTest"><strong><?php echo $value->getTouser()->getUsername(); ?></strong></div>
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
                if (is_array($value->getImage()->getLovers()) && in_array($currentUser->getId(), $value->getImage()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['add_img']; ?></div>
                                        <div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?></div>
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
                                                    $pathImageThumb = $fileManagerService->getPhotoPath($value->getFromuser()->getId(), $value->getImage()->getThumbnail());
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
                            <a class="note grey" onclick="love(this, 'Image', '<?php echo $value->getImage()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getImage()->getId(); ?>', '<?php echo $value->getImage()->getFromuser()->getId(); ?>', 'Image', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getImage()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getImage()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getImage()->getSharecounter(); ?></a>
                        </div>
                    </div>
                </div>
                </div>
                <!---- COMMENT ---->
                <div class="box-opinion no-display"></div>
                </div>
                <?php
                break;
            case 'IMAGEUPLOADED':
                if (is_array($value->getImage()->getLovers()) && in_array($currentUser->getId(), $value->getImage()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['image_uploaded']; ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 columns">
                                        <div id="box-albumDetail" style="margin-top: 10px;">
                                            <ul class="small-block-grid-3 small-block-grid-2 ">
                                                <!--THUMB Image-->
                                                <?php
                                                $fileManagerService = new FileManagerService();
                                                $pathImageThumb = $fileManagerService->getPhotoPath($value->getFromuser()->getId(), $value->getImage()->getThumbnail());
                                                ?>
                                                <li><a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="<?php echo $pathImageThumb; ?>" onerror="this.src='<?php echo DEFIMAGETHUMB; ?>'" alt></a></li>
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
                            <a class="note grey" onclick="love(this, 'Image', '<?php echo $value->getImage()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getImage()->getId(); ?>', '<?php echo $value->getImage()->getFromuser()->getId(); ?>', 'Image', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getImage()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getImage()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getImage()->getSharecounter(); ?></a>
                        </div>
                    </div>
                </div>
                </div>
                <!---- COMMENT ---->
                <div class="box-opinion no-display"></div>
                </div>
                <?php
                break;
            case 'INVITED':
                if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getId(), $value->getEvent()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['invite_ok']; ?></div>
                                        <div class="sottotitle grey-dark"><?php echo $value->getEvent()->getTitle(); ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 columns">
                                        <div id="box-albumDetail" style="margin-top: 10px;">
                                            <ul class="small-block-grid-3 small-block-grid-2 ">
                                                <!-- THUMBNAIL EVENT -->
                                                <?php
                                                $fileManagerService = new FileManagerService();
                                                $pathEventThumb = $fileManagerService->getEventPhotoPath($value->getEvent()->getFromuser()->getId(), $value->getEvent()->getThumbnail());
                                                ?>
                                                <li>
                                                    <a class="photo-colorbox-group cboxElement" href="event.php?event=<?php echo $value->getEvent()->getId(); ?>"><img class="photo" src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'"></a>
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
                            <a class="note grey" onclick="love(this, 'Event', '<?php echo $value->getEvent()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getEvent()->getId(); ?>', '<?php echo $value->getEvent()->getFromuser()->getId(); ?>', 'Event', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getEvent()->getSharecounter(); ?></a>
                        </div>
                    </div>
                </div>
                </div>
                <!---- COMMENT ---->
                <div class="box-opinion no-display"></div>
                </div>
                <?php
                break;
            case 'NEWBADGE':
                ?>
                <div class="row">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['new_badge']; ?></div>
                                    </div>
                                </div>
                                <div class="row newBadge">
                                    <div class="small-2 columns">
                                        <div class="badgeThumb"><img src="views/resources/images/badge/badgeElectro.png" onerror="this.src='<?php echo BADGE0; ?>'"></div>						
                                    </div>
                                    <div class="small-10 columns ">
                                        <div class="row ">							
                                            <div class="small-12 columns ">
                                                <h5>Electro Addicted</h5>
                                                <p>Descrizione lunga badge</p>
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
            case 'NEWEVENTREVIEW':
                if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getId(), $value->getEvent()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
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
                                        $pathEventThumb = $fileManagerService->getEventPhotoPath($value->getEvent()->getFromuser()->getId(), $value->getEvent()->getThumbnail());
                                        ?>
                                        <div class="coverThumb"><a href="event.php?event=<?php echo $value->getEvent()->getId(); ?>"><img src="<?php echo $pathEventThumb; ?>" onerror="this.src='<?php echo DEFEVENTTHUMB; ?>'" alt="<?php echo $value->getEvent()->getTitle(); ?>"></a></div>
                                    </div>
                                    <div class="small-10 columns ">
                                        <div class="row ">							
                                            <div class="small-12 columns ">
                                                <div class="sottotitle grey-dark">
                                                    <?php
                                                    echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
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
                            <a class="note grey" onclick="love(this, 'Event', '<?php echo $value->getEvent()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getEvent()->getId(); ?>', '<?php echo $value->getEvent()->getFromuser()->getId(); ?>', 'Event', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getEvent()->getSharecounter(); ?></a>
                        </div>
                    </div>
                </div>
                </div>
                <!---- COMMENT ---->
                <div class="box-opinion no-display"></div>
                </div>
                <?php
                break;
            case 'NEWLEVEL':
                ?>
                <div class="row">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['new_level']; ?></div>
                                        <div class="sottotitle grey-dark">Titolo del Livello</div>
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
            case 'NEWRECORDREVIEW':
                if (is_array($value->getRecord()->getLovers()) && in_array($currentUser->getId(), $value->getRecord()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
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
                                         $pathRecordThumb = $fileManagerService->getRecordPhotoPath($value->getRecord()->getFromuser()->getId(), $value->getRecord()->getThumbnail());
                                         ?>
                                         <div class="coverThumb"><a href="record.php?record=<?php echo $pathRecordThumb; ?>"><img src="<?php echo $value->getRecord()->getThumbnail(); ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'" alt="<?php echo $value->getRecord()->getTitle(); ?>"></a></div>
                                    </div>
                                    <div class="small-10 columns ">
                                        <div class="row ">							
                                            <div class="small-12 columns ">
                                                <div class="sottotitle grey-dark">
                                                    <?php
                                                    echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
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
                            <a class="note grey" onclick="love(this, 'Record', '<?php echo $value->getRecord()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getRecord()->getId(); ?>', '<?php echo $value->getRecord()->getFromuser()->getId(); ?>', 'RecordReview', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getRecord()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getRecord()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getRecord()->getSharecounter(); ?></a>
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
                if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getId(), $value->getComment()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="text grey">
                                    <?php
                                    echo strlen($value->getComment()->getText()) <= 25 ? $value->getComment()->getText() : substr($value->getComment()->getText(), 0, 25) . ' ...';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box-propriety">
                        <div class="small-7 columns ">
                            <a class="note grey" onclick="love(this, 'Comment', '<?php echo $value->getComment()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getComment()->getId(); ?>', '<?php echo $value->getComment()->getFromuser()->getId(); ?>', 'Comment', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getComment()->getSharecounter(); ?></a>
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
                if (is_array($value->getRecord()->getLovers()) && in_array($currentUser->getId(), $value->getRecord()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['record_created']; ?></div>
                                        <div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 columns">
                                        <div id="box-albumDetail" style="margin-top: 10px;">
                                            <ul class="small-block-grid-3 small-block-grid-2 ">
                                                <!-- THUMBNAIL RECORD -->
                                                <?php
                                                $fileManagerService = new FileManagerService();
                                                $pathRecordThumb = $fileManagerService->getRecordPhotoPath($value->getFromuser()->getId(), $value->getRecord()->getThumbnail());
                                                ?>
                                                <li>
                                                    <a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $value->getRecord()->getId(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a>
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
                            <a class="note grey" onclick="love(this, 'Record', '<?php echo $value->getRecord()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getRecord()->getId(); ?>', '<?php echo $value->getRecord()->getFromuser()->getId(); ?>', 'Record', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getRecord()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getRecord()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getRecord()->getSharecounter(); ?></a>
                        </div>
                    </div>
                </div>
                </div>
                <!---- COMMENT ---->
                <div class="box-opinion no-display"></div>
                </div>
                <?php
                break;
            case 'SONGAADDEDTORECORD':
                if (is_array($value->getSong()->getLovers()) && in_array($currentUser->getId(), $value->getSong()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['song_added']; ?></div>
                                        <div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-12 columns">
                                        <div id="box-albumDetail" style="margin-top: 10px;">
                                            <ul class="small-block-grid-3 small-block-grid-2 ">
                                                <!-- THUMBNAIL RECORD -->
                                                <?php
                                                $fileManagerService = new FileManagerService();
                                                $pathRecordThumb = $fileManagerService->getRecordPhotoPath($value->getFromuser()->getId(), $value->getRecord()->getThumbnail());
                                                ?>
                                                <li><a class="photo-colorbox-group cboxElement" href="record.php?record=<?php echo $value->getSong()->getRecord(); ?>"><img class="photo" src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a></li>
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
                            <a class="note grey" onclick="love(this, 'Song', '<?php echo $value->getSong()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getSong()->getId(); ?>', '<?php echo $value->getSong()->getFromuser()->getId(); ?>', 'Song', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getSong()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getSong()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getSong()->getSharecounter(); ?></a>
                        </div>
                    </div>
                </div>
                </div>
                <!---- COMMENT ---->
                <div class="box-opinion no-display"></div>
                </div>
                <?php
                break;
            case 'SONGUPLOADED':
                if (is_array($value->getSong()->getLovers()) && in_array($currentUser->getId(), $value->getSong()->getLovers())) {
                    $css_love = '_love orange';
                    $text_love = $views['UNLOVE'];
                } else {
                    $css_love = '_unlove grey';
                    $text_love = $views['LOVE'];
                }
                ?>
                <div class="row line">
                    <div class="small-12 columns ">
                        <div class="row ">
                            <div class="small-12 columns ">
                                <div class="row  ">
                                    <div class="large-12 columns ">
                                        <div class="text orange"><?php echo $views['stream']['song_uploaded']; ?></div>
                                    </div>
                                </div>
                                <div class="row box-detail" onclick="">
                                    <!-- THUMBNAIL RECORD -->
                                    <?php
                                    $fileManagerService = new FileManagerService();
                                    $pathRecordThumb = $fileManagerService->getRecordPhotoPath($value->getFromuser()->getId(), $value->getSong()->getRecord()->getThumbnail());
                                    ?>
                                    <div class="small-2 columns">
                                        <div class="coverThumb"><a href="record.php?record=<?php echo $value->getSong()->getRecord()->getId(); ?>"><img src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></a></div>
                                    </div>
                                    <div class="small-10 columns">
                                        <div class="row">							
                                            <div class="small-12 columns">
                                                <div class="sottotitle grey-dark"><?php echo $value->getSong()->getTitle(); ?></div>
                                            </div>	
                                        </div>	
                                        <div class="row">						
                                            <div class="small-12 columns">
                                                <div class="grey"><?php echo $value->getRecord()->getTitle(); ?></div>
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
                            <a class="note grey" onclick="love(this, 'Song', '<?php echo $value->getSong()->getId(); ?>', '<?php echo $currentUser->getId(); ?>')"><?php echo $text_love; ?></a>
                            <a class="note grey" onclick="loadBoxOpinion('<?php echo $value->getSong()->getId(); ?>', '<?php echo $value->getSong()->getFromuser()->getId(); ?>', 'Song', '#<?php echo $value->getId(); ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
                            <a class="note grey" onclick="share(this, 'Khlv07KRGH', 'social-EventReview')"><?php echo $views['SHARE']; ?></a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getSong()->getLovecounter(); ?></a>
                            <a class="icon-propriety _comment"><?php echo $value->getSong()->getCommentcounter(); ?></a>
                            <a class="icon-propriety _share"><?php echo $value->getSong()->getSharecounter(); ?></a>
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
        */
                #TEMP
                ?>
                <div class="row">
                    <div class="box-propriety">
                        <div class="small-7 columns ">
                            <a class="note grey" onclick="">???</a>
                            <a class="note grey" onclick="">???</a>
                            <a class="note grey" onclick="">???</a>
                        </div>
                        <div class="small-5 columns propriety ">			
                            <a class="icon-propriety <?php echo $css_love ?>">0</a>
                            <a class="icon-propriety _comment">0</a>
                            <a class="icon-propriety _share">0</a>
                        </div>
                    </div>
                </div>
                </div>
                <!---- COMMENT ---->
                <div class="box-opinion no-display"></div>
                </div>
                <?php
    }
}
?>