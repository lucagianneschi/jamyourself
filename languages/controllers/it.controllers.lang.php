<?php

/* ! \par Info Generali:
 *  \author    Luca Gianneschi
 *  \version   1.0
 *  \date      2013
 *  \copyright Jamyourself.com 2013
 *
 *  \par       Info:
 *  \brief     Italian strings for controllers
 *  \warning
 *  \bug
 *  \todo	traduzioni 
 */

$controllers = array(
    //GENERAL
    'NOTOUSER' => 'toUser non specificato',
    'NOFROMUSER' => 'fromUser  non specificato',
    'NOCLASSTYPE' => 'classType non specificato',
    'NOOBJECTID' => 'objectId non specificato',
    'ROLLKO' => 'ROLLBACK KO',
    'ROLLOK' => 'ROLLBACK OK',
    'NOUSERID' => 'User ID non definito',
    'CLASSTYPEKO' => 'ClassType non accettato',
    'NOPOSTREQUEST' => 'La tua richiesta non è di tipo POST',
    'USERNOSES' => 'Non esiste nessun utente in SESSION',
    'USERNOTFOUND' => 'User non trovato',
    'NOSESSIONTOKEN' => 'SessionToken non definito',
    'NOMAIL' => 'Impossibile inviare mail',
    'NODATA' => 'Nessun dato disponibile',
    'NOEXPIRED' => 'Expired non impostato',
    //POST
    'POSTSAVED' => 'Il tuo post è stato salvato',
    'SHORTPOST' => 'Dimensione post troppo corta | lungh:',
    'LONGPOST' => 'Dimensione post troppo lunga | lungh:',
    'NOPOST' => 'Post non specificato',
    //COMMENT
    'NOCOMMENT' => 'Commento non specificato',
    'SHORTCOMMENT' => 'Dimensione commento troppo corta | lungh:',
    'LONGCOMMENT' => 'Dimensione commment troppo lunga | lungh:',
    'COMMENTSAVED' => 'Il tuo commento è stato salvato',
    'COMMENTERR' => 'Unable to save comment',
    //DELETE
    'NOVIDEOFORDELETE' => 'Video non trovato per cancellazione',
    'NOSTATUSFORDELETE' => 'Status non trovato per cancellazione',
    'NOSONGFORDELETE' => 'Canzone non trovata per cancellazione',
    'NORECORDFORDELETE' => 'Record non trovato per cancellazione',
    'NOPLAYLISTFORDELETE' => 'Playlist non trovata per cancellazione',
    'NOPLAYLISTFORDELETE' => 'Immagine non trovato per cancellazione',
    'NOEVENTFORDELETE' => 'Evento non trovato per cancellazione',
    'NOCOMMENTFORDELETE' => 'Comment or Review not found for delete',
    'NOALBUMFORDELETE' => 'Album non trovato per cancellazione',
    'NOACTIVITYFORDELETE' => 'Activity non trovata per cancellazione',
    'DELETEOK' => 'Operazione di cancellazione effettuata con successo',
    'CND' => 'Impossibile eliminare questo elemento: non sei il proprietario',
    'SBJ' => 'Il tuo account è stato cancellato',
    'DELERR' => 'Errore in fase di cancellazione',
    //MESSAGE
    'NOMESSAGE' => 'Messaggio non specificato',
    'SHORTMESSAGE' => 'Dimensione messaggio troppo corta | lungh:',
    'MESSAGESAVED' => 'Messaggio inviato',
    'MESSAGEREAD' => 'Message correctly read',
    'NOACTFORREADMESS' => 'Nessuna activity trovata per lettura messaggio',
    'NOREAD' => 'Impossibile leggere correttamente questo messaggio',
    'NOSAVEMESS' => 'Impossibile salvere ed inviare il messaggio',
    'NOPLAYLISTID' => 'Playlist ID non impostato',
    'NOSONGTID' => 'Song ID non impostato',
    'NOADDSONGTOPLAY' => 'Impossibile aggiungere canzone alla playlist',
    'NOREMOVESONGTOPLAY' => 'Impossibile rimuovere canzone alla playlist',
    'SHORTTITLEMESSAGE' => 'Titolo del messaggio troppo corto',
    'NOMESSAGETITLE' => 'Titolo del messaggio non impostato',
    //LOVE
    'LOVEPLUSERR' => 'Errore incrementando Love',
    'LOVEMINUSERR' => 'Error decrementando Love',
    'LOVE' => 'Hai fatto love su',
    'UNLOVE' => 'Hai rimosso lova',
    //REVIEW
    'SBJE' => 'Il tuo evento ha ricevuto una recensione',
    'SBJR' => 'Il tuo record ha ricevuto una recensione',
    'NOREW' => 'Nessuna recensione specificata',
    'SHORTREW' => 'Dimensione recensione troppo corta | lungh:',
    'LONGREW' => 'Dimensione recensione troppo lunga | lungh:',
    'REWSAVED' => 'Recensione salvata con successo',
    'NOMAILFORREVIEW' => 'Indirizzo mail non settato per notifica review',
    'NOSELFREVIEW' => 'Non puoi recensire i tuoi contenuti',
    'NOSAVEDREVIEW' => 'Impossibile salvare la review',
    'NOTITLE' => 'Titolo non impostato',
    'SHORTREWTITLE' => 'Titolo review troppo corto',
    'LONGREWTITLE' => 'Titolo review troppo lungo',
    //RELATION
    'RELDENIED' => 'Invio relazione negato',
    'SELF' => 'Non essere timido, invia la richiesta di relazione ad altri!',
    'SBJ' => 'Richiesta di relazione',
    'SBJOK' => 'Richiesta di relazione accettata',
    'RELSAVED' => 'La tua richiesta è stata correttamente inviata',
    'NORELDEL' => 'Nessuna relazione da cancellare',
    'NOACTUPDATE' => 'Impossibile aggiornare activity di relazione',
    'NORELACC' => 'Impossibile accettare relazione',
    'RELDECLINED' => 'Richiesta di relazione declinata',
    'NOACSAVE' => 'Impossibile salvare activity',
    'RELDELETED' => 'Relazione rimossa',
    'ERROREMOVINGREL' => 'Errore in fase di rimozione relazione',
    'RELACCEPTED' => 'Relazione accettata',
    'NOFRIENDSHIPUPDATE' => 'Impossibile aggiornare relazione di amicizia',
    'NOFRIENDSHIPCOUNTERUPDATE' => 'Impossibile aggiornare counter di amicizia',
    'NOCOLLABORATIONUPDATE' => 'Impossibile aggiornare relazione di collaborazione',
    'NOCOLLABORATIONCOUNTERUPDATE' => 'Impossibile aggiornare counter di collaborazione',
    'NOSPECIFICCOLLABORATIONCOUNTERUPDATE' => 'Impossibile aggiornare counter di collaborazione (venue or jammer) counter',
    'ALREADYINREALTION' => 'Utenti già in relazione',
    'NORELFOUNDFORREMOVING' => 'Utenti non in relazione, impossibile rimuovere',
    'RELATIONCHECKERROR' => 'Errore in fase di test di esistenza di una relazione',
    //LOGIN
    'NOLOGIN' => 'Credenziali di accesso non valide',
    'OKLOGIN' => 'Login eseguito',
    //LOGOUT
    'NOLOGOUT' => 'Impossibile effettuare logout',
    'OKLOGOUT' => 'Logout Eseguito',
    //SOCIALLOGIN
    'OKSOCIALLINK' => 'Il tuo account social è stato collegato al tuo account Jamyourself',
    'SOCIALLOGINERR' => 'Impossibile effettuare il login con questo account social',
    'OKLOGINSOCIAL' => 'Login con social account effettuato',
    'USERNOTFOUND' => 'Utente non trovato per effettuare il link con account social',
    'NOLINK' => 'Impossibile effettuare il link con il tuo account social',
    'NOSOCIALNETUNSPECIFIED' => 'Social Network non specificato',
    'INVALIDSOCIALNET' => 'Social Network non valido',
    'OKSOCIALUNLINK' => 'Il tuo account social è stato scollegato dal tuo account Jamyourself',
    'NOUNLINK' => 'Impossibile scollegare il tuo account dal tuo account social',
    //PASSWORDRESET
    'OKPASSWORDRESETREQUEST' => 'La tua richiesta di reset password è stata inoltrata correttamente',
    'USERNOTFOUNDFORPASSRESET' => 'User non trovato per reset della password',
    'NOEMAILFORRESETPASS' => 'Email non settata per reset della password',
    //SEARCH
    'NOSEARCHTEXT' => 'Devi inserire un testo da ricercare',
    'SHORTSEARCHTEXT' => 'Il testo da ricercare è troppo breve',
    'SEARCHOK' => 'Ricerca ok',
    //PLAYLIST
    'SONGADDEDTOPLAYLIST' => 'Canzone aggiunta alla playlist',
    'SONGREMOVEDFROMPLAYLIST' => 'Song removed from playlist',
    'NOPLAYLIST' => 'Playlist non trovata',
    'NOSONGTID' => 'Song ID non impostato',
    'NOADDSONGTOPLAY' => 'Impossibile aggiungere canzone alla playlist',
    'NOREMOVESONGTOPLAY' => 'Impossibile rimuovere canzone dalla playlist',
    'SONGALREADYINTRACKLIST' => 'Canzone già presente nella playlist playlist',
    'SONGNOTINTRACKLIST' => 'Impossibile trovare canzone da rimuovere dalla playlist',
    //SETTINGS
    'NOSETTINGUPDATE' => 'Impossibile effettuare aggiornamento dei setting',
    'NOSETTING' => 'Setting non specificato nella richiesta',
    'SETTINGUPDATED' => 'Setting Aggiornato'
);

