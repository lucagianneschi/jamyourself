function love(_this, classType, id, idUser) {
    var json_love = {};
    typeOpt = $(_this).text();
    switch (typeOpt) {
	case 'Love':
	    json_love.request = "incrementLove";
	    break;
	case 'Unlove':
	    json_love.request = "decrementLove";
	    break;
    }
    json_love.classType = classType;
    json_love.id = id;
    json_love.idUser = idUser;

    $.ajax({
        type: "POST",
        url: "../../../controllers/request/loveRequest.php",
        data: json_love
    })
    .done(function(response, status, xhr) {
        number_love = $.parseJSON(xhr.responseText).status;
        if (typeOpt == 'Love') {
            parent = $(_this).parent().parent();
            objectLove = $(parent).find("a._unlove");
            $(objectLove).toggleClass('orange grey');
            $(objectLove).text(number_love);
            $(objectLove).toggleClass('_love _unlove');
            $(_this).text('Unlove');
        } else {
            parent = $(_this).parent().parent();
            objectLove = $(parent).find("a._love");
            $(objectLove).toggleClass('grey orange');
            $(objectLove).text(number_love);
            $(objectLove).toggleClass('_unlove _love');
            $(_this).text('Love');
        }
        code = xhr.status;
        console.log("Code: " + code + " | Message: " + number_love);
        })
    .fail(function(xhr) {
        message = $.parseJSON(xhr.responseText).status;
        code = xhr.status;
        console.log("Code: " + code + " | Message: " + message);
    });
}