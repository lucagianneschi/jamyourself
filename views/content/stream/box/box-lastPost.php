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

if (session_id() == '')
    session_start();

$currentUser = $_SESSION['currentUser'];
$postBox = new PostBox();
$postBox->init($currentUser->getObjectId(), 1, 0);
$posts = $postBox->postArray;

if (count($posts) == 0) {
    ?>
    <p>Your last post is...</p>
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
    <div id='<?php echo $post->getObjectId(); ?>'>
    	<br /><br />
        <p class="grey">Your last post is...</p>
        <h5 style="margin-top:0"><?php echo $post->getText(); ?>	</h5>
        <!-- p class="grey"> <?php echo $post->getCreatedAt()->format('l j F Y - H:i'); ?></p -->
        <br />
    </div>
    <?php
}
?>