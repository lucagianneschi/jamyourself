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
require_once SERVICES_DIR . 'debug.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
require_once BOXES_DIR . 'stream.box.php';
require_once CLASSES_DIR . 'userParse.class.php';

if (session_id() == '') session_start();
    
$currentUser = $_SESSION['currentUser'];

$streamBox = new StreamBox();
$streamBox->init(10, 0);
if (is_null($streamBox->error)) {
	$activities = $streamBox->activitiesArray;
    $activityCounter = count($activities);
    
    ?>
    <!---------------- POST ----------------->
    <h3><?php echo $views['stream']['write_post']; ?></h3>
    <div class="row  ">
        <div class="large-12 columns ">
            <form action="" class="box-write" onsubmit="sendPost('', $('#post').val()); return false;">
                <div class="">
                    <div class="row  ">
                        <div class="small-9 columns ">
                            <input id="post" type="text" class="post inline" placeholder="Spread the word about your interest!">
                        </div>
                        <div class="small-3 columns ">
                            <input type="button" id="button-post" class="post-button inline" value="<?php echo $views['post_button']; ?>" onclick="sendPost('<?php echo $currentUser->getObjectId(); ?>', $('#post').val())">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    
    <!---------------- STREAM ----------------->
    <h3 style="margin-top:30px"><?php echo $views['stream']['stream']; ?></h3>
    
    
    <?php    
    foreach ($activities as $key => $value) {
        ?>
        <div id="<?php echo $value->getObjectId(); ?>">
            <div class="box ">
                <div class="row line">
                    <div class="small-1 columns ">
                        <div class="icon-header">
                            <img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='images/default/defaultAvatarThumb.jpg'">
                        </div>
                    </div>
                    <div class="small-5 columns">
                        <div class="text grey" style="margin-bottom: 0px;">
                            <strong><?php echo $value->getFromUser()->getUsername(); ?></strong>
                        </div>
                        <div class="note orange">
                            <strong><?php echo $value->getFromUser()->getType(); ?></strong>
                        </div>
                    </div>
                    <div class="small-6 columns propriety">
                        <div class="note grey-light">
                            <?php echo ucwords(strftime("%A %e %B %Y - %H:%M", $value->getCreatedAt()->getTimestamp())); ?>
                        </div>
                    </div>
                </div>
        <?php
        switch ($value->getType()) {
            case 'ALBUMCREATED':
                if (is_array($value->getAlbum()->getLovers()) && in_array($currentUser->getObjectId(), $value->getAlbum()->getLovers())) {
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
                                                <div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?> - <?php echo $value->getAlbum()->getImageCounter(); ?> <?php echo $views['stream']['photos']; ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL -->
                                                        <li><a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a></li>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getAlbum()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getAlbum()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getAlbum()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'COLLABORATIONREQUEST':
                ?>
                        <div class="row  line">
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
                                                                <img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='images/default/defaultAvatarThumb.jpg'">
                                                            </div>
                                                        </div>
                                                        <div class="small-9 columns ">
                                                            <div class="text grey-dark breakOffTest"><strong><?php echo $value->getToUser()->getUsername(); ?></strong></div>
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
                if (is_array($value->getAlbum()->getLovers()) && in_array($currentUser->getObjectId(), $value->getAlbum()->getLovers())) {
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
                                                <div class="text orange">Commented an Album</div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF THE CLASS -->
                                                        <li>
                                                        <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getAlbum()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getAlbum()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getAlbum()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'COMMENTEDONIMAGE':
                if (is_array($value->getImage()->getLovers()) && in_array($currentUser->getObjectId(), $value->getImage()->getLovers())) {
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
                                                <div class="text orange">Commented an Image</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF THE CLASS -->
                                                        <li>
                                                        <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getImage()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getImage()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getImage()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'COMMENTEDONEVENT':
                if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getObjectId(), $value->getEvent()->getLovers())) {
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
                                                <div class="text orange">Commented an Event</div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getEvent()->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF THE CLASS -->
                                                        <li>
                                                        <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getEvent()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'COMMENTEDONEVENTREVIEW':
                if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getObjectId(), $value->getComment()->getLovers())) {
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
                                                <div class="text orange">Commented an Event Review</div>
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
                                                        <!-- THUMBNAIL OF THE CLASS -->
                                                        <li>
                                                        <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'COMMENTEDONPOST':
                if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getObjectId(), $value->getComment()->getLovers())) {
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
                                                <div class="text orange">Commented a Post</div>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'COMMENTEDONRECORD':
                if (is_array($value->getRecord()->getLovers()) && in_array($currentUser->getObjectId(), $value->getRecord()->getLovers())) {
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
                                                <div class="text orange">Commented a Record</div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF THE CLASS -->
                                                        <li>
                                                        <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getRecord()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getRecord()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getRecord()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'COMMENTEDONRECORDREVIEW':
                if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getObjectId(), $value->getComment()->getLovers())) {
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
                                                <div class="text orange">Commented a Record Review</div>
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
                                                        <!-- THUMBNAIL OF THE CLASS -->
                                                        <li>
                                                        <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'COMMENTEDONVIDEO':
                if (is_array($value->getVideo()->getLovers()) && in_array($currentUser->getObjectId(), $value->getVideo()->getLovers())) {
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
                                                <div class="text orange">Commented a Video</div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getVideo()->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF THE CLASS -->
                                                        <li>
                                                        <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getVideo()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getVideo()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getVideo()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'EVENTCREATED':
                if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getObjectId(), $value->getEvent()->getLovers())) {
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
                                                        <!-- THUMBNAIL -->
                                                        <li><a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../users/<?php echo $value->getFromUser()->getObjectId(); ?>/images/eventcoverthumb/<?php echo $value->getEvent()->getThumbnail(); ?>" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a></li>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getEvent()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'FOLLOWING':
                ?>
                        <div class="row line">
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
                                                                <img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='images/default/defaultAvatarThumb.jpg'">
                                                            </div>
                                                        </div>
                                                        <div class="small-9 columns ">
                                                            <div class="text grey-dark breakOffTest"><strong><?php echo $value->getToUser()->getUsername(); ?></strong></div>
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
                        <div class="row  line">
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
                                                                <img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='images/default/defaultAvatarThumb.jpg'">
                                                            </div>
                                                        </div>
                                                        <div class="small-9 columns ">
                                                            <div class="text grey-dark breakOffTest"><strong><?php echo $value->getToUser()->getUsername(); ?></strong></div>
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
                if (is_array($value->getImage()->getLovers()) && in_array($currentUser->getObjectId(), $value->getImage()->getLovers())) {
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
                                                <div class="text orange">New Image Added to Album</div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF ADDED IMAGE -->
                                                        <li>
                                                            <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../users/xxxxxxxxxx/images/eventcoverthumb/immagine.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getImage()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getImage()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getImage()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'IMAGEUPLOADED':
                if (is_array($value->getImage()->getLovers()) && in_array($currentUser->getObjectId(), $value->getImage()->getLovers())) {
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
                                                        <!-- THUMBNAIL -->
                                                        <li><a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a></li>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getImage()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getImage()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getImage()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'INVITED':
                if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getObjectId(), $value->getEvent()->getLovers())) {
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
                                                <div class="text orange">Invited accepted</div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getEvent()->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF EVENT-->
                                                        <li>
                                                            <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../users/xxxxxxxxxx/images/eventcoverthumb/immagine.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getEvent()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'NEWBADGE':
                ?>
                        <div class="row  line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange">New Badge Earned</div>
                                            </div>
                                        </div>
                                        <div class="row newBadge">
                                            <div class="small-2 columns">
                                                <div class="badgeThumb"><img src="/media/images/badge/badgeElectro.png" onerror="this.src='/media/images/badge/badgeDefault.png'"></div>						
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
                if (is_array($value->getEvent()->getLovers()) && in_array($currentUser->getObjectId(), $value->getEvent()->getLovers())) {
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
                                                <div class="coverThumb"><img src="../media/../../../../media/images/default/defaultEventThumb.jpg" onerror="this.src='../../../../media/images/default/defaultEventThumb.jpg'"></div>						
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getEvent()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getEvent()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getEvent()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'NEWLEVEL':
                ?>
                        <div class="row  line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange">New Level Earned</div>
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
                if (is_array($value->getRecord()->getLovers()) && in_array($currentUser->getObjectId(), $value->getRecord()->getLovers())) {
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
                                            <div class="small-2 columns ">
                                                <div class="coverThumb"><img src="../media/../../../../media/images/default/defaultEventThumb.jpg" onerror="this.src='../../../../media/images/default/defaultEventThumb.jpg'"></div>						
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getRecord()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getRecord()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getRecord()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'POSTED':
                if (is_array($value->getComment()->getLovers()) && in_array($currentUser->getObjectId(), $value->getComment()->getLovers())) {
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getComment()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'RECORDCREATED':
                if (is_array($value->getRecord()->getLovers()) && in_array($currentUser->getObjectId(), $value->getRecord()->getLovers())) {
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
                                                <div class="text orange">Record Created</div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF RECORD -->
                                                        <li>
                                                            <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../users/xxxxxxxxxx/images/eventcoverthumb/immagine.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getRecord()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getRecord()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getRecord()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            #TODO
            /* --> saranno implementate in un secondo momento
            case 'SHAREDIMAGE':
                break;
            case 'SHAREDSONG':
                break;
            */
            case 'SONGAADDEDTORECORD':
                if (is_array($value->getSong()->getLovers()) && in_array($currentUser->getObjectId(), $value->getSong()->getLovers())) {
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
                                                <div class="text orange">Song Added to Record</div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getRecord()->getTitle(); ?></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!-- THUMBNAIL OF RECORD -->
                                                        <li>
                                                            <a class="photo-colorbox-group cboxElement" href="#"><img class="photo" src="../users/xxxxxxxxxx/images/eventcoverthumb/immagine.jpg" onerror="this.src='../../../../media/images/default/defaultImage.jpg'"></a>
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getSong()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getSong()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getSong()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
            case 'SONGUPLOADED':
                if (is_array($value->getSong()->getLovers()) && in_array($currentUser->getObjectId(), $value->getSong()->getLovers())) {
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
                                            <div class="small-2 columns">
                                                <div class="coverThumb"><img src="../media/../../../../media/images/default/defaultEventThumb.jpg" onerror="this.src='../../../../media/images/default/defaultEventThumb.jpg'"></div>						
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
                                    <a class="note grey" onclick="love(this, 'Comment', 'Khlv07KRGH', '')"><?php echo $text_love ?></a>
                                    <a class="note grey" onclick="setCounter(this,'Khlv07KRGH','EventReview')"><?php echo $views['COMM']; ?></a>
                                    <a class="note grey" onclick="share(this,'Khlv07KRGH','social-EventReview')"><?php echo $views['SHARE']; ?></a>
                                </div>
                                <div class="small-5 columns propriety ">			
                                    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $value->getSong()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getSong()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getSong()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---- COMMENT ---->
                    <div class="box-comment no-display"></div>
                </div>
                <?php
                break;
        }
    }
}
?>