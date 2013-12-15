var restServerList = {
    "access": "accessRequest.php",
    "comment": "commentRequest.php",
    "delete": "deleteRequest.php",
    "event": "eventRequest.php",
    "love": "loveRequest.php",
    "message": "messageRequest.php",
    "playlist": "playlistRequest.php",
    "post": "postRequest.php",
    "relation": "relationRequest.php",
    "search": "searchRequest.php",
    "signup": "signupRequest.php",
    "social": "socialRequest.php",
    "upload": "uploadRequest.php",
    "uploadEvent": "uploadEventRequest.php",
    "uploadRecord": "uploadRecordRequest.php",
    "uploadReview": "uploadReviewRequest.php",
    "test": "testRequest.php",
};

function sendRequest(_server, _action, _data, _callback, _async) {
    try {
        if (_action !== undefined && _action !== null && _data !== undefined && _data !== null) {

            var serverREST = eval("restServerList." + _server);
            _data.request = _action;
            var url = "./" + serverREST;
            var type = "POST";
            var async = true;
            if (async !== undefined && async !== null) {
                async = _async;
            }
            $("#request").html(JSON.stringify(_data));
            $.ajax({
                type: type,
                url: url,
                data: _data,
                dataType: "json",
                async: async,
                success: function(data, status, xhr) {
                    //gestione success
                    if (_callback !== undefined && _callback !== null) {
                        //gestione callback per l'errore
                        _callback(data, "success", xhr);
                    }

                },
                error: function(data, status, xhr) {
                    if (_callback !== undefined && _callback !== null) {
                        //gestione callback per l'errore: per poter ottenere l'oggetto
                        _callback(JSON.parse(data.responseText), "error", xhr);
                    }
                }
            });
        }
    } catch (err) {
        window.console.log("sendRequest | An error occurred - message : " + err.message);
    }
}

function testCallback(data, status, xhr){
    alert(data.status);
    $("#data").html(JSON.stringify(data));
    $("#status").html(JSON.stringify(status));
    $("#xhr").html(JSON.stringify(xhr));
}

function syncCall(){
    $("#data").html("Attendi...");
    $("#status").html("Attendi...");
    $("#xhr").html("Attendi...");
    var data = {};
    sendRequest("test", "test", data, testCallback, false);
}

function asyncCall(){
    $("#data").html("Attendi...");
    $("#status").html("Attendi...");
    $("#xhr").html("Attendi...");
    var data = {};
    sendRequest("test", "test", data, testCallback, true);
}

function syncCallError(){
    $("#data").html("Attendi...");
    $("#status").html("Attendi...");
    $("#xhr").html("Attendi...");
    var data = {"forceError" : true};
    sendRequest("test", "test", data, testCallback, false);
}

function asyncCallError(){
    $("#data").html("Attendi...");
    $("#status").html("Attendi...");
    $("#xhr").html("Attendi...");
    var data = {"forceError" : true};
    sendRequest("test", "test", data, testCallback, true);
}