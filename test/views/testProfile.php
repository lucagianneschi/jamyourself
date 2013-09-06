<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
function love(classType, objectId, opType) {
	
	var json_profile = {};
	if (opType == 'increment') {
		json_profile.request = "incrementLove";
	} else {
		json_profile.request = "decrementLove";
	}
	json_profile.classType = classType;
	json_profile.objectId = objectId;
	
	$.ajax({
		type:         "POST",
		url:          "../../controllers/profile/profileRequest.php",
		data:         json_profile,
		async:        false,
		"beforeSend": function(xhr) {
			xhr.setRequestHeader("X-AjaxRequest", "1");
		},
		success: function(data, status) {
			alert("[onLoad] [SUCCESS] Status: " + data);
			//console.log("[onLoad] [SUCCESS] Status: " + status + " " + data);
		},
		error: function(data, status) {
			alert("[onLoad] [ERROR] Status: " + data);
			//console.log("[onLoad] [ERROR] Status: " + status + " " + data);
		}
	});
}
</script>
</head>
<body>
Cliccando i bottoni seguenti si incrementa e decrementa il campo loveCounter dell'Image con objectId "gdZowTbFRk"<br />
<br />
<button type="button" onclick="love('Image', 'gdZowTbFRk', 'increment')">Increment Love</button>
&nbsp;
<button type="button" onclick="love('Image', 'gdZowTbFRk', 'decrement')">Decrement Love</button>
</body>
</html>