var is_uploading = false;
$(function() {
    // preventing page from redirecting
    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
        //$("h5").text("Drag here");
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    // Drag enter
    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        //$("h5").text("Drop");
    });

    // Drag over
    $('.upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        //$("h5").text("Drop");
    });

    // Drop
    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        //$("h5").text("Upload");
        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData();

        fd.append('file', file[0]);

        uploadData(fd);
    });

    // Open file selector on div click
    $("#uploadfile").click(function() {
        $("#file").click();
    });

    // file selected
    $("#file").change(function(){
        var fd = new FormData();

        var files = $('#file')[0].files[0];

        fd.append('file',files);

        uploadData(fd);
    });

});

// Sending AJAX request and upload file
function uploadData(formdata) {
    if (is_uploading) {
        return false;
    }
    var module_name = $('.drop-drap-file').attr("data-module");
    if (!module_name.length) {
        return false;
    }

    formdata.append('module',module_name);

    $('.loading').fadeIn();
    is_uploading = true;
    $.ajax({
        url: 'images/upload/do_upload',
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
            addThumbnail(response);
        },
        error: function (xhr, errorType, error) {
            is_uploading = false;
            $('.loading').fadeOut();
        }
    });
}

function delete_file(obj) {
    if (is_uploading) {
        return false;
    }
    $('.loading').fadeIn();

    var image_url = $(obj).attr("data-image-url");
    var image_thumb = $(obj).attr("data-thumb");
    var from_action = $('.drop-drap-file').attr("data-from");

    if (from_action.length && from_action == 'edit') {
        $('#' + image_thumb).hide().fadeOut();
        $('.loading').fadeOut();
    } else {
        is_uploading = true;
        $.ajax({
            url: 'images/upload/do_delete',
            type: 'POST',
            data: {'image_url': image_url},
            dataType: 'json',
            success: function (data) {
                is_uploading = false;
                $('.loading').fadeOut();
                var response = JSON.stringify(data);
                response = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                }
                $('#' + image_thumb).hide().fadeOut();
                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').fadeOut();
            }
        });
    }
}

// Added thumbnail
function addThumbnail(data) {
    //$("#uploadfile h5").remove();
    var is_multi = $(".drop-drap-file").attr("data-is-multi");
    if (is_multi == 'false') {
        $(".drop-drap-file #image_thumb").html("");
    }

    var len = $(".drop-drap-file #image_thumb div.thumbnail").length;

    var num = Number(len);
    num = num + 1;

    var name = data.file.file_name;
    var size = convertSize(data.file.file_size);
    var src = image_url + data.image;

    // Creating an thumbnail
    $(".drop-drap-file #image_thumb").append('<div id="thumbnail_' + num + '" class="thumbnail"></div>');
    $("#thumbnail_"+num).append('<input type="hidden" name="file_upload[]" value="' + data.image + '">');
    $("#thumbnail_"+num).append('<a href="' + src + '" data-lightbox="photos"><img src="' + src + '" class="img-thumbnail mr-1 img-fluid"></a>');
    $("#thumbnail_"+num).append('<span class="size">' + size + '</span>');
    $("#thumbnail_"+num).append('<div class="delete btn btn-sm btn-outline-light" onclick="delete_file(this)" data-thumb="thumbnail_' + num + '" data-image-url="' + data.image + '"><i class="far fa-trash-alt"></i></div>');
}

// Bytes conversion
function convertSize(size) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (size == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
    return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
}