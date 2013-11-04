<?php
/* box per gli album musicali
 * box chiamato tramite ajax con:
 * data: {currentUser: objectId},
 * data-type: html,
 * type: POST o GET
 *
 * box solo per jammer
 */

 if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'boxes/' . getLanguage() . '.boxes.lang.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';  
 
$data = $_POST['data'];
$typeUser = $_POST['typeUser'];
$recordCounter = $data['recordCounter'];
?>
<!----------------------------------------- PLAYER ALBUM ----------------------------------------------->
<div class="row" id="profile-Record">
	<div class="large-12 columns">
	<div class="row">
			<div  class="small-12 columns">
				<h3>Tracklist</h3>
			</div>	
			
		</div>	
	
	
	<!---------------------------- ALBUM SINGOLO --------------------------------------------->
	<?php //for($i=0; $i<$recordCounter;  $i++){ 
			$recordSingle_thumbnailCover = $data['record'.$i]['thumbnailCover'];
			$recordSingle_objectId = $data['record'.$i]['objectId'];
			$recordSingle_title = $data['record'.$i]['title'];
			$recordSingle_data = $data['record'.$i]['year'];
			$recordSinle_songCounter= $data['record'.$i]['songCounter'];
			$recordSingle_detail = $data['record'.$i]['recordDetail']['tracklist'];
			$recordSingle_love = $data['record'.$i]['counters']['loveCounter'];
			$recordSingle_comment = $data['record'.$i]['counters']['commentCounter'];
			$recordSingle_share = $data['record'.$i]['counters']['shareCounter'];
			$recordSingle_review = $data['record'.$i]['counters']['reviewCounter'];	
		?>
	<div class="box" style="padding: 0px !important;">		
		
			<div class="row  " id="<?php echo $value['objectId'] ?>"> <!------------------ CODICE TRACCIA: track01  ------------------------------------>
				<div class="small-12 columns ">
				<div class="track">
					<div class="row">
						<div class="small-9 columns ">					
							<a class="ico-label _play-large text breakOffTest">01. Titolo Traccia - 3:15</a>
								
						</div>
						<div class="small-3 columns track-propriety align-right" style="padding-right: 15px;">					
							<a class="icon-propriety _menu-small note orange "> <?php echo $views['record']['ADDPLAYLIST'];?></a>
																		
						</div>
						<div class="small-3 columns track-nopropriety align-right" style="padding-right: 15px;">
							<a class="icon-propriety "><?php echo $value['duration'] ?></a>	
						</div>		
					</div>
					<div class="row track-propriety" >
						<div class="box-propriety album-single-propriety">
							<div class="small-5 columns ">
								<a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $views['LOVE'];?></a>
								<a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $views['SHARE'];?></a>	
							</div>
							<div class="small-5 columns propriety ">					
								<a class="icon-propriety _unlove grey" >20</a>
								<a class="icon-propriety _share" >14</a>			
							</div>
						</div>		
					</div>
				</div>
				</div>
			</div>
			<div class="row  " id="<?php echo $value['objectId'] ?>"> <!------------------ CODICE TRACCIA: track01  ------------------------------------>
				<div class="small-12 columns ">
					<div class="track">
					<div class="row">
						<div class="small-9 columns ">					
							<a class="ico-label _play-large text breakOffTest">02. Titolo Traccia - 1:05</a>
								
						</div>
						<div class="small-3 columns track-propriety align-right" style="padding-right: 15px;">					
							<a class="icon-propriety _menu-small note orange "> <?php echo $views['record']['ADDPLAYLIST'];?></a>
																		
						</div>
						<div class="small-3 columns track-nopropriety align-right" style="padding-right: 15px;">
							<a class="icon-propriety "><?php echo $value['duration'] ?></a>	
						</div>		
					</div>
					<div class="row track-propriety" >
						<div class="box-propriety album-single-propriety">
							<div class="small-5 columns ">
								<a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $views['LOVE'];?></a>
								<a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $views['SHARE'];?></a>	
							</div>
							<div class="small-5 columns propriety ">					
								<a class="icon-propriety _unlove grey" >20</a>
								<a class="icon-propriety _share" >14</a>			
							</div>
						</div>		
					</div>
					</div>
				</div>
			</div>
			<div class="row " id="<?php echo $value['objectId'] ?>"> <!------------------ CODICE TRACCIA: track01  ------------------------------------>
				<div class="small-12 columns ">
					<div class="track">
					<div class="row">
						<div class="small-9 columns ">					
							<a class="ico-label _play-large text breakOffTest">03. Titolo Traccia - 1:05</a>
								
						</div>
						<div class="small-3 columns track-propriety align-right" style="padding-right: 15px;">					
							<a class="icon-propriety _menu-small note orange "> <?php echo $views['record']['ADDPLAYLIST'];?></a>
																		
						</div>
						<div class="small-3 columns track-nopropriety align-right" style="padding-right: 15px;">
							<a class="icon-propriety "><?php echo $value['duration'] ?></a>	
						</div>		
					</div>
					<div class="row track-propriety" >
						<div class="box-propriety album-single-propriety">
							<div class="small-5 columns ">
								<a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $views['LOVE'];?></a>
								<a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $views['SHARE'];?></a>	
							</div>
							<div class="small-5 columns propriety ">					
								<a class="icon-propriety _unlove grey" >20</a>
								<a class="icon-propriety _share" >14</a>			
							</div>
						</div>		
					</div>
					</div>
				</div>
			</div>	
			
	</div>
			
	<?php // } ?>
	
	<!---------------------------------------- comment ------------------------------------------------->
	<div class="box-comment no-display"></div>
	</div>
</div>
	