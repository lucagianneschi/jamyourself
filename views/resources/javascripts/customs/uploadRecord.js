$(document).ready(function() {
	
	//scorrimento lista album record 
	$("#uploadRecord-listRecordTouch").touchCarousel({
		pagingNav : false,
		snapToItems : true,
		itemsPerMove : 1,
		scrollToLast : false,
		loopItems : false,
		scrollbar : false
	});
	
	//gestione select album record
	$('.uploadRecord-boxSingleRecord').click(function(){
		$( "#uploadRecord01" ).fadeOut( 100, function() {
    		$("#uploadRecord03").fadeIn( 100 );
		});
	});
	
	//gesione button create new 
	$('#uploadRecord-new').click(function(){
		$( "#uploadRecord01" ).fadeOut( 100, function() {
    		$("#uploadRecord02").fadeIn( 100 );
		});
	});
	
	//gestione button new in uploadRecord02
	$('#uploadRecord02-next').click(function(){
		$( "#uploadRecord02" ).fadeOut( 100, function() {
    		$("#uploadRecord03").fadeIn( 100 );
		});
	});
	
	//carica i tag music
	$.ajax({
	    url : "../config/views/tag.config.json",
	    dataType : 'json',
	    success : function (data,stato) {
	       var music = data.music; 
	        
	       for(var value in music){	       	      
	       	 	var tagCheck = '<input type="checkbox" name="';
	       	 	var tagCheckTrack = '<input type="checkbox" name="';
	       		var name = 'tag-music'+value+'"';
	       		var nameTrack = 'tag-musicTrack'+value+'"';
	       		
	       		tagCheck = tagCheck + name + 'id="' + name + 'value="' + value + '" class="no-display">';
	       		tagCheck = tagCheck + '<label for="' + name + '>' + music[value] + '</label>';
	       		
	       		tagCheckTrack = tagCheckTrack + nameTrack + 'id="' + nameTrack + 'value="' + value + '" class="no-display">';
	       		tagCheckTrack = tagCheckTrack + '<label for="' + nameTrack + '>' + music[value] + '</label>';
	       		
	       		$(tagCheck).appendTo('#uploadRecord #tag-music');
	       		$(tagCheckTrack).appendTo('#uploadRecord #tag-musicTrack');	     	       		
	       }
	       
	    },
	    error : function (richiesta,stato,errori) {
	        console.log("E' evvenuto un errore. Il stato della chiamata: "+stato);
	    }
	});
	
});