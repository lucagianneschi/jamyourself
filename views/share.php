<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once VIEWS_DIR . 'utilities/share.php';

$classType = $_GET['classType'];
$id = $_GET['id'];
$imgPath = $_GET['imgPath'];
$params = getShareParameters($classType, $id, $imgPath);
?>
<!DOCTYPE html>
<html>
    <head>
	<meta property="og:title" content="<?php echo $params['title']; ?>" />
	<meta property="og:description" content="<?php echo $params['description']; ?>" />
	<meta property="og:image" content="<?php echo $params['img']; ?>" />
    </head>
    <body>
	<script type="text/javascript">window.location = "<?php echo $params['url']; ?>"</script>
	JavaScript redirect unsuccessful. Click <a href="<?php echo $params['url']; ?>">here</a> to continue.
    </body>
</body>
</html>