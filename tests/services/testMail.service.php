<?php
	if (isset($_POST['inviaEmail'])) {
		if (!defined('ROOT_DIR'))
			define('ROOT_DIR', '../../');
		require_once ROOT_DIR . 'config.php';
		require_once SERVICES_DIR . 'mail.service.php';
		
		try {
			$mail = mailService();
			$mail->AddAddress('daniele.caldelli@gmail.com');
			
			$mail->Subject = 'Test';
			$mail->Body    = $_POST['messaggio'];
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
			   echo 'Message could not be sent.<br />';
			   echo 'Mailer Error: ' . $mail->ErrorInfo . '<br />';
			   exit;
			}
			
			echo 'Messaggio inviato<br />';
		} catch (phpmailerException $e) {
			echo 'Eccezione ' . $e->getMessage();
			//throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		} catch (Exception $e) {
			echo 'Eccezione ' . $e->getMessage();
			//throwError($e, __CLASS__, __FUNCTION__, func_get_args());
		}
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="post.js"></script>
        <title></title>
    </head>
    <body>
        <form action="" method="POST">
			Destinatario: <input type="text" name="indirizzo" />
			<br />
			Testo: <textarea name="messaggio"></textarea>
			<br />
            <input type="submit" value="Invia email" name="inviaEmail" />
        </form>
		ATTENZIONE: ai fini di eseguire i test e' stato utilizzato un server smtp PRIVATO, pertanto si prega di NON rispondere in nessun modo all'indirizzo del mittente.
    </body>
</html>