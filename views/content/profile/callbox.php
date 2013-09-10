<?php
//
ini_set('display_errors', '1');
/*
 * DEFINE DEFAULT IMAGE DA SPOSTARE
 */

define('DEFBACKGROUND', 'images/default/defaultBackground.jpg');
define('DEFPROFILEPICTURE', 'images/default/defaultProfilepicture.jpg');
define('DEFALCBUMCOVERTHUM', 'images/default/defaultAlbumcoverthumb.jpg'); 
define('DEFEVENTCOVERTHUM', 'images/default/defaultEventcoverthumb.jpg'); 
define('DEFIMAGE', 'images/default/defaultImage.jpg'); 
define('DEFRECORDCOVERTHUM', 'images/default/defaultRecordCoverThumb.jpg'); 
define('DEFPROFILEPICTURETHUM', 'images/default/defaultProfilepicturethumb.jpg'); 

error_reporting(0);

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';


$box = $_POST['typebox'];
$objectId = $_POST['objectId'];
$type = $_POST['type'];
$class = $_POST['classBox'];
/*
 $box = 'comment';
 $objectId = 'gdZowTbFRk';
 $type = 'SPOTTER';
 $class = 'Image';
 */
$result = array();

$result['error']['code'] = 0;
$result['error']['message'] = 'ok';

