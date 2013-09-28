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
 * @classBox: definisce la classe per la quale viene chiamato il box (ad esempio se typebox == comment allora classBox
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
	classBox : '',
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
				classBox :  this.classBox
			},
			type : 'POST',
			dataType : 'json',
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
							
							callBox.load('album');
							callBox.load('relation');
							callBox.load('post');
							break;
						
						case 'review':
							//aggiungo box review Record se non utente venue
							if (__this.typeUser != 'VENUE')
								addBoxRecordReview(data, __this.typeUser);
							//aggiungo box review Event
							addBoxRecordEvent(data, __this.typeUser);							
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
							addBoxAlbum(data, __this.typeUser);							
							break;

						case 'post':
							//aggiunge box post
							addBoxPost(data, __this.typeUser);
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
							return data;
							break;	
						default:

					}
					
					console.log('Box: ' + typebox + ', TypeUser: ' + __this.typeUser + ', objectId: ' + __this.objectIdUser);
					return data;
				} else {
					
				//	$('.body-content').load('content/general/error.php');
				}

			},
			error : function(richiesta, stato, errori) {
				console.log(stato);
			}
		});

	}
}

/*
 * Variabili
 */
var rsi_event;
var rsi_album;


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
 * box recordReview chiama box-recordReview.php
 */
function addBoxRecordReview(data, typeUser) {
	$('#box-recordReview').load('content/profile/box-social/box-recordReview.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: 
		slideReview('recordReviewSlide');
		hcento();
	});
}

/*
 * box eventReview chiama box-eventReview.php
 */
function addBoxRecordEvent(data, typeUser) {
	$('#box-recordEvent').load('content/profile/box-social/box-eventReview.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success:
		slideReview('eventReviewSlide'); 
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
function addBoxAlbum(data, typeUser) {
	$('#box-album').load('content/profile/box-profile/box-album.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: 
		rsi_album = slideReview('albumSlide');
		lightBoxPhoto('photo-colorbox-group');
		hcento();
	});
}

/*
 * box post chiama box-post.php
 */
function addBoxPost(data, typeUser) {
	$('#box-post').load('content/profile/box-social/box-post.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: hcento();
	});
}

function addBoxHeader(data, typeUser){
	$('#header-profile').load('content/header/box-profile.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: hcento();
	});
	$('#header-social').load('content/header/box-social.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: hcento();
	});
}




/*
 * scorrimento dei box
 */

function royalSlide(idBox) {
 $('#' + idBox).royalSlider({
		arrowsNav : true,
		arrowsNavAutoHide : false,
		fadeinLoadedSlide : false,
		controlNavigationSpacing : 0,
		controlNavigation : 'none',
		imageScaleMode : 'none',
		imageAlignCenter : false,
		blockLoop : false,
		loop : false,
		numImagesToPreload : 6,
		transitionType : 'fade',
		autoHeight: true,
		keyboardNavEnabled : true,
		block : {
			delay : 400
		}
	}).data('royalSlider');
	
}


function slideReview(idBox) {
var rsi = $('#' + idBox).royalSlider({
		arrowsNav : false,
		arrowsNavAutoHide : false,
		navigateByClick: false,
		fadeinLoadedSlide : false,
		controlNavigationSpacing : 0,
		controlNavigation : 'none',
		imageScaleMode : 'none',
		imageAlignCenter : false,
		blockLoop : false,
		loop : false,
		numImagesToPreload : 6,
		transitionType : 'fade',
		keyboardNavEnabled : true,
		autoHeight: true,
		block : {
			delay : 400
		}
	}).data('royalSlider');
	return rsi;
}

function royalSlideNext(box){
	var rsi;
	switch(box) {
		case 'record':
		rsi = rsi_record;
		break;
		case 'event':
		rsi = rsi_event;
		break;
		case 'album':
		rsi = rsi_album;
		break;
		default:
		break;
	}
	rsi.next();
   	
  
}

function royalSlidePrev(box){
	var rsi;
	switch(box) {
		case 'record':
		rsi = rsi_record;
		break;
		case 'event':
		rsi = rsi_event;
		break;
		case 'album':
		rsi = rsi_album;
		break;
		default:
		break;
	}
	rsi.prev();
	
 }




