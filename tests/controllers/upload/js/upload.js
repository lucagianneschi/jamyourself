// Custom example logic
$(function() {
    var uploader = new plupload.Uploader({
        runtimes: 'html4', //runtime di upload
        browse_button: "pickfiles", //id del pulsante di selezione file
        container: "container", //id del div per l'upload
        max_file_size: '10mb', //dimensione max dei file da caricare
        multi_selection: false, //forza un file alla volta per upload
        url: "http://localhost/jamyourself/controllers/request/uploadRequest.php",
        filters: [
            {title: "Image files", extensions: "jpg,gif,png"}, //lista file accettati
            {title: "Zip files", extensions: "zip"}
        ],
        multipart_params: {"request": "upload"}, //parametri passati in POST
        resize: {width: 320, height: 240, quality: 90}
    });

    uploader.bind('Init', function(up, params) {
        $('#filelist').html("<div>Current runtime: " + params.runtime + "</div>");
    });

    uploader.init();

//setup FileUploaded Action
    uploader.bind('FilesAdded', function(up, files) {
        uploader.start();
//        e.preventDefault();
    });

    uploader.bind('UploadProgress', function(up, file) {
        $('#' + file.id + " b").html(file.percent + "%");
    });

    uploader.bind('Error', function(up, err) {
        $('#filelist').append("<div>Error: " + err.code +
                ", Message: " + err.message +
                (err.file ? ", File: " + err.file.name : "") +
                "</div>"
                );

        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader.bind('FileUploaded', function(up, file, response) {
        console.log(response.response);
        $('#' + file.id + " b").html("100%");
        var obj = JSON.parse(response.response);
        
        $('#immagine').attr("src","./uploadTestFolder/"+obj.id);
    });

});
