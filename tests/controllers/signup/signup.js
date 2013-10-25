function signupCallback(data, status) {
    console.debug("Data : " + JSON.stringify(data) + " | Status: " + status);
    $("#log").html("Data : " + JSON.stringify(data) + " | Status: " + status);
}

function sendRequest(_action, _data, callback, _async) {
    if (_action === undefined || _action === null || _data === undefined || _data === null) {
        callback(null);
    }
    _data.request = _action;
    var url = "../../../controllers/request/signupRequest.php";
    var type = "POST";
    var async = true;
    if (async !== undefined && async !== null)
        async = _async;

    $.ajax({
        type: type,
        url: url,
        data: _data,
        async: async,
        success: function(data, status) {
            //gestione success
            callback(data, status);
        },
        error: function(data, status) {
            callback(data, status);
        }
    });
}

function spotter() {
    $.getJSON("spotter.json", function(json) {
        json.username = json.username + getRandomInt();
        var arrMail = json.email.split("@");
        json.email = arrMail[0] + getRandomInt() + "@" + arrMail[1];
        console.log("Caricato : \n " + json);
        console.debug(json);
        sendRequest("signup", json, signupCallback, true);
    });
}
function venue() {
    $.getJSON("venue.json", function(json) {
        json.username = json.username + getRandomInt();
        var arrMail = json.email.split("@");
        json.email = arrMail[0] + getRandomInt() + "@" + arrMail[1];
        console.log("Caricato : \n " + json);
        console.debug(json);
        sendRequest("signup", json, signupCallback, true);
    });

}
function jartist() {
    $.getJSON("jammer_artist.json", function(json) {
        json.username = json.username + getRandomInt();
        var arrMail = json.email.split("@");
        json.email = arrMail[0] + getRandomInt() + "@" + arrMail[1];
        console.log("Caricato : \n " + json);
        console.debug(json);
        sendRequest("signup", json, signupCallback, true);
    });

}
function jband() {
    $.getJSON("jammer_band.json", function(json) {
        json.username = json.username + getRandomInt();
        var arrMail = json.email.split("@");
        json.email = arrMail[0] + getRandomInt() + "@" + arrMail[1];
        console.log("Caricato : \n " + json);
        console.debug(json);
        sendRequest("signup", json, signupCallback, true);
    });

}

function getRandomInt() {
    var min = 0;
    var max = 100000;
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function checkEmailExists() {
    var json_email = {};
    json_email.email = $("#email").val(); //recupero il valore della email o lo passo come parametro

    console.log("[checkEmailExists] email :" + $("#email").val());

    sendRequest("checkEmailExists", json_email, signupCallback, true);


}

function checkUsernameExists() {
    var json_username = {};
    json_username.username = $("#username").val(); //recupero il valore della email o lo passo come parametro
    console.log("[checkUsernameExists] username :" + $("#username").val());

    sendRequest("checkUsernameExists", json_username, signupCallback, true);

}