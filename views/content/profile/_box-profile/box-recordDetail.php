
<?php 
/* box per gli dettagli album record
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
$recordSingle_detail = $data['recordDetail'];

if(count($recordSingle_detail) > 0 && $recordSingle_detail != $boxes['NOTRACK']){
		foreach ($recordSingle_detail as $key => $value) {
			if($value['showLove'] == 'true'){
				$track_css_love = '_unlove grey';
				$track_text_love = $views['LOVE'];
			}
			else{
				$track_css_love = '_love orange';
				$track_text_love = $views['UNLOVE'];
			}
			
		
?>

<div class="row track " id="<?php echo $value['objectId'] ?>"> <!------------------ CODICE TRACCIA: track01  ------------------------------------>
	<div class="small-12 columns ">	
		<div class="row">
			<div class="small-9 columns ">					
				<a class="ico-label _play-large text breakOffTest"><?php echo $key+1 ?>. <?php echo $value['title'] ?></a>
					
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
					<a class="note white" onclick="setCounter(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $track_text_love;?></a>
					<a class="note white" onclick="share(this, '<?php echo $value['objectId'] ?>','Song')"><?php echo $views['SHARE'];?></a>	
				</div>
				<div class="small-5 columns propriety ">					
					<a class="icon-propriety <?php echo $track_css_love ?>" ><?php echo $value['counters']['loveCounter'] ?></a>
					<a class="icon-propriety _share" ><?php echo $value['counters']['shareCounter'] ?></a>			
				</div>
			</div>		
		</div>
		<!---------------------------------------- SHARE ------------------------------------------------->
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox">
			<div class="hover_menu">
			        <div class="addthis_toolbox addthis_default_style"
						addThis:url="http://socialmusicdiscovering.com/tests/controllers/share/testShare2.controller.php?classe=Album"
						addThis:title="Titolo della pagina di un album">
			        <a class="addthis_button_twitter"></a>
			        <a class="addthis_button_facebook"></a>
			        <a class="addthis_button_google_plusone_share"></a>
			       </div>	        
			</div>
		</div>
		<!-- AddThis Button END -->
	</div>
</div>
<?php }} ?>