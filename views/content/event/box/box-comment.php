<?php
/* box comment
 * box chiamato tramite load con:
 * data: {data,typeuser}
 *
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'debug.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
require_once BOXES_DIR . 'comment.box.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$objectId = $_POST['objectId'];
$fromUserObjectId = $_POST['fromUserObjectId'];
$limit = $_POST['limit'];
$skip = $_POST['skip'];
$commentToShow = 3;

$commentBox = new CommentBox();
$commentBox->init($objectId, 'Event', $limit, $skip);
if (is_null($commentBox->error) || isset($_SESSION['currentUser'])) {
    $currentUser = $_SESSION['currentUser'];
    $comments = $commentBox->commentArray;
    $commentCounter = count($comments);
    ?>
    <div class="row" id="social-Comment <?php echo $objectId; ?>">
        <div  class="large-12 columns">
            <h3>Comment</h3>

            <div class="row ">
                <div  class="large-12 columns ">

                    <div class="row  ">
                        <div  class="large-12 columns ">
                            <form action="" class="box-write" onsubmit="sendComment('<?php echo $fromUserObjectId; ?>', $('#commentEvent_<?php echo $objectId; ?>').val(), '<?php echo $objectId; ?>', 'Event', 'box-comment', '<?php echo $limit; ?>', '<?php echo $skip; ?>'); return false;">
                                <div class="">
                                    <div class="row  ">
                                        <div  class="small-9 columns ">
                                            <input id="commentEvent_<?php echo $objectId; ?>" type="text" class="comment inline" placeholder="<?php echo $views['comment']['WRITE'];?>" />
                                        </div>
                                        <div  class="small-3 columns ">
                                            <input type="button" class="post-button inline" value="Comment" onclick="sendComment('<?php echo $fromUserObjectId; ?>', $('#commentEvent_<?php echo $objectId; ?>').val(), '<?php echo $objectId; ?>', 'Event', 'box-comment', '<?php echo $limit; ?>', '<?php echo $skip; ?>')"/>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    
                    <?php  
                    $comment_limit_count = $commentCounter > $limit ? $limit : $commentCounter;
                    $comment_other = $comment_limit_count >= $commentCounter ? 0 : ($commentCounter - $comment_limit_count); 
                    if ($commentCounter > 0) {
                        $indice = 1;
                        foreach ($comments as $key => $value) {
                            $comment_user_objectId = $value->getFromUser()->getObjectId();
                            $comment_user_thumbnail = $value->getFromUser()->getProfileThumbnail();
                            $comment_user_username = $value->getFromUser()->getUsername();
                            $comment_user_type = $value->getFromUser()->getType();
                            $comment_objectId = $value->getObjectId();
                            $comment_data = $value->getCreatedAt()->format('l j F Y - H:i');
                            $comment_title = $value->getTitle();
                            $comment_text = $value->getText();
                            #TODO
                            //$comment_rating = $value->getRating();
                            $comment_counter_love = $value->getLoveCounter();
                            $comment_counter_comment = $value->getCommentCounter();
                            $comment_counter_share = $value->getShareCounter();
                            
                            if (in_array($currentUser->getObjectId(), $value->getLovers())) {
                                $css_love = '_love orange';
                                $text_love = $views['UNLOVE'];
                            } else{
                                $css_love = '_unlove grey';
                                $text_love = $views['LOVE'];
                            }
                            ?>				
                            <div id='<?php echo $comment_objectId; ?>'>
                                
                                <div class="box">
                                
                                    <div class="row  line">
                                        <div  class="small-1 columns ">
                                            <div class="icon-header">
                                                <img src="../media/<?php echo $comment_user_thumbnail; ?>" onerror="this.src='../media/<?php echo $default_img['DEFAVATARTHUMB']; ?>'">
                                            </div>
                                        </div>
                                        <div  class="small-5 columns">
                                            <div class="text grey" style="margin-bottom: 0px;">
                                                <strong><?php echo $comment_user_username; ?></strong>
                                            </div>
                                            <div class="note orange">
                                                <strong><?php echo $comment_user_type ?></strong>
                                            </div>
                                        </div>
                                        <div  class="small-6 columns propriety">
                                            <div class="note grey-light">
                                                <?php echo $comment_data;?>
                                            </div>
                                        </div>
                
                                    </div>
                                    <div class="row  line">
                                        <div  class="small-12 columns ">
                                            <div class="row ">
                                                <div  class="small-12 columns ">
                                                    <div class="text grey">
                                                        <?php echo $comment_text;?>	
                                                    </div>
                                                </div>
                                            </div>
                
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="box-propriety">
                                            <div class="small-5 columns ">
                                                <a class="note grey " onclick="love(this, 'Comment', '<?php echo $comment_objectId; ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
                                            </div>
                                            <div class="small-5 columns propriety ">
                                                <a class="icon-propriety <?php echo $css_love; ?>"><?php echo $comment_counter_love; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div> <!--------------- BOX -------------------->	
                                
                            </div>
                            <?php
                            if ($indice == $comment_limit_count) break;
                            $indice++;
                        }
                    }
                    if ($comment_other > 0) {
                        ?>
                        <div class="row otherSet">
                            <div class="large-12 colums">
                                <?php
                                $nextToShow = ($commentCounter - $limit > $commentToShow) ? $commentToShow : $commentCounter - $limit;
                                ?>
                                <div class="text" onclick="loadBoxComment(<?php echo $limit + $commentToShow; ?>, 0);">Other <?php echo $nextToShow;?> Comment</div>	
                            </div>
                        </div>
                        <?php
                    }
                    if ($commentCounter == 0) {
                        ?>
                        <div class="box">	
                            <div class="row">
                                <div  class="large-12 columns ">
                                    <p class="grey"><?php echo $views['comment']['NODATA'];?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}