/*
 * Il contenitore CallBox permette di effettuare una chiamata ajax a callBax.php 
 * che restituisce le query per ogni box
 * Inizialmente verrà effettuata la chiamata al box infoUser, in parallelo vengono chiamate 
 * le query per tutti gli altri box
 * Alla restituzione dei dati questi verranno inviati ai box html rispettivi e caricati sequenzialmente
 * 
 * @url: url dello script callbox.php che effettua le chiamate ai boxes
 * @typebox: viene definito il nome del box che puo essere:
 * 			userinfo, review, activity, record, event, relation, album e post
 * @objectIdUser: dell'utente del profilo
 * @typeUser: definita all'interno della load nella prima chiamata in userinfo, specifica il type dell'utente
 * @typeCurrentUser: type dell'utente corrente
 * @classObject: definisce la classe per la quale viene chiamato il box (ad esempio se typebox == comment allora classObject
 * 	deve essere o Image, Record o Event)
 *
 * @author: Maria Laura Fresu
 */

var callBox = {
	url : "content/profile/callbox.php",
	typebox : '',
	objectIdUser : '',
	typeUser : '',
	typeCurrentUser : '',
	objectIdCurrentUser: '',
	objectId: '',
	classObject : '',
	classBox: '',
	countBoxActivity: 0,
	numBoxActivity: 1,
	dataActivity: {'record':'','event':'','relation':''},
	load : function(typebox) {
		__this = this;
		this.typebox = typebox;
		
		$.ajax({
			url : this.url,
			data : {
				typebox : this.typebox,
				objectIdUser : this.objectIdUser,
				typeUser : this.typeUser,
				objectIdCurrentUser : this.objectIdCurrentUser,
				classObject :  this.classObject,
				objectId: this.objectId
			},
			async: true,
			type : 'POST',
			dataType : 'json',
			beforeSend: function(){
				
				switch(typebox){
					case 'record':
						getPinner('record');
					break;
					case 'event':
						getPinner('event');
					break;
					case 'album':
						getPinner('album');
					break;
					case 'relation':
						if (__this.typeUser == 'SPOTTER'){							
							getPinner('friends');
							getPinner('following');
						}
						else{
							getPinner('collaboration');
							getPinner('followers');
						}
						getPinner('activity');
					break;
					case 'post':
						getPinner('post');
					break;
					case 'review':					
						if (__this.typeUser != 'VENUE')
							getPinner('RecordReview');
						getPinner('EventReview');						
					break;
				}					
			},
			success : function(data, stato) {
				//NOT ERROR
				if (data != null && data['error']['code'] == 0) {					
					switch(typebox) {						
						case 'userinfo':
							//Prelevo il type dell'utente
							__this.typeUser = data.type;
							//aggiungo i box: box-userinfo, box-information e box-status
							addBoxUserInfo(data,__this.typeCurrentUser);
							
							//chiamata ricorsiva al box review
							callBox.load('review');
							if (__this.typeUser == 'JAMMER'){
								__this.numBoxActivity++;
								callBox.load('record');
							} 
							if (__this.typeUser != 'SPOTTER'){
								__this.numBoxActivity++;
								callBox.load('event');
							} 
							callBox.load('relation');
							callBox.load('album');							
							callBox.load('post');
							break;
						
						case 'review':
							//aggiungo box review Record se non utente venue
							if (__this.typeUser != 'VENUE')
								addBoxRecordReview(data, __this.typeUser, __this.objectIdUser);
							//aggiungo box review Event
							addBoxEventReview(data, __this.typeUser, __this.objectIdUser);							
							break;
						
						case 'record':
							addBoxRecord(data, __this.typeUser);
						
							__this.dataActivity['record'] = data.activity.record;
							
							__this.countBoxActivity = __this.countBoxActivity + 1;							
							if(__this.countBoxActivity == __this.numBoxActivity){								
								callBox.load('activity');
							}
							break;
						case 'event':
							addBoxEvent(data, __this.typeUser);
							
							__this.dataActivity['event'] = data.activity.event;
							
							__this.countBoxActivity = __this.countBoxActivity + 1;							
							if(__this.countBoxActivity == __this.numBoxActivity){
								callBox.load('activity');
							}
							break;

						case 'relation':												
							//se spotter aggiungi relation profile
							if (__this.typeUser == 'SPOTTER') addBoxRelationProfile(data, __this.typeUser);
							//se jammer o venue aggiunge social profile
							else addBoxRelationSocial(data, __this.typeUser);
							
							
							__this.dataActivity['relation'] = data.activity.relation;
							
							__this.countBoxActivity = __this.countBoxActivity + 1;
							if(__this.countBoxActivity == __this.numBoxActivity){
								callBox.load('activity');
							}
							break;

						case 'album':
							//aggiunge box album
							addBoxAlbum(data, __this.typeUser, __this.objectIdUser);							
							break;

						case 'post':
							//aggiunge box post
							addBoxPost(data, __this.typeUser, __this.objectIdUser);
							break;
						
						case 'activity':							
							//aggiunge box activity
							console.log(__this.dataActivity);
							addBoxActivity(data,__this.dataActivity, __this.typeUser);
							//chiamate ricorsive di record o event o album
							break;
						
						case 'header':
							//aggiunge box post
							addBoxHeader(data, __this.typeUser);
							break;
							
						case 'comment':
							addBoxComment(data, __this.typeUser, __this.classBox, __this.objectId, __this.objectIdUser);							
							break;	
						default:

					}
					
					console.log('Box: ' + typebox + ', TypeUser: ' + __this.typeUser + ', objectId: ' + __this.objectIdUser);
					return data;
				} else {
					if(typebox == 'userinfo')
						$('.body-content').load('content/general/error.php');
					else{
						console.log('Error: '+typebox);
					}
				}

			},
			error : function(richiesta, stato, errori) {
				console.log(typebox+' '+richiesta+' '+stato+' '+errori);
				console.log(richiesta);
			}
		});

	}
}

