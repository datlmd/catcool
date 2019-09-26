var is_uploading = false;
var Photo = {
    loadImageReview: function () {
        $("html").on("dragover", function(e) { e.preventDefault(); e.stopPropagation(); /*$("h5").text("Drag here");*/});
        $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });
        $('.upload-area').on('dragenter', function (e) { e.stopPropagation(); e.preventDefault(); /*$("h5").text("Drop");*/});
        $('.upload-area').on('dragover', function (e) { e.stopPropagation(); e.preventDefault(); });

        // Drop
        $('html').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();

//            document.querySelector('#file').files = e.originalEvent.dataTransfer.files;
//           document.querySelector('#file_photos_' + num).files =  new FileListItem(file_tmp); set value den input file

            var file     = e.originalEvent.dataTransfer.files;
            var formdata = new FormData();

            for (var i = 0; i < file.length; i++)
            {
                formdata.append("files[]", file[i]);
            }

            Photo.uploadData(formdata);

            //Photo.imagesPreview(e.originalEvent.dataTransfer);
        });

        // Open file selector on div click
        $(".drop-drap-file .upload-area").click(function() {
            $(".drop-drap-file #file").click();
        });

        // file selected
        $(".drop-drap-file #file").change(function() {

            var formdata = new FormData();
            var files    = $('#file');

            for (var i = 0; i < this.files.length; i++)
            {
                formdata.append("files[]", files[0].files[i]);
            }

            Photo.uploadData(formdata);
        });
    },
    uploadData: function (formdata) {
        if (is_uploading) {
            return false;
        }

        $('.loading').fadeIn();
        is_uploading = true;
        $.ajax({
            url: 'photos/manage/do_upload',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data){
                is_uploading = false;
                $('.loading').fadeOut();
                var response = JSON.stringify(data);
                response     = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type':'danger'});
                    return false;
                }
                $('#image_thumb').append(response.image);
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').fadeOut();
            }
        });
    },
    imagesPreview: function(input) {
        if (input.files) {
            var filesAmount = input.files.length;


            for (i = 0; i < filesAmount; i++) {
                var file_tmp = input.files[i];


                var len = $(".drop-drap-file #image_thumb div.thumbnail").length;
                var num = Number(len);
                num = num + 1;

                var thumbnail_id = 'thumbnail_' + num;

                $('.drop-drap-file #image_thumb').append('<div id="' + thumbnail_id + '" class="thumbnail"></div>');
                $("#" + thumbnail_id).append('<input type="file" name="file_photos[photo_' + num + ']" id="file_photos_' + num +'"/>');
                document.querySelector('#file_photos_' + num).files =  new FileListItem(file_tmp);

                var reader = new FileReader();
                reader.onload = function(event) {



                    $("#" + thumbnail_id).append('<a href="' + event.target.result + '" data-lightbox="photos"><img src="' + event.target.result + '" class="img-thumbnail mr-1 img-fluid"></a>');
                    $("#" + thumbnail_id).append('<span class="size">' + Photo.convertSize(event.loaded) + '</span>');
                    $("#" + thumbnail_id).append('<input type="text" name="photo_' + num + '" value="" class="form-control">');
                }

                reader.readAsDataURL(input.files[i]);



            }
        }
    },
    // Bytes conversion
    convertSize: function (size) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (size == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
        return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
    },
};

// Used for creating a new FileList in a round-about way
function FileListItem(a) {
    a = [].slice.call(Array.isArray(a) ? a : arguments)
    for (var c, b = c = a.length, d = !0; b-- && d;) d = a[b] instanceof File
    if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
    for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(a[c])
    return b.files
}

$(function () {

    Photo.loadImageReview();//khoi tao drop image

});
