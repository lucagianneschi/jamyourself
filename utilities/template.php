<?php/* * Per il seguente TEMPLATE sono richiesti i seguenti dati: * <nome> 		- Il nome di chi ha fatto la richiesta * <mittente>	- L'indirizzo email di chi ha fatto la richiesta * <oggetto>	- L'oggetto della richiesta * <messaggio>	- Il corpo del messaggio della richiesta * */$tplMailSistema = '<html>	<body>		<table cellspacing="0">			<tr>				<td style="background-image:url(\'http://www.socialmusicdiscovering.com/script/wp_daniele/02_wp_contatti/header_mail.png\'); background-repeat:no-repeat;" height="158px" width="638px"></td>			</tr>			<tr>				<td style="background-image:url(\'http://www.socialmusicdiscovering.com/script/wp_daniele/02_wp_contatti/body_mail.png\'); background-repeat:repeat-y; padding: 10px;" width="638px">				Un utente ha appena eseguito una richiesta di informazione.<br />				I suoi dati sono i seguenti.<br />				<br />				Nome: <nome><br />				Email: <mittente><br />				Oggetto: <oggetto><br />				Messaggio:<br />				<messaggio>				</td>			</tr>			<tr>				<td style="background-image:url(\'http://www.socialmusicdiscovering.com/script/wp_daniele/02_wp_contatti/footer_mail.png\'); background-repeat:no-repeat;" height="32px" width="638px"></td>			</tr>		</table>			</body></html>';/* * Per il seguente TEMPLATE sono richiesti i seguenti dati: * <nome> 		- Il nome di chi ha fatto la richiesta * <oggetto>	- L'oggetto della richiesta * <messaggio>	- Il corpo del messaggio della richiesta * */$tplMailMittente = '<html>	<body>		<table cellspacing="0">			<tr>				<td style="background-image:url(\'http://www.socialmusicdiscovering.com/script/wp_daniele/02_wp_contatti/header_mail.png\'); background-repeat:no-repeat;" height="158px" width="638px"></td>			</tr>			<tr>				<td style="background-image:url(\'http://www.socialmusicdiscovering.com/script/wp_daniele/02_wp_contatti/body_mail.png\'); background-repeat:repeat-y; padding: 10px;" width="638px">				Ciao <nome>,<br />				hai appena inoltrato una richiesta a JamYourself.<br />				<br />				Oggetto:<br />				<oggetto><br />				<br />				Messaggio:<br />				<messaggio><br />				<br />				Grazie,<br />				Lo staff di JamYourself				</td>			</tr>			<tr>				<td style="background-image:url(\'http://www.socialmusicdiscovering.com/script/wp_daniele/02_wp_contatti/footer_mail.png\'); background-repeat:no-repeat;" height="32px" width="638px"></td>			</tr>		</table>			</body></html>';/* * Per il seguente TEMPLATE sono richiesti i seguenti dati: * <answer> 	- La richiesta * <messaggio>	- La risposta alla richiesta * */$tplMailRisposta = '<html>	<body>		<table cellspacing="0">			<tr>				<td style="background-image:url(\'http://www.socialmusicdiscovering.com/script/wp_daniele/02_wp_contatti/header_mail.png\'); background-repeat:no-repeat;" height="158px" width="638px"></td>			</tr>			<tr>				<td style="background-image:url(\'http://www.socialmusicdiscovering.com/script/wp_daniele/02_wp_contatti/body_mail.png\'); background-repeat:repeat-y; padding: 10px;" width="638px">				<answer><br />				<br />				Risposta a seguito della richiesta:<br />				<messaggio>				</td>			</tr>			<tr>				<td style="background-image:url(\'http://www.socialmusicdiscovering.com/script/wp_daniele/02_wp_contatti/footer_mail.png\'); background-repeat:no-repeat;" height="32px" width="638px"></td>			</tr>		</table>			</body></html>';?>