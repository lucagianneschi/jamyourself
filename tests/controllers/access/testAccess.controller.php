<!DOCTYPE html>
<html>
    <head>
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="../../../views/resources/javascripts/customs/signupFacebook.js"></script>
        <script type="text/javascript">
            function access(usernameOrEmail, password, opType, userId) {

                var json_access = {};
                if (opType === 'login') {
                    json_access.request = "login";
                    json_access.usernameOrEmail = usernameOrEmail;
                    json_access.password = password;
                } else if (opType === 'logout') {
                    json_access.request = "logout";
                    json_access.userId = userId;
                } else {
                    json_access.request = "socialLogin";
					json_access.usernameOrEmail = usernameOrEmail;
                    json_access.password = password;
                }

                $.ajax({
                    type: "POST",
                    url: "../../../controllers/request/accessRequest.php",
                    data: json_access,
                    async: false,
                    "beforeSend": function(xhr) {
                        xhr.setRequestHeader("X-AjaxRequest", "1");
                    },
                    success: function(data, status) {
                        alert("[onLoad] [SUCCESS] Status: " + data);
                        //console.log("[onLoad] [SUCCESS] Status: " + status + " " + data);
                    },
                    error: function(data, status) {
                        alert("[onLoad] [ERROR] Status: " + data);
                        //console.log("[onLoad] [ERROR] Status: " + status + " " + data);
                    }
                });
            }
        </script>
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