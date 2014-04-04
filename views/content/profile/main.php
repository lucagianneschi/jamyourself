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
			var countLoadBoxRecord = 0;
		    function loadBoxRecord() {
			var json_data = {};
			json_data.id = '<?php echo $user->getId(); ?>';
			json_data.username = '<?php echo $user->getUsername(); ?>';
			$.ajax({
			    type: "POST",
			    url: "content/profile/box/box-record.php",
			    data: json_data,
			    
			    timeout:5000,
			    beforeSend: function(xhr) {
					goSpinnerBox('#box-record', 'record');
			    }
			}).done(function(message, status, xhr) {
			    $("#box-record").html(message);
			    //plugin scorrimento box
			    rsi_record = slideReview('recordSlide');
			    //plugin share
			    addthis.init();
			    addthis.toolbox(".addthis_toolbox");
			    //adatta pagina per scroll
			    hcento();
			    code = xhr.status;
			    console.log("Code: " + code + " | Message: box-record successfully completed");
			}).fail(function(xhr) {
			    message = xhr.statusText;
				code = xhr.status;
				if(message == 'timeout' && countLoadBoxRecord < 3){
					countLoadBoxRecord++;
					window.setTimeout("loadBoxRecord()", Math.floor((Math.random()*2000)+100));					
				}
				else 
				console.log("Error box-record. Code: " + code + " | Message: " + message);		    
			});
		    }
		</script>

		<?php
		if ($user->getType() == 'JAMMER' || $user->getType() == 'VENUE') {
		    ?>
    		<div id='box-event'></div>
    		<script type="text/javascript">
    			var countLoadBoxEvent = 0;
    		    function loadBoxEvent() {
    			var json_data = {typeUser: '<?php echo $type ?>'};
    			json_data.id = '<?php echo $user->getId(); ?>';
    			$.ajax({
    			    type: "POST",
    			    url: "content/profile/box/box-event.php",
    			    data: json_data,
    			    
    			    timeout:5000,
    			    beforeSend: function(xhr) {
    					goSpinnerBox('#box-event', 'event');
    			    }
    			}).done(function(message, status, xhr) {
    			    $("#box-event").html(message);
    			    //plugin scorrimento box
    			    rsi_event = slideReview('eventSlide');
    			    //adatta pagina per scroll
    			    hcento();
    			    code = xhr.status;
    			    console.log("Code: " + code + " | Message: box-event successfully completed");
    			}).fail(function(xhr) {
    			    message = xhr.statusText;
					code = xhr.status;
					if(message == 'timeout' && countLoadBoxEvent < 3){
						countLoadBoxEvent++;
						window.setTimeout("loadBoxEvent()", Math.floor((Math.random()*2000)+100));							
					}
					else 
					console.log("Error box-event. Code: " + code + " | Message: " + message);
    			});
    		    }
    		</script>
		    <?php
		}
		?>

		<?php
		if ($user->getType() == 'SPOTTER') {
		    ?>
    		<div id='box-friends'></div>
    		<script type="text/javascript">
    			var countLoadBoxFriends = 0;
    		    function loadBoxFriends() {
    			var json_data = {};
    			json_data.id = '<?php echo $user->getId(); ?>';
    			json_data.friendshipCounter = '<?php echo $user->getFriendshipCounter(); ?>';
    			$.ajax({
    			    type: "POST",
    			    url: "content/profile/box/box-friends.php",
    			    data: json_data,
    			    
    			    timeout:5000,
    			    beforeSend: function(xhr) {
    					goSpinnerBox('#box-friends', 'friends');
    			    }
    			}).done(function(message, status, xhr) {
    			    $("#box-friends").html(message);
    			    code = xhr.status;
    			    console.log("Code: " + code + " | Message: box-friends successfully completed");
    			}).fail(function(xhr) {
    			    message = xhr.statusText;
					code = xhr.status;
					if(message == 'timeout' && countLoadBoxFriends < 3){
						countLoadBoxFriends++;
						window.setTimeout("loadBoxFriends()", Math.floor((Math.random()*2000)+100));	
					}
					else 
					console.log("Error box-friends. Code: " + code + " | Message: " + message);
    			});
    		    }
    		</script>

    		<div id='box-following' ></div>	
    		<script type="text/javascript">
    		var countLoadBoxFollowing = 0;
    		    function loadBoxFollowing() {
    			var json_data = {};
    			json_data.id = '<?php echo $user->getId(); ?>';
    			json_data.followingCounter = '<?php echo $user->getFollowingCounter(); ?>';
    			$.ajax({
    			    type: "POST",
    			    url: "content/profile/box/box-following.php",
    			    data: json_data,
    			    
    			    timeout:5000,
    			    beforeSend: function(xhr) {
    					goSpinnerBox('#box-following', 'following');
    			    }
    			}).done(function(message, status, xhr) {
    			    $("#box-following").html(message);
    			    code = xhr.status;
    			    console.log("Code: " + code + " | Message: box-following successfully completed");
    			}).fail(function(xhr) {
    			    message = xhr.statusText;
					code = xhr.status;
					if(message == 'timeout' && countLoadBoxFollowing < 3){
						countLoadBoxFollowing++;
						window.setTimeout("loadBoxFollowing()", Math.floor((Math.random()*2000)+100));	
					}
					else 
					console.log("Error box-following. Code: " + code + " | Message: " + message);
    			});
    		    }
    		</script>
		    <?php
		}
		?>

		<div id='box-album'></div>
		<script type="text/javascript">
		var countLoadBoxAlbum = 0;
		    function loadBoxAlbum() {
			var json_data = {objectIdUser: '<?php echo $user->getId() ?>'};
			json_data.id = '<?php echo $user->getId(); ?>';
			$.ajax({
			    type: "POST",
			    url: "content/profile/box/box-album.php",
			    data: json_data,
			    
			    timeout:5000,
			    beforeSend: function(xhr) {
					goSpinnerBox('#box-album', 'album');
			    }
			}).done(function(message, status, xhr) {
			    $("#box-album").html(message);
			    rsi_album = slideReview('albumSlide');
			    code = xhr.status;
			    console.log("Code: " + code + " | Message: box-album successfully completed");
			}).fail(function(xhr) {
			    message = xhr.statusText;
					code = xhr.status;
					if(message == 'timeout' && countLoadBoxAlbum < 3){
						countLoadBoxAlbum++;
						window.setTimeout("loadBoxAlbum()", Math.floor((Math.random()*2000)+100));	
					}
					else 
					console.log("Error box-album. Code: " + code + " | Message: " + message);
			});
		    }
		</script>
	    </div>
	</div>
    </div>
    <div id='scroll-social' class='hcento' style="width: 50%;float: right;">
	<div id="social" style="max-width:500px; float:left" class="row">
	    <div class="large-12 columns">
		<div id='box-status'>
		    <?php require_once(VIEWS_DIR . "content/profile/box/box-status.php"); ?>
		</div>

		<div id="box-recordReview"></div>	
		<script type="text/javascript">
		var countLoadBoxReview = 0;
		    function loadBoxRecordReview() {
			var json_data = {};
			json_data.id = '<?php echo $user->getId(); ?>';
			json_data.type = '<?php echo $user->getType(); ?>';
			$.ajax({
			    type: "POST",
			    url: "content/profile/box/box-recordReview.php",
			    data: json_data,
			    
			    timeout:5000,
			    beforeSend: function(xhr) {
					goSpinnerBox('#box-recordReview', 'recordReview');
			    }
			}).done(function(message, status, xhr) {
			    $("#box-recordReview").html(message);
			    rsi_recordReview = slideReview('recordReviewSlide');
			    addthis.init();
			    addthis.toolbox(".addthis_toolbox");
			    hcento();
			    code = xhr.status;
			    console.log("Code: " + code + " | Message: box-recordReview successfully completed");
			}).fail(function(xhr) {
			    message = xhr.statusText;
					code = xhr.status;
					if(message == 'timeout' && countLoadBoxReview < 3){
						countLoadBoxReview++;
						window.setTimeout("loadBoxRecordReview()", Math.floor((Math.random()*2000)+100));	
					}
					else 
					console.log("Error box-recordReview. Code: " + code + " | Message: " + message);
			});
		    }
		</script>

		<div id="box-eventReview"></div>
		<script type="text/javascript">
		var countLoadBoxEventReview = 0;
		    function loadBoxEventReview() {
			var json_data = {};
			json_data.id = '<?php echo $user->getId(); ?>';
			json_data.type = '<?php echo $user->getType(); ?>';
			$.ajax({
			    type: "POST",
			    url: "content/profile/box/box-eventReview.php",
			    data: json_data,
			    
			    timeout:5000,
			    beforeSend: function(xhr) {
					goSpinnerBox('#box-eventReview', 'EventReview');
			    }
			}).done(function(message, status, xhr) {
			    $("#box-eventReview").html(message);
			    rsi_eventReview = slideReview('eventReviewSlide');
			    addthis.init();
			    addthis.toolbox(".addthis_toolbox");
			    hcento();
			    code = xhr.status;
			    console.log("Code: " + code + " | Message: box-eventReview successfully completed");
			}).fail(function(xhr) {
			    message = xhr.statusText;
					code = xhr.status;
					if(message == 'timeout' && countLoadBoxEventReview < 3){
						countLoadBoxEventReview++;
						window.setTimeout("loadBoxEventReview()", Math.floor((Math.random()*2000)+100));	
					}
					else 
					console.log("Error box-eventReview. Code: " + code + " | Message: " + message);
			});
		    }
		</script>

		<div id="box-activity"></div>
		<script type="text/javascript">
		var countLoadBoxActivity = 0;
		    function loadBoxActivity() {
			var json_data = {};
			json_data.id = '<?php echo $user->getId(); ?>';
			json_data.type = '<?php echo $user->getType(); ?>';
			$.ajax({
			    type: "POST",
			    url: "content/profile/box/box-activity.php",
			    data: json_data,
			    
			    timeout:5000,
			    beforeSend: function(xhr) {
					goSpinnerBox('#box-activity', 'activity');
			    }
			}).done(function(message, status, xhr) {
			    $("#box-activity").html(message);
			    code = xhr.status;
			    console.log("Code: " + code + " | Message: box-activity successfully completed");
			}).fail(function(xhr) {
			    message = xhr.statusText;
					code = xhr.status;
					if(message == 'timeout' && countLoadBoxActivity < 3){
						countLoadBoxActivity++;
						window.setTimeout("loadBoxActivity()", Math.floor((Math.random()*2000)+100));	
					}
					else 
					console.log("Error box-activity. Code: " + code + " | Message: " + message);
			});
		    }
		</script>

		<?php
		if ($user->getType() == 'JAMMER' || $user->getType() == 'VENUE') {
		    ?>
    		<div id="box-collaboration"></div>
    		<script type="text/javascript">
    		var countLoadBoxCollaboration = 0;
    		    function loadBoxCollaboration() {
    			var json_data = {};
    			json_data.id = '<?php echo $user->getId(); ?>';
    			json_data.collaborationcounter = '<?php echo $user->getCollaborationcounter() ?>';
    			$.ajax({
    			    type: "POST",
    			    url: "content/profile/box/box-collaboration.php",
    			    data: json_data,
    			    
    			    timeout:5000,
    			    beforeSend: function(xhr) {
    					goSpinnerBox('#box-collaboration', 'collaboration');
    			    }
    			}).done(function(message, status, xhr) {
    			    $("#box-collaboration").html(message);
    			    code = xhr.status;
    			    console.log("Code: " + code + " | Message: box-collaboration successfully completed");
    			}).fail(function(xhr) {
    			    message = xhr.statusText;
					code = xhr.status;
					if(message == 'timeout' && countLoadBoxCollaboration < 3){
						countLoadBoxCollaboration++;
						window.setTimeout("loadBoxCollaboration()", Math.floor((Math.random()*2000)+100));	
					}
					else 
					console.log("Error box-collaboration. Code: " + code + " | Message: " + message);
    			});
    		    }
    		</script>

    		<div id="box-followers"></div>
    		<script type="text/javascript">
    		var countLoadBoxFollowers = 0;
    		    function loadBoxFollowers() {
    			var json_data = {};
    			json_data.id = '<?php echo $user->getId(); ?>';
    			json_data.type = '<?php echo $user->getType(); ?>';
    			json_data.followersCounter = '<?php echo $user->getFollowersCounter(); ?>';
    			$.ajax({
    			    type: "POST",
    			    url: "content/profile/box/box-followers.php",
    			    data: json_data,
    			    
    			    timeout:5000,
    			    beforeSend: function(xhr) {
    					goSpinnerBox('#box-followers', 'followers');
    			    }
    			}).done(function(message, status, xhr) {
    			    $("#box-followers").html(message);
    			    code = xhr.status;
    			    console.log("Code: " + code + " | Message: box-followers successfully completed");
    			}).fail(function(xhr) {
    			    message = xhr.statusText;
					code = xhr.status;
					if(message == 'timeout' && countLoadBoxFollowers < 3){
						countLoadBoxFollowers++;
						window.setTimeout("loadBoxFollowers()", Math.floor((Math.random()*2000)+100));	
					}
					else 
					console.log("Error box-followers. Code: " + code + " | Message: " + message);
    			});
    		    }
    		</script>
		    <?php
		}
		?>

		<div id="box-post"></div>
		<script type="text/javascript">
		var countLoadBoxPost = 0;
		    function loadBoxPost() {
			var json_data = {};
			json_data.id = '<?php echo $user->getId(); ?>';
			json_data.type = '<?php echo $user->getType(); ?>';
			$.ajax({
			    type: "POST",
			    url: "content/profile/box/box-post.php",
			    data: json_data,
			    
			    timeout:5000,
			    beforeSend: function(xhr) {
				goSpinnerBox('#box-post', 'post');
			    }
			}).done(function(message, status, xhr) {
			    $("#box-post").html(message);
			    code = xhr.status;
			    console.log("Code: " + code + " | Message: box-post successfully completed");
			}).fail(function(xhr) {
			    message = xhr.statusText;
				code = xhr.status;
				if(message == 'timeout' && countLoadBoxPost < 3){
						countLoadBoxPost++;
						window.setTimeout("loadBoxPost()", Math.floor((Math.random()*2000)+100));	
					}
					else 
				console.log("Error box-post. Code: " + code + " | Message: " + message);
			});
		    }
		</script>

		<script type="text/javascript">
		    function loadBoxOpinion(id, toUser, classBox, box, limit, skip) {
			if ($(box).hasClass('no-display')) {
			    var json_data = {};
			    json_data.id = id;
			    json_data.toUser = toUser;
			    json_data.classBox = classBox;
			    json_data.box = box;
			    json_data.limit = limit;
			    json_data.skip = skip;
			    $.ajax({
				type: "POST",
				url: "content/profile/box/box-opinion.php",
				data: json_data,
				
				timeout:5000,
				beforeSend: function(xhr) {								
				    goSpinnerBox(box, '');
				    console.log('Sono partito loadBoxOpinion(' + id + ', ' + toUser + ', ' + classBox + ', ' + box + ', ' + limit + ', ' + skip + ')');
				}
			    })
				.done(function(message, status, xhr) {
					$(box).html(message);
					$(box).prev().addClass('box-commentSpace');
					$(box).removeClass('no-display');
					if (classBox == 'Image') {
					    $("#cboxLoadedContent").mCustomScrollbar("update");
					    //	hcento();
					}
	
					code = xhr.status;
					console.log("Code: " + code + " | Message: box-opinion successfully completed");
			    })
				.fail(function(xhr) {
					console.log(xhr); message = xhr.statusText;
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
    <div id="box-relation">
	<div id="modalRelation" class="reveal-modal medium"></div>
    </div>
    <script type="text/javascript">
	//$id, 'following', '_User', false, $this->config->followings, 0
	function loadBoxRelation(relation, limit, skip, tot) {
	    var json_data = {};
	    json_data.id = '<?php echo $user->getId(); ?>';
	    json_data.relation = relation;
	    json_data.limit = limit;
	    json_data.skip = skip;
	    json_data.tot = tot;
	    $.ajax({
		type: "POST",
		url: "content/profile/box/box-relation.php",
		data: json_data,
		timeout:5000,
		
		beforeSend: function(xhr) {
		    $('#modalRelation').html('<div id="spinnerRelation"></div>');
		    goSpinner('#spinnerRelation')
		    $('#modalRelation').foundation('reveal', 'open');
		}
	    }).done(function(message, status, xhr) {
		stopSpinner('#spinnerRelation');
		$("#modalRelation").html(message);
		code = xhr.status;
		console.log("Code: " + code + " | Message: box-relation successfully completed");
	    }).fail(function(xhr) {
			message = xhr.statusText;
			code = xhr.status;
			console.log("Error box-relation. Code: " + code + " | Message: " + message);			
	    });
	}
    </script>	
</div>		
