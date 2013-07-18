var duration;

// MODIFICARE (leggere in soundManager.onload)
duration = $('#duration-player').val();


$(document).ready(function() {

// permette di muovere il playhead ------ INIT POSITION playhead-player 110
$("#playhead-player").draggable({ 
	containment: "#bar-player",
	axis: "x",
	opacity:50,
    drag: function(ev,ui) {      
    //   d_width = $('#bar-player').width();
    	pos = ui.position.left - 110;
       	
       	//--- in base alla posizione del playhead si muove la barra dello status della canzone
       	$("#statusbar-player").css({width: pos+"px"});
       	 
    //   pos = ui.position.left;	       
    //   tempo_att = (duration * pos)/d_width;
       
    //   soundManager.setPosition('mySound',tempo_att);	
    }
});


//controllo sul clic play-pause 
$('.play-pause').click(function() {
	if($("#pause").is(":visible") == true){
		$('#pause').hide();
		$('#play').show();
	}
	else{
		$('#play').hide();
		$('#pause').show();
	}
}); 

});