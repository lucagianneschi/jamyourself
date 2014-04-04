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
require_once BOXES_DIR . 'post.box.php';
require_once CLASSES_DIR . 'user.class.php';

if (session_id() == '')
    session_start();

$currentUserId = $_SESSION['id'];
$postBox = new PostBox();
$postBox->initForStream($currentUserId);
$posts = $postBox->postArray;
if (count($posts) == 0) {
    ?>
    <p><?php echo $views['stream']['last_post']; ?></p>
    <h5><?php echo $views['stream']['not_yet']; ?></h5>
    <?php
} else {
    $post = current($posts);
    ?>
    <div id='<?php echo $post->getId(); ?>'>
        <br /><br />
        <p class="grey"><?php echo $views['stream']['last_post']; ?></p>
        <h5 style="margin-top:0"><?php echo $post->getText(); ?></h5>
	<?php echo ucwords(strftime("%A %d %B %Y - %H:%M", $post->getCreatedat()->getTimestamp())); ?>
        <br />
    </div>
    <?php
}
?>