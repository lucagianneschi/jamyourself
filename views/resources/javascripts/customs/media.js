$(document).ready(function() {
	//lanciare al caricamento del box review
	cropText();
});
/*
 * taglia il testo delle recensioni a 170 caratteri
 */
function cropText(){
		
	var numCharacters = $('.cropText').text().length;
	
	if(numCharacters > 170){
		
		$( ".cropText" ).each(function( index, element ) {
			
			textCrop = $( this ).text().substr(0, 170);
			
			textCrop = textCrop + '... ';
		
			$( this ).text(textCrop);
			
			$( this ).next().removedClass('no-display');		
			
			$( this ).next().appendTo(this);
		  
		});
	}
	else{
		$('.viewText').addClass('no-display');
	}
	
	
}

/*
 * Visualizza o nasconde il testo delle recensioni
 */
function toggleText(_this, box, text){
	
	if($(_this).text() == 'View All'){
		
		$('#'+box+' .viewText').insertBefore('#'+box+' .closeText');
		
		$('#'+box+' .cropText').text(text);
		
		$('#'+box+' .viewText').addClass('no-display');
		
		$('#'+box+' .closeText').removeClass('no-display');
		
		hcento();
	}
		
	if($(_this).text() == 'Close'){
		
		$('#'+box+' .closeText').addClass('no-display');
		
		var text = $('#'+box+" .cropText");
		
		textCrop = text.text().substr(0, 170);						
		
		textCrop = textCrop + '... ';
		
		text.text(textCrop);
		
		$('#'+box+' .viewText').removeClass('no-display');
		
		$('#'+box+' .viewText').appendTo(text);
		
		hcento();
		
	}
}
