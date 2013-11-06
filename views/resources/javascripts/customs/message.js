function sendMessage(toUser, message, title) {
    var json_message = {};
    json_message.toUser = toUser;
    json_message.message = message;
    json_message.title = title;
    json_message.request = 'message';

    $.ajax({
        type: "POST",
        url: "../../../controllers/request/messageRequest.php",
        data: json_message,
        beforeSend: function() {
            //aggiungere il caricamento del bottone
        }
    })//ADATTARE AL MESSAGE
            .done(function(message, status, xhr) {
                callBox.objectId = objectId;
                callBox.classBox = classType;
                callBox.load('comment');
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + message);
            })
            .fail(function(xhr) {
                //mostra errore
                message = $.parseJSON(xhr.responseText).status;
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + message);
            });
}

function readMessage(activityId) {
    var json_message = {};
    json_message.activityId = activityId;
    $.ajax({
        type: "POST",
        url: "../../../controllers/request/messageRequest.php",
        data: json_message
    }) //ADATTARE AL MESSAGE
            .done(function(message, status, xhr) {
                callBox.objectId = objectId;
                callBox.classBox = classType;
                callBox.load('comment');
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + message);
            })
            .fail(function(xhr) {
                //mostra errore
                message = $.parseJSON(xhr.responseText).status;
                code = xhr.status;
                console.log("Code: " + code + " | Message: " + message);
            });
}