
var uploader = new plupload.Uploader({
    runtimes: 'html4',
    browse_button: 'pickfiles', // you can pass in id...
    container: document.getElementById('container'), // ... or DOM Element itself
    url: 'upload.php',
    filters: {
        max_file_size: '10mb',
        mime_types: [
            {title: "Image files", extensions: "jpg,gif,png"},
        ]
    },
    init: {
        PostInit: function() {
            document.getElementById('filelist').innerHTML = '';

            document.getElementById('uploadfiles').onclick = function() {
                uploader.start();
                return false;
            };
        },
        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
            });
        },
        UploadProgress: function(up, file) {
            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        },
        Error: function(up, err) {
            console.log("\nError #" + err.code + ": " + err.message);
        },
        FileUploaded: function(up, file, info) {
            // Called when a file has finished uploading
            console.log('[FileUploaded] File:', file, "Info:", JSON.stringify(info));
        }
    }
});

uploader.init();