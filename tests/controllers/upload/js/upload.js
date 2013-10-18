// Custom example logic

$(function() {
    var uploader = new plupload.Uploader({
        runtimes: 'html4',
        browse_button: 'pickfiles',
        container: container,
        max_file_size: '10mb',
        url: 'http://localhost/jamyourself/controllers/request/uploadRequest.php',
        filters: [
            {title: "Image files", extensions: "jpg,gif,png"},
            {title: "Zip files", extensions: "zip"}
        ],
        multipart_params: {"request": "upload"},
        resize: {width: 320, height: 240, quality: 90}
    });

    uploader.bind('Init', function(up, params) {
        $('#filelist').html("<div>Current runtime: " + params.runtime + "</div>");
    });

    $('#uploadfiles').click(function(e) {
        uploader.start();
        e.preventDefault();
    });

    uploader.init();

    uploader.bind('FilesAdded', function(up, files) {
        $.each(files, function(i, file) {
            $('#filelist').append(
                    '<div id="' + file.id + '">' +
                    file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                    '</div>');
        });

        up.refresh(); // Reposition Flash/Silverlight
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

    uploader.bind('FileUploaded', function(up, file,response) {
        console.log(response);
        $('#' + file.id + " b").html("100%");
    });
});
