<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <!-- div di avviso  -->
        <div id="error" class='error'></div>
        <div id="message" class='message'></div>
        <div id="login" style="display: none"></div>
        <div id="logout" style="display: none"></div>
        <input type="button" value="Cliccami ohh yeah" onclick="javascript:test();">

        <script type="text/javascript" src="jquery-min.js"></script>

        <script>


            function test() {
                window.console.log("[Function test] - start");
                hideMessage();
                hideError();

                var request = null;
                data = {};

                data['uno'] = "Stringa di test numero 1";
                data['due'] = "Stringa di test numero 2";

                // preparo la richiesta
                request = {};
                request['action'] = "testFunction";
                request['data'] = JSON.stringify(data);

                // invio la richiesta
                risp = $.ajax({
                    type: "POST",
                    url: "exampl2.controller.php",
                    data: request,
                    dataType: "json",
                    async: false,
                    error: function(data) {
                        showError("Errore di rete");
                    }
                });


                data = risp['responseText'];
                
                window.console.log("[Function test] - risposta NON decodificata: " + data);
                
                //decodifico
                json = JSON.parse(data);
                window.console.log("[Function test] - risposta decodificata: " + data);
                if (json.error !== null) {
                    showError(json.error);
                    return null;
                }
                else {
                    showMessage(json.message);
                    return json.data;
                }

            }

            function showError(text) {
                $("#error").html("<span>" + text + "</span>");
            }

            function hideError() {
                $("#error").html("");
            }

            function showMessage(text) {
                $("#message").html("<span>" + text + "</span>");
            }

            function hideMessage() {
                $("#message").html("");
            }

        </script>
    </body>
</html>


