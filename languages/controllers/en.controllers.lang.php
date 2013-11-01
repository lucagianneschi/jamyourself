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
    'NOTOUSER' => 'No toUser specified',
    'NOFROMUSER' => 'No fromUser specified',
    'NOCLASSTYPE' => 'No classType specified',
    'NOOBJECTID' => 'No objectId specified',
    'ROLLKO' => 'ROLLBACK KO',
    'ROLLOK' => 'ROLLBACK OK',
    'NOUSERID' => 'User ID non definito',
    'CLASSTYPEKO' => 'ClassType non accettato',
    'NOPOSTREQUEST' => 'Your Request is not a POST Request',
    'USERNOSES' => 'No User in session',
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
    //MESSAGE
    'NOMESSAGE' => 'No message specified',
    'SHORTMESSAGE' => 'Your message is too short | lenght:',
    'MESSAGESAVED' => 'Your message has been sent',
    'MESSAGEREAD' => 'Message correctly read',
    'NOACTFORREADMESS' => 'No activity found for read message',
    'NOREAD' => 'Unable to read correctly this message',
    'NOSAVEMESS' => 'Unable to save and send this message',
    //LOVE
    'LOVEPLUSERR' => 'Error incrementing Love',
    'LOVEMINUSERR' => 'Error decrementing Love',
    'LOVE' => 'You love a',
    'UNLOVE' => 'You don&apost love anymore a',
    //REVIEW
    'SBJE' => 'Your Event has been reviewed',
    'SBJR' => 'Your Record has been reviewed',
    'NOREW' => 'No review specified',
    'SHORTREW' => 'Your review is too short | lenght:',
    'LONGREW' => 'Your review is too long | lenght:',
    'REWSAVED' => 'Your review has been saved',
    //RELATION
    'RELDENIED' => 'You are not allowed to send a relationship request to this user!',
    'SELF' => 'Don&apos;t be shy, ask someone else to be your friend or your collaborator!',
    'SBJ' => 'Relation Request',
    'SBJOK' => 'Relation Request Accepted',
    'RELSAVED' => 'Your request has been sent correctly',
    'NORELDEL' => 'No relation to remove',
    //LOGIN
    'NOLOGIN' => 'Invalid login credentials',
    'OKLOGIN' => 'You are logged in',
    //LOGOUT
    'NOLOGOUT' => 'Cannot log out',
    'OKLOGOUT' => 'You are logged out',
    //SOCIALLOGIN
    'OKSOCIALLINK' => 'Your Social account has been correctly linked to your Jamyourself account',
    'USERNOTFOUND' => 'User not found for linking with your social account',
    'NOLINK' => 'Unable to link your account',
    'OKSOCIALUNLINK' => 'Your Social account has been correctly unlinked from your Jamyourself account',
    'NOUNLINK' => 'Unable to unlink your account',
    //PASSWORDRESET
    'OKPASSWORDRESETREQUEST' => 'Your password reset request has been sent',
    'USERNOTFOUNDFORPASSRESET' => 'User not found for passwordreset',
    'NOEMAILFORRESETPASS' => 'No email set for password reset',
    //SEARCH
    'NOSEARCHTEXT' => 'You must set a text to be searched',
    'SHORTSEARCHTEXT' => 'The text you want to search it too short',
    //PLAYLIST
    'SONGADDEDTOPLAYLIST' => 'Song correctly added to playlist',
    'SONGREMOVEDFROMPLAYLIST' => 'Song removed from playlist',
    'NOPLAYLIST' => 'Playlist not found for setting your tracklist',
    'NOPLAYLISTID' => 'Playlist ID unset',
    'NOSONGTID' => 'Song ID unset',
    'NOADDSONGTOPLAY' => 'Unable to add song to playlist',
    'NOREMOVESONGTOPLAY' => 'Unable to remove song from playlist',
    //SETTINGS
    'NOSETTINGUPDATE' => 'Unable to update your setting',
    'NOSETTING' => 'No setting specified in the request'
);

$mail_files = array(
    'USERDELETED' => 'en.userDeletion.html',
    'FRIENDSHIPREQUESTEMAIL' => 'en.friendshipRequest.html',
    'COLLABORATIONREQUESTEMAIL' => 'en.collaborationRequest.html',
    'FOLLOWINGEMAIL' => 'en.following.html',
    'FRIENDSHIPACCEPTEDEMAIL' => 'en.friendshipRequestAccepted.html',
    'COLLABORATIONACCEPTEDEMAIL' => 'en.collaborationRequestAccepted.html',
    'EVENTREVIEWEMAIL' => 'en.eventReviewReceived.html',
    'RECORDREVIEWEMAIL' => 'en.recordReviewReceived.html'
);

$rest_strings = array(
    '100' => 'Continue',
    '101' => 'Switching Protocols',
    '200' => 'OK',
    '201' => 'Created',
    '202' => 'Accepted',
    '203' => 'Non-Authoritative Information',
    '204' => 'No Content',
    '205' => 'Reset Content',
    '206' => 'Partial Content',
    '300' => 'Multiple Choices',
    '301' => 'Moved Permanently',
    '302' => 'Found',
    '303' => 'See Other',
    '304' => 'Not Modified',
    '305' => 'Use Proxy',
    '306' => '(Unused)',
    '307' => 'Temporary Redirect',
    '400' => 'Bad Request',
    '401' => 'Unauthorized',
    '402' => 'Payment Required',
    '403' => 'Forbidden',
    '404' => 'Not Found',
    '405' => 'Method Not Allowed',
    '406' => 'Not Acceptable',
    '407' => 'Proxy Authentication Required',
    '408' => 'Request Timeout',
    '409' => 'Conflict',
    '410' => 'Gone',
    '411' => 'Length Required',
    '412' => 'Precondition Failed',
    '413' => 'Request Entity Too Large',
    '414' => 'Request-URI Too Long',
    '415' => 'Unsupported Media Type',
    '416' => 'Requested Range Not Satisfiable',
    '417' => 'Expectation Failed',
    '500' => 'Internal Server Error',
    '501' => 'Not Implemented',
    '502' => 'Bad Gateway',
    '503' => 'Service Unavailable',
    '504' => 'Gateway Timeout',
    '505' => 'HTTP Version Not Supported'
);
?>