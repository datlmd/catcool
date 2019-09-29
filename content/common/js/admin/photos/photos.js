
var is_uploading = false;
var Photo = {
    loadImageReview: function () {
        $("html").on("dragover", function (e) {
            e.preventDefault();
            e.stopPropagation();
            /*$("h5").text("Drag here");*/
        });
        $("html").on("drop", function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $('.upload-area').on('dragenter', function (e) {
            e.stopPropagation();
            e.preventDefault();
            /*$("h5").text("Drop");*/
        });
        $('.upload-area').on('dragover', function (e) {
            e.stopPropagation();
            e.preventDefault();
        });

        // Drop
        $('html').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();
//            document.querySelector('#file').files = e.originalEvent.dataTransfer.files;
//           document.querySelector('#file_photos_' + num).files =  new FileListItem(file_tmp); set value den input file

            var file = e.originalEvent.dataTransfer.files;
            var formdata = new FormData();

            for (var i = 0; i < file.length; i++) {
                formdata.append("files[]", file[i]);
            }

            Photo.uploadData(formdata);

            //Photo.imagesPreview(e.originalEvent.dataTransfer);
        });

        // Open file selector on div click
        $(".drop-drap-file .upload-area").click(function () {
            $(".drop-drap-file #file").click();
        });

        // file selected
        $(".drop-drap-file #file").change(function () {

            var formdata = new FormData();
            var files = $('#file');

            for (var i = 0; i < this.files.length; i++) {
                formdata.append("files[]", files[0].files[i]);
            }

            Photo.uploadData(formdata);
        });
    },
    delete_div_photo: function (obj) {
        if (is_uploading) {
            return false;
        }
        if ($('input[name="confirm_title"]').length) {
            var confirm_title = $('input[name="confirm_title"]').val();
        }
        if ($('input[name="confirm_content"]').length) {
            var confirm_content = $('input[name="confirm_content"]').val();
        }
        if ($('input[name="confirm_btn_ok"]').length) {
            var confirm_btn_ok = $('input[name="confirm_btn_ok"]').val();
        }
        if ($('input[name="confirm_btn_close"]').length) {
            var confirm_btn_close = $('input[name="confirm_btn_close"]').val();
        }

        $.confirm({
            title: confirm_title,
            content: confirm_content,
            icon: 'fa fa-question',
            columnClass: 'col-md-6 col-md-offset-3',
            //theme: 'bootstrap',
            closeIcon: true,
            //animation: 'scale',
            typeAnimated: true,
            type: 'red',
            buttons: {
                formSubmit: {
                    text: confirm_btn_ok,
                    btnClass: 'btn-danger',
                    keys: ['y', 'enter', 'shift'],
                    action: function(){
                        $('.loading').fadeIn();

                        var image_key = $(obj).attr("data-photo_key");
                        $('#photo_key_' + image_key).remove().fadeOut();
                    }
                },
                cancel: {
                    text: confirm_btn_close,
                    keys: ['n']
                },
            }
        });
    },
    submitAlbum: function (form_id, is_edit) {
        if (is_uploading) {
            return false;
        }
        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');
        is_uploading = true;
        $.ajax({
            url: $('#' + form_id).attr('action'),
            type: 'POST',
            data: $("#" + form_id).serialize(),
            success: function (data) {
                is_uploading = false;
                $('.loading').fadeOut();
                var response = JSON.stringify(data);
                response = JSON.parse(response);

                if (response.status == 'redirect') {
                    window.location = response.url;
                    return false;
                } else if (response.status == 'ng') {
                    $.notify(response.msg, {'type': 'danger'});
                    return false;
                }

                if (is_edit == true) {
                    $.notify(response.msg);
                }

                var edit_url = 'photos/albums/manage/edit/' + response.id;
                Photo.loadView(edit_url);

                //location.reload();
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').fadeOut();
            }
        });

        return false;
    },
    loadView: function (url, formdata) {
        history.pushState(null, '', url);

        if (!$('#view_albums').length) {
            window.location = url;
        }

        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

        $.ajax({
            url: url,
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: true,
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
                $('#view_albums').html(response.view);
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').fadeOut();
            }
        });
    },
    uploadData: function (formdata) {
        if (is_uploading) {
            return false;
        }

        $('body').append('<div class="loading"><span class="dashboard-spinner spinner-xs"></span></div>');

        is_uploading = true;
        $.ajax({
            url: 'photos/manage/do_upload',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
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
                $('#image_thumb').append(response.image);
                $('#image_thumb').focus();
            },
            error: function (xhr, errorType, error) {
                is_uploading = false;
                $('.loading').fadeOut();
            }
        });
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