$mail_files = array(
    'USERDELETED' => 'it.userDeletion.html',
    'FRINDSHIPREQUESTEMAIL' => 'it.friendshipRequest.html',
    'COLLABORATIONREQUESTEMAIL' => 'it.collaborationRequest.html',
    'FRIENDSHIPACCEPTEDEMAIL' => 'it.friendshipRequestAccepted.html',
    'COLLABORATIONACCEPTEDEMAIL' => 'it.collaborationRequestAccepted.html',
    'FOLLOWINGEMAIL' => 'it.following.html',
    'EVENTREVIEWEMAIL' => 'it.eventReviewReceived.html',
    'RECORDREVIEWEMAIL' => 'it.recordReviewReceived.html'
);

$rest_strings = array(
    '100' => 'Continua',
    '101' => 'Cambio Di Protocolli',
    '200' => 'OK',
    '201' => 'Creato',
    '202' => 'Accettato',
    '203' => 'Informazione Non Interessante',
    '204' => 'Nessun Contenuto',
    '205' => 'Reset del contenuto',
    '206' => 'Contenuto Parziale',
    '300' => 'Scelta Multipla',
    '301' => 'Spostato Definitivamente',
    '302' => 'Trovato',
    '303' => 'Vedi Altro',
    '304' => 'Non MOdificato',
    '305' => 'Usa Proxy',
    '306' => '(Non Usato)',
    '307' => 'Redirect Temporaneo',
    '400' => 'Richiesta Non Valida',
    '401' => 'Non Autorizzato',
    '402' => 'Richiesto Pagamento',
    '403' => 'Non Consentito',
    '404' => 'Non Trovato',
    '405' => 'Metodo Non Consentito',
    '406' => 'Non Accettato',
    '407' => 'Richiesta Autenticazione Proxy',
    '408' => 'Richiesta Time Out',
    '409' => 'Conflitto',
    '410' => 'Andato',
    '411' => 'Lunghezza richiesta',
    '412' => 'Requisito Non Soddisfatto',
    '413' => 'Request Entity Troppo Estesa',
    '414' => 'Request-URI Troppo Lungo',
    '415' => 'Media Non Supportato',
    '416' => 'Requested Range Not Satisfiable',
    '417' => 'Richiesta Fallita',
    '500' => 'Errore Server',
    '501' => 'Non Implementato',
    '502' => 'Gateway Non Valido',
    '503' => 'Servizio Non Disponibile',
    '504' => 'Gateway Timeout',
    '505' => 'Versione HTTP Non Supportata'
);
?>