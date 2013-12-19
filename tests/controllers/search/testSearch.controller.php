<!DOCTYPE html>
<html>
  <head>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<script type="text/javascript">
	  function deleteObj(classType, objectId) {

		var json_delete = {};

		json_delete.classType = classType;
		json_delete.objectId = objectId;
		json_delete.request = 'deleteObj';

		$.ajax({
		  type: "POST",
		  url: "../../../controllers/request/deleteRequest.php",
		  data: json_delete,
		  async: false,
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
	<title>Test di ricerca tra le classi</title>
	<meta name="description" content="Test cancellazione istanze di classe" />
  </head>
  <body>
	Operazione di ricerca tra le classi<br />
	<br />
	<button type="button" onclick="deleteObj('Activity', 'kqtpmgTVp6')">Delete Activity kqtpmgTVp6 OK</button>
	&nbsp;
	<button type="button" onclick="deleteObj('Activity', 'npwAb03Y18')">Delete Activity npwAb03Y18 FAIL</button>
	&nbsp;<hr>
	<button type="button" onclick="deleteObj('Album', 'pSxpUEQ580')">Delete Album pSxpUEQ580 OK</button>
	&nbsp;
	<button type="button" onclick="deleteObj('Album', 'iH2oruHDLk')">Delete Album iH2oruHDLk FAIL</button>
	&nbsp;<hr>
	<button type="button" onclick="deleteObj('Comment', 'ZssN7t1iip')">Delete Comment ZssN7t1iip OK</button>
	&nbsp;
	<button type="button" onclick="deleteObj('Comment', 'pTWoTDoglH')">Delete Comment pTWoTDoglH FAIL</button>
	&nbsp;<hr>
	<button type="button" onclick="deleteObj('Event', 'JaERXoYiqm')">Delete Event JaERXoYiqm OK</button>
	&nbsp;
	<button type="button" onclick="deleteObj('Event', 'OXi0VJUoao')">Delete Event OXi0VJUoao FAIL</button>
	&nbsp;<hr>
	<button type="button" onclick="deleteObj('Image', 'gdZowTbFRk')">Delete Image gdZowTbFRk OK</button>
	&nbsp;
	<button type="button" onclick="deleteObj('Image', 'bFIHiXnKgf')">Delete Image bFIHiXnKgf FAIL</button>
	&nbsp;<hr>
	<button type="button" onclick="deleteObj('Playlist', '2mopUyVXXj')">Delete Playlist 2mopUyVXXj OK</button>
	&nbsp;
	<button type="button" onclick="deleteObj('Playlist', '5qppX3ATpJ')">Delete Playlist 5qppX3ATpJ FAIL</button>
	&nbsp;<hr>
	<button type="button" onclick="deleteObj('Record', 'Xbu7rDWqpj')">Delete Record Xbu7rDWqpj OK</button>
	&nbsp;
	<button type="button" onclick="deleteObj('Record', '4ezqor8VgO')">Delete Record 4ezqor8VgO FAIL</button>
	&nbsp;<hr>
	<button type="button" onclick="deleteObj('Song', 'j0AM1J4YIR')">Delete Song j0AM1J4YIR OK</button>
	&nbsp;
	<button type="button" onclick="deleteObj('Song', 'SdJx4roDEs')">Delete Song SdJx4roDEs FAIL</button>
	&nbsp;<hr>
	<button type="button" onclick="deleteObj('User', 'GuUAj83MGH')">Delete User --> RICORDATI di RIATTIVARE SPATAFORA!</button>
	&nbsp;<hr>
	<button type="button" onclick="deleteObj('Video', '8e1sj32BK2')">Delete Video 8e1sj32BK2 OK</button>
	&nbsp;
	<button type="button" onclick="deleteObj('Video', 'Rmuz47ux6F')">Delete Video Rmuz47ux6F FAIL</button>
	&nbsp;
	<hr>
  </body>
</html>