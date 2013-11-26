<div class="bg-double">	
		<div id='scroll-profile' class='hcento' style="width: 50%;float: left;">						
			<div id="profile" style="width:100%; max-width:500px; float:right">
				<div class="row">
					<div class="large-12 columns">
						<div id='box-userinfo'></div>	
						<div id='box-information' ></div>
						<div id="box-record"></div>
					</div>
				</div>
			</div>
		</div>
		<div id='scroll-social' class='hcento' style="width: 50%;float: right;">
			<div id="social" style="width:100%; max-width:500px; float:left">
				<div class="row">
					<div class="large-12 columns">
						<div id='box-status' ></div>
						<div id="box-RecordReview"></div>	
						<div id="box-EventReview"></div>	
						<div id="box-commentMedia"></div>
						<script type="text/javascript">
							var json_data = {};
							json_data.eventObjectId = '<?php echo $eventObjectId; ?>';
							json_data.limit = 5;
							json_data.skip = 1;
							$.ajax({
								type: "POST",
								url: "content/event/box-social/box-comment.php",
								data: json_data,
								beforeSend: function(xhr) {
									//spinner.show();
									console.log('Sono partito');
								},
								success: function(data, status) {
									//spinner.hide();
									$("#box-commentMedia").html(data);
								},
								error: function(richiesta, stato, errori) {
									//spinner.hide();
									console.log('ERRORE=>'+richiesta+' '+stato+' '+errori);
								}
							});
						</script>
					</div>
				</div>			
			</div>
		</div>	
	</div>		
</div>