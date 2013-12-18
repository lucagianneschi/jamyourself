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
        if (_server !== undefined && _server !== null && _action !== undefined && _action !== null) {

            var serverREST = eval("restServerList." + _server);
            if (_data === undefined || _data === null) {
                _data = {};
            }
            _data.request = _action;
            var url = "../controllers/request/" + serverREST;
            var type = "POST";
            var async = true;
            if (async !== undefined && async !== null) {
                async = _async;
            }
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
        window.console.error("sendRequest | An error occurred - message : " + err.message);
    }
}

function prepareLocationObj(_result) {
    try {
        var location = {};
        location.address_components = _result.address_components;
        location.latitude = _result.geometry.location.nb;
        location.longitude = _result.geometry.location.ob;
        location.formatted_address = _result.formatted_address;
        return location;
    }
    catch (err) {
        window.console.error("prepareLocationObj | An error occurred - message : " + err.message);
    }
}

