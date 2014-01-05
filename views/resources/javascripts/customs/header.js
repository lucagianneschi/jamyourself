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
			$('#box-notification').slideUp();
		}
	}).done(function(message, status, xhr){			
			$('#header-social').html(message);			
			$('#header-social').slideDown();
			rsi_not = slideReview('box-notification');
			rsi_not.updateSliderSize(true);
			hcento();
	}).fail(function(xhr){							
			console.log($.parseJSON(xhr.responseText));					
	});
}
