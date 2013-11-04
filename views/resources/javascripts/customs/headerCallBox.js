/*
 * Il contenitore CallBox permette di effettuare una chiamata ajax a callBax.php 
 * che restituisce le query per ogni box, nello specifico viene utilizzata per i box dello header
 * 
 * @url: url dello script callbox.php che effettua le chiamate ai boxes
 * @typebox: viene definito il nome del box che puo essere:
 * 			userinfo, review, activity, record, event, relation, album e post
 * @objectIdCurrentUser: objectId dell'utente corrente
 *
 * @author: Maria Laura Fresu
 */

var headerCallBox = {
	url : "content/profile/callbox.php",
	typebox : '',	
	objectIdCurrentUser: '',	
	load : function(typebox) {
		__this = this;
		this.typebox = typebox;
		
		$.ajax({
			url : this.url,
			data : {
				typebox : this.typebox,
				objectIdCurrentUser : this.objectIdCurrentUser
			},
			async: true,
			type : 'POST',
			dataType : 'json',
			
			success : function(data, stato) {
				//NOT ERROR
				if (data != null && data['error']['code'] == 0) {					
					switch(typebox) {						
						case 'header':
							//aggiunge box post
							addBoxHeader(data);
							break;	
					}
					
					console.log('Box: ' + typebox + ', objectId User Current: ' + __this.objectIdCurrentUser);
					return data;
				} else {
					console.log('Error: '+typebox);
					console.log(data);
				}

			},
			error : function(richiesta, stato, errori) {
				console.log(typebox+' '+richiesta+' '+stato+' '+errori);
				console.log(richiesta);
			}
		});

	}
}


function addBoxHeader(data){
	$('#header-profile').load('content/header/box-profile.php', {
		'data' : data
	}, function() { success: hcento();
	});
	$('#header-social').load('content/header/box-social.php', {
		'data' : data
	}, function() { success: hcento();
	});
}







