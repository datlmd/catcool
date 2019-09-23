var is_processing = false;
var Article = {
    addCategoryModal: function () {/// chua chay on dinh, da an modal
        if (!$('#modal_add_data').length || !$('#btn_submit_modal').length || !$('#addCategoryModal').length) {
            return false;
        }
        $('#addCategoryModal').on('hide.bs.modal', function (e) {
            $('#validation_error').html('');
        })

        $('#addCategoryModal').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#btn_submit_modal').click(function () {
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: $("#modal_add_data").attr('action'),
                type: 'POST',
                data: $("#modal_add_data").serialize(),
                success: function (data) {
                    is_processing = false;

                    var response = JSON.stringify(data);
                    response     = JSON.parse(response);
                    if (response.status == 'ng') {
                        $('#validation_error').html(response.msg);
                        return false;
                    }
                    $('#addCategoryModal').modal('hide');

                    $str_chk = '<label class="custom-control custom-checkbox">';
                    $str_chk += '<input type="checkbox" name="category_ids[]" checked="checked" id="category_' + response.item.id + '" value="' + response.item.id + '" class="custom-control-input">';
                    $str_chk += '<span class="custom-control-label">' + response.item.title + '</span>';
                    $str_chk += '</label>';

                    $('#add_more_data').append($str_chk);

                    $.notify(response.msg);
                },
                error: function (xhr, errorType, error) {
                    is_processing = false;
                }
            });
        });
    },
    changeCategoryByLang: function (obj) {
        if (is_processing) {
            return false;
        }
        if (!$('input[name="manage"]').length) {
            return false;
        }
        var manage   = $('input[name="manage"]').val();
        var id       = 0;
        var language = $(obj).val();
        var url_api  = manage + '/categories/manage_api/get_parent';

        if ($('input[name="id"]').length) {
            id = $('input[name="id"]').val();
        }

        is_processing = true;
        $.ajax({
            url: url_api,
            data: {'language' : language, 'id': id, 'is_not_format': 1},
            type:'POST',
            success: function (data) {
                is_processing = false;

                var response = JSON.stringify(data);
                response     = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type':'danger'});
                    return false;
                }


                $str_chk = '<div id="add_more_data"></div>';
                $.each(response.list, function(i, item) {
                    $str_chk += '<label class="custom-control custom-checkbox">';
                    $str_chk += '<input type="checkbox" name="category_ids[]" id="category_' + item.id + '" value="' + item.id + '" class="custom-control-input">';
                    $str_chk += '<span class="custom-control-label">' + item.title + '</span>';
                    $str_chk += '</label>';
                });

                $('#list_category').html($str_chk);

                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
            }
        });
    },
    loadImageReview: function () {
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
            //var fd = new FormData();

            //fd.append('files', file[0]);
            console.log(file);

            //uploadData(file);
        });

        // Open file selector on div click
        $(".upload-area").click(function() {
            $("#file").click();
        });

        // file selected
        $("#article_image_add").change(function(){

            //this.imagesPreview(this, 'div.gallery');
            // var fd = new FormData();
            //
            // var files = $('#file').files;
            //
            // if (files && files[0]) {
            //     var reader = new FileReader();
            //
            //     reader.onload = function (e) {alert(e.target.result);
            //         $(".drop-drap-file #image_thumb").append('<div id="thumbnail_' + 1 + '" class="thumbnail"></div>');
            //         $("#thumbnail_"+num).append('<a href="' + src + '" data-lightbox="photos"><img src="' + e.target.result + '" class="img-thumbnail mr-1 img-fluid"></a>');
            //         $("#thumbnail_"+num).append('<span class="size">' + e.target.size + '</span>');
            //         $("#thumbnail_"+num).append('<div class="delete btn btn-sm btn-outline-light" onclick="delete_file(this)" data-thumb="thumbnail_' + 1 + '" data-image-url="' + e.target.result + '"><i class="far fa-trash-alt"></i></div>');
            //     }
            //     reader.readAsDataURL(input.files[0]);
            // }



            //fd.append('files',files);

            // uploadData(files);
        });
    },
    imagesPreview: function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $(".drop-drap-file #image_thumb").append('<div id="thumbnail_1" class="thumbnail"></div>');
                    $("#thumbnail_1").append('<a href="' + event.target.result + '" data-lightbox="photos"><img src="' + event.target.result + '" class="img-thumbnail mr-1 img-fluid"></a>');

                    // $(placeToInsertImagePreview)
                    // $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    // fd.appendTo('file[]', input.files[i]);
                }

                reader.readAsDataURL(input.files[i]);

                $("#thumbnail_1").append('<span class="size">' + input.files[i].file_size + '</span>');
            }
        }

    },
};
    /* action - event */
$(function () {
    Tiny_content.loadTiny('content');

    Article.addCategoryModal();//them moi khi goi modal


    Article.loadImageReview();
    $('#file').on('change', function() {
        Article.imagesPreview(this, 'div.gallery');
    });

    if ($('.change_language_article').length) {
        $(".change_language_article").change(function () {
            Article.changeCategoryByLang(this);
        });
    }

    if ($('input[name="content"]').length) {
        var article_content = $('textarea[name="content"]').val();
        Tiny_content.setTiny(article_content, 'content');
    }

    $('#add_validationform').submit(function () {
        var iframe = $('#content_ifr');
        var editorContent = $('#tinymce[data-id="content"]', iframe.contents()).html();
        $("#content").val(editorContent);

        return true;
    });

    $('#edit_validationform').submit(function () {
        var iframe = $('#content_ifr');
        var editorContent = $('#tinymce[data-id="content"]', iframe.contents()).html();
        $("#content").val(editorContent);

        return true;
    });
});
