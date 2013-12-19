<!DOCTYPE html>
<html>
    <head>
        <title>$.geocomplete()</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="styles.css" />
    </head>
    <body>

        <form>
            <input id="geocomplete" type="text" placeholder="Type in an address" size="90" />
        </form>
        <div id="logger">Log:</div>

        <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

        <script src="jquery.geocomplete.js"></script>

        <script>
            $(function() {

                $("#geocomplete").geocomplete()
                        .bind("geocode:result", function(event, result) {
//                    $("#logger").html(JSON.stringify(result));
                        var data = {"location" : {} };
                        data.location.address_components = result.address_components;
                        data.location.latitude = result.geometry.location.nb;
                        data.location.longitude = result.geometry.location.ob;
                        data.location.formatted_address = result.formatted_address;
                        sendRequest("geo.php",data,true,callback);
                })
                        .bind("geocode:error", function(event, status) {
                    $.log("ERROR: " + status);
                })
                        .bind("geocode:multiple", function(event, results) {
                });

            });
            
            function callback(data, status, xhr){
                window.console.log(data);
            }


            function sendRequest(_server, _data, _callback, _async) {
                try {
                    if (_server !== undefined && _server !== null) {
                        var url = _server;
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
        </script>
    </body>
</html>

