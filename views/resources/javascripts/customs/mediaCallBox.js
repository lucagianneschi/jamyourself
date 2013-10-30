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

var callBoxMedia = {
	url : "content/media/callbox.php",
	typebox : '',
	objectIdUser : '',
	typeUser : '',
	typeCurrentUser : '',
	objectIdCurrentUser: '',
	objectId: '',
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
				classBox :  this.classBox,
				objectId: this.objectId
			},
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
								addBoxRecordReview(data, __this.typeUser);
							//aggiungo box review Event
							addBoxEventReview(data, __this.typeUser);							
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
							addBoxComment(data, __this.typeUser, __this.classBox,__this.objectId);							
							break;	
						default:

					}
					
					console.log('Box: ' + typebox + ', TypeUser: ' + __this.typeUser + ', objectId: ' + __this.objectIdUser);
					return data;
				} else {
					if(typebox == 'userinfo')
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
