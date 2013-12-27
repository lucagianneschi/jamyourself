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

    <h3 style="margin-top:30px">Stream</h3>
    <?php
    
    foreach ($activities as $key => $value) {
        debug(DEBUG_DIR, 'debug.txt', json_encode($value->getType()));
        switch ($value->getType()) {
            case ($value->getType() == 'COMMENTEDONALBUM' ||
                  $value->getType() == 'COMMENTEDONIMAGE' ||
                  $value->getType() == 'COMMENTEDONEVENT' ||
                  $value->getType() == 'COMMENTEDONEVENTREVIEW' ||
                  $value->getType() == 'COMMENTEDONRECORD' ||
                  $value->getType() == 'COMMENTEDONRECORDREVIEW' || 
                  $value->getType() == 'COMMENTEDONPOST' ||
                  $value->getType() == 'COMMENTEDONVIDEO'):
                break;
            case 'ALBUMCREATED':
                ?>
                <div id="<?php echo $value->getObjectId(); ?>">
                    <div class="box ">
                        
                        <div class="row line">
                            <div class="small-1 columns ">
                                <div class="icon-header">
                                    <img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='../media/images/default/defaultAvatarThumb.jpg'">
                                </div>
                            </div>
                            <div class="small-5 columns">
                                <div class="text grey" style="margin-bottom: 0px;">
                                    <?php
                                    debug(DEBUG_DIR, 'debug.txt', json_encode((array)$value->getFromUser()));
                                    ?>
                                    <strong><?php echo $value->getFromUser()->getUsername(); ?></strong>
                                </div>
                                <div class="note orange">
                                    <strong><?php echo $value->getFromUser()->getType(); ?></strong>
                                </div>
                            </div>
                            <div class="small-6 columns propriety">
                                <div class="note grey-light">
                                    <?php echo $value->getCreatedAt()->format('l j F Y - H:i'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange">New photo</div>
                                                <div class="sottotitle grey-dark"><?php echo $value->getAlbum()->getTitle(); ?> - <?php echo $value->getAlbum()->getImageCounter(); ?> photos</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-12 columns">
                                                
                                                <div id="box-albumDetail" style="margin-top: 10px;">
                                                    <ul class="small-block-grid-3 small-block-grid-2 ">
                                                        <!------------------------------ THUMBNAIL ---------------------------------->
                                                    <li><a class="photo-colorbox-group cboxElement" href="#o8uxB9jcQ6"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../media/../../../../media/images/default/defaultImage.jpg'"></a></li>
                                                
                                                        <!------------------------------ THUMBNAIL ---------------------------------->
                                                    <li><a class="photo-colorbox-group cboxElement" href="#7v89ijnq1Y"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../media/../../../../media/images/default/defaultImage.jpg'"></a></li>
                                                
                                                        <!------------------------------ THUMBNAIL ---------------------------------->
                                                    <li><a class="photo-colorbox-group cboxElement" href="#SJbjQ1BxfJ"><img class="photo" src="../media/../../../../media/images/default/defaultImage.jpg" onerror="this.src='../media/../../../../media/images/default/defaultImage.jpg'"></a></li>
                                                
                                                    </ul>
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
            case 'EVENTCREATED':
                break;
            case 'RECORDCREATED':
                break;
            case 'DEFAULTALBUMCREATED':
                break;
            case 'DEFAULTRECORDCREATED':
                break;
            case 'IMAGEUPLOADED':
                break;
            case 'INVITED':
                break;
            case 'NEWLEVEL':
                break;
            case 'NEWBADGE':
                break;
            case 'POSTED':
                ?>
                <div id="<?php echo $value->getObjectId(); ?>">
                    <div class="box ">
                        
                        <div class="row  line">
                            <div class="small-1 columns ">
                                <div class="icon-header">
                                    <img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='../media/images/default/defaultAvatarThumb.jpg'">
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
                                    <?php echo $value->getCreatedAt()->format('l j F Y - H:i'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row  line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="text grey">
                                            <?php echo $value->getComment()->getText(); ?>
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
                                    <a class="icon-propriety _unlove grey"><?php echo $value->getComment()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-comment no-display">
                            
                    </div>
                    
                </div>
                <?php
                break;
            case 'SHAREDIMAGE':
                break;
            case 'SHAREDSONG':
                break;
            case 'SONGUPLOADED':
                break;
            case 'FOLLOWING':
                ?>
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
                <?php
                break;
            case 'FRIENDSHIPREQUEST':
                ?>
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
                <?php
                break;
            case 'NEWEVENTREVIEW':
                ?>
                <div id="<?php echo $value->getObjectId(); ?>">
                    <div class="box ">
                        
                        <div class="row line">
                            <div class="small-1 columns ">
                                <div class="icon-header">
                                    <img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='../media/images/default/defaultAvatarThumb.jpg'">
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
                                    <?php echo $value->getCreatedAt()->format('l j F Y - H:i'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row  line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange">Event Review</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-2 columns ">
                                                <div class="coverThumb"><img src="../media/../../../../media/images/default/defaultEventThumb.jpg" onerror="this.src='../media/../../../../media/images/default/defaultEventThumb.jpg'"></div>						
                                            </div>
                                            <div class="small-8 columns ">
                                                <div class="row ">							
                                                    <div class="small-12 columns ">
                                                        <div class="sottotitle grey-dark">Recensione Evento</div>
                                                    </div>	
                                                </div>	
                                                <div class="row">						
                                                    <div class="small-12 columns ">
                                                        <div class="note grey">Rating</div>
                                                    </div>
                                                </div>
                                                <div class="row ">						
                                                    <div class="small-12 columns ">
                                                        <a class="icon-propriety _star-orange"></a><a class="icon-propriety _star-grey"></a><a class="icon-propriety _star-grey"></a><a class="icon-propriety _star-grey"></a><a class="icon-propriety _star-grey"></a>
                                                    </div>
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
                                    <a class="icon-propriety _unlove grey"><?php echo $value->getComment()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-comment no-display">
                    </div>
                </div>
                <?php
                break;
            case 'NEWRECORDREVIEW':
                ?>
                <div id="<?php echo $value->getObjectId(); ?>">
                    <div class="box ">
                        
                        <div class="row line">
                            <div class="small-1 columns ">
                                <div class="icon-header">
                                    <img src="../media/images/default/defaultAvatarThumb.jpg" onerror="this.src='../media/images/default/defaultAvatarThumb.jpg'">
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
                                    <?php echo $value->getCreatedAt()->format('l j F Y - H:i'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="row  line">
                            <div class="small-12 columns ">
                                <div class="row ">
                                    <div class="small-12 columns ">
                                        <div class="row  ">
                                            <div class="large-12 columns ">
                                                <div class="text orange">Record Review</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="small-2 columns ">
                                                <div class="coverThumb"><img src="../media/../../../../media/images/default/defaultEventThumb.jpg" onerror="this.src='../media/../../../../media/images/default/defaultEventThumb.jpg'"></div>						
                                            </div>
                                            <div class="small-8 columns ">
                                                <div class="row ">							
                                                    <div class="small-12 columns ">
                                                        <div class="sottotitle grey-dark">Recensione Record</div>
                                                    </div>	
                                                </div>	
                                                <div class="row">						
                                                    <div class="small-12 columns ">
                                                        <div class="note grey">Rating</div>
                                                    </div>
                                                </div>
                                                <div class="row ">						
                                                    <div class="small-12 columns ">
                                                        <a class="icon-propriety _star-orange"></a><a class="icon-propriety _star-grey"></a><a class="icon-propriety _star-grey"></a><a class="icon-propriety _star-grey"></a><a class="icon-propriety _star-grey"></a>
                                                    </div>
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
                                    <a class="icon-propriety _unlove grey"><?php echo $value->getComment()->getLoveCounter(); ?></a>
                                    <a class="icon-propriety _comment"><?php echo $value->getComment()->getCommentCounter(); ?></a>
                                    <a class="icon-propriety _share"><?php echo $value->getComment()->getShareCounter(); ?></a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!---- COMMENT ---->
                        <div class="box-comment no-display">
                    </div>
                </div>
                <?php
                break;
            case 'COLLABORATIONREQUEST':
                ?>
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
                <?php
                break;
        }   
    }
    ?>
    
    <!---------------- BOX JUST ADDED ----------------->

    
<?php
}
?>