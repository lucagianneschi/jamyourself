<?php/* box le activity * box chiamato tramite ajax con: * data-type: html, * type: POST o GET * */ini_set('display_errors', '1');if (!defined('ROOT_DIR'))    define('ROOT_DIR', '../../../../');require_once ROOT_DIR . 'config.php';require_once SERVICES_DIR . 'debug.service.php';require_once SERVICES_DIR . 'lang.service.php';require_once LANGUAGES_DIR . 'views/' . getLanguage() . '.views.lang.php';require_once BOXES_DIR . 'record.box.php';$lat = $_POST['latitude'];$lon = $_POST['longitude'];$city = $_POST['city'];$country = $_POST['country'];$genre = $_POST['genre'];$recordBox = new RecordBox();$recordBox->initForStream($lat, $lon, $city, $country, $genre);if (is_null($recordBox->error)) {    $records = $recordBox->recordArray;    if (count($records) > 0) {        foreach ($records as $key => $value) {            ?>            <div id="<?php echo $value->getObjectId(); ?>">                <div class="box ">                    <div class="row line">                        <div class="small-1 columns ">                            <div class="icon-header">                                <!--THUMB FROMUSER-->                                <?php $pathPictureThumbFromUser = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . 'profilepicturethumb' . DIRECTORY_SEPARATOR . $value->getFromUser()->getProfileThumbnail(); ?>                                <img src="<?php echo $pathPictureThumbFromUser; ?>" onerror="this.src='<?php echo DEFAVATARJAMMER; ?>'">                            </div>                        </div>                        <div class="small-5 columns">                            <div class="text grey" style="margin-bottom: 0px;">                                <strong><?php echo $value->getFromUser()->getUsername(); ?></strong>                            </div>                            <div class="note orange">                                <strong><?php echo $value->getFromUser()->getType(); ?></strong>                            </div>                        </div>                        <div class="small-6 columns propriety">                        </div>                    </div>                    <div class="row  line">                        <div class="small-12 columns box-detail">                            <div class="row ">                                <div class="small-12 columns">                                    <div class="row">                                        <div class="small-2 columns ">                                            <?php $pathRecordThumb = USERS_DIR . $value->getFromUser()->getObjectId() . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "recordcoverthumb" . DIRECTORY_SEPARATOR . $value->getRecord()->getThumbnailCover(); ?>                                            <div class="coverThumb"><img src="<?php echo $pathRecordThumb; ?>" onerror="this.src='<?php echo DEFRECORDTHUMB; ?>'"></div>						                                        </div>                                        <div class="small-10 columns ">                                            <div class="row ">							                                                <div class="small-12 columns ">                                                    <h5><?php echo $value->getTitle(); ?></h5>                                                    <h6><?php echo $value->getGenre(); ?></h6>                                                </div>	                                            </div>	                                            <div class="row">						                                                <div class="small-12 columns ">                                                </div>                                            </div>                                        </div>                                    </div>                                </div>                            </div>                        </div>                    </div>                </div>            </div>            <?php        }    } else {        ?>        Un c'� nulla!!!        <?php    }    ?>    <div class="row">        <div  class="large-5 columns">            <div class="" onclick="hideResult()"><h6><?php echo $views['stream']['new_search']; ?></h6></div>        </div>	        <div  class="large-7 columns align-right">            <div class="row">					                <div  class="small-9 columns">                    <a class="slide-button-prev _prevPage slide-button-prev-disabled" onclick=""><?php echo $views['PREV']; ?></a>                </div>                <div  class="small-3 columns">                    <a class="slide-button-next _nextPage" onclick=""><?php echo $views['NEXT']; ?></a>                </div>            </div>        </div>	    </div>    <?php}?>