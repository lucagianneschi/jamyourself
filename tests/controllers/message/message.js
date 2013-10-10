function sendRequest(_action, _data, callback, _async) {
    if (_action === undefined || _action === null || _data === undefined || _data === null) {
        callback(null);
    }
    _data.request = _action;
    var url = "../../../controllers/request/messageRequest.php";
    var type = "POST";
    var async = true;
    if (_async !== undefined && _async !== null)
        async = _async;

    $.ajax({
        type: type,
        url: url,
        data: _data,
        async: async,
        success: function(data, status) {
            $("#data").html(data);
            callback(data, status);
        },
        error: function(data, status) {
			$("#data").html(data);
            callback(data, status);
        }
    });
}

function confirmation(data, status) {
    console.debug("Data : " + data + " | Status: " + status);
    $("#data").html(data);
}

function sendMessage(toUser) {
    var message = {"text" : $("#message").val(), "toUser" : toUser };
    window.console.log("Sending Message: " + message);
    sendRequest("sendMessage", message, confirmation, true);
}