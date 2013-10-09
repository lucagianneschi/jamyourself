function sendRequest(_action, _data, callback, _async) {
    if (_action === undefined || _action === null || _data === undefined || _data === null) {
	callback(null);
    }
    _data.request = _action;
    var url = "../../../controllers/request/commentRequest.php";
    var type = _action;
    var async = true;
    if (_async !== undefined && _async !== null)
	async = _async;

    $.ajax({
	type: type,
	url: url,
	data: _data,
	async: async,
	success: function(data, status) {
	    callback(data, status);
	},
	error: function(data, status) {
	    callback(data, status);
	}
    });
}

function confirmation(data, status) {
    console.debug("Data : " + data + " | Status: " + status);
    $("#data").html(data);
}

function sendComment() {
    var comment = {};
    //recupero il commento
    comment.text = $("#comment").val();

    //TODO
    //forzo l'utente su cui sto facendo il commento
    comment.toUser = "GuUAj83MGH";

    window.console.log("Sending comment: " + comment);
    sendRequest("POST", comment, confirmation, true);
}