<?php
/* box post
 * box chiamato tramite load con:
 * data: {data,typeuser}
 *
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

require_once ROOT_DIR . 'config.php';
require_once SERVICES_DIR . 'mantainance.service.php';
require_once CLASSES_DIR . 'userParse.class.php';

session_start();

print_r($_SESSION);

?>
<script type="text/javascript" src="<?php echo ROOT_DIR; ?>views/resources/javascripts/plugins/jquery/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_DIR; ?>views/resources/javascripts/customs/access.js"></script>
<script type="text/javascript" src="<?php echo ROOT_DIR; ?>views/resources/javascripts/customs/social.js"></script>
<form action="javascript:access($('#user').val(), $('#pass').val(), 'login', null)">
	<input type="text" id="user" placeholder="username" />
	<input type="password" id="pass" placeholder="password" />
	<input type="submit" value="Login" />
	<input type="button" value="Logout" onclick="access(null, null, 'logout', null)"/>
</form>
Ldf<br />
MHURRg5X<br />
<br />
<input type="button" value="Link FB" onclick="userUtilities(null, 'linkUser', null, null, null, 'facebook')"/>
<input type="button" value="Unlink FB" onclick="userUtilities(null, 'unlinkUser', null, null, null, 'facebook')"/>
<input type="button" value="Login FB" onclick="userUtilities(null, 'loginUser', null, null, null, 'facebook')"/>

<?php
//se impostato dalla pagina da cui si viene permette di ricaricare la pagina dopo
// il login
if(isset($_GET['from']) && strlen($_GET['from'])>0){
    echo '<br/><br/><a href="'.$_GET['from'].'">back</a>'; 
    echo '<br/><input type="hidden" id="from" value="'.$_GET['from'].'"/>';
}

?>