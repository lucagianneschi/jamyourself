function loadBoxSocial(notification, objectId, userType){
	$.ajax({
		url : './content/header/box-social.php',
		data : {
			userObjectId: objectId,
			userType: userType,
			typeNotification: notification
		},
		type : 'POST',
		beforeSend: function(){
			
		}
	}).done(function(message, status, xhr){			
			$('#header-social').html(message);
			hcento();
	}).fail(function(xhr){							
			console.log($.parseJSON(xhr.responseText));					
	});
}
