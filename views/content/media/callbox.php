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

$typebox			= $_POST['typebox'];
$classMedia 		= $_POST['classMedia'];
$objectIdMedia  	= $_POST['objectIdMedia'];
$limit 				= $_POST['limit'];
$skip 				= $_POST['skip'];
$typeListUserEvent	= $_POST['typeListUserEvent'];
$print				= $_POST['print'];

$result = array();

$result['error']['code'] = 0;

switch ($typebox) {
	case 'classinfo' :
		try{
			
			if($classMedia == 'event'){
					
				require_once BOXES_DIR . 'event.box.php';	
				
				$eventBoxC = new EventBox();
				
				$eventBox = $eventBoxC->initForMediaPage($objectIdMedia);
				
				if (!($eventBox instanceof Error)) {				
					$result['classinfo']['config'] =  $eventBox->config;
					$result['classinfo']['fromUserInfo'] =  $eventBox->fromUserInfo;					
					$result['classinfo']['address'] =  $eventBox->eventInfoArray->address == $boxes['NODATA'] ? '' : $eventBox->eventInfoArray->address;
					$result['classinfo']['attendee'] =  $eventBox->eventInfoArray->attendee;
					$result['classinfo']['attendeeCounter'] =  $eventBox->eventInfoArray->attendeeCounter;
					$result['classinfo']['city'] =  $eventBox->eventInfoArray->city == $boxes['NODATA'] ? '' : $eventBox->eventInfoArray->city;
					$result['classinfo']['counters'] =  $eventBox->eventInfoArray->counters;
					$result['classinfo']['description'] =  $eventBox->eventInfoArray->description == $boxes['NODATA'] ? '' : $eventBox->eventInfoArray->description;
					$result['classinfo']['eventDate'] =  $eventBox->eventInfoArray->eventDate == $boxes['NODATA'] ? '' : $eventBox->eventInfoArray->eventDate;
					$result['classinfo']['featuring'] =  $eventBox->eventInfoArray->featuring;
					$result['classinfo']['featuringCounter'] =  $eventBox->eventInfoArray->featuringCounter;
					$result['classinfo']['image'] =  $eventBox->eventInfoArray->image == $boxes['DEFEVENTIMAGE'] ? '' : $eventBox->eventInfoArray->image;
					$result['classinfo']['invited'] =  $eventBox->eventInfoArray->invited;
					$result['classinfo']['invitedCounter'] =  $eventBox->eventInfoArray->invitedCounter;
					$result['classinfo']['location'] =  $eventBox->eventInfoArray->location == $boxes['NODATA'] ? '' : $eventBox->eventInfoArray->location;
					$result['classinfo']['locationName'] =  $eventBox->eventInfoArray->locationName == $boxes['NODATA'] ? '' : $eventBox->eventInfoArray->locationName;
					$result['classinfo']['tags'] =  $eventBox->eventInfoArray->tags;									
					$result['classinfo']['title'] =  $eventBox->eventInfoArray->title == $boxes['NODATA'] ? '' : $eventBox->eventInfoArray->title;							
				}
				else{
					$result['error']['code'] = 101;
		   			$result['error']['message'] = 'Error event $objectIdMedia: object not found for get';
				}
			
			}
			if($classMedia == 'record'){
					
				require_once BOXES_DIR . 'record.box.php';	
				
				$recordBoxC = new RecordBox();
				
				$recordBox = $recordBoxC->initForMediaPage($objectIdMedia);
				
				if (!($recordBox instanceof Error)) {				
					$result['classinfo']['config'] =  $recordBox->config;
					$result['classinfo']['fromUserInfo'] =  $recordBox->fromUserInfo;					
					$result['classinfo']['buylink'] =  $recordBox->recordInfoArray->buylink == $boxes['NODATA'] ? '' : $recordBox->recordInfoArray->buylink;				
					$result['classinfo']['city'] =  $recordBox->recordInfoArray->city == $boxes['NODATA'] ? '' : $recordBox->recordInfoArray->city;
					$result['classinfo']['counters'] =  $recordBox->recordInfoArray->counters;
					$result['classinfo']['cover'] =  $recordBox->recordInfoArray->cover;
					$result['classinfo']['description'] =  $recordBox->recordInfoArray->description == $boxes['NODATA'] ? '' : $recordBox->recordInfoArray->description;
					$result['classinfo']['featuring'] =  $recordBox->recordInfoArray->featuring;
					$result['classinfo']['genre'] =  $recordBox->recordInfoArray->genre == $boxes['NODATA'] ? '' : $recordBox->recordInfoArray->genre;
					$result['classinfo']['label'] =  $recordBox->recordInfoArray->label == $boxes['NODATA'] ? '' : $recordBox->recordInfoArray->label;
					$result['classinfo']['locationName'] =  $recordBox->recordInfoArray->locationName == $boxes['NODATA'] ? '' : $recordBox->recordInfoArray->locationName;
					$result['classinfo']['tracklist'] =  $recordBox->recordInfoArray->tracklist;
					$result['classinfo']['title'] =  $recordBox->recordInfoArray->title == $boxes['NODATA'] ? '' : $recordBox->recordInfoArray->title;
					$result['classinfo']['year'] =  $recordBox->recordInfoArray->year == $boxes['NODATA'] ? '' : $recordBox->recordInfoArray->year;				
				}
				else{
					$result['error']['code'] = 101;
		   			$result['error']['message'] = 'Error record $objectIdMedia: object not found for get';
				}
			}
			
		}catch (Exception $e) {
		   	
		   $result['error']['code'] = 101;
		   $result['error']['message'] = 'Error classinfo';
		  
		}
		
		break;

	
	case 'comment' :
		require_once BOXES_DIR . 'comment.box.php';
		$commentBoxP = new CommentBox();		
		try  {
			$commentBox = $commentBoxP -> init('Comment', $objectIdMedia, $limit, $skip);					
			if (!($commentBox instanceof Error)) {
				$result['comment']['commentCounter'] = count($commentBox->commentInfoArray);
				foreach ($commentBox->commentInfoArray as $key => $value) {					
					$result['comment']['commentInfoArray'][$key]['user_objectId'] = $value -> fromUserInfo -> objectId;
					$result['comment']['commentInfoArray'][$key]['user_thumbnail'] = $value -> fromUserInfo -> thumbnail != $boxes['NODATA'] ? $value -> fromUserInfo -> thumbnail : $default_img['DEFTHUMB'];
					$result['comment']['commentInfoArray'][$key]['user_type'] = $value -> fromUserInfo -> type != $boxes['NODATA'] ? $value -> fromUserInfo -> type : '';
					$result['comment']['commentInfoArray'][$key]['user_username'] = $value -> fromUserInfo -> username != $boxes['NODATA'] ? $value -> fromUserInfo -> username : '';
					$result['comment']['commentInfoArray'][$key]['createdAt'] = $value -> createdAt;
					$result['comment']['commentInfoArray'][$key]['text'] = $value -> text;					
				}
				
			} else {
				$result['error']['code'] = 101;
				$result['error']['message'] = 'Error comment for $objectIdMedia: object not found for get';				
			}
		}catch (Exception $e) {
		   $result['comment'] = '';
		   $result['error']['message'] = 'Error Comment';
		}
		
		break;
		
	case 'relation' :
		require_once BOXES_DIR . 'event.box.php';
		
		$eventBoxC = new EventBox();
				
		$result['relation'] = $eventBoxC->getRelatedUsers($objectIdMedia, $typeListUserEvent, true, 'Media');				
		
	break;
	case 'review' :
		require_once BOXES_DIR . 'review.box.php';
		
		$reviewBox = new ReviewBox();
		
		try{
			
			if($classMedia == 'event') $review = $reviewBox->initForMediaPage($objectIdMedia,'Event', $limit, $skip);
			if($classMedia == 'record') $review = $reviewBox->initForMediaPage($objectIdMedia,'Record', $limit, $skip);
			
			if (!($review instanceof Error)) {
				
				$result['review']['config'] = $review->config;
				foreach ($review->reviewArray as $key => $value) {
					$result['review']['reviewArray'][$key]['counters'] = $value->counters;
					$result['review']['reviewArray'][$key]['fromUserInfo'] = $value->fromUserInfo;
					$result['review']['reviewArray'][$key]['objectId'] = $value->objectId;
					$result['review']['reviewArray'][$key]['rating'] = $value->rating;
					$result['review']['reviewArray'][$key]['text'] = $value->text = $boxes['NODATA'] ? '' : $value->text;
					$result['review']['reviewArray'][$key]['title'] = $value->title = $boxes['NODATA'] ? '' : $value->title;
					$result['review']['reviewArray'][$key]['thumbnailCover'] = $value->thumbnailCover;
				}
				
				
			} else {
				$result['error']['code'] = 101;
				$result['error']['message'] = 'Error review for $objectIdMedia: object not found for get';
			}
		

		}catch (Exception $e) {
		   $result['error']['code'] = 101;
		   $result['error']['message'] = 'Error Review';
		}
		
		break;
	
	default :
		
		break;
}

if($print == 'true'){
	print "<pre>";
	print_r($result);
	print "</pre>";
}
else echo json_encode($result);


?>