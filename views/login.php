<?php
/* box post
 * box chiamato tramite load con:
 * data: {data,typeuser}
 *
 */

if (!defined('ROOT_DIR'))
	define('ROOT_DIR', '../');

session_start();

echo 'Sessione: ';
print_r($_SESSION);

?>
<script type="text/javascript" src="<?php echo ROOT_DIR; ?>views/resources/javascripts/plugins/jquery/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_DIR; ?>tests/controllers/access/access.js"></script>
<form action="javascript:access($('#user').val(), $('#pass').val(), 'login', null)">
	<input type="text" id="user" placeholder="username" />
	<input type="password" id="pass" placeholder="password" />
	<input type="submit" value="Login" />
</form>
Ldf - MHURRg5X