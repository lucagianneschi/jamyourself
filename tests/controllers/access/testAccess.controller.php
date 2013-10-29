<!DOCTYPE html>
<html>
    <head>
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="../../../views/resources/javascripts/customs/signupFacebook.js"></script>
        <script type="text/javascript" src="access.js"></script>
        <title>Il titolo della pagina</title>
        <meta name="description" content="La descrizione della pagina" />
    </head>
    <body>
        Cliccando i bottoni si effettuano operazioni di login e logout<br />
        <br />
        <button type="button" onclick="access('lucagianneschi', 'fVoZVNdm', 'login', null)">Login lucagianneschi</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" onclick="access('lucagianneschi', 'fVoZVNdm', 'logout', null)">Logout lucagianneschi</button>
        &nbsp;<hr>
        <button type="button" onclick="access('Ldf', 'MHURRg5X', 'login', null)">Login Ldf</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" onclick="access('Ldf', 'MHURRg5X', 'logout', null)">Logout Ldf</button>
        &nbsp;<hr>
        <button type="button" onclick="signupFacebook()">SocialLogin</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </body>
</html>