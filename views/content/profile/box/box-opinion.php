<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';
require_once BOXES_DIR . 'comment.box.php';
require_once SERVICES_DIR . 'fileManager.service.php';
require_once SERVICES_DIR . 'log.service.php';

$id = $_POST['id'];
$touser = $_POST['toUser'];
$class = strtolower($_POST['classBox']);
$box = $_POST['box'];
$limit = (int) $_POST['limit'];
$skip = (int) $_POST['skip'];
$comment = new CommentBox();
$comment->init($id, $class, $limit, $skip);
$countComment = count($comment->commentArray);
/*
if ($countComment > 0) {
    ?>
    <script type="text/javascript">
    objectCmt = $('<?php echo $box; ?>').prev().find("a._comment");
    $(objectCmt).text(<?php echo current($comment->commentArray)->getComment()->getCommentcounter(); ?>);
    console.log('Ho girato e ho prodotto: ' + $.parseJSON(parent) + ' | ' + $.parseJSON(objectCmt));
    </script>
    <?php
}
*/
?>
<div class="row">
    <div  class="small-12 columns">
	<?php
    if ($countComment > 0) {
	    $comments = array_reverse($comment->commentArray);
	    foreach ($comments as $key => $value) {
		$comment_data = $value->getCreatedat()->format('l j F Y - H:i');
		switch ($value->getFromuser()->getType()) {
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
		<div class="box-singole-comment">
		    <div class='line'>
			<div class="row">
			    <div  class="small-1 columns ">
				<div class="icon-header">
				    <!-- THUMB USER-->
				    <?php
				    $fileManagerService = new FileManagerService();
				    $thumbPath = $fileManagerService->getPhotoPath($value->getFromuser()->getId(), $value->getFromuser()->getThumbnail());
				    ?>
				    <img src="<?php echo $thumbPath; ?>" onerror="this.src='<?php echo $defaultThum; ?>'" alt="<?php echo $value->getFromuser()->getUsername(); ?>">
				</div>
			    </div>
			    <div  class="small-5 columns">
				<div class="text grey" style="margin-bottom: 0p">
				    <strong><?php echo $value->getFromuser()->getUsername(); ?></strong>
				</div>

			    </div>
			    <div  class="small-6 columns align-right">
				<div class="note grey-light">
				    <?php echo $comment_data; ?>
				</div>
			    </div>
			</div>
		    </div>
		    <div class="row ">
			<div  class="small-12 columns ">
			    <div class="row ">
				<div  class="small-12 columns ">
				    <div class="text grey">
					<?php echo $value->getText(); ?>
				    </div>
				</div>
			    </div>
			</div>
		    </div>

		</div>
		<?php
	    }
	} else {
	    ?>
    	<div class="box-singole-comment">
    	    <div class="row"><div  class="large-12 columns"><p class="grey"><?php echo $views['comment']['nodata']; ?></p></div></div>
    	</div>
	    <?php
	}
	?>
        <div class="row  ">
            <div  class="large-12 columns ">
		<form action="" class="box-write" onsubmit="sendOpinion('<?php echo $touser; ?>', $('#comment<?php echo $class . '_' . $id; ?>').val(), '<?php echo $id; ?>', '<?php echo $class; ?>', '<?php echo $box; ?>', '10', 0);
			  return false;">
                    <div class="">
                        <div class="row  ">
                            <div  class="small-9 columns ">
                                <input id="comment<?php echo $class . '_' . $id; ?>" type="text" class="post inline" placeholder="<?php echo $views['comment']['write']; ?>" />
                            </div>
                            <div  class="small-3 columns ">
                                <input type="button" class="comment-button inline comment-btn" value="Comment" onclick="sendOpinion('<?php echo $touser; ?>', $('#comment<?php echo $class . '_' . $id; ?>').val(), '<?php echo $id; ?>', '<?php echo $class; ?>', '<?php echo $box; ?>', 10, 0)" />
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="row">
            <div  class="large-12 columns ">
                <div class="comment-error" onClick="postError()"><img src="./resources/images/error/error-post.png" alt/></div>
            </div>
        </div>
    </div>
</div>