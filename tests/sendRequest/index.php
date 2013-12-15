<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="request.js"></script>
                
        <title></title>
    </head>
    <body>

        <h1>SIMULAZIONE REST API CON REQUEST COMUNE</h1>

        <div style ="width: 100%;">
            <table>
                <tr>
                    <td>
                        <button onclick="javascript:syncCall()">SIMULA CHIAMATA SINCRONA</button>
                    </td>
                    <td>
                        <button onclick="javascript:asyncCall()">SIMULA CHIAMATA ASINCRONA</button>
                    </td>
                    <td>
                        <button onclick="javascript:syncCallError()">SIMULA CHIAMATA SINCRONA CON ERRORE</button>
                    </td>
                    <td>
                        <button onclick="javascript:asyncCallError()">SIMULA CHIAMATA ASINCRONA CON ERRORE</button>
                    </td>
                </tr>

            </table>

        </div>       
        <h3>Contenuto richiesta:</h3>
        <div id="request" style ="width: 100%; border: 2px solid black;">Scegli un'azione per iniziare!</div><br><br>
        <h3>Contenuto risposta : data:</h3>
        <div id="data" style ="width: 100%; border: 2px solid black;">Scegli un'azione per iniziare!</div><br><br>
        <h3>Contenuto risposta : status:</h3>
        <div id="status" style ="width: 100%; border: 2px solid black;">Scegli un'azione per iniziare!</div><br><br>
        <h3>Contenuto risposta : xhr:</h3>
        <div id="xhr" style ="width: 100%; border: 2px solid black;">Scegli un'azione per iniziare!</div><br><br>
    </body>
</html>
