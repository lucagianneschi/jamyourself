<?php
if (!defined('ROOT_DIR'))
    define('ROOT_DIR', '../../../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'lang.service.php';
require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';

$pathCoverEvent = USERS_DIR . $authorObjectId . '/images/eventcoverthumb/';

if ($_GET["type"] == 'Record') {
    $link = 'record.php?record=' . $_GET["rewiewId"];
    $pathCoverEvent = USERS_DIR . $authorObjectId . '/images/recordcoverthumb/';
    $tags = explode(',', $tagGenere);
    foreach ($tags as $key => $value) {
	if ($key == 0)
	    $stringGenre = $views['tag']['music'][$value];
	else
	    $stringGenre = $stringGenre . ', ' . $views['tag']['music'][$value];
    }
} else {
    $link = 'event.php?event=' . $_GET["rewiewId"];
    $pathCoverEvent = USERS_DIR . $authorObjectId . '/images/eventcoverthumb/';
    foreach ($tagGenere as $key => $value) {
	$stringGenre = $stringGenre . $space . $views['tag']['localType'][$value];
	$space = ', ';
    }
}
?>
<div class="bg-white">
    <div class="row">
        <div class="large-12 columns">
            <div class="box-upload-review-event">
                <h3><?php echo $views['uploadReview']['review']; ?></h3>
                <div class="row">
                    <div class="large-12 columns">
                        <div class="box">

                            <div class="row box-upload-title">
                                <div class="large-12 columns">
                                    <h2><?php echo $views['uploadReview']['create']; ?></h2>
                                </div>
                            </div>

                            <div class="row">
                                <div class="large-4 columns">
                                    <div class="sidebar">

                                        <div class="oggetto-review">
					    <a href="<?php echo $link ?>">
						<div class="row">
						    <div class="small-3 columns ">							    						
							<div class="coverThumb" style="cursor: pointer">
							    <img src="<?php echo $pathCoverEvent . $thumbnail ?>" onerror="this.src='<?php echo DEFEVENTTHUMB ?>'">
							</div>
						    </div>						
						    <div class="small-9 columns ">
							<div class="row ">							
							    <div class="small-12 columns ">
								<a href="record.php?record=<?php echo $_GET["rewiewId"] ?>"><div class="sottotitle grey-dark"><?php echo $title ?></div></a>
								<a class="ico-label _tag inline text grey"><?php echo $stringGenre ?></a>
							    </div>		
							</div>	
						    </div>
						</div>
					    </a>
                                            <div class="row">
                                                <div class="large-12 columns"><div class="line"></div></div>
                                            </div>
                                            <!--div class="row">						
                                                <div class="small-3 columns ">
												<div class="note grey"><?php echo $views['uploadReview']['rating']; ?></div>
                                                </div>
                                                <div class="small-9 columns ">
					    <?php /*
					      switch ($rating) {
					      case 0 :
					      ?>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <?php
					      break;
					      case 1 :
					      ?>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <?php
					      break;
					      case 2 :
					      ?>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <?php
					      break;
					      case 3 :
					      ?>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <?php
					      break;
					      case 4 :
					      ?>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-grey"></a>
					      <?php
					      break;
					      case 5 :
					      ?>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <a class="icon-propriety _star-orange"></a>
					      <?php
					      break;
					      } */
					    ?>
                                                </div>
                                            </div-->
					</div>
					<?php $pathAuthor = USERS_DIR . $authorObjectId . '/images/profilepicturethumb/'; ?>
					<div class="row ">
					    <div class="large-12 columns ">
						<div class="text orange"><?php echo $views['uploadReview']['performed']; ?></div>
						<div class="row">
						    <div class="small-12 columns">
							<a href="profile.php?user=<?php echo $authorObjectId ?>">
							    <div class="box-membre">
								<div class="row">
								    <div class="small-2 columns">
									<div class="icon-header">
									    <img src="<?php echo $pathAuthor . $authorThumbnail ?>" onerror="this.src='<?php echo DEFAVATARSPOTTER; ?>'">
									</div>
								    </div>
								    <div class="small-10 columns ">
									<div class="text grey-dark breakOffTest"><?php echo $author; ?></div>
								    </div>		
								</div>	
							    </div>
							</a>
						    </div>
						</div>	
					    </div>								
					</div>
					<br> <br>
					<div class="row ">
					    <div class="large-12 columns ">
						<div class="text orange"><?php echo $views['uploadReview']['featuring']; ?></div>
						<div class="row">
						    <div class="small-12 columns">
							<?php
							if (is_array($uploadReviewController->reviewedFeaturing) && count($uploadReviewController->reviewedFeaturing) > 0) {
							    foreach ($uploadReviewController->reviewedFeaturing as $featuringUser) {
								switch ($featuringUser->getType()) {
								    case 'JAMMER':
									$defaultThum = DEFTHUMBJAMMER;
									break;
								    case 'VENUE':
									$defaultThum = DEFTHUMBVENUE;
									break;
								}
								$featuringThumbnail = $featuringUser->getProfileThumbnail();
								$featuringUsername = $featuringUser->getUsername();
								$featuringUserId = $featuringUser->getObjectId();
								$pathfeaturingUserId = USERS_DIR . $featuringUserId . '/images/profilepicturethumb/';
								?>
								<a href="profile.php?user=<?php echo $featuringUserId ?>">
								    <div class="box-membre" id="<?php echo $featuringUserId ?>">
									<div class="row">
									    <div class="small-2 columns ">
										<div class="icon-header">
										    <img src="<?php echo $pathfeaturingUserId . $featuringThumbnail ?>" onerror="this.src='<?php echo $defaultThum ?>'">
										</div>
									    </div>
									    <div class="small-10 columns">
										<div class="text grey-dark breakOffTest"><?php echo $featuringUsername ?></div>
									    </div>		
									</div>	
								    </div>
								</a>
								<?php
							    }
							} else {
							    ?>
    							<div class="row">
    							    <div class="small-12 columns">
    								<div class="text gray"><?php echo $views['uploadReview']['notfeaturing']; ?></div>
    							    </div>
    							</div>
							<?php } ?>
						    </div>
						</div>	
					    </div>								
					</div>

				    </div>
				</div>
				<div class="large-6 large-offset-1 end columns">
				    <div class="row">
					<div class="large-12 columns ">
					    <h5><?php echo $views['uploadReview']['write']; ?></h5>
					    <textarea></textarea>
					</div>
				    </div>
				    <div class="row rating">
					<div class="large-3 columns ">
					    <h5><?php echo $views['uploadReview']['your_rating']; ?></h5>
					</div>
					<div class="large-9 columns big-star">
					    <select id="example-f" name="rating">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					    </select>
					</div>
				    </div>
				</div>
			    </div>
			    <br><br>
			    <div class="row">
				<div class="large-12">
				    <input type="button" class="buttonNext" id="button_publish" value="<?php echo $views['publish']; ?>">
				    <input type="hidden" id="record_id" value="<?php echo $uploadReviewController->reviewedId; ?>">
				    <input type="hidden" id="type" value="<?php echo $uploadReviewController->reviewedClassType; ?>">
				</div>
			    </div>

			</div>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</div>
