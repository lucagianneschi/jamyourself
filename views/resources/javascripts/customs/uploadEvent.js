

$(document).ready(function() {
		
   	//gestione calendario
   	$( "#date" ).datepicker({ 
   		altFormat: "dd/mm/yy"
   	});
    
    //gesione button create
    $('#uploadEvent01-next').click(function() {
     
    });
    
    var time = getClockTime();
    $("#hours").html(time);

    //carica i tag music
    $.ajax({
        url: "../config/views/tag.config.json",
        dataType: 'json',
        success: function(data, stato) {
            music = data.music;

            for (var value in music) {
                var tagCheck = '<input type="checkbox" name="';
                var tagCheckTrack = '<input type="checkbox" name="';
                var name = 'tag-music' + value + '"';
                var nameTrack = 'tag-musicTrack' + value + '"';
                tagCheck = tagCheck + name + 'id="' + name + 'value="' + value + '" class="no-display">';
                tagCheck = tagCheck + '<label for="' + name + '>' + music[value] + '</label>';

                tagCheckTrack = tagCheckTrack + nameTrack + 'id="' + nameTrack + 'value="' + value + '" class="no-display">';
                tagCheckTrack = tagCheckTrack + '<label for="' + nameTrack + '>' + music[value] + '</label>';

                $(tagCheck).appendTo('#uploadEvent #tag-music');
                $(tagCheckTrack).appendTo('#uploadEvent #tag-musicTrack');
            }

        },
        error: function(richiesta, stato, errori) {
            console.log("E' evvenuto un errore. Il stato della chiamata: " + stato);
        }
    });

});

function getClockTime(){
	var timeString = '';
	timeString = timeString + '<option value=""></option>'
    for(i=0; i< 24; i++){
    	if(i < 10){ 
    		timeString = timeString + '<option value="0'+i+':00">0'+i+':00</option>'
    		timeString = timeString + '<option value="0'+i+':30">0'+i+':30</option>'
    	}
    	else{
    		timeString = timeString + '<option value="'+i+':00">'+i+':00</option>'
    		timeString = timeString + '<option value="'+i+':30">'+i+':30</option>'
    	}
    }
    return timeString;
}
