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
        'controller' => 'access.controller.php'
    ),
    array(
        'type' => 'LOGGEDOUT',
        'action' => 'Utente effettua Logout',
        'controller' => 'access.controller.php'
    ),
    array(
        'type' => 'SOCIALLOGGEDIN',
        'action' => 'Utente effettua Login con Social Network',
        'controller' => 'access.controller.php'
    ),
    array(
        'type' => 'COMMENTEDONALBUM',
        'action' => 'Commento su istanza classe Album',
        'controller' => 'comment.controller.php'
    ),
    array(
        'type' => 'COMMENTEDONCOMMENT',
        'action' => 'Commento su istanza classe Comment (Commento,Post o Review)',
        'controller' => 'comment.controller.php'
    ),
    array(
        'type' => 'COMMENTEDONEVENT',
        'action' => 'Commento su istanza classe Event',
        'controller' => 'comment.controller.php'
    ),
    array(
        'type' => 'COMMENTEDONIMAGE',
        'action' => 'Commento su istanza classe Image',
        'controller' => 'comment.controller.php'
    ),
    array(
        'type' => 'COMMENTEDONSTATUS',
        'action' => 'Commento su istanza classe Status',
        'controller' => 'comment.controller.php'
    ),
    array(
        'type' => 'COMMENTEDONRECORD',
        'action' => 'Commento su istanza classe Record',
        'controller' => 'comment.controller.php'
    ),
    array(
        'type' => 'COMMENTEDONVIDEO',
        'action' => 'Commento su istanza classe Video',
        'controller' => 'comment.controller.php'
    ),
    array(
        'type' => 'DELETEDACTIVITY',
        'action' => 'Cancellata istanza classe Activity',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDALBUM',
        'action' => 'Cancellata istanza classe Album',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDCOMMENT',
        'action' => 'Cancellata istanza classe (Commento,Post o Review)',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDEVENT',
        'action' => 'Cancellata istanza classe Event',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDIMAGE',
        'action' => 'Cancellata istanza classe Image',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDPLAYLIST',
        'action' => 'Cancellata istanza classe Playlist',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDRECORD',
        'action' => 'Cancellata istanza classe Record',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDSONG',
        'action' => 'Cancellata istanza classe Song',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDSTATUS',
        'action' => 'Cancellata istanza classe Status',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDUSER',
        'action' => 'Cancellata istanza classe User',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'DELETEDVIDEO',
        'action' => 'Cancellata istanza classe Video',
        'controller' => 'delete.controller.php'
    ),
    array(
        'type' => 'LOVEDALBUM',
        'action' => 'Azione love su istanza classe Album',
        'controller' => 'love.controller.php'
    ),
    array(
        'type' => 'LOVEDCOMMENT',
        'action' => 'Azione love su istanza classe Comment(Commento,Post o Review)',
        'controller' => 'love.controller.php'
    ),
    array(
        'type' => 'LOVEDEVENT',
        'action' => 'Azione love su istanza classe Event',
        'controller' => 'love.controller.php'
    ),
    array(
        'type' => 'LOVEDIMAGE',
        'action' => 'Azione love su istanza classe Image',
        'controller' => 'love.controller.php'
    ),
    array(
        'type' => 'LOVEDRECORD',
        'action' => 'Azione love su istanza classe Record',
        'controller' => 'love.controller.php'
    ),
    array(
        'type' => 'LOVEDSONG',
        'action' => 'Azione love su istanza classe Song',
        'controller' => 'love.controller.php'
    ),
    array(
        'type' => 'LOVEDSTATUS',
        'action' => 'Azione love su istanza classe Status',
        'controller' => 'love.controller.php'
    ),
    array(
        'type' => 'LOVEDVIDEO',
        'action' => 'Azione love su istanza classe Video',
        'controller' => 'love.controller.php'
    ),
    array(
        'type' => 'MESSAGESENT',
        'action' => 'Invio messaggio privato',
        'controller' => 'message.controller.php'
    ),
    array(
        'type' => 'SONGADDEDTOPLAYLIST',
        'action' => 'Aggiunta istanza Song ad istanza classe playlist',
        'controller' => 'playlist.controller.php'
    ),
    array(
        'type' => 'SONGADDEDTOPLAYLIST',
        'action' => 'Aggiunta istanza Song ad istanza classe playlist',
        'controller' => 'playlist.controller.php'
    ),
    array(
        'type' => 'SONGREMOVEDFROMPLAYLIST',
        'action' => 'Rimossa istanza Song ad istanza classe playlist',
        'controller' => 'playlist.controller.php'
    ),
    array(
        'type' => 'POSTED',
        'action' => 'Utente effettua post, istanzia classe Comment con type P',
        'controller' => 'post.controller.php'
    ),
    array(
        'type' => 'FRIENDSHIPREQUEST',
        'action' => 'Richiesta relazione SPOTTER/SPOTTER',
        'controller' => 'relation.controller.php'
    ),
    array(
        'type' => 'COLLABORATIONREQUEST',
        'action' => 'Richiesta relazione VENUE/JAMMER o VENUE/VENUE o JAMMER/JAMMER',
        'controller' => 'relation.controller.php'
    ),
    array(
        'type' => 'NEWEVENTREVIEW',
        'action' => 'Nuova review su istanza classe Event',
        'controller' => 'review.controller.php'
    ),
    array(
        'type' => 'NEWRECORDREVIEW',
        'action' => 'Nuova review su istanza classe Record',
        'controller' => 'review.controller.php'
    ),
    array(
        'type' => 'SIGNEDUP',
        'action' => 'Registrazione nuovo utente',
        'controller' => 'signup.controller.php'
    ),
    array(
        'type' => 'SOCIALACCOUNTLINKED',
        'action' => 'Link account standard & social',
        'controller' => 'userUtilities.controller.php'
    ),
    array(
        'type' => 'SOCIALACCOUNTUNLINKED',
        'action' => 'UnLink account standard & social',
        'controller' => 'userUtilities.controller.php'
    ),
    array(
        'type' => 'PASSWORDRESETREQUEST',
        'action' => 'Richiesta reset password',
        'controller' => 'userUtilities.controller.php'
    ),
    array(
        'type' => 'USERSETTINGSUPDATED',
        'action' => 'Update setting istanza User',
        'controller' => 'userUtilities.controller.php'
    )
);
echo "<h2> Elenco Activities</h2>";
echo "<pre>";
print_r($activities);
echo "</pre>";
?>