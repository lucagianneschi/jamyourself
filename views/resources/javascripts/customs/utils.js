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
        window.console.log("sendRequest | An error occurred - message : " + err.message);
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
        window.console.log("prepareLocationObj | An error occurred - message : " + err.message);
    }
}

function startLoader(id) {
    try {
        var opts = {
            lines: 9, // The number of lines to draw
            length: 0, // The length of each line
            width: 4, // The line thickness
            radius: 9, // The radius of the inner circle
            corners: 1, // Corner roundness (0..1)
            rotate: 4, // The rotation offset
            direction: 1, // 1: clockwise, -1: counterclockwise
            color: '#000', // #rgb or #rrggbb or array of colors
            speed: 2.2, // Rounds per second
            trail: 56, // Afterglow percentage
            shadow: false, // Whether to render a shadow
            hwaccel: false, // Whether to use hardware acceleration
            className: 'spinner', // The CSS class to assign to the spinner
            zIndex: 2e9, // The z-index (defaults to 2000000000)
            top: 'auto', // Top position relative to parent in px
            left: 'auto' // Left position relative to parent in px
        };
         
        new Spinner(opts).spin(document.getElementById(id));
    } catch (err) {
        window.console.err("startLoader | An error occurred - message : " + err.message);
    }

}

function stopLoader(spinner) {
    try {
        spinner.stop();
    } catch (err) {
        window.console.err("stopLoader | An error occurred - message : " + err.message);
    }
}