<?php

/* ! \par Info Generali:
 *  \author    Luca Gianneschi
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par       Info:
 *  \brief     Print out activities list 
 *  \warning
 *  \bug
 *  \todo
 *
 *  
 *  
 */

$activities = array(
    array(
        'type' => 'LOGGEDIN',
        'action' => 'Utente effettua Login',
        'file' => array('access.controller.php')
    ),
    array(
        'type' => 'LOGGEDOUT',
        'action' => 'Utente effettua Logout',
        'file' => array('access.controller.php')
    ),
    array(
        'type' => 'SOCIALLOGGEDIN',
        'action' => 'Utente effettua Login con Social Network',
        'file' => array('access.controller.php')
    ),
    array(
        'type' => 'COMMENTEDONALBUM',
        'action' => 'Commento su istanza classe Album',
        'file' => array('comment.controller.php')
    ),
    array(
        'type' => 'COMMENTEDONCOMMENT',
        'action' => 'Commento su istanza classe Comment (Commento,Post o Review)',
        'file' => array('comment.controller.php')
    ),
    array(
        'type' => 'COMMENTEDONEVENT',
        'action' => 'Commento su istanza classe Event',
        'file' => array('comment.controller.php')
    ),
    array(
        'type' => 'COMMENTEDONIMAGE',
        'action' => 'Commento su istanza classe Image',
        'file' => array('comment.controller.php')
    ),
    array(
        'type' => 'COMMENTEDONSTATUS',
        'action' => 'Commento su istanza classe Status',
        'file' => array('comment.controller.php')
    ),
    array(
        'type' => 'COMMENTEDONRECORD',
        'action' => 'Commento su istanza classe Record',
        'file' => array('comment.controller.php')
    ),
    array(
        'type' => 'COMMENTEDONVIDEO',
        'action' => 'Commento su istanza classe Video',
        'file' => array('comment.controller.php')
    ),
    array(
        'type' => 'DELETEDACTIVITY',
        'action' => 'Cancellata istanza classe Activity',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDALBUM',
        'action' => 'Cancellata istanza classe Album',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDCOMMENT',
        'action' => 'Cancellata istanza classe (Commento,Post o Review)',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDEVENT',
        'action' => 'Cancellata istanza classe Event',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDIMAGE',
        'action' => 'Cancellata istanza classe Image',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDPLAYLIST',
        'action' => 'Cancellata istanza classe Playlist',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDRECORD',
        'action' => 'Cancellata istanza classe Record',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDSONG',
        'action' => 'Cancellata istanza classe Song',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDSTATUS',
        'action' => 'Cancellata istanza classe Status',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDUSER',
        'action' => 'Cancellata istanza classe User',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'DELETEDVIDEO',
        'action' => 'Cancellata istanza classe Video',
        'file' => array('delete.controller.php')
    ),
    array(
        'type' => 'LOVEDALBUM',
        'action' => 'Azione love su istanza classe Album',
        'file' => array('love.controller.php')
    ),
    array(
        'type' => 'LOVEDCOMMENT',
        'action' => 'Azione love su istanza classe Comment(Commento,Post o Review)',
        'file' => array('love.controller.php')
    ),
    array(
        'type' => 'LOVEDEVENT',
        'action' => 'Azione love su istanza classe Event',
        'file' => array('love.controller.php')
    ),
    array(
        'type' => 'LOVEDIMAGE',
        'action' => 'Azione love su istanza classe Image',
        'file' => array('love.controller.php')
    ),
    array(
        'type' => 'LOVEDRECORD',
        'action' => 'Azione love su istanza classe Record',
        'file' => array('love.controller.php')
    ),
    array(
        'type' => 'LOVEDSONG',
        'action' => 'Azione love su istanza classe Song',
        'file' => array('love.controller.php')
    ),
    array(
        'type' => 'LOVEDSTATUS',
        'action' => 'Azione love su istanza classe Status',
        'file' => array('love.controller.php')
    ),
    array(
        'type' => 'LOVEDVIDEO',
        'action' => 'Azione love su istanza classe Video',
        'file' => array('love.controller.php')
    ),
    array(
        'type' => 'MESSAGESENT',
        'action' => 'Invio messaggio privato',
        'file' => array('message.controller.php , notification.box.php')
    ),
    array(
        'type' => 'SONGADDEDTOPLAYLIST',
        'action' => 'Aggiunta istanza Song ad istanza classe playlist',
        'file' => array('playlist.controller.php')
    ),
    array(
        'type' => 'SONGADDEDTOPLAYLIST',
        'action' => 'Aggiunta istanza Song ad istanza classe playlist',
        'file' => array('playlist.controller.php')
    ),
    array(
        'type' => 'SONGREMOVEDFROMPLAYLIST',
        'action' => 'Rimossa istanza Song ad istanza classe playlist',
        'file' => array('playlist.controller.php')
    ),
    array(
        'type' => 'POSTED',
        'action' => 'Utente effettua post, istanzia classe Comment con type P',
        'file' => array('post.controller.php')
    ),
    array(
        'type' => 'FRIENDSHIPREQUEST',
        'action' => 'Richiesta relazione SPOTTER/SPOTTER',
        'file' => array('relation.controller.php' , 'relation.box.php', 'notification.box.php')
    ),
    array(
        'type' => 'COLLABORATIONREQUEST',
        'action' => 'Richiesta relazione VENUE/JAMMER o VENUE/VENUE o JAMMER/JAMMER',
        'file' => array('relation.controller.php' , 'notification.box.php')
    ),
    array(
        'type' => 'NEWEVENTREVIEW',
        'action' => 'Nuova review su istanza classe Event',
        'file' => array('review.controller.php')
    ),
    array(
        'type' => 'NEWRECORDREVIEW',
        'action' => 'Nuova review su istanza classe Record',
        'file' => array('review.controller.php')
    ),
    array(
        'type' => 'SIGNEDUP',
        'action' => 'Registrazione nuovo utente',
        'file' => array('signup.controller.php')
    ),
    array(
        'type' => 'SOCIALACCOUNTLINKED',
        'action' => 'Link account standard & social',
        'file' => array('userUtilities.controller.php')
    ),
    array(
        'type' => 'SOCIALACCOUNTUNLINKED',
        'action' => 'UnLink account standard & social',
        'file' => array('userUtilities.controller.php')
    ),
    array(
        'type' => 'PASSWORDRESETREQUEST',
        'action' => 'Richiesta reset password',
        'file' => array('userUtilities.controller.php')
    ),
    array(
        'type' => 'USERSETTINGSUPDATED',
        'action' => 'Update setting istanza User',
        'file' => array('userUtilities.controller.php')
    ),
    array(
        'type' => 'SONGLISTENED',
        'action' => 'Utente ha premuto play per ascoltare song',
        'file' => array('activity.box.php')
    ),
    array(
        'type' => 'EVENTCONFIRMED',
        'action' => 'Utente ha confermato presenza ad un evento',
        'file' => array('activity.box.php')
    ),
    array(
        'type' => 'FOLLOWING',
        'action' => 'Utente segue altro utente',
        'file' => array('relation.box.php' , 'notification.box.php')
    ),
    array(
        'type' => 'INVITED',
        'action' => 'Utente viene invitato ad event',
        'file' => array('notification.box.php')
    ) 
);
echo "<h2> Elenco Activities</h2>";
echo "<pre>";
print_r($activities);
echo "</pre>";
?>