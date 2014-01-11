<?php
/* box post
 * box chiamato tramite load con:
 * data: {data,typeuser}
 *
 */
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'post.box.php';
require_once CLASSES_DIR . 'userParse.class.php';
session_start();

$postBox = new PostBox();
$postBox->init($_POST['objectId']);

if (is_null($postBox->error) || isset($_SESSION['currentUser'])) {
    $currentUser = $_SESSION['currentUser'];
    $posts = $postBox->postArray;
    $postCounter = count($posts);
    ?>

    <!------------------------------------- Post ------------------------------------>
    <div class="row" id="social-Post" style='margin-bottom: 40px;'>
        <div  class="large-12 columns">
    	<h3><?php echo $views['post']['TITLE'] ?></h3>

    	<div class="row ">
    	    <div  class="large-12 columns ">

    		<div class="row  ">
    		    <div  class="large-12 columns ">
    			<form action="" class="box-write" onsubmit="sendPost('<?php echo $currentUser->getObjectId(); ?>', $('#post').val());
    				return false;">
    			    <div class="">
    				<div class="row  ">
    				    <div class="small-9 columns ">
    					<input id="post" type="text" class="post inline" placeholder="<?php echo $views['post']['WRITE']; ?>" />
    				    </div>
    				    <div class="small-3 columns ">
    					<input type="button" id="button-post" class="post-button inline" value="Post" onclick="sendPost('<?php echo $currentUser->getObjectId(); ?>', $('#post').val())" />
    				    </div>
    				</div>
    			    </div>

    			</form>
    		    </div>
    		</div>
    		<div class="row  ">
    		    <div  class="large-12 columns ">
    			<div id="post-error" onClick="postError()"><img src="./resources/images/error/error-post.png" /></div>
    		    </div>
    		</div>
		    <?php
		    if ($postCounter > 0) {
			foreach ($posts as $key => $value) {
			    $post_objectId = $value->getObjectId();
			    $post_createdAt = $value->getCreatedAt()->format('l j F Y - H:i');
			    $post_fromUser_objectId = $value->getFromUser()->getObjectId();
			    $post_fromUser_profileThumbnail = $value->getFromUser()->getProfileThumbnail();
			    $post_fromUser_username = $value->getFromUser()->getUsername();
			    $post_fromUser_type = $value->getFromUser()->getType();
			    $post_text = $value->getText();
			    $post_loveCounter = $value->getLoveCounter();
			    $post_commentCounter = $value->getCommentCounter();
			    if (in_array($currentUser->getObjectId(), $value->getLovers())) {
				$css_love = '_love orange';
				$text_love = $views['UNLOVE'];
			    } else {
				$css_love = '_unlove grey';
				$text_love = $views['LOVE'];
			    }
			    switch ($post_fromUser_type) {
				case 'JAMMER':
				    $defaultThum = DEFTHUMBJAMMER;
				    break;
				case 'VENUE':
				    $defaultThum = DEFTHUMBVENUE;
				    break;
				case 'SPOTTER':
				    $defaultThum = DEFTHUMBSPOTTER;
				    break;
			    }
			    ?>
	    		<div id='<?php echo $post_objectId; ?>'>
	    		    <div class="box <?php echo $data['post' . $i]['showLove'] ?>">

	    			<div class="row  line">
	    			    <div  class="small-1 columns ">
	    				<div class="icon-header">
	    				    <img src="../media/<?php echo $post_fromUser_profileThumbnail; ?>" onerror="this.src='<?php echo $defaultThum; ?>'">
	    				</div>
	    			    </div>
	    			    <div  class="small-5 columns">
	    				<div class="text grey" style="margin-bottom: 0px;">
	    				    <strong><?php echo $post_fromUser_username; ?></strong>
	    				</div>
	    				<div class="note orange">
	    				    <strong><?php echo $post_fromUser_type; ?></strong>
	    				</div>
	    			    </div>
	    			    <div  class="small-6 columns propriety">
	    				<div class="note grey-light">
						<?php echo $post_createdAt; ?>
	    				</div>
	    			    </div>

	    			</div>
	    			<div class="row  line">
	    			    <div  class="small-12 columns ">
	    				<div class="row ">
	    				    <div  class="small-12 columns ">
	    					<div class="text grey">
							<?php echo $post_text; ?>	
	    					</div>
	    				    </div>
	    				</div>

	    			    </div>
	    			</div>
	    			<div class="row">
	    			    <div class="box-propriety">
	    				<div class="small-5 columns ">
	    				    <a class="note grey " onclick="love(this, 'Comment', '<?php echo $post_objectId; ?>', '<?php echo $currentUser->getObjectId(); ?>')"><?php echo $text_love; ?></a>
	    				    <a class="note grey" onclick="loadBoxOpinion('<?php echo $post_objectId; ?>', '<?php echo $post_fromUser_objectId; ?>', 'Comment', '#<?php echo $post_objectId; ?> .box-opinion', 10, 0)"><?php echo $views['COMM']; ?></a>
	    				</div>
	    				<div class="small-5 columns propriety ">
	    				    <a class="icon-propriety <?php echo $css_love ?>"><?php echo $post_loveCounter; ?></a>
	    				    <a class="icon-propriety _comment"><?php echo $post_commentCounter; ?></a>
	    				</div>
	    			    </div>
	    			</div>
	    		    </div> <!--------------- BOX -------------------->	
	    		    <!---------------------------------------- COMMENT ------------------------------------------------->
	    		    <div class="box-opinion no-display" ></div>
	    		</div>
			    <?php
			}
		    } else {
			?>
			<div class="box">
			    <div class="row">
				<div  class="large-12 columns ">
				    <p class="grey"><?php echo $views['post']['NODATA']; ?></p>
				</div>
			    </div>
			</div>
			<?php
		    }
		    ?>


    	    </div>
    	</div>
        </div>
	<?php
    }