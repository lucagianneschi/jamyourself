<?php

/* ! \par		Info Generali:
 * \author		Maria Laura Fresu
 * \version		1.0
 * \date		2013
 * \copyright	Jamyourself.com 2013
 * \brief		script per il carimaneto dei box 
 * \details		I box vengono chiamati in base ai parametri passati come POST
 * \par			Commenti:
 * \warning
 * \bug
 * \todo		
 *
 */
 
error_reporting(0);


if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'geocoder.service.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';

$box 				 = $_POST['typebox'];
$objectId 			 = $_POST['objectIdUser'];
$type 				 = $_POST['typeUser'];
$objectIdCurrentUser = $_POST['objectIdCurrentUser'];
$classBox			 = $_POST['classBox'];
$objectIdComment 	 = $_POST['objectId'];

$result = array();

$result['error']['code'] = 0;
$result['error']['message'] = 'ok';

switch ($box) {
	case 'userinfo' :
		try{
			
			require_once BOXES_DIR . 'userInfo.box.php';
				
			$userInfo = new UserInfoBox();
			
			$dati = $userInfo -> initForPersonalPage($objectId);
			
			if (!($dati instanceof Error)) {
				$result['backGround'] = $dati -> backGround != $boxes['NODATA'] ? $dati -> backGround : $boxes['DEFBGD'];
				$result['city'] = $dati -> city != $boxes['NODATA'] ? $dati -> city : '';
				$result['county'] = $dati -> county != $boxes['NODATA'] ? $dati -> county : '';
				$result['description'] = $dati -> description != $boxes['NODATA'] ? $dati -> description : '';
				$result['facebook'] = $dati -> fbPage != $boxes['NODATA'] ? $dati -> fbPage : '';
				$result['google'] = $dati -> googlePlusPage != $boxes['NODATA'] ? $dati -> googlePlusPage : '';
				$result['level'] = $dati -> level != $boxes['NODATA'] ? $dati -> level : '0';
				$result['levelValue'] = $dati -> levelValue != $boxes['NODATA'] ? $dati -> levelValue : '';
				$dati -> type != $boxes['NODATA'] ? $result['type'] = $dati -> type : $result['error'] = 1;
				$result['twitter'] = $dati -> twitterPage != $boxes['NODATA'] ? $dati -> twitterPage : '';
				$dati -> userName != $boxes['NODATA'] ? $result['username'] = $dati -> userName : $result['error'] = 1;
				$result['profilePicture'] = $dati -> profilePicture != $boxes['DEFAULTAVATAR'] ? $dati -> profilePicture : $boxes['DEFAVATAR'];
				$result['youtube'] = $dati -> youtubeChannel != $boxes['NODATA'] ? $dati -> youtubeChannel : '';
				$result['web'] = $dati -> webSite != $boxes['NODATA'] ? $dati -> webSite : '';
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
				$result['lat'] = '';
				$result['lng'] = '';
				$result['address'] = '';
				if ($result['type'] == 'VENUE') {					
					if($dati->geoCoding instanceof parseGeoPoint){
						$result['lat'] = $dati->geoCoding->lat;
						$result['lng'] = $dati->geoCoding->long;												
											
						$geocode = new GeocoderService();
						
						$addressCode = $geocode->getAddress($result['lat'], $result['lng']);
						if(count($addressCode)>0){
							$result['address'] = $addressCode['route'] . " " . $addressCode['street_number'];
						}						 
					}
				}
			} else {
				$result['error']['code'] = 101;
				$result['error']['message'] = 'object not found for get';
			}
		}catch (Exception $e) {
		   $result['error']['code'] = 101;
		   $result['error']['message'] = 'Error infoUser';
		}
		$result = json_encode($result);
		break;

	case 'activity' :
		require_once BOXES_DIR . 'activity.box.php';
		$activityBoxP = new ActivityBox();
		try{
			$activityBox = $activityBoxP -> initForPersonalPage($objectId, $type);

		if (!($activityBox instanceof Error)) {
			$result['albumInfo']['imageCounter'] = $activityBox -> albumInfo -> imageCounter;
			$result['albumInfo']['objectId'] = $activityBox -> albumInfo -> objectId;
			$result['albumInfo']['title'] = $activityBox -> albumInfo -> title != $boxes['NODATA'] ? $activityBox -> albumInfo -> title : '';
			foreach ($activityBox -> albumInfo -> imageArray as $key => $value) {
				$result['albumInfo']['album' . $key]['thumbnail'] = $value -> thumbnail != $boxes['NODATA'] ? $value -> thumbnail : $boxes['DEFALBUMTHUMB'];
			}
			$result['eventInfo']['address'] = $activityBox -> eventInfo -> address != $boxes['NODATA'] ? $activityBox -> eventInfo -> address : '';
			$result['eventInfo']['city'] = $activityBox -> eventInfo -> city != $boxes['NODATA'] ? $activityBox -> eventInfo -> city : '';
			$result['eventInfo']['eventDate'] = $activityBox -> eventInfo -> eventDate != $boxes['NODATA'] ? $activityBox -> eventInfo -> eventDate : '';
			$result['eventInfo']['locationName'] = $activityBox -> eventInfo -> locationName != $boxes['NODATA'] ? $activityBox -> eventInfo -> locationName : '';
			$result['eventInfo']['objectId'] = $activityBox -> eventInfo -> objectId != $boxes['NODATA'] ? $activityBox -> eventInfo -> objectId : '';
			$result['eventInfo']['thumbnail'] = $activityBox -> eventInfo -> thumbnail != $boxes['NODATA'] ? $activityBox -> eventInfo -> thumbnail : $boxes['DEFEVENTTHUMB'];
			$result['eventInfo']['title'] = $activityBox -> eventInfo -> title != $boxes['NODATA'] ? $activityBox -> eventInfo -> title : '';

			$result['recordInfo']['fromUserInfo'] = $activityBox -> recordInfo -> fromUserInfo != $boxes['NODATA'] ? $activityBox -> recordInfo -> fromUserInfo : '';
			$result['recordInfo']['objectId'] = $activityBox -> recordInfo -> objectId != $boxes['NODATA'] ? $activityBox -> recordInfo -> objectId : '';
			$result['recordInfo']['thumbnailCover'] = $activityBox -> recordInfo -> thumbnailCover != $boxes['NODATA'] ? $activityBox -> recordInfo -> thumbnailCover : $boxes['DEFRECORDTHUMB'];
			$result['recordInfo']['title'] = $activityBox -> recordInfo -> title != $boxes['NODATA'] ? $activityBox -> recordInfo -> title : '';
			$result['recordInfo']['songTitle'] = $activityBox -> recordInfo -> songTitle != $boxes['NODATA'] ? $activityBox -> recordInfo -> songTitle : '';
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		}catch (Exception $e) {
		   $result['error']['code'] = 101;
				$result['error']['message'] = 'Error Activity';
		}
		$result = json_encode($result);
		break;

	case 'album' :
		require_once BOXES_DIR . 'album.box.php';
		$albumBoxP = new AlbumBox();
		try{
		$albumBox = $albumBoxP -> initForPersonalPage($objectId);
		if (!($albumBox instanceof Error)) {
			$result['albumCounter'] = $albumBox -> albumCounter;
			foreach ($albumBox -> albumInfoArray as $key => $value) {
				$result['album' . $key]['counters'] = $value -> counters;
				$result['album' . $key]['imageCounter'] = $value -> imageCounter;
				$result['album' . $key]['objectId'] = $value -> objectId;
				$result['album' . $key]['thumbnailCover'] = $value -> thumbnailCover != $boxes['NODATA'] ? $value -> thumbnailCover : $boxes['DEFALBUMTHUMB'];
				$result['album' . $key]['title'] = $value -> title != $boxes['NODATA'] ? $value -> title : '';
				$albumDetail = $albumBoxP -> initForDetail($value -> objectId);
				foreach ($albumDetail->imageArray as $keyImage => $valueImage) {
					$result['album' . $key]['image' . $keyImage]['counters'] = $valueImage -> counters;
					$result['album' . $key]['image' . $keyImage]['description'] = $valueImage -> description != $boxes['NODATA'] ? $valueImage -> description : '';
					$result['album' . $key]['image' . $keyImage]['filePath'] = $valueImage -> filePath != $boxes['NODATA'] ? $valueImage -> filePath : $boxes['DEFIMAGE'];
					$result['album' . $key]['image' . $keyImage]['objectId'] = $valueImage -> objectId != $boxes['NODATA'] ? $valueImage -> objectId : '';
					$result['album' . $key]['image' . $keyImage]['tags'] = $valueImage -> tags != $boxes['NODATA'] ? $valueImage -> tags : '';
					$result['album' . $key]['image' . $keyImage]['thumbnail'] = $valueImage -> thumbnail != $boxes['NODATA'] ? $valueImage -> thumbnail : $boxes['DEFIMAGE'];
					$location = $valueImage -> location != $boxes['NODATA'] ? $valueImage -> location : '';
					$address = "";	
								
					if($location instanceof parseGeoPoint){
												
						$lat = $location->lat;
						$lng = $location->long;						
						$geocode = new GeocoderService();
						
						$addressCode = $geocode->getAddress($lat, $lng);
						if(count($addressCode)>0){
							$address = $addressCode['locality'] . " - " . $addressCode['country'];
						}						 
					}
					$result['album' . $key]['image' . $keyImage]['location'] = $address;
				}

			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		}catch (Exception $e) {
		   $result['error']['code'] = 101;
				$result['error']['message'] = 'Error Album';
		}
		$result = json_encode($result);
		break;
	case 'comment' :
		require_once BOXES_DIR . 'comment.box.php';
		$commentBoxP = new CommentBox();		
		try  {
			$commentBox = $commentBoxP -> init($classBox, $objectIdComment);			
			if (!($commentBox instanceof Error)) {
				$result['comment']['commentCounter'] = count($commentBox->commentInfoArray);
				foreach ($commentBox->commentInfoArray as $key => $value) {					
					$result['comment'. $key]['user_objectId'] = $value -> fromUserInfo -> objectId;
					$result['comment'. $key]['user_thumbnail'] = $value -> fromUserInfo -> thumbnail != $boxes['NODATA'] ? $value -> fromUserInfo -> thumbnail : $boxes['DEFTHUMB'];
					$result['comment'. $key]['user_type'] = $value -> fromUserInfo -> type != $boxes['NODATA'] ? $value -> fromUserInfo -> type : '';
					$result['comment'. $key]['user_username'] = $value -> fromUserInfo -> username != $boxes['NODATA'] ? $value -> fromUserInfo -> username : '';
					$result['comment'. $key]['createdAt'] = $value -> createdAt;
					$result['comment'. $key]['text'] = $value -> text;					
				}
				
			} else {
				$result['error']['code'] = 101;
				$result['error']['message'] = 'object not found for get';				
			}
		}catch (Exception $e) {
		   $result['comment'] = '';
		   $result['error']['message'] = 'Error Comment';
		}
		$result = json_encode($result);
		break;
		
	case 'event' :
		require_once BOXES_DIR . 'event.box.php';
		$eventBoxP = new EventBox();
		try  {
			$eventBox = $eventBoxP -> initForPersonalPage($objectId);
			if (!($eventBox instanceof Error)) {
				$result['eventCounter'] = $eventBox -> eventCounter;
				foreach ($eventBox->eventInfoArray as $key => $value) {
					$result['event' . $key]['address'] = $value -> address != $boxes['NODATA'] ? $value -> address : '';
					$result['event' . $key]['city'] = $value -> city != $boxes['NODATA'] ? $value -> city : '';
					$result['event' . $key]['counters'] = $value -> counters != $boxes['NODATA'] ? $value -> counters : '';
					$result['event' . $key]['eventDate'] = $value -> eventDate != $boxes['NODATA'] ? $value -> eventDate : '';
					$result['event' . $key]['featuring'] = $value -> featuring != $boxes['NODATA'] ? $value -> featuring : array();
					$result['event' . $key]['fromUserInfo'] = $value -> fromUserInfo != $boxes['NODATA'] ? $value -> fromUserInfo : '';
					$result['event' . $key]['locationName'] = $value -> locationName != $boxes['NODATA'] ? $value -> locationName : '';
					$result['event' . $key]['tags'] = $value -> tags != $boxes['NODATA'] ? $value -> tags : '';
					$result['event' . $key]['thumbnail'] = $value -> thumbnail != $boxes['NODATA'] ? $value -> thumbnail : $boxes['DEFEVENTTHUMB'];
					$result['event' . $key]['title'] = $value -> title != $boxes['NODATA'] ? $value -> title : '';
					$result['event' . $key]['objectId'] = $value -> objectId != $boxes['NODATA'] ? $value -> objectId : '';
				}
			$result['activity']['event'] = $result['event' . 0];
			} else {
				$result['error']['code'] = 101;
				$result['error']['message'] = 'object not found for get';
			}
		}catch (Exception $e) {
		   $result['error']['code'] = 101;
				$result['error']['message'] = 'Error Event';
		}
		$result = json_encode($result);
		break;
	case 'post' :
		require_once BOXES_DIR . 'post.box.php';
		$recordPostP = new PostBox();
		try  {
		$recordPost = $recordPostP -> initForPersonalPage($objectId);
			if (!($eventBox instanceof Error)) {
				$result['postCounter'] = $recordPost -> postCounter;
				foreach ($recordPost->postInfoArray as $key => $value) {
					$result['post' . $key]['counters'] = $value -> counters != $boxes['NODATA'] ? $value -> counters : '';
					$result['post' . $key]['createdAt'] = $value -> createdAt != $boxes['NODATA'] ? $value -> createdAt : '';
					$result['post' . $key]['user_type'] = $value -> fromUserInfo -> type != $boxes['NODATA'] ? $value -> fromUserInfo -> type : '';
					$result['post' . $key]['user_username'] = $value -> fromUserInfo -> username != $boxes['NODATA'] ? $value -> fromUserInfo -> username : '';
					$result['post' . $key]['user_thumbnail'] = $value -> fromUserInfo -> thumbnail != $boxes['NODATA'] ? $value -> fromUserInfo -> thumbnail : '';
					$result['post' . $key]['text'] = $value -> createdAt != $boxes['NODATA'] ? $value -> text : '';
				}
	
			} else {
				$result['error']['code'] = 101;
				$result['error']['message'] = 'object not found for get';
			}
		}catch (Exception $e) {
		   $result['error']['code'] = 101;
				$result['error']['message'] = 'Error Post';
		}
		$result = json_encode($result);
		break;
	case 'record' :
		require_once BOXES_DIR . 'record.box.php';
		$recordBoxP = new RecordBox();
		try  {
			$recordBox = $recordBoxP -> initForPersonalPage($objectId);
			if (!($recordBox instanceof Error)) {
				$result['recordCounter'] = $recordBox -> recordCounter;
				$result['tracklist'] = $recordBox -> tracklist;
				foreach ($recordBox->recordInfoArray as $key => $value) {
					$result['record' . $key]['counters'] = $value -> counters != $boxes['NODATA'] ? $value -> counters : '';
					$result['record' . $key]['genre'] = $value -> genre != $boxes['NODATA'] ? $value -> genre : '';
					$result['record' . $key]['objectId'] = $value -> objectId != $boxes['NODATA'] ? $value -> objectId : '';
					$result['record' . $key]['songCounter'] = $value -> songCounter != $boxes['NODATA'] ? $value -> songCounter : '';
					$result['record' . $key]['thumbnailCover'] = $value -> thumbnailCover != $boxes['NODATA'] ? $value -> thumbnailCover : $boxes['DEFRECORDTHUMB'];
					$result['record' . $key]['title'] = $value -> title != $boxes['NODATA'] ? $value -> title : '';
					$result['record' . $key]['year'] = $value -> year != $boxes['NODATA'] ? $value -> year : '';
					$recordDetail = $recordBoxP -> initForDetail($result['record' . $key]['objectId']);
					$result['record' . $key]['recordDetail'] = $recordDetail;				
				}
				$result['activity']['record'] = $result['record' . 0];
			} else {
				$result['error']['code'] = 101;
				$result['error']['message'] = 'object not found for get';
			}
		}catch (Exception $e) {
		   $result['error']['code'] = 101;
				$result['error']['message'] = 'Error Record';
		}
		$result = json_encode($result);
		break;
	case 'relation' :
		require_once BOXES_DIR . 'relation.box.php';
		$relationsP = new RelationsBox();
		try  {
		$relationsBox = $relationsP -> initForPersonalPage($objectId, $type);
		$result['activity']['relation'] = "";
		if (!($relationsBox instanceof Error)) {
			if ($relationsBox -> relationArray['followers'] != $boxes['ND']) {
				$result['relation']['followers']['followersCounter'] = count($relationsBox -> relationArray ['followers']);
				foreach ($relationsBox->relationArray['followers'] as $key => $value) {					
					$result['relation']['followers'. $key]['objectId'] = $value  -> objectId;
					$result['relation']['followers'. $key]['thumbnail'] = $value  -> thumbnail != $boxes['NODATA'] ? $value  -> thumbnail : $boxes['DEFTHUMB'];
					$result['relation']['followers'. $key]['type'] = $value  -> type;
					$result['relation']['followers'. $key]['username'] = $value  -> username;
				}
			}
			if ($relationsBox -> relationArray ['following'] != $boxes['ND']) {
				$result['relation']['following']['followingCounter'] = count($relationsBox -> relationArray ['following']);
				$followingVenueCounter = 0;
				$followingJammerCounter = 0;
				foreach ($relationsBox->relationArray['following'] as $key => $value) {
						if($value  -> type == 'VENUE'){
							$result['relation']['followingVenue'. $key]['objectId'] = $value  -> objectId;
							$result['relation']['followingVenue'. $key]['thumbnail'] = $value  -> thumbnail != $boxes['NODATA'] ? $value  -> thumbnail : $boxes['DEFTHUMB'];
							$result['relation']['followingVenue'. $key]['type'] = $value  -> type;
							$result['relation']['followingVenue'. $key]['username'] = $value  -> username;
							$followingVenueCounter++;
						}
						if($value  -> type == 'JAMMER'){
							$result['relation']['followingJammer'. $key]['objectId'] = $value  -> objectId;
							$result['relation']['followingJammer'. $key]['thumbnail'] = $value  -> thumbnail != $boxes['NODATA'] ? $value  -> thumbnail : $boxes['DEFTHUMB'];
							$result['relation']['followingJammer'. $key]['type'] = $value  -> type;
							$result['relation']['followingJammer'. $key]['username'] = $value  -> username;
							$followingJammerCounter++;
						}
						if($key < 2){
							$result['activity']['relation']['following'. $key]['objectId'] = $value  -> objectId;
							$result['activity']['relation']['following'. $key]['thumbnail'] = $value  -> thumbnail != $boxes['NODATA'] ? $value  -> thumbnail : $boxes['DEFTHUMB'];
							$result['activity']['relation']['following'. $key]['type'] = $value  -> type;
							$result['activity']['relation']['following'. $key]['username'] = $value  -> username;							
						}
				}
				
				
				$result['relation']['followingVenue']['followingVenueCounter'] = $followingVenueCounter;
				$result['relation']['followingJammer']['followingJammerCounter'] = $followingJammerCounter;
			}
			if ($relationsBox -> relationArray ['friendship'] != $boxes['ND']) {
				$result['relation']['friendship']['friendshipCounter'] = count($relationsBox -> relationArray ['friendship']);
				foreach ($relationsBox->relationArray['friendship'] as $key => $value) {
					$result['relation']['friendship'. $key]['objectId'] = $value  -> objectId;
					$result['relation']['friendship'. $key]['thumbnail'] = $value  -> thumbnail != $boxes['NODATA'] ? $value  -> thumbnail : $boxes['DEFTHUMB'];
					$result['relation']['friendship'. $key]['type'] = $value  -> type;
					$result['relation']['friendship'. $key]['username'] = $value  -> username;
					
					if($key < 2){
						$result['activity']['relation']['friendship'.$key] = $result['relation']['friendship'. $key];
					}				
				}
				
			}
			if ($relationsBox -> relationArray ['venuesCollaborators'] != $boxes['ND']) {
				$result['relation']['venuesCollaborators']['venuesCollaboratorsCounter'] = count($relationsBox -> relationArray ['venuesCollaborators']);
				foreach ($relationsBox->relationArray['venuesCollaborators'] as $key => $value) {
					$result['relation']['venuesCollaborators'. $key]['objectId'] = $value  -> objectId;
					$result['relation']['venuesCollaborators'. $key]['thumbnail'] = $value  -> thumbnail != $boxes['NODATA'] ? $value  -> thumbnail : $boxes['DEFTHUMB'];
					$result['relation']['venuesCollaborators'. $key]['type'] = $value  -> type;
					$result['relation']['venuesCollaborators'. $key]['username'] = $value  -> username;
					
					if($key < 2){
						$result['activity']['relation']['venuesCollaborators'.$key] = $result['relation']['venuesCollaborators'. $key];
					}
				}
				
			}
			if ($relationsBox -> relationArray ['jammersCollaborators'] != $boxes['ND']) {
				$result['relation']['jammersCollaborators']['jammersCollaboratorsCounter'] = count($relationsBox -> relationArray ['jammersCollaborators']);
				foreach ($relationsBox->relationArray['jammersCollaborators'] as $key => $value) {
					$result['relation']['jammersCollaborators'. $key]['objectId'] = $value  -> objectId;
					$result['relation']['jammersCollaborators'. $key]['thumbnail'] = $value  -> thumbnail != $boxes['NODATA'] ? $value  -> thumbnail : $boxes['DEFTHUMB'];
					$result['relation']['jammersCollaborators'. $key]['type'] = $value  -> type;
					$result['relation']['jammersCollaborators'. $key]['username'] = $value  -> username;
					
					if($key < 2){
						$result['activity']['relation']['jammersCollaborators'.$key] = $result['relation']['jammersCollaborators' . $key];
					}
				}
				
			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		}catch (Exception $e) {
		   $result['error']['code'] = 101;
				$result['error']['message'] = 'Error Relation';
		}
		$result = json_encode($result);
		break;
	case 'review' :
		require_once BOXES_DIR . 'review.box.php';
		$reviewBox = new ReviewBox();
		try{
		if ($type != 'VENUE') {
			$reviewRecordBox = $reviewBox -> initForPersonalPage($objectId, $type, 'Record');
			if (!($reviewRecordBox instanceof Error)) {
				$result['recordReviewCounter'] = $reviewRecordBox -> reviewCounter;

				foreach ($reviewRecordBox->reviewArray as $key => $value) {
					$result['recordReview' . $key]['counters'] = $value -> counters;
					$result['recordReview' . $key]['objectId'] = $value -> objectId;
					$result['recordReview' . $key]['rating'] = $value -> rating;
					$result['recordReview' . $key]['text'] = $value -> text != $boxes['NODATA'] ? $value -> text : '';
					$result['recordReview' . $key]['title'] = $value -> title != $boxes['NODATA'] ? $value -> title : '';
					$result['recordReview' . $key]['thumbnailCover'] = $value -> thumbnailCover != $boxes['NODATA'] ? $value -> thumbnailCover : $boxes['DEFRECORDTHUMB'];
					$result['recordReview' . $key]['user_objectId'] = $value -> fromUserInfo -> objectId != $boxes['NODATA'] ? $value -> fromUserInfo -> objectId : '';
					$result['recordReview' . $key]['user_type'] = $value -> fromUserInfo -> type != $boxes['NODATA'] ? $value -> fromUserInfo -> type : '';
					$result['recordReview' . $key]['user_thumbnail'] = $value -> fromUserInfo -> thumbnail != $boxes['NODATA'] ? $value -> fromUserInfo -> thumbnail : $boxes['DEFTHUMB'];
					$result['recordReview' . $key]['user_username'] = $value -> fromUserInfo -> username != $boxes['NODATA'] ? $value -> fromUserInfo -> username : '';
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
				$result['eventReview' . $key]['text'] = $value -> text != $boxes['NODATA'] ? $value -> text : '';
				$result['eventReview' . $key]['title'] = $value -> title != $boxes['NODATA'] ? $value -> title : '';
				$result['eventReview' . $key]['thumbnailCover'] = $value -> thumbnailCover != $boxes['NODATA'] ? $value -> thumbnailCover : $boxes['DEFEVENTTHUMB'];
				$result['eventReview' . $key]['user_type'] = $value -> fromUserInfo -> type != $boxes['NODATA'] ? $value -> fromUserInfo -> type : '';
				$result['eventReview' . $key]['user_thumbnail'] = $value -> fromUserInfo -> thumbnail != $boxes['NODATA'] ? $value -> fromUserInfo -> thumbnail : $boxes['DEFTHUMB'];
			}
		} else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		}catch (Exception $e) {
		   $result['error']['code'] = 101;
				$result['error']['message'] = 'Error Review';
		}
		$result = json_encode($result);
		break;
	case 'header' :
		require_once BOXES_DIR . 'playlist.box.php';
		$playListBoxP = new PlaylistBox();
		try{		$playListBox = $playListBoxP->init($objectIdCurrentUser);
		if (!($playListBox instanceof Error)) {
			$result['playlist']['name'] = $playListBox->name != $boxes['NODATA'] ? $playListBox->name : '';
			$result['playlist']['tracklist'] = array();
			foreach ($playListBox->tracklist as $key => $value) {
				$track['author']['objectId'] = 	$value -> author->objectId != $boxes['NODATA'] ? $value -> author->objectId : '';
				$track['author']['thumbnail'] = 	$value -> author->thumbnail != $boxes['NODATA'] ? $value -> author->thumbnail : $boxes['DEFTHUMB'];
				$track['author']['type'] = 	$value -> author->type != $boxes['NODATA'] ? $value -> author->type : '';
				$track['author']['username'] = 	$value -> author->username != $boxes['NODATA'] ? $value -> author->username : '';
				$track['thumbnail'] = 	$value -> thumbnail != $boxes['NODATA'] ? $value -> thumbnail : $boxes['DEFRECORDTHUMB'];
				$track['title'] = $value -> title != $boxes['NODATA'] ? $value -> title : '';
				array_push($result['playlist']['tracklist'], $track);
			}
		}else {
			$result['error']['code'] = 101;
			$result['error']['message'] = 'object not found for get';
		}
		}catch (Exception $e) {
		   $result['error']['code'] = 101;
				$result['error']['message'] = 'Error Header';
		}
		$result = json_encode($result);
		break;
	default :
		$result = json_encode($result);
		break;
}

echo $result;


?>