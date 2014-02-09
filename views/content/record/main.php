<div class="bg-double">	
    <div id='scroll-profile' class='hcento' style="width: 50%;float: left;">						
	<div id="profile" style="width:100%; max-width:500px; float:right">
	    <div class="row">
		<div class="large-12 columns">

		    <div id='box-userinfo'>
			<?php require_once(VIEWS_DIR . "content/record/box/box-classinfo.php"); ?>
		    </div>

		    <div id='box-information'>
			<?php require_once(VIEWS_DIR . "content/record/box/box-information.php"); ?>
		    </div>
		    <div id="box-record"></div>
		    <script type="text/javascript">
			function loadBoxRecord() {
			    var json_data = {};
			    json_data.objectId = '<?php echo $objectId; ?>';
			    json_data.userId = '<?php echo $fromUserObjectId ?>';
			    $.ajax({
				type: "POST",
				url: "content/record/box/box-record.php",
				data: json_data,
				beforeSend: function(xhr) {
				    //spinner.show();
				    console.log('Sono partito loadBoxRecord()');
				    goSpinnerBox('#box-record', 'media Record');
				}
			    }).done(function(message, status, xhr) {
				//spinner.hide();
				$("#box-record").html(message);
				code = xhr.status;
				//console.log("Code: " + code + " | Message: " + message);
				console.log("Code: " + code + " | Message: <omitted because too large>");
			    }).fail(function(xhr) {
				//spinner.hide();
				message = $.parseJSON(xhr.responseText).status;
				code = xhr.status;
				console.log("Code: " + code + " | Message: " + message);
			    });
			}
		    </script>

		</div>
	    </div>
	</div>
    </div>
    <div id='scroll-social' class='hcento' style="width: 50%;float: right;">
	<div id="social" style="width:100%; max-width:500px; float:left">
	    <div class="row">
		<div class="large-12 columns">

		    <div id='box-status'>
			<?php require_once(VIEWS_DIR . "content/record/box/box-status.php"); ?>
		    </div>

		    <div id="box-recordReview"></div>
		    <script type="text/javascript">
			function loadBoxRecordReview(limit, skip) {
			    var json_data = {};
			    json_data.objectId = '<?php echo $objectId; ?>';
			    json_data.limit = limit;
			    json_data.skip = skip;
			    $.ajax({
				type: "POST",
				url: "content/record/box/box-recordReview.php",
				data: json_data,
				beforeSend: function(xhr) {
				    //spinner.show();
				    console.log('Sono partito loadBoxRecordReview(' + limit + ', ' + skip + ')');
				    goSpinnerBox('#box-recordReview', 'media RecordReview');
				}
			    }).done(function(message, status, xhr) {
				//spinner.hide();
				$("#box-recordReview").html(message);
				code = xhr.status;
				//console.log("Code: " + code + " | Message: " + message);
				console.log("Code: " + code + " | Message: <omitted because too large>");
			    }).fail(function(xhr) {
				//spinner.hide();
				message = $.parseJSON(xhr.responseText).status;
				code = xhr.status;
				console.log("Code: " + code + " | Message: " + message);
			    });
			}
		    </script>

		    <div id="box-comment"></div>
		    <script type="text/javascript">
			function loadBoxComment(limit, skip) {
			    var json_data = {};
			    json_data.objectId = '<?php echo $objectId; ?>';
			    json_data.fromUserObjectId = '<?php echo $record->getFromUser()->getObjectId(); ?>';
			    json_data.limit = limit;
			    json_data.skip = skip;
			    $.ajax({
				type: "POST",
				url: "content/record/box/box-comment.php",
				data: json_data,
				beforeSend: function(xhr) {
				    //spinner.show();
				    console.log('Sono partito loadBoxComment(' + limit + ', ' + skip + ')');
				    goSpinnerBox('#box-comment', 'media Comment');
				}
			    })
				    .done(function(message, status, xhr) {
				//spinner.hide();
				$("#box-comment").html(message);
				code = xhr.status;
				//console.log("Code: " + code + " | Message: " + message);
				console.log("Code: " + code + " | Message: <omitted because too large>");
			    })
				    .fail(function(xhr) {
				//spinner.hide();
				console.log('ERRORE=>' + richiesta + ' ' + stato + ' ' + errori);
				message = $.parseJSON(xhr.responseText).status;
				code = xhr.status;
				console.log("Code: " + code + " | Message: " + message);
			    });
			}

		    </script>
		    <script type="text/javascript">
			function loadBoxOpinion(objectId, toUser, classBox, box, limit, skip) {

			    if ($(box).hasClass('no-display')) {

				var json_data = {};
				json_data.objectId = objectId;
				json_data.toUser = toUser;
				json_data.classBox = classBox;
				json_data.box = box;
				json_data.limit = limit;
				json_data.skip = skip;
				$.ajax({
				    type: "POST",
				    url: "content/record/box/box-opinion.php",
				    data: json_data,
				    beforeSend: function(xhr) {
					//spinner.show();
					console.log('Sono partito loadBoxOpinion(' + objectId + ', ' + toUser + ', ' + classBox + ', ' + box + ', ' + limit + ', ' + skip + ')');
				    }
				})
					.done(function(message, status, xhr) {
				    //spinner.hide();
				    $(box).html(message);
				    $(box).prev().addClass('box-commentSpace');
				    $(box).removeClass('no-display');
				    code = xhr.status;
				    //console.log("Code: " + code + " | Message: " + message);
				    console.log("Code: " + code + " | Message: <omitted because too large>");
				})
					.fail(function(xhr) {
				    //spinner.hide();
				    //console.log('ERRORE=>'+richiesta+' '+stato+' '+errori);
				    message = $.parseJSON(xhr.responseText).status;
				    code = xhr.status;
				    console.log("Code: " + code + " | Message: " + message);
				});
			    } else {
				$(box).prev().removeClass('box-commentSpace');
				$(box).addClass('no-display');
			    }
			}
		    </script>
		</div>
	    </div>			
	</div>
    </div>	
</div>		
</div>