function sendRequest(_server, _action, _data, _callback, _async) {
    try {
        if (_action !== undefined && _action !== null && _data !== undefined && _data !== null) {

            _data.request = _action;
            var url = "./testRequest.php";
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
    $("#data").html(JSON.stringify(data.objectReturned));
}

function syncCall(){
    $("#data").html("Attendi...");
    var data = {"objectId": $("#objectId").val(), "class" : $( "#class option:selected" ).val()};
    sendRequest("test", "getObject", data, testCallback, false);
}