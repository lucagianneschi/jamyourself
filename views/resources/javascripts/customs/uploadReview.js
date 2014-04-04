$(document).ready(function() {
    var json_upload_review = {"rating": 3, "review": ""};

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

    function publihsCallback(data, status, xhr) {
	try {
	    if (status === "success" && data !== undefined && data !== null && data.id !== undefined && data.id !== null) {
		alert(data.status);
		switch (json_upload_review.type) {
		    case  "Record" :
			redirect("record.php?record=" + data.id);
			break;
		    case "Event":
			redirect("event.php?event=" + data.id);
			break;
		}
	    } else {
		location.reload();
	    }
	} catch (err) {
	    console.log("publihsCallback | An error occurred - message : " + err.message);
	}
    }

    $("#button_publish").click(function() {
	try {
	    json_upload_review.review = $("textarea").val();
	    json_upload_review.reviewedId = $("#reviewedId").val();
	    json_upload_review.type = $("#type").val();
	    console.log(JSON.stringify(json_upload_review));
	    sendRequest("uploadReview", "publish", json_upload_review, publihsCallback, true);
	} catch (err) {
	    console.log("button_publish.click | An error occurred - message : " + err.message);
	}
    });


    $('#example-f').barrating({showSelectedRating: false});
});