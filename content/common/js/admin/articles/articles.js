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
        $("html").on("dragover", function(e) { e.preventDefault(); e.stopPropagation(); /*$("h5").text("Drag here");*/});
        $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });
        $('.upload-area').on('dragenter', function (e) { e.stopPropagation(); e.preventDefault(); /*$("h5").text("Drop");*/});
        $('.upload-area').on('dragover', function (e) { e.stopPropagation(); e.preventDefault(); });

        // Drop
        $('html').on('drop', function (e) {
            e.stopPropagation();
            e.preventDefault();

            //$("h5").text("Upload");
            var file = e.originalEvent.dataTransfer.files;


//            $('.drop-drap-file').append('file', file[0]);
            document.querySelector('#file').files = e.originalEvent.dataTransfer.files;

            Article.imagesPreview(e.originalEvent.dataTransfer);
        });

        // Open file selector on div click
        $(document).on('click', ".drop-drap-file .upload-area", function() {
            $(".drop-drap-file #file").click();
        });

        // file selected
        $(document).on('change', ".drop-drap-file #file", function() {
            Article.imagesPreview(this);
        });
    },
    imagesPreview: function(input) {
        if (input.files) {
            var filesAmount = input.files.length;

            $('.drop-drap-file #image_thumb').html('');
            for (i = 0; i < filesAmount; i++) {
                var len = $(".drop-drap-file #image_thumb div.thumbnail").length;
                var num = Number(len);
                num = num + 1;

                var reader = new FileReader();
                reader.onload = function(event) {
                    $('.drop-drap-file #image_thumb').append('<div id="thumbnail_' + num + '" class="thumbnail"></div>');
                    $("#thumbnail_" + num).append('<a href="' + event.target.result + '" data-lightbox="photos"><img src="' + event.target.result + '" class="img-thumbnail mr-1 img-fluid"></a>');
                    $("#thumbnail_" + num).append('<span class="size">' + Article.convertSize(event.loaded) + '</span>');
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
    /* action - event */
$(function () {
    Tiny_content.loadTiny('content', 600);

    Article.addCategoryModal();//them moi khi goi modal
    Article.loadImageReview();//khoi tao drop image

    if ($('.change_language_article').length) {
        $(document).on('change', ".change_language_article", function() {
            Article.changeCategoryByLang(this);
        });
    }

    // if ($('input[name="content"]').length) {
    //     var article_content = $('textarea[name="content"]').val();
    //     Tiny_content.setTiny(article_content, 'content');
    // }

    $('#add_validationform').submit(function () {
        return true;
    });

    $('#edit_validationform').submit(function () {
        return true;
    });
});