function getPinner(box){	
	$('#box-'+box).load('content/profile/box-general/box-spinner.php', {
		'box' : box
	}, function(){
		success: spinner();
	});			
}

/*
 * Variabili
 */

var rsi_event, rsi_album ,rsi_eventReview, rsi_recordReview ,rsi_record ;


/*
 * box userInfo: chiama box-userinfo.php, box-status.php e box-information.php
 */
function addBoxUserInfo(data,typeCurrentUser) {
	$('#box-userinfo').load('content/profile/box-profile/box-userinfo.php', {
		'data' : data
	}, function() { success: hcento();
	});
	$('#box-status').load('content/profile/box-social/box-status.php', {
		'data' : data,
		'typeCurrentUser': typeCurrentUser,
	}, function() { success: {
			slideAchievement();
			hcento();
		}
	});
	$('#box-information').load('content/profile/box-profile/box-information.php', {
		'data' : data
	}, function() { 
		success:{
			
			hcento();
		}
	
	});
	

}

/*
 * box record chiama box-record.php
 */
function addBoxRecord(data, typeUser) {
	$('#box-record').load('content/profile/box-profile/box-record.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: {
			rsi_record = slideReview('recordSlide');
			hcento();
		}
	});

}

/*
 * box event chiama box-event.php
 */
function addBoxEvent(data, typeUser) {
	$('#box-event').load('content/profile/box-profile/box-event.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: {
			rsi_event = slideReview('eventSlide');
			hcento();
		}
	});
}

/*
 * box RecordReview chiama box-RecordReview.php
 */
function addBoxRecordReview(data, typeUser, objectIdUser) {
	$('#box-RecordReview').load('content/profile/box-social/box-recordReview.php', {
		'data' : data,
		'typeUser' : typeUser,
		'objectIdUser' : objectIdUser
	}, function() { success: 
		rsi_RecordReview = slideReview('recordReviewSlide');
		hcento();
	});
}

/*
 * box eventReview chiama box-eventReview.php
 */
function addBoxEventReview(data, typeUser, objectIdUser) {
	$('#box-EventReview').load('content/profile/box-social/box-eventReview.php', {
		'data' : data,
		'typeUser' : typeUser,
		'objectIdUser' : objectIdUser
	}, function() { success:
		rsi_eventReview = slideReview('eventReviewSlide'); 
		hcento();
	});
}

/*
 * box activity chiama box-activity.php
 */
function addBoxActivity(data,dataActivity, typeUser) {	
	$('#box-activity').load('content/profile/box-social/box-activity.php', {
		'data' : data,
		'dataActivity' : dataActivity,
		'typeUser' : typeUser
	}, function() { success: hcento();
	});
}

/*
 * box relationProfile chiama box-friends.php box-following.php
 */
function addBoxRelationProfile(data, typeUser) {
	$('#box-friends').load('content/profile/box-profile/box-friends.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: hcento();
	});
	$('#box-following').load('content/profile/box-profile/box-following.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: hcento();
	});
}

/*
 * box relationSocial chiama box-collaboration.php box-followers.php
 */
function addBoxRelationSocial(data, typeUser) {
	$('#box-collaboration').load('content/profile/box-social/box-collaboration.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: hcento();
	});
	$('#box-followers').load('content/profile/box-social/box-followers.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: hcento();
	});
}

/*
 * box album chiama box-album.php
 */
function addBoxAlbum(data, typeUser, objectIdUser) {
	$('#box-album').load('content/profile/box-profile/box-album.php', {
		'data' : data,
		'typeUser' : typeUser,
		'objectIdUser' : objectIdUser
	}, function() { success: 
		rsi_album = slideReview('albumSlide');
		lightBoxPhoto('photo-colorbox-group');
		hcento();
	});
}

/*
 * box post chiama box-post.php
 */
function addBoxPost(data, typeUser, objectIdUser) {
	$('#box-post').load('content/profile/box-social/box-post.php', {
		'data' : data,
		'typeUser' : typeUser,
		'objectIdUser' : objectIdUser
	}, function() { success: hcento();
	});
}

/*
 * box post chiama box-post.php
 */
function addBoxComment(data, typeUser,classbox,objectId,objectIdUser) {
	var idBox = '';
	if(classbox == 'RecordReview' || classbox == 'EventReview'){
		idBox = '#social-'+classbox;		
	}
	if(classbox == 'Album' || classbox == 'Record'){
		idBox = '#profile-'+classbox;
	}
	if(classbox == 'Image' || classbox == 'Post' || classbox == 'Comment'){
		idBox = '#'+objectId;
	}
	$(idBox+' .box-comment').load('content/profile/box-general/box-comment.php', {
		'data' : data,
		'typeUser' : typeUser,
		'objectId': objectId,
		'objectIdUser': objectIdUser
	},function(){
		success:{ 
			if(classbox == 'Image'){
				$("#cboxLoadedContent").mCustomScrollbar("update");
			} 
			hcento();
		}
	});
	
}








