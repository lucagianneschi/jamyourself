function sendRequest(_action, _data, callback, _async) {
    if (_action === undefined || _action === null || _data === undefined || _data === null) {
        callback(null);
    }
    _data.request = _action;
    var url = "./../controllers/request/postRequest.php";
    var type = _action;
    var async = true;
    if (_async !== undefined && _async !== null)
        async = _async;
		
	$.ajax({
        type: type,
        url: url,
        data: _data,
        async: async,
        beforeSend: function(){
        	//alert('wei')
        	$('#social-Post #button-post').addClass('post-button-send');
        	$('#social-Post #button-post').val('');
        }, 
        success: function(data, status) {
            callback(data, status);
        },
        error: function(data, status) {
            callback(data, status);
        }
    });
}

function confirmation(data, status){
    console.debug("Data : " + data + " | Status: " + status);
    $("#data").html(data);
    if(status == 'error'){
    	$('#post-error').delay(500).show();
    	$('#social-Post #button-post').removeClass('post-button-send');
        $('#social-Post #button-post').val('Post');
    }
    	
    else{
    	$('#post-error').delay(500).hide();
    	callBox.load('post');
    } 
}

function sendPost(){
	var post = {};
    //recupero il commento
	post.text = $("#post").val();
	
	//TODO
	//forzo l'utente su cui sto facendo il commento
	post.toUser = "GuUAj83MGH";
	
	window.console.log("Sending post: " + JSON.stringify(post));
    sendRequest("POST", post, confirmation, true);
}