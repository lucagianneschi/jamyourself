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
<title>Il titolo della pagina</title>
<!-- meta name="description" content="La descrizione della pagina" / -->
<meta property="og:title" content="El titulo" />
<meta property="og:description" content="La Descricion" />
<meta property="og:image" content="http://www.scoutadventure.org/img/sa/intro.png" />
</head>
<body>
Cliccando i bottoni seguenti si incrementa e decrementa il campo loveCounter delle classi che possono aveve azioni di love e unlove<br />
<br />
<button type="button" onclick="love('Album', 'cjqaTR1kQW', 'increment')">Increment Love Album cjqaTR1kQW</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="button" onclick="love('Album', 'cjqaTR1kQW', 'decrement')">Decrement Love Album cjqaTR1kQW</button>
&nbsp;<hr>
<button type="button" onclick="love('Comment', 'rEJJMsGCTo', 'increment')">Increment Love Comment rEJJMsGCTo</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="button" onclick="love('Comment', 'rEJJMsGCTo', 'decrement')">Decrement Love Comment rEJJMsGCTo</button>
&nbsp;<hr>
<button type="button" onclick="love('Event', 'OXi0VJUoao', 'increment')">Increment Love Event OXi0VJUoao</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="button" onclick="love('Event', 'OXi0VJUoao', 'decrement')">Decrement Love Event OXi0VJUoao</button>
&nbsp;<hr>
<button type="button" onclick="love('Image', 'gdZowTbFRk', 'increment')">Increment Love Image gdZowTbFRk</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="button" onclick="love('Image', 'gdZowTbFRk', 'decrement')">Decrement Love Image gdZowTbFRk</button>
&nbsp;<hr>
<button type="button" onclick="love('Record', 'Xbu7rDWqpj', 'increment')">Increment Love Record Xbu7rDWqpj</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="button" onclick="love('Record', 'Xbu7rDWqpj', 'decrement')">Decrement Love Record Xbu7rDWqpj</button>
&nbsp;<hr>
<button type="button" onclick="love('Song', 'j0AM1J4YIR', 'increment')">Increment Love Song j0AM1J4YIR</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="button" onclick="love('Song', 'j0AM1J4YIR', 'decrement')">Decrement Love Song j0AM1J4YIR</button>
&nbsp;<hr>
<button type="button" onclick="love('Status', '4byv8FeP7S', 'increment')">Increment Love Status 4byv8FeP7S</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="button" onclick="love('Status', '4byv8FeP7S', 'decrement')">Decrement Love Status 4byv8FeP7S</button>
&nbsp;<hr>
<button type="button" onclick="love('Video', 'ihcPvm6BIv', 'increment')">Increment Love Video ihcPvm6BIv</button>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button type="button" onclick="love('Video', 'ihcPvm6BIv', 'decrement')">Decrement Love Video ihcPvm6BIv</button>
<hr>

<!-- AddThis Button BEGIN -->
<!-- div class="addthis_toolbox addthis_default_style addthis_32x32_style" addThis:url="http://www.scoutadventure.org/page.php?id=1" -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_facebook"></a>
<a class="addthis_button_twitter"></a>
<a class="addthis_button_google_plusone_share"></a>
</div>
<script type="text/javascript">
	var addthis_config = {
		"data_track_addressbar":true
	};
	var addthis_share = {
		url_transforms : {
			shorten: {
				twitter: 'bitly'
			}
		}, 
		shorteners : {
			bitly : {}
		}
	}
</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-522dd258579a55ca"></script>
<!-- AddThis Button END -->

addThis:url funziona e addThis:title/description non funzionano per Facebook. Fb si preoccupa di cercare tutti i tag "img" per creare delle miniature, oppure gli si possono forzare via header di pagina.
Con Open Graph protocol è possibile istruire Fb su tutte le istruzioni che vogliamo.<br />
addThis:url/title funzionano e addThis:description non funzionano per Twitter.<br />
addThis:url funziona e addThis:title/description non funzionano per Google+. Le immagini e certe modifiche su G+ devono essere digerite dal sistema. Qui c'è una guida: https://developers.google.com/+/web/+1button/?hl=it#plus-snippet<br />

</body>
</html>