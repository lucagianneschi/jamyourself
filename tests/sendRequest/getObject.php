<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="requestObject.js"></script>

        <title></title>
    </head>
    <body>

        <h1>RECUPERO DIRETTO OGGETTI DA PARSE</h1>

        <div style ="width: 100%;">
            <table>
                <tr>
                    <td>
                        <input type="text" id="objectId">
                    </td>
                    <td>
                        <select id="class">
                            <option value="activity">  activity</option>
                            <option value="album">    album</option>
                            <option value="comment">  comment</option>
                            <option value="error">    error</option>
                            <option value="event">    event</option>
                            <option value="faq">      faq</option>
                            <option value="image">    image</option>
                            <option value="location"> location</option>
                            <option value="playlist"> playlist</option>
                            <option value="question"> question</option>
                            <option value="record">   record</option>
                            <option value="song">     song</option>
                            <option value="status">   status</option>
                            <option value="user">     user </option>
                            <option value="video">    video	</option>
                        </select>
                    </td>                    
                    <td>
                        <button onclick="javascript:syncCall();">get it!</button>
                    </td>
                </tr>

            </table>

        </div>       
        <h3>Contenuto richiesta:</h3>
        <div id="request" style ="width: 100%; border: 2px solid black;">Scegli un'azione per iniziare!</div><br><br>
        <h3>Contenuto oggetto:</h3>
        <div id="data" style ="width: 100%; border: 2px solid black;">Scegli un'azione per iniziare!</div><br><br>
    </body>
</html>
