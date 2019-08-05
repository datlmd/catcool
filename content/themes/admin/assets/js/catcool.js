var is_processing = false;
var Catcool = {
    makeSlug: function(obj){
        var text_slug = $(obj).val();
        text_slug = text_slug.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();

        //Đổi ký tự có dấu thành không dấu
        text_slug = text_slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        text_slug = text_slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        text_slug = text_slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        text_slug = text_slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        text_slug = text_slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        text_slug = text_slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        text_slug = text_slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        text_slug = text_slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        text_slug = text_slug.replace(/ /gi, " - ");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        text_slug = text_slug.replace(/\-\-\-\-\-/gi, '-');
        text_slug = text_slug.replace(/\-\-\-\-/gi, '-');
        text_slug = text_slug.replace(/\-\-\-/gi, '-');
        text_slug = text_slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        text_slug = '@' + text_slug + '@';
        text_slug = text_slug.replace(/\@\-|\-\@|\@/gi, '');

        text_slug = text_slug.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

        $(".linked_slug").val(text_slug);

        return true;
    },
    changePublish: function (obj) {
        if (is_processing) {
            return false;
        }
        if (!$('input[name="manage"]').length) {
            return false;
        }

        var manage   = $('input[name="manage"]').val();
        var id       = $(obj).attr("data-id");
        var is_check = $(obj).is(':checked');
        var url_api  = manage + '/manage/api_publish';

        is_processing = true;
        $.ajax({
            url: url_api,
            data: {'id' : id, 'publised': is_check},
            type:'POST',
            success: function (data) {
                is_processing = false;

                var response = JSON.stringify(data);
                response = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type':'danger'});
                    $(obj).prop("checked", $(obj).attr("value"));
                    return false;
                }
                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
            }
        });
    },
    changeListParentByLang: function (obj) {
        if (is_processing) {
            return false;
        }
        if (!$('input[name="manage"]').length) {
            return false;
        }
        var manage   = $('input[name="manage"]').val();
        var id       = 0;
        var language = $(obj).val();
        var url_api  = manage + '/manage/api_get_parent';

        if ($('input[name="id"]').length) {
            id = $('input[name="id"]').val();
        }

        is_processing = true;
        $.ajax({
            url: url_api,
            data: {'language' : language, 'id': id},
            type:'POST',
            success: function (data) {
                is_processing = false;

                var response = JSON.stringify(data);
                response     = JSON.parse(response);
                if (response.status == 'ng') {
                    $.notify(response.msg, {'type':'danger'});
                    return false;
                }
                if ($('#parent_id').length) {
                    $('#parent_id').html('');
                    $.each(response.list, function (key, value) {
                        $('#parent_id').append(new Option(value, key));
                    });
                }
                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
            }
        });
    },
    submitFormModal: function () {
        if (!$('#modal_add_data').length || !$('#btn_submit_modal').length || !$('#addNewModal').length) {
            return false;
        }
        $(document).on('hide.bs.modal', '#addNewModal', function (e) {
            $('#validation_error').html('');
        })



        $('#addNewModal').on('keyup keypress', function(e) {
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
                    $('#addNewModal').modal('hide');

                    $str_chk = '<label class="custom-control custom-checkbox">';
                    $str_chk += '<input type="checkbox" name="categories[]" checked="checked" id="categories_' + response.item.id + '" value="' + response.item.id + '" class="custom-control-input">';
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
    checkBoxDelete: function () {
        if (!$('input[name="manage_check_all"]').length) {
            return false;
        }

        if (!$('input[name="manage_ids[]"]').length) {
            return false;
        }

        $('input[name="manage_check_all"]').change(function () {
            $('#delete_multiple').show();
            $('input[name="manage_ids[]"]').prop('checked', $(this).prop("checked"));
            if (!$('input[name="manage_ids[]"]:checked').length) {
                $('#delete_multiple').hide();
            }
        });
        $('input[name="manage_ids[]"]').change(function () {
            $('input[name="manage_ids[]"]').each(function(){
                if($(this).is(":checked")) {
                    $('#delete_multiple').show();
                }
            });

            $('input[name="manage_check_all"]').prop('checked', false);
            if (!$('input[name="manage_ids[]"]:checked').length) {
                $('#delete_multiple').hide();
            } else if ($('input[name="manage_ids[]"]:checked').length == $('input[name="manage_ids[]"]').length) {
                $('input[name="manage_check_all"]').prop('checked', true);
            }
        });
        $('#delete_multiple').click(function () {
            var $boxes = [];
            $('input[name="manage_ids[]"]:checked').each(function(){
                $boxes.push($(this).val());
            });

            if (!$('input[name="manage"]').length) {
                return false;
            }

            var manage   = $('input[name="manage"]').val();
            var url      = manage + '/manage/delete';
            var form     = $('<form action="' + url + '" method="post">' +
                '<input type="text" name="delete_ids" value="' + $boxes + '" />' +
                '</form>');
            $('body').append(form);
            form.submit();
        });
    },
    showDatetime: function () {
        if ($('#show-datetime-picker').length) {
            $('#show-datetime-picker').datetimepicker({
                sideBySide: true,
                format: 'DD/MM/YYYY HH:mm'
                // icons: {
                //     time: "far fa-clock",
                //     date: "fa fa-calendar-alt",
                //     up: "fa fa-arrow-up",
                //     down: "fa fa-arrow-down"
                // }
            });
        }
    },
    showDate: function () {
        if ($('#show-date-picker').length) {
            $('#show-date-picker').datetimepicker({
                sideBySide: false,
                format: 'DD/MM/YYYY'
            });
        }
    },
    checkBoxPermission: function () {
        if (!$('input[name="cb_permission_all"]').length) {
            return false;
        }
        if (!$('input[name="permissions[]"]').length) {
            return false;
        }

        $('input[name="cb_permission_all"]').change(function () {
            $('input[name="permissions[]"]').prop('checked', $(this).prop("checked"));
        });
        $('input[name="permissions[]"]').change(function () {
            $('input[name="cb_permission_all"]').prop('checked', false);
            if ($('input[name="permissions[]"]:checked').length == $('input[name="permissions[]"]').length) {
                $('input[name="cb_permission_all"]').prop('checked', true);
            }
        });
    },
};

/* action - event */
$(function () {
    $('.loading').fadeOut();
    if ($('.make_slug').length) {
        $(".make_slug").on("keyup", function () {
            Catcool.makeSlug(this);
        });
    }

    if ($('.change_publish').length) {
        $('.change_publish').on('change', function (e) {
            Catcool.changePublish(this);
        });
    }
    if ($('.change_language').length) {
        $(".change_language").change(function () {
            Catcool.changeListParentByLang(this);
        });
    }

    /* set gia tri mac dinh */
    $.notifyDefaults({
        type: 'success',
        placement: {
            from: 'top',
            align: 'center'
        }
    });
    /* load alert neu ton tai session */
    if ($('input[name="alert_msg"]').length) {
        if ($('input[name="alert_type"]').length) {
            $.notify($('input[name="alert_msg"]').val(),{type: $('input[name="alert_type"]').val()});
        } else {
            $.notify($('input[name="alert_msg"]').val());
        }
    }

    Catcool.checkBoxDelete();
    Catcool.showDatetime();
    Catcool.showDate();//only date
    Catcool.submitFormModal();//them moi khi goi modal
    Catcool.checkBoxPermission();

    $(document).on("click", '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
});

