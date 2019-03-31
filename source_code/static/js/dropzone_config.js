var fileCount = 0;
var maxFiles = 5;

Dropzone.autoDiscover = false;
$(document).ready(function () {
    $("div#myDrop").dropzone({
        url: "https://api.imgur.com/3/image", //imgur endpoint for image upload
        paramName: "image", //important for imgur request name
        method: "post",
        addRemoveLinks: true,
        autoProcessQueue: false,
        acceptedFiles: '.png,.jpg,.jpeg',
        maxFiles: maxFiles,
        parallelUploads: 5,
        headers: {
            'Cache-Control': null, //required for cors
            'X-Requested-With': null, //required for cors
            'Authorization': "Client-ID b0fe35e83401711"
        },

        // Strings
        dictRemoveFileConfirmation: "Are you Sure?",
        dictRemoveFile: "x",
        dictCancelUpload: "x",

        init: function () {
            var submitButton = document.querySelector('#upload-all');
            myDropzone = this;
            submitButton.addEventListener("click", function () {
                myDropzone.processQueue();
            });

            this.on("addedfile", function (file) {
                if (file.type !== "image/jpeg" && file.type !== "image/png" && file.type !== "image/jpg") {
                    alert("The file uploaded is not in the correct format");
                    this.removeFile(file);
                }
                fileCount += 1;
                if (fileCount > maxFiles) {
                    alert(maxFiles + " files have already been uploaded");
                    this.removeFile(file);
                }
            });

            this.on("complete", function (file) {
                if (fileCount <= maxFiles) {
                    upload2imgur(file);
                } else {
                    alert("5 files have already been uploaded");
                }
                if (this.getQueuedFiles().length === 0 && this.getUploadingFiles().length === 0) {
                    var _this = this;
                    _this.removeAllFiles();
                }
            });

            this.on("maxfilesexceeded", function (file) {
                alert("You can only upload " + maxFiles + " files!");
                this.removeFile(file);
            });
        },
    });
});


function upload2imgur(file) {
    var form = new FormData();
    form.append("image", file);

    var settings = {
        "url": "https://api.imgur.com/3/image",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Authorization": "Client-ID b0fe35e83401711"
        },
        "processData": false,
        "mimeType": "multipart/form-data",
        "contentType": false,
        "data": form
    }
}

