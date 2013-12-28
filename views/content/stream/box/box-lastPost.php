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
require_once BOXES_DIR . 'post.box.php';
require_once CLASSES_DIR . 'userParse.class.php';

if (session_id() == '') session_start();
    
$currentUser = $_SESSION['currentUser'];
$postBox = new PostBox();
$postBox->init($currentUser->getObjectId(), 1, 0);
$posts = $postBox->postArray;

if (count($posts) == 0) {
    ?>
    <h5>Ops! You have not written anything yet!</h5>
    <?php
} else {
    $post = current($posts);
    if (in_array($currentUser->getObjectId(), $post->getLovers())) {
        $css_love = '_unlove grey';
        $text_love = $views['LOVE'];
    } else {
        $css_love = '_love orange';
        $text_love = $views['UNLOVE'];
    }
    ?>
    <!-- p>Your last post is...</p -->
    <h5>Your last post is...</h5>
    <div class="row" id="social-Post" style='margin-bottom: 40px;'>
        <div class="large-12 columns">
            <div class="row">
                <div class="large-12 columns ">
                    <div id='<?php echo $post->getObjectId(); ?>'>
                    <div class="box">
                    
                    <div class="row  line">
                        <div  class="small-1 columns ">
                            <div class="icon-header">
                                <img src="../media/<?php echo $post->getFromUser()->getProfileThumbnail(); ?>" onerror="this.src='../media/<?php echo DEFTHUMB; ?>'">
                            </div>
                        </div>
                        <div  class="small-5 columns">
                            <div class="text grey" style="margin-bottom: 0px;">
                                <strong><?php echo $post->getFromUser()->getUsername(); ?></strong>
                            </div>
                            <div class="note orange">
                                <strong><?php echo $post->getFromUser()->getType(); ?></strong>
                            </div>
                        </div>
                        <div  class="small-6 columns propriety">
                            <div class="note grey-light">
                                <?php echo $post->getCreatedAt()->format('l j F Y - H:i'); ?>
                            </div>
                        </div>

                    </div>
                    <div class="row  line">
                        <div  class="small-12 columns ">
                            <div class="row ">
                                <div  class="small-12 columns ">
                                    <div class="text grey">
                                        <?php echo $post->getText(); ?>	
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="box-propriety">
                            <div class="small-5 columns propriety ">
                                <a class="icon-propriety <?php echo $css_love ?>"><?php echo $post->getLoveCounter(); ?></a>
                                <a class="icon-propriety _comment"><?php echo $post->getCommentCounter(); ?></a>
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
}
?>