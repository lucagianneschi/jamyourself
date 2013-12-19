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

function getCompleteLocationInfo(json) {
    try {
        var info = {};
        info.latitude = 0;
        info.longitude = 0;
        info.number = null;
        info.address = null;
        info.city = null;
        info.province = null;
        info.region = null;
        info.country = null;
        info.formattedAddress = null;
        if (json !== undefined && json !== null) {
            if (json.address_components !== undefined && json.address_components !== null && json.address_components.length > 0) {
                json.address_components.forEach(function(address_component) {
                    if (address_component.types !== undefined && address_component.types !== null && address_component.types.length > 0 && $.inArray("street_number", address_component.types) !== -1) {
                        info.number = address_component.long_name;
                    } else if (address_component.types !== undefined && address_component.types !== null && address_component.types.length > 0 && $.inArray("route", address_component.types) !== -1) {
                        info.address = address_component.long_name;
                    } else if (address_component.types !== undefined && address_component.types !== null && address_component.types.length > 0 && $.inArray("locality", address_component.types) !== -1) {
                        info.city = address_component.long_name;
                    } else if (address_component.types !== undefined && address_component.types !== null && address_component.types.length > 0 && $.inArray("administrative_area_level_1", address_component.types) !== -1) {
                        info.region = address_component.long_name;
                    } else if (address_component.types !== undefined && address_component.types !== null && address_component.types.length > 0 && $.inArray("administrative_area_level_2", address_component.types) !== -1) {
                        info.province = address_component.long_name;
                    } else if (address_component.types !== undefined && address_component.types !== null && address_component.types.length > 0 && $.inArray("country", address_component.types) !== -1) {
                        info.country = address_component.long_name;
                    }
                });
            }

            if (json.formatted_address !== undefined && json.formatted_address !== null && json.formatted_address.length > 0) {
                info.formattedAddress = json.formatted_address;
            }

            if (json.latitude !== undefined && json.latitude !== null && json.longitude !== undefined && json.longitude !== null) {
                info.latitude = json.latitude;
                info.longitude = json.longitude;
            }
        }

        return info;
    } catch (err) {
        window.console.error("getCompleteLocationInfo | An error occurred - message : " + err.message);
    }
}
