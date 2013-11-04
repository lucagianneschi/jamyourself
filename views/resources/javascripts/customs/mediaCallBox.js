/*
 * Il contenitore CallBox permette di effettuare una chiamata ajax a callBax.php 
 * che restituisce le query per ogni box
 * Inizialmente verrà effettuata la chiamata al box classinfo, in parallelo vengono chiamate 
 * le query per tutti gli altri box
 * Alla restituzione dei dati questi verranno inviati ai box html rispettivi e caricati sequenzialmente
 * 
 * @url: url dello script callbox.php che effettua le chiamate ai boxes
 * @typebox: viene definito il nome del box che puo essere:
 * 			classinfo, review, comment
 * @classMedia: tipo di pagina media (event o record)
 * @objectIdMedia: objectId della pagina media che si vuole visualizzare
 * @limit: rappresenta il limite della query di uno specifico box (vale per le review e comment)
 * @skip: rappresenta lo skip della query (vale per le review e comment)
 * @typeListUserEvent: rappresenta il tipo di lista utenti (attendee,featuring,invited)
 *
 * @author: Maria Laura Fresu
 */

var callBoxMedia = {
	url : "content/media/callbox.php",
	classMedia: '',
	objectIdMedia: '',
	limit: '',
	skip: '',
	typeListUserEvent: '',
	load : function(typebox) {
		
		__this = this;
				
		$.ajax({
			url : __this.url,
			data : {
				typebox: typebox,
				classMedia : __this.classMedia,
				objectIdMedia : __this.objectIdMedia,
				limit : __this.limit,
				skip: __this.skip,
				typeListUserEvent: __this.typeListUserEvent,
			},
			type : 'POST',
			dataType : 'json',
			beforeSend: function(){
								
				switch(typebox){
					case 'comment':
						getPinnerMedia('Comment');
					break;
					case 'record':
						getPinnerMedia('Record');
					break;					
					case 'review':					
						if (__this.classMedia == 'record')	getPinnerMedia('RecordReview');
						else getPinnerMedia('EventReview');						
					break;
				}					
			},
			success : function(data, stato) {
				//NOT ERROR
				if (data != null && data['error']['code'] == 0) {
										
					switch(typebox) {						
						case 'classinfo':
							
							addBoxClassInfo(data,__this.classMedia);
							
							if(__this.classMedia == 'record')
								addBoxRecordMedia(data);		
							
							//chiamata box comment								
							callBoxMedia.load('comment');
							//chiamata box review							
							callBoxMedia.load('review');
							
						break;
						
						case 'comment':
							addBoxCommentMedia(data);							
						
						break;	
							
						case 'review':
							if(__this.classMedia == 'event')
								addBoxEventReviewMedia(data);
							if(__this.classMedia == 'record')
								addBoxRecordReviewMedia(data);							
						break;
						
						default:

					}					
					console.log('Box: ' + typebox + ', class: ' + __this.classMedia + ', objectId: ' + __this.objectIdMedia);
					return data;
				} else {
					if(typebox == 'classinfo')
						$('.body-content').load('content/general/error.php');
				}

			},
			error : function(richiesta, stato, errori) {
				console.log(richiesta+' '+stato+' '+errori);
				console.log(richiesta);
			}
		});

	}
}

function getPinnerMedia(box){	
	$('#box-'+box).load('content/media/box-general/box-spinner.php', {
		'box' : box
		}, function(){
		success: spinner();
	});			
}

function addBoxClassInfo(data, classMedia){
	$('#box-userinfo').load('content/media/box-profile/box-classinfo.php', {
		'data' : data,
		'classMedia': classMedia,
		}, function() { 
		success: hcento();
	});
	$('#box-status').load('content/media/box-social/box-status.php', {
		'data' : data,
		'classMedia': classMedia,
		}, function() { success: hcento();		
	});
	$('#box-information').load('content/media/box-profile/box-information.php', {
		'data' : data,
		'classMedia': classMedia,
		}, function() { 
		success: hcento();
	});
}

function addBoxRecordMedia(data){
	$('#box-record').load('content/media/box-profile/box-record.php', {
		'data' : data
		}, function() { 
		success: hcento();
	});
}

function addBoxCommentMedia(data){
	$('#box-commentMedia').load('content/media/box-social/box-comment.php', {
		'data' : data
		}, function() { 
		success: hcento();
	});
}

function addBoxEventReviewMedia(data){
	$('#box-EventReview').load('content/media/box-social/box-eventReview.php', {
		'data' : data
		}, function() { 
		success: hcento();
	});
}

function addBoxRecordReviewMedia(data){
	$('#box-RecordReview').load('content/media/box-social/box-recordReview.php', {
		'data' : data
		}, function() { 
		success: hcento();
	});
}

