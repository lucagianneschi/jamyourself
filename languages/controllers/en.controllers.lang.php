<?php

/* ! \par Info Generali:
 *  \author    Luca Gianneschi
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par       Info:
 *  \brief     English strings for controllers
 *  \warning
 *  \bug
 *  \todo 
 */

$controllers = array(
    //GENERAL
    'INVALIDEMAIL' => 'Invalid e-Mail',
    'NOTOUSER' => 'No toUser specified',
    'NOTOUSERTYPE' => 'No toUser type specified',
    'NOFROMUSER' => 'No fromUser specified',
    'NOCLASSTYPE' => 'No classType specified',
    'NOOBJECTID' => 'No id specified',
    'ROLLKO' => 'ROLLBACK KO',
    'ROLLOK' => 'ROLLBACK OK',
    'NOUSERID' => 'User ID non definito',
    'CLASSTYPEKO' => 'ClassType non accettato',
    'NOPOSTREQUEST' => 'Your Request is not a POST Request',
    'USERNOSES' => 'No User in session',
    'USERNOTFOUND' => 'User not found',
    'NOSESSIONTOKEN' => 'SessionToken undefined',
    'NOMAIL' => 'Unable to send mail',
    'nodata' => 'No data available',
    'NOEXPIRED' => 'Expired unset',
    'NODEERROR' => 'Unable to create node',
    //SUBSCRIBE
    'SUBSCRIPTIONOK' => 'You have been subscribed',
    'SUBSCRIPTIONERROR' => 'An error occurred',
    //SIGNUP
    'NOCAPTCHAVALIDATION' => 'No Captcha or invalid Captcha',
    'INVALIDNEWUSER' => 'Invalid user',
    'NEWUSERCREATIONFAILED' => 'Save failed',
    'USERCREATED' => 'User created with success',
    'WRONGRECAPTCHA' => 'Invalid captcha code',
    'NOCAPTCHA' => 'Captcha not present',
    'CORRECTCAPTCHA' => 'Captcha is correct',
    'NOMAILSPECIFIED' => 'No email specified',
    'MAILALREADYEXISTS' => 'Invalid email',
    'VALIDMAIL' => 'Email is valid',
    'VALIDUSERNAME' => 'Username is valid',
    'USERNAMEALREADYEXISTS' => 'Invalid username',
    'NOUSERNAMESPECIFIED' => 'No username specified',
    //POST
    'POSTSAVED' => 'Your post has been saved',
    'SHORTPOST' => 'Your post is too short | lenght:',
    'LONGPOST' => 'Your post is too long | lenght:',
    'NOPOST' => 'No post specified',
    //COMMENT
    'NOCOMMENT' => 'No comment specified',
    'SHORTCOMMENT' => 'Your comment is too short | lenght:',
    'LONGCOMMENT' => 'Your comment is too long | lenght:',
    'COMMENTSAVED' => 'Your comment has been saved',
    'COMMENTERR' => 'Unable to save comment',
    'SBJCOMMENT' => 'Your content received a comment',
    //DELETE
    'NOVIDEOFORDELETE' => 'Video not found for delete',
    'NOSTATUSFORDELETE' => 'Status not found for delete',
    'NOSONGFORDELETE' => 'Song not found for delete',
    'NORECORDFORDELETE' => 'Record not found for delete',
    'NOPLAYLISTFORDELETE' => 'Playlist not found for delete',
    'NOPLAYLISTFORDELETE' => 'Image not found for delete',
    'NOEVENTFORDELETE' => 'Event not found for delete',
    'NOCOMMENTFORDELETE' => 'Comment or Review not found for delete',
    'NOALBUMFORDELETE' => 'Album not found for delete',
    'NOACTIVITYFORDELETE' => 'Activity not found for delete',
    'DELETEOK' => 'Delete action completed',
    'CND' => 'Cannot delete this element: you are not its owner!',
    'SBJ' => 'Account delation confirmed',
    'DELERR' => 'Error deleting this element',
    'NOCITY' => 'Location not specified',
    'CITYEXISTS' => 'Valid location ',
    'CITYNOEXISTS' => 'Invalid  location',
    //MESSAGE
    'NOMESSAGE' => 'No message specified',
    'SHORTMESSAGE' => 'Your message is too short | lenght:',
    'MESSAGESAVED' => 'Your message has been sent',
    'MESSAGEREAD' => 'Message correctly read',
    'MESSAGEDELETE' => 'Message correctly delete',
    'NOACTFORREADMESS' => 'No activity found for read message',
    'NOREAD' => 'Unable to read correctly this message',
    'NOSAVEMESS' => 'Unable to save and send this message',
    'SHORTTITLEMESSAGE' => 'Message title too short',
    'NOMESSAGETITLE' => 'Message title unset',
    'NOSPAM' => 'You are not authorized to send this message this reciepient',
    'ALREADYREAD' => 'Message already marked as read',
    'SBJMESSAGE' => 'You have a new message',
    'NO_DEL' => 'No conversation for deleting',
    'ERROR_MSG' => 'Error Retrieving messages',
    'CONVERSATION_DEL' => 'Conversation Deleted',
    'ERROR_DEL_MSG' => 'Error Deleting messages',
    //LOVE
    'LOVEPLUSERR' => 'Error incrementing Love',
    'LOVEMINUSERR' => 'Error decrementing Love',
    'LOVE' => 'Love OK',
    'UNLOVE' => 'Unlove OK',
    'ALREADYLOVED' => 'You have already loved this object',
    'NOLOVE' => 'There is no love action for this object',
    //REVIEW
    'SBJE' => 'Your Event has been reviewed',
    'SBJR' => 'Your Record has been reviewed',
    'NOREW' => 'No review specified',
    'SHORTREW' => 'Your review is too short | lenght:',
    'LONGREW' => 'Your review is too long | lenght:',
    'REWSAVED' => 'Your review has been saved',
    'NOMAILFORREVIEW' => 'NO email address set to send mail',
    'NOSELFREVIEW' => 'You cannot review your contents',
    'NOSAVEDREVIEW' => 'Unable to save review',
    'NOTITLE' => 'No title set',
    'SHORTREWTITLE' => 'Review title too short',
    'LONGREWTITLE' => 'Review title too long',
    'NORATING' => 'Rating unset',
    //RECORD
    'GETRECORDSOK' => 'Record recuperati correttamente',
    'RECORDSAVED' => 'Record saved',
    'NODESCRIPTION' => 'No description',
    'NOTAGS' => 'No tags',
    'NOSONGID' => 'No songId specified',
    'NOREMOVERELATIONFROMRECORD' => 'Can not remove the song from the record',
    'SONGREMOVEDFROMRECORD' => 'Song deleted',
    'NORECORDID' => 'No recordId specified',
    'NOSONGLIST' => 'No song list specified',
    'NORECORD' => 'No record founded with this recordId',
    'MP3SAVEERROR' => 'Mp3 not saved',
    'NOSONGSAVED' => 'No Mp3 saved',
    'SONGSAVEDWITHERROR' => 'Mp3s saved with errors',
    'ALLSONGSSAVED' => 'Mp3s saved with success',
    'COUNTSONGOK' => 'Request Accepted',
    'NOSONGFORRECORD' => 'Record have no song',
    'NOCOUNT' => 'Count is not present',
    //RELATION
    'RELDENIED' => 'You are not allowed to send a relationship request to this user!',
    'SELF' => 'Don&apos;t be shy, ask someone else to be your friend or your collaborator!',
    'SBJ' => 'Relation Request',
    'SBJOK' => 'Relation Request Accepted',
    'RELSAVED' => 'Your request has been sent correctly',
    'NORELDEL' => 'No relation to remove',
    'NOACTUPDATE' => 'Unable to update relation activity',
    'NORELACC' => 'Unable to accept relation',
    'RELDECLINED' => 'Relation Request Declined',
    'NOACSAVE' => 'Unable to save activity',
    'RELDELETED' => 'Relation removed',
    'ERROREMOVINGREL' => 'Error removing relationship',
    'RELACCEPTED' => 'Relation accepted',
    'NOFRIENDSHIPUPDATE' => 'Unable to update friendhip relation',
    'NOFRIENDSHIPCOUNTERUPDATE' => 'Unable to update friendhip counter',
    'NOCOLLABORATIONUPDATE' => 'Unable to update collaboration relation',
    'NOCOLLABORATIONCOUNTERUPDATE' => 'Unable to update collaboration counter',
    'NOSPECIFICCOLLABORATIONCOUNTERUPDATE' => 'Unable to update specific (venue or jammer) collaboration counter',
    'ALREADYINREALTION' => 'Users are already in a relationship',
    'NORELFOUNDFORREMOVING' => 'User are not in relation, cannot remove this',
    'RELATIONCHECKERROR' => 'Error checking if a relation exists',
    //LOGIN
    'NOLOGIN' => 'Invalid login credentials',
    'OKLOGIN' => 'You are logged in',
    //LOGOUT
    'NOLOGOUT' => 'Cannot log out',
    'OKLOGOUT' => 'You are logged out',
    //SOCIALLOGIN
    'OKSOCIALLINK' => 'Your Social account has been correctly linked to your Jamyourself account',
    'SOCIALLOGINERR' => 'Unable to login in with this social account',
    'OKLOGINSOCIAL' => 'Login with social account ok',
    'USERNOTFOUND' => 'User not found for linking with your social account',
    'OKSOCIALUNLINK' => 'Your Social account has been correctly unlinked from your Jamyourself account',
    'NOUNLINK' => 'Unable to unlink your account',
    'NOLINK' => 'Unable to link your account',
    'NOSOCIALNETUNSPECIFIED' => 'Social Network is not set',
    'INVALIDSOCIALNET' => 'Invalid Social Network',
    'NOUPDATESHARE' => 'Unable to update shareCounter',
    'OKSHARECOUNTER' => 'ShareCounter Updated',
    //PASSWORDRESET
    'OKPASSWORDRESETREQUEST' => 'Your password reset request has been sent',
    'USERNOTFOUNDFORPASSRESET' => 'User not found for passwordreset',
    'NOEMAILFORRESETPASS' => 'No email set for password reset',
    //SEARCH
    'NOSEARCHTEXT' => 'You must set a text to be searched',
    'SHORTSEARCHTEXT' => 'The text you want to search it too short',
    'SEARCHOK' => 'Search ok',
    //PLAYLIST
    'SONGADDEDTOPLAYLIST' => 'Song correctly added to playlist',
    'SONGREMOVEDFROMPLAYLIST' => 'Song removed from playlist',
    'NOPLAYLIST' => 'Playlist not found for setting your tracklist',
    'NOPLAYLISTID' => 'Playlist ID unset',
    'NOSONGID' => 'Song ID unset',
    'NOADDSONGTOPLAYREL' => 'Unable to add song to playlist (Relation)',
    'NOADDSONGTOPLAYARRAY' => 'Unable to add song to playlist (Array)',
    'NOREMOVESONGTOPLAYREL' => 'Unable to remove song from playlist(Relation)',
    'NOREMOVESONGTOPLAYARRAY' => 'Unable to remove song from playlist(Array)',
    'SONGALREADYINTRACKLIST' => 'This song already exists in your playlist',
    'SONGNOTINTRACKLIST' => 'Song not found for removing from playlist',
    'TOMANYSONGS' => 'To many songs in your playlist',
    'NOTHINGTOREMOVE' => 'No song to remove',
    //SETTINGS
    'NOSETTINGUPDATE' => 'Unable to update your setting',
    'NOSETTING' => 'No setting specified in the request',
    'SETTINGUPDATED' => 'Setting Updated',
    //EVENTMANAGEMENT
    'NORESPONSE' => 'Response to invitation is unset',
    'INVALIDRESPONSE' => 'Response to invitation is invalid',
    'INVITATIONDECLINED' => 'Invitation declined',
    'INVITATIONACCEPTED' => 'Invitation accepted',
    'NOEVENTID' => 'Event ID unset',
    'INVITATIONSENT' => 'Invitation sent',
    'INVITATIONMAILSBJ' => 'You have been invited to an Event',
    'NOTINRELATION' => 'User not in a relationship',
    'NOEVENTFOUND' => 'Event not found for update',
    'NOAVAILABLEFORINVITATION' => 'User invalid for invitation',
    'NOACTIVITYID' => 'ObjectId unset for activity',
    'ACTNOTFOUND' => 'Activity not found for accept invitation',
    'UNABLETOADDATTENDEE' => 'Unable to add attendee',
    'PARTECIPATIONREMOVED' => 'Partecipation cancelled',
    'NOEVENTTITLE' => 'No event title given',
    'NOEVENTDESCRIPTION' => 'No event description given',
    'NOEVENTDATE' => 'No event date given',
    'NOEVENTHOURS' => 'No event hours given',
    'NOEVENTTAGS' => 'No event tag type given',
    'NOEVENTFEATURING' => 'No jammer event given',
    'NOEVENTVENUE' => 'No venue given for this event',
    'NOEVENTADDRESS' => 'No event address given',
    'NOEVENTIMAGE' => 'No event image give',
    'EVENTCREATEERROR' => 'An error occurred during the creation of the new event',
    'NOEVENTTHUMB' => 'No thumbnail given for this event',
    'EVENTCREATED' => 'Event created with success',
    'DIRECTATTENDEE' => 'User attendance direct confirmation',
    'ERRORUPDATINGEVENTATTENDEE' => 'Unable to add directly attendde to current event',
    //PLAYER
    'ACTSONGNOTPLAYED' => 'Unable to save activity for last song played',
    'SONGPLAYED' => 'Activity for last song played saved',
    'ERRORSONGINFO' => 'Unable to retrive record info for save activity for last song played',
    //ALBUM
    'NOALBUMTITLE' => 'No title specified for this album',
    'NOALBUMDESCRIPTION' => 'No description specified for this album',
    'ALBUMSAVED' => 'Album saved with success',
    'NOIMAGEFORALBUM' => 'No images found for this album',
    'COUNTALBUMOK' => 'Ok',
    'GETALBUMSSOK' => 'Album loaded with success',
    'NOALBUMLOCATION' => "No location specified",
    'NOALBUMIMAGES' => 'No image loaded',
    'ALBUMNOTSAVED' => 'Album creation failed',
    'ALBUMSAVENOIMGSAVED' => 'Album saved, but no image saved',
    'ALBUMSAVEDWITHERRORS' => 'Album saved, but some image throw errors',
    'ALBUMSAVED' => 'Album created with success',
    'NOALBUMID' => 'No albumId specified',
    'NOALBUMIMAGES' => 'No image loaded',
    'NOALBUMFOUNDED' => 'Album not found',
    'NOIMAGESAVED' => 'Save failed',
    'IMAGESSAVEDWITHERRORS' => 'Saved with some error',
    'IMAGESSAVED' => 'Images loaded with success'
);

$mail_files = array(
    'USERDELETED' => 'en.userDeletion.html',
    'FRIENDSHIPREQUESTEMAIL' => 'en.friendshipRequest.html',
    'COLLABORATIONREQUESTEMAIL' => 'en.collaborationRequest.html',
    'FOLLOWINGEMAIL' => 'en.following.html',
    'FRIENDSHIPACCEPTEDEMAIL' => 'en.friendshipRequestAccepted.html',
    'COLLABORATIONACCEPTEDEMAIL' => 'en.collaborationRequestAccepted.html',
    'EVENTREVIEWEMAIL' => 'en.eventReviewReceived.html',
    'RECORDREVIEWEMAIL' => 'en.recordReviewReceived.html',
    'EVENTINVITATION' => 'en.eventInvitation.html',
    'COMMENTEMAIL' => 'en.commentEmail.html',
    'MESSAGEEMAIL' => 'en.messageEmail.php'
);
?>