<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

require_once ROOT_DIR . 'config.php';
require_once PARSE_DIR . 'parse.php';
require_once CLASSES_DIR . 'utils.php';
require_once CLASSES_DIR . 'comment.class.php';
require_once CLASSES_DIR . 'commentParse.class.php';

$cmtParse = new CommentParse();

$cmtParse->updateField('FIEm6BFFxl', 'active', false);

//$cmtParse->updateField('FIEm6BFFxl', 'image', toParsePointer('Image', 'MuTAFCZIKd'));

//$parseGeoPoint = new parseGeoPoint('56.78', '12.34');
//$cmtParse->updateField('FIEm6BFFxl', 'location', toParseGeoPoint($parseGeoPoint));

//$parseACL = new parseACL();
//$parseACL->setPublicWriteAccess(false);
//$cmtParse->updateField('FIEm6BFFxl', 'ACL', toParseACL($parseACL));

//$cmtParse->updateField('FIEm6BFFxl', 'commentators', array('n1TXVlIqHw', 'WeTEWWfASn'), true, 'remove', '_User');

echo 'FINITO';
?>