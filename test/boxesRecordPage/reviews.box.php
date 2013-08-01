<?php

/* ! \par		Info Generali:
 * \author		Luca Gianneschi
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \par			Info Classe:
 * \brief		box review record
 * \details		Recupera le review legate al record
 * \par			Commenti:
 * \warning
 * \bug
 * \todo
 *
 */


if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../');

ini_set('display_errors', '1');
require_once ROOT_DIR . 'config.php';
require_once ROOT_DIR . 'string.php';
require_once PARSE_DIR . 'parse.php';


class ReviewRecordInfo {

    public $commentCounter;
    public $createdAt;
    public $loveCounter;
    public $shareCounter;
    public $text;
    public $thumbnail;
    public $type;
    public $username;

    function __construct($commentCounter, $createdAt, $loveCounter, $shareCounter, $text, $thumbnail, $type, $username) {
		is_null($commentCounter) ? $this->commentCounter = NODATA : $this->commentCounter = $commentCounter;
		is_null($createdAt) ? $this->createdAt = NODATA : $this->createdAt = $createdAt;
		is_null($loveCounter) ? $this->loveCounter = NODATA : $this->loveCounter = $loveCounter;
		is_null($shareCounter) ? $this->shareCounter = NODATA : $this->shareCounter = $shareCounter;
		is_null($text) ? $this->text = NODATA : $this->text = $text;
		is_null($thumbnail) ? $this->thumbnail = NODATA : $this->thumbnail = $thumbnail;
		is_null($type) ? $this->type = NODATA : $this->type = $type;
		is_null($username) ? $this->username = NODATA : $this->username = $username;
    }

}

class ReviewRecordBox {

    public $postInfoArray;
    public $postCounter;

	public function init($objectId) {
	
	
		$postBox = new ReviewRecordBox() ;
		$info = array();
		$counter = 0;
	
		$commentP = new CommentParse();
		$commentP->wherePointer('record', 'Record', $objectId);
		$commentP->where('type', 'RR');
		$commentP->where('active', true);
		$commentP->whereInclude('fromUser');
		$commentP->setLimit(1000);
		$commentP->orderByDescending('createdAt');
		$reviews = $commentP->getComments();
		if ($reviews != 0) {
			if (get_class($reviews) == 'Error') {
			echo '<br />ATTENZIONE: e\' stata generata un\'eccezione: ' . $reviews->getErrorMessage() . '<br/>';
			} else {
				for ($i = 0; i < count($reviews); ++$i) {
					$counter = ++$counter;
					
					$review = $reviews[$i];
					
					$fromUser = $review->fromUser;
					$thumbnail = $fromUser->getProfileThumbnail();
					$type = $fromUser->getType();
					$username = $fromUser->getUsername();
					
					$commentCounter = $review->getCommentCounter();
					$createdAt = $review->getCreatedAt();
					$loveCounter = $review->getLoveCounter();
					$shareCounter = $review->getShareCounter();
					$text = $review->getText();
					
					$reviewRecordInfo = new PostInfo($commentCounter, $createdAt, $loveCounter, $shareCounter, $text, $thumbnail, $type, $username);
					array_push($info, $reviewRecordInfo);
				}
			}
		}
	}
}

?>