switch ($box) {
	case 'userinfo' :
		require_once BOXES_DIR . 'userInfo.box.php';

		$userInfo = new UserInfoBox();
		$dati = $userInfo -> initForPersonalPage($objectId);
		if (!($dati instanceof Error)) {
			$result['backGround'] = $dati -> backGround != NODATA ? $dati -> backGround : DEFBACKGROUND;
			$result['city'] = $dati -> city != NODATA ? $dati -> city : '';
			$result['county'] = $dati -> county != NODATA ? $dati -> county : '';
			$result['description'] = $dati -> description != NODATA ? $dati -> description : '';
			$result['facebook'] = $dati -> fbPage != NODATA ? $dati -> fbPage : '';
			$result['google'] = $dati -> googlePlusPage != NODATA ? $dati -> googlePlusPage : '';
			$result['level'] = $dati -> level != NODATA ? $dati -> level : '0';
			$result['levelValue'] = $dati -> levelValue != NODATA ? $dati -> levelValue : '';
			$dati -> type != NODATA ? $result['type'] = $dati -> type : $result['error'] = 1;
			$result['twitter'] = $dati -> twitterPage != NODATA ? $dati -> twitterPage : '';
			$dati -> userName != NODATA ? $result['username'] = $dati -> userName : $result['error'] = 1;
			$result['profilePicture'] = $dati -> profilePicture != DEFAULTAVATAR ? $dati -> profilePicture : DEFPROFILEPICTURE;
			$result['youtube'] = $dati -> youtubeChannel != NODATA ? $dati -> youtubeChannel : '';
			$result['web'] = $dati -> webSite != NODATA ? $dati -> webSite : '';
			if ($result['type'] == 'JAMMER' || $result['type'] == 'SPOTTER') {
				$result['record'] = '';
				if (is_array($dati -> record)) {
					foreach ($dati -> record as $key => $value) {
						$result['record'] = $value . ' ' . $result['record'];
					}
				}

				if (is_array($dati -> membres)) {
					$result['membres'] = $dati -> membres;
				} else
					$result['membres'] = array();

			}
			$result['geoCoding'] = '';
			if ($result['type'] == 'VENUE') {
				$result['geoCoding'] = $dati -> geoCoding;
			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		$result = json_encode($result);
		break;

	case 'activity' :
		require_once BOXES_DIR . 'activity.box.php';
		$activityBoxP = new ActivityBox();
		$activityBox = $activityBoxP -> initForPersonalPage($objectId, $type);

		if (!($activityBox instanceof Error)) {
			$result['albumInfo']['imageCounter'] = $activityBox -> albumInfo -> imageCounter;
			$result['albumInfo']['objectId'] = $activityBox -> albumInfo -> objectId;
			$result['albumInfo']['title'] = $activityBox -> albumInfo -> title != NODATA ? $activityBox -> albumInfo -> title : '';
			foreach ($activityBox -> albumInfo -> imageArray as $key => $value) {
				$result['albumInfo']['album' . $key]['thumbnail'] = $value -> thumbnail != NODATA ? $value -> thumbnail : DEFALCBUMCOVERTHUM;
			}
			$result['eventInfo']['address'] = $activityBox -> eventInfo -> address != NODATA ? $activityBox -> eventInfo -> address : '';
			$result['eventInfo']['city'] = $activityBox -> eventInfo -> city != NODATA ? $activityBox -> eventInfo -> city : '';
			$result['eventInfo']['eventDate'] = $activityBox -> eventInfo -> eventDate != NODATA ? $activityBox -> eventInfo -> eventDate : '';
			$result['eventInfo']['locationName'] = $activityBox -> eventInfo -> locationName != NODATA ? $activityBox -> eventInfo -> locationName : '';
			$result['eventInfo']['objectId'] = $activityBox -> eventInfo -> objectId != NODATA ? $activityBox -> eventInfo -> objectId : '';
			$result['eventInfo']['thumbnail'] = $activityBox -> eventInfo -> thumbnail != NODATA ? $activityBox -> eventInfo -> thumbnail : DEFEVENTCOVERTHUM;
			$result['eventInfo']['title'] = $activityBox -> eventInfo -> title != NODATA ? $activityBox -> eventInfo -> title : '';

			$result['recordInfo']['fromUserInfo'] = $activityBox -> recordInfo -> fromUserInfo != NODATA ? $activityBox -> recordInfo -> fromUserInfo : '';
			$result['recordInfo']['objectId'] = $activityBox -> recordInfo -> objectId != NODATA ? $activityBox -> recordInfo -> objectId : '';
			$result['recordInfo']['thumbnailCover'] = $activityBox -> recordInfo -> thumbnailCover != NODATA ? $activityBox -> recordInfo -> thumbnailCover : DEFRECORDCOVERTHUM;
			$result['recordInfo']['title'] = $activityBox -> recordInfo -> title != NODATA ? $activityBox -> recordInfo -> title : '';
			$result['recordInfo']['songTitle'] = $activityBox -> recordInfo -> songTitle != NODATA ? $activityBox -> recordInfo -> songTitle : '';
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		$result = json_encode($result);
		break;

	case 'album' :
		require_once BOXES_DIR . 'album.box.php';
		$albumBoxP = new AlbumBox();
		$albumBox = $albumBoxP -> initForPersonalPage($objectId);
		if (!($albumBox instanceof Error)) {
			$result['albumCounter'] = $albumBox -> albumCounter;
			foreach ($albumBox -> albumInfoArray as $key => $value) {
				$result['album' . $key]['counters'] = $value -> counters;
				$result['album' . $key]['imageCounter'] = $value -> imageCounter;
				$result['album' . $key]['objectId'] = $value -> objectId;
				$result['album' . $key]['thumbnailCover'] = $value -> thumbnailCover != NODATA ? $value -> thumbnailCover : DEFALCBUMCOVERTHUM;
				$result['album' . $key]['title'] = $value -> title != NODATA ? $value -> title : '';
				$albumDetail = $albumBoxP -> initForDetail($value -> objectId);
				foreach ($albumDetail->imageArray as $keyImage => $valueImage) {
					$result['album' . $key]['image' . $keyImage]['counters'] = $valueImage -> albumCounter;
					$result['album' . $key]['image' . $keyImage]['description'] = $valueImage -> description != NODATA ? $valueImage -> description : '';
					$result['album' . $key]['image' . $keyImage]['filePath'] = $valueImage -> filePath != NODATA ? $valueImage -> filePath : DEFIMAGE;
					$result['album' . $key]['image' . $keyImage]['objectId'] = $valueImage -> objectId != NODATA ? $valueImage -> objectId : '';
					$result['album' . $key]['image' . $keyImage]['tags'] = $valueImage -> tags != NODATA ? $valueImage -> tags : '';
					$result['album' . $key]['image' . $keyImage]['thumbnail'] = $valueImage -> thumbnail != NODATA ? $valueImage -> thumbnail : DEFIMAGE;
				}

			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		$result = json_encode($result);
		break;
	case 'comment' :
		require_once BOXES_DIR . 'comment.box.php';
		$commentBoxP = new CommentBox();
		$commentBox = $commentBoxP -> init($class, $objectId);
		if (!($commentBox instanceof Error)) {
			foreach ($commentBox->commentInfoArray as $key => $value) {
				$result['comment' . $key]['user_objectId'] = $value -> fromUserInfo -> objectId;
				$result['comment' . $key]['user_thumbnail'] = $value -> fromUserInfo -> thumbnail != NODATA ? $value -> fromUserInfo -> thumbnail : DEFPROFILEPICTURETHUM;
				$result['comment' . $key]['user_type'] = $value -> fromUserInfo -> type != NODATA ? $value -> fromUserInfo -> type : '';
				$result['comment' . $key]['user_username'] = $value -> fromUserInfo -> username != NODATA ? $value -> fromUserInfo -> username : '';
				$result['comment' . $key]['createdAt'] = $value -> createdAt;
				$result['comment' . $key]['text'] = $value -> text;
			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		break;
		$result = json_encode($result);
	case 'event' :
		require_once BOXES_DIR . 'event.box.php';
		$eventBoxP = new EventBox();
		$eventBox = $eventBoxP -> initForPersonalPage($objectId);
		if (!($eventBox instanceof Error)) {
			$result['eventCounter'] = $eventBox -> eventCounter;
			foreach ($eventBox->eventInfoArray as $key => $value) {
				$result['event' . $key]['address'] = $value -> address != NODATA ? $value -> address : '';
				$result['event' . $key]['city'] = $value -> city != NODATA ? $value -> city : '';
				$result['event' . $key]['counters'] = $value -> counters != NODATA ? $value -> counters : '';
				$result['event' . $key]['eventDate'] = $value -> eventDate != NODATA ? $value -> eventDate : '';
				$result['event' . $key]['featuring'] = $value -> featuring != NODATA ? $value -> featuring : array();
				$result['event' . $key]['fromUserInfo'] = $value -> fromUserInfo != NODATA ? $value -> fromUserInfo : '';
				$result['event' . $key]['locationName'] = $value -> locationName != NODATA ? $value -> locationName : '';
				$result['event' . $key]['tags'] = $value -> tags != NODATA ? $value -> tags : '';
				$result['event' . $key]['thumbnail'] = $value -> thumbnail != NODATA ? $value -> thumbnail : DEFEVENTCOVERTHUM;
				$result['event' . $key]['title'] = $value -> title != NODATA ? $value -> title : '';
			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		$result = json_encode($result);
		break;
	case 'post' :
		require_once BOXES_DIR . 'post.box.php';
		$recordPostP = new PostBox();
		$recordPost = $recordPostP -> initForPersonalPage($objectId);
		if (!($eventBox instanceof Error)) {
			$result['postCounter'] = $recordPost -> postCounter;
			foreach ($recordPost->postInfoArray as $key => $value) {
				$result['post' . $key]['counters'] = $value -> counters != NODATA ? $value -> counters : '';
				$result['post' . $key]['createdAt'] = $value -> createdAt != NODATA ? $value -> createdAt : '';
				$result['post' . $key]['user_type'] = $value -> fromUserInfo -> type != NODATA ? $value -> fromUserInfo -> type : '';
				$result['post' . $key]['user_username'] = $value -> fromUserInfo -> username != NODATA ? $value -> fromUserInfo -> username : '';
				$result['post' . $key]['user_thumbnail'] = $value -> fromUserInfo -> thumbnail != NODATA ? $value -> fromUserInfo -> thumbnail : '';
				$result['post' . $key]['text'] = $value -> createdAt != NODATA ? $value -> text : '';
			}

		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		$result = json_encode($result);
		break;
	case 'record' :
		require_once BOXES_DIR . 'record.box.php';
		$recordBoxP = new RecordBox();
		$recordBox = $recordBoxP -> initForPersonalPage($objectId);
		if (!($recordBox instanceof Error)) {
			$result['recordCounter'] = $recordBox -> recordCounter;
			$result['tracklist'] = $recordBox -> tracklist;
			foreach ($recordBox->recordInfoArray as $key => $value) {
				$result['record' . $key]['counters'] = $value -> counters != NODATA ? $value -> counters : '';
				$result['record' . $key]['genre'] = $value -> genre != NODATA ? $value -> genre : '';
				$result['record' . $key]['objectId'] = $value -> objectId != NODATA ? $value -> objectId : '';
				$result['record' . $key]['songCounter'] = $value -> songCounter != NODATA ? $value -> songCounter : '';
				$result['record' . $key]['thumbnailCover'] = $value -> thumbnailCover != NODATA ? $value -> thumbnailCover : DEFRECORDCOVERTHUM;
				$result['record' . $key]['title'] = $value -> title != NODATA ? $value -> title : '';
				$result['record' . $key]['year'] = $value -> year != NODATA ? $value -> year : '';
				$recordDetail = $recordBoxP -> initForDetail($result['record' . $key]['objectId']);
				$result['record' . $key]['recordDetail'] = $recordDetail;
			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		$result = json_encode($result);
		break;
	case 'relation' :
		require_once BOXES_DIR . 'relation.box.php';
		$relationsP = new RelationsBox();
		$relationsBox = $relationsP -> initForPersonalPage($objectId, $type);
		if (!($relationsBox instanceof Error)) {
			if ($relationsBox -> relationArray -> followers != ND) {
				$result['relation']['followers']['followersCounter'] = count($relationsBox -> relationArray -> followers);
				foreach ($relationsBox->relationArray->followers->followersArray as $key => $value) {					
					$result['relation']['followers'. $key]['objectId'] = $value -> userInfo -> objectId;
					$result['relation']['followers'. $key]['thumbnail'] = $value -> userInfo -> thumbnail != NODATA ? $value -> userInfo -> thumbnail : DEFPROFILEPICTURETHUM;
					$result['relation']['followers'. $key]['type'] = $value -> userInfo -> type;
					$result['relation']['followers'. $key]['username'] = $value -> userInfo -> username;
				}
			}
			if ($relationsBox -> relationArray -> following != ND) {
				$result['relation']['following']['followingCounter'] = count($relationsBox -> relationArray -> following);
				$followingVenueCounter = 0;
				$followingJammerCounter = 0;
				foreach ($relationsBox->relationArray->following->followingArray as $key => $value) {
							if($value -> userInfo -> type == 'VENUE'){
								$result['relation']['followingVenue'. $key]['objectId'] = $value -> userInfo -> objectId;
								$result['relation']['followingVenue'. $key]['thumbnail'] = $value -> userInfo -> thumbnail != NODATA ? $value -> userInfo -> thumbnail : DEFPROFILEPICTURETHUM;
								$result['relation']['followingVenue'. $key]['type'] = $value -> userInfo -> type;
								$result['relation']['followingVenue'. $key]['username'] = $value -> userInfo -> username;
								$followingVenueCounter++;
							}
							if($value -> userInfo -> type == 'JAMMER'){
								$result['relation']['followingJammer'. $key]['objectId'] = $value -> userInfo -> objectId;
								$result['relation']['followingJammer'. $key]['thumbnail'] = $value -> userInfo -> thumbnail != NODATA ? $value -> userInfo -> thumbnail : DEFPROFILEPICTURETHUM;
								$result['relation']['followingJammer'. $key]['type'] = $value -> userInfo -> type;
								$result['relation']['followingJammer'. $key]['username'] = $value -> userInfo -> username;
								$followingJammerCounter++;
							}
				}
				$result['relation']['followingVenue']['followingVenueCounter'] = $followingVenueCounter;
				$result['relation']['followingVenue']['followingJammerCounter'] = $followingJammerCounter;
			}
			if ($relationsBox -> relationArray -> friendship != ND) {
				$result['relation']['friendship']['friendshipCounter'] = count($relationsBox -> relationArray -> friendship);
				foreach ($relationsBox->relationArray->friendship->friendshipArray as $key => $value) {
					$result['relation']['friendship'. $key]['objectId'] = $value -> userInfo -> objectId;
					$result['relation']['friendship'. $key]['thumbnail'] = $value -> userInfo -> thumbnail != NODATA ? $value -> userInfo -> thumbnail : DEFPROFILEPICTURETHUM;
					$result['relation']['friendship'. $key]['type'] = $value -> userInfo -> type;
					$result['relation']['friendship'. $key]['username'] = $value -> userInfo -> username;
				}
			}
			if ($relationsBox -> relationArray -> venuesCollaborators != ND) {
				$result['relation']['venuesCollaborators']['venuesCollaboratorsCounter'] = count($relationsBox -> relationArray -> venuesCollaborators);
				foreach ($relationsBox->relationArray->venuesCollaborators->venuesArray as $key => $value) {
					$result['relation']['venuesCollaborators'. $key]['objectId'] = $value -> userInfo -> objectId;
					$result['relation']['venuesCollaborators'. $key]['thumbnail'] = $value -> userInfo -> thumbnail != NODATA ? $value -> userInfo -> thumbnail : DEFPROFILEPICTURETHUM;
					$result['relation']['venuesCollaborators'. $key]['type'] = $value -> userInfo -> type;
					$result['relation']['venuesCollaborators'. $key]['username'] = $value -> userInfo -> username;
				}
			}
			if ($relationsBox -> relationArray -> jammersCollaborators != ND) {
				$result['relation']['jammersCollaborators']['jammersCollaboratorsCounter'] = count($relationsBox -> relationArray -> jammersCollaborators);
				foreach ($relationsBox->relationArray->jammersCollaborators->jammersArray as $key => $value) {
					$result['relation']['jammersCollaborators'. $key]['objectId'] = $value -> userInfo -> objectId;
					$result['relation']['jammersCollaborators'. $key]['thumbnail'] = $value -> userInfo -> thumbnail != NODATA ? $value -> userInfo -> thumbnail : DEFPROFILEPICTURETHUM;
					$result['relation']['jammersCollaborators'. $key]['type'] = $value -> userInfo -> type;
					$result['relation']['jammersCollaborators'. $key]['username'] = $value -> userInfo -> username;
				}
			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		$result = json_encode($result);
		break;
	case 'review' :
		require_once BOXES_DIR . 'review.box.php';
		$reviewBox = new ReviewBox();
		if ($type != 'VENUE') {
			$reviewRecordBox = $reviewBox -> initForPersonalPage($objectId, $type, 'Record');
			if (!($reviewRecordBox instanceof Error)) {
				$result['recordReviewCounter'] = $reviewRecordBox -> reviewCounter;

				foreach ($reviewRecordBox->reviewArray as $key => $value) {
					$result['recordReview' . $key]['counters'] = $value -> counters;
					$result['recordReview' . $key]['objectId'] = $value -> objectId;
					$result['recordReview' . $key]['rating'] = $value -> rating;
					$result['recordReview' . $key]['text'] = $value -> text != NODATA ? $value -> text : '';
					$result['recordReview' . $key]['title'] = $value -> title != NODATA ? $value -> title : '';
					$result['recordReview' . $key]['thumbnailCover'] = $value -> thumbnailCover != NODATA ? $value -> thumbnailCover : DEFRECORDCOVERTHUM;
					$result['recordReview' . $key]['user_objectId'] = $value -> fromUserInfo -> objectId != NODATA ? $value -> fromUserInfo -> objectId : '';
					$result['recordReview' . $key]['user_type'] = $value -> fromUserInfo -> type != NODATA ? $value -> fromUserInfo -> type : '';
					$result['recordReview' . $key]['user_thumbnail'] = $value -> fromUserInfo -> thumbnail != NODATA ? $value -> fromUserInfo -> thumbnail : DEFPROFILEPICTURETHUM;
					$result['recordReview' . $key]['user_username'] = $value -> fromUserInfo -> username != NODATA ? $value -> fromUserInfo -> username : '';
				}
			} else {
				$result['error']['code'] = 101;
				$result['error']['message'] = 'object not found for get';
			}
		}
		$reviewEventBox = $reviewBox -> initForPersonalPage($objectId, 'JAMMER', 'Event');
		if (!($reviewEventBox instanceof Error)) {
			$result['eventReviewCounter'] = $reviewEventBox -> reviewCounter;

			foreach ($reviewEventBox->reviewArray as $key => $value) {
				$result['eventReview' . $key]['counters'] = $value -> counters;
				$result['eventReview' . $key]['objectId'] = $value -> objectId;
				$result['eventReview' . $key]['rating'] = $value -> rating;
				$result['eventReview' . $key]['text'] = $value -> text != NODATA ? $value -> text : '';
				$result['eventReview' . $key]['title'] = $value -> title != NODATA ? $value -> title : '';
				$result['eventReview' . $key]['thumbnailCover'] = $value -> thumbnailCover != NODATA ? $value -> thumbnailCover : DEFEVENTCOVERTHUM;
				$result['eventReview' . $key]['user_type'] = $value -> fromUserInfo -> type != NODATA ? $value -> fromUserInfo -> type : '';
				$result['eventReview' . $key]['user_thumbnail'] = $value -> fromUserInfo -> thumbnail != NODATA ? $value -> fromUserInfo -> thumbnail : DEFPROFILEPICTURETHUM;
			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		$result = json_encode($result);
		break;
	default :
		$result = json_encode($result);
		break;
}

echo $result;
/*
 print "<pre>";
 print_r($commentBox);
 print "</pre>";
 *
 */
?>