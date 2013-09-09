$(document).ready(function() {

	/*
	 * Il contenitore CallBox permette di definire un oggetto per effettuare la chiamata ai box,
	 * ad ogni box viene prima effettuata una chiamata ajax per richiedere i dati al server e successivamente questi dati vengono passati
	 * ai file php contenente l'html dei box.
	 * Inizialmente si definisce l'objectId relativo al l'utente del profilo, typeCurrentUser il type dell'utente corrente
	 * e viene chiamata la load su il primo box userinfo
	 * All'interno della funzione load viene effettutato un cast per le varie operazioni a seconda del tipo di box
	 * i successivi box vengono chiamati ricorsivamente all'interno della load stessa.
	 *
	 * @url: url dello script callbox.php che effettua le chiamate ai boxes
	 * @typebox: viene definito il nome del box che puo essere:
	 * 			userinfo, review, activity, record, event, relation, album e post
	 * @objectId: dell'utente del profilo
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
		objectId : '',
		typeUser : '',
		typeCurrentUser : '',
		classBox : '',
		load : function(typebox) {
			__this = this;
			this.typebox = typebox;

			$.ajax({
				url : this.url,
				data : {
					typebox : this.typebox,
					objectId : this.objectId,
					type : this.typeUser,
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
								break;

							case 'review':
								//aggiungo box review Record se non utente venue
								if (__this.typeUser != 'VENUE')
									addBoxRecordReview(data, __this.typeUser);
								//aggiungo box review Event
								addBoxRecordEvent(data, __this.typeUser);
								//chiamata ricorsiva al box record se jammer altrimenti chiama il box event
								callBox.load('activity');
								break;

							case 'activity':
								//aggiunge box activity
								addBoxActivity(data, __this.typeUser);
								//chiamate ricorsive di record o event o album
								if (__this.typeUser == 'JAMMER')
									callBox.load('record');
								else {
									if (__this.typeUser != 'SPOTTER')
										callBox.load('event');
									else
										callBox.load('relation');
								}
								break;

							case 'record':
								addBoxRecord(data, __this.typeUser);
								callBox.load('event');
								break;

							case 'event':
								addBoxEvent(data, __this.typeUser);
								callBox.load('relation');
								break;

							case 'relation':
								//se spotter aggiungi relation profile
								if (__this.typeUser == 'SPOTTER')
									addBoxRelationProfile(data, __this.typeUser);
								//se jammer o venue aggiunge social profile
								else
									addBoxRelationSocial(data, __this.typeUser);
								callBox.load('album');
								break;

							case 'album':
								//aggiunge box album
								addBoxAlbum(data, __this.typeUser);
								callBox.load('post');
								break;

							case 'post':
								//aggiunge box post
								addBoxPost(data, __this.typeUser);
								break;

							default:

						}

						console.log('Box: ' + typebox + ', TypeUser: ' + __this.typeUser + ', objectId: ' + __this.objectId);
					} else {
						$('.body-content').load('content/general/error.php');
					}

				},
				error : function(richiesta, stato, errori) {
					console.log(stato);
				}
			});

		}
	}

	//CHIAMATA CALLBOX
	callBox.objectId = '1oT7yYrpfZ';
	callBox.typeCurrentUser = 'SPOTTER';
	callBox.load('userinfo');

	/*
	 *
	 //SPOTTER
	 $mari = '1oT7yYrpfZ'; //MARI
	 $FLAVYCAP = 'oN7Pcp2lxf'; //FLAVYCAP
	 $Kessingtong = '2OgmANcYaT'; //Kessingtong
	 //JAMMER
	 $ROSESINBLOOM = 'uMxy47jSjg'; //ROSESINBLOOM
	 $Stanis = 'HdqSpIhiXo'; //Stanis <-album foto
	 $LDF = '7fes1RyY77'; //LDF
	 //Venue
	 $ZonaPlayed = '2K5Lv7qxzw'; //ZonaPlayed
	 $Ultrasuono = 'iovioSH5mq'; //Ultrasuono
	 $jump = 'wrpgRuSgRA'; //jump rock club
	 */
});

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
		success: 
		viewMap();
		hcento();
	});
	//viewMap();

}

/*
 * box record chiama box-record.php
 */
function addBoxRecord(data, typeUser) {
	$('#box-record').load('content/profile/box-profile/box-record.php', {
		'data' : data,
		'typeUser' : typeUser
	}, function() { success: {
			royalSlide('record');
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
			royalSlide('event');
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
function addBoxActivity(data, typeUser) {
	$('#box-activity').load('content/profile/box-social/box-activity.php', {
		'data' : data,
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
		//slideReview('albumSlide');
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

/*
 * scorrimento dei box
 */
var rsi
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




