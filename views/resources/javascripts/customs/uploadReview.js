$(document).ready(function() {
    var json_upload_review = {"rating": 3, "review": "", "record":""};

    function sendRequest(_action, _data, callback, _async) {
        if (_action === undefined || _action === null || _data === undefined || _data === null) {
            callback(null);
        }
        _data.request = _action;
        var url = "../controllers/request/uploadReviewRequest.php";
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

    //gestione rating
    $("a[id^='star_rating_']").click(function() {
        // ^= indicates "starts with". Conversely, $= indicates "ends with".
        json_upload_review.rating = parseInt(this.id.charAt(this.id.length - 1));

        for (var i = 0; i <= json_upload_review.rating; i++) {
            $("#star_rating_" + i).attr("class", "icon-propriety _star-orange-big");
        }
        for (var j = 5; j > json_upload_review.rating; j--) {
            $("#star_rating_" + j).attr("class", "icon-propriety _star-grey-big");

        }
    });
    
    function publicCallback(data){
        window.console.log(data);
    }
    
    $("#button_publish").click(function() {
        json_upload_review.review = $("textarea").val();
        json_upload_review.record = $("#record_id").val();
        json_upload_review.type = $("#type").val();
        console.log(JSON.stringify(json_upload_review));
        sendRequest("publish", json_upload_review, publicCallback, true);
    });



});