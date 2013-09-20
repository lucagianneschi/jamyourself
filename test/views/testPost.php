<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
function post(fromUser, toUser) {
	
	var json_post = {};
	json_post.request = "post";
	json_post.fromUser = fromUser;
	json_post.toUser = toUser;
	json_post.text = document.getElementById("testo").value;
	
	$.ajax({
		type:         "POST",
		url:          "../../controllers/post/postRequest.php",
		data:         json_post,
		async:        false,
		"beforeSend": function(xhr) {
			xhr.setRequestHeader("X-AjaxRequest", "1");
		},
		success: function(data, status) {
			alert("[onLoad] [SUCCESS] Status: [" + status + "] " + data);
		},
		error: function(data, status) {
			alert("[onLoad] [ERROR] Status: [" + status + "] " + data);
			console.log("[onLoad] [ERROR] Status: " + status + " " + data);
		}
	});
}
</script>
</head>
<body>

<textarea id="testo"></textarea>
<br />
<button type="button" onclick="post('GuUAj83MGH', 'GuUAj83MGH')">Invia Post*</button>
<br />
* = cosi' facendo si invia un Post con FromUser e toUser settato a "GuUAj83MGH"

</body>
</html>