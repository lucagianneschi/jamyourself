<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
?>
<div class="bg-double">	
		<div id='scroll-profile' class='hcento' style="width: 50%;float: left;">						
			<div id="profile" style="max-width:500px; float:right" class="row">
					<div class="large-12 columns">
						<div id='box-userinfo'>
							<?php require_once(VIEWS_DIR . "content/profile/box/box-userinfo.php"); ?>
						</div>
						
						<div id='box-information' >
							<?php require_once(VIEWS_DIR . "content/profile/box/box-information.php"); ?>
						</div>
						
						<div id="box-record"></div>
						<script type="text/javascript">
							function loadBoxRecord() {
								var json_data = {};
								json_data.objectId = '<?php echo $user->getObjectId(); ?>';
								$.ajax({
									type: "POST",
									url: "content/profile/box/box-record.php",
									data: json_data,
									beforeSend: function(xhr) {
										//spinner.show();
										console.log('Sono partito box-record');
									}
								}).done(function(message, status, xhr) {
									//spinner.hide();
									$("#box-record").html(message);
									code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
									console.log("Code: " + code + " | Message: <omitted because too large>");
								}).fail(function(xhr) {
									//spinner.hide();
									console.log("Error: " + $.parseJSON(xhr));
									//message = $.parseJSON(xhr.responseText).status;
									//code = xhr.status;
									//console.log("Code: " + code + " | Message: " + message);
								});
							}
						</script>
						
						<div id='box-event' ></div>	
						<div id='box-friends'></div>	
						<div id='box-following' ></div>	
						<div id='box-album' ></div>
				</div>
			</div>
		</div>
		<div id='scroll-social' class='hcento' style="width: 50%;float: right;">
			<div id="social" style="max-width:500px; float:left" class="row">
					<div class="large-12 columns">
						<div id='box-status' ></div>
						<div id="box-RecordReview"></div>	
						<div id="box-EventReview"></div>	
						<div id="box-activity"></div>
						<div id="box-collaboration"></div>
						<div id="box-followers"></div>
						<div id="box-post"></div>
				</div>			
			</div>
		</div>	
	</div>		
</div>
