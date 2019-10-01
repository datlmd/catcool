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
        var url_api  = manage + '/manage_api/publish';

        is_processing = true;
        $.ajax({
            url: url_api,
            data: {'id' : id, 'published': is_check},
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
        var url_api  = manage + '/manage_api/get_parent';

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
                    $('#parent_id').append(response.list);
                }
                $.notify(response.msg);
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
            }
        });
    },
    checkBoxDelete: function () {
        if (!$('input[name="manage_check_all"]').length) {
            return false;
        }
        if (!$('input[name="manage_ids[]"]').length) {
            return false;
        }

        $(document).on('change', 'input[name="manage_check_all"]', function() {
            $('#delete_multiple').show();
            $('input[name="manage_ids[]"]').prop('checked', $(this).prop("checked"));
            if (!$('input[name="manage_ids[]"]:checked').length) {
                $('#delete_multiple').hide();
            }
        });
        $(document).on('change', 'input[name="manage_ids[]"]', function() {
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
        $(document).on('click', "#delete_multiple", function() {
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

        $(document).on('change', 'input[name="cb_permission_all"]', function() {
            $('input[name="permissions[]"]').prop('checked', $(this).prop("checked"));
        });

        $(document).on('change', 'input[name="permissions[]"]', function() {
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
        $(document).on('change', '.change_publish', function(event) {
            event.preventDefault();
            Catcool.changePublish(this);
        });
    }
    if ($('.change_language').length) {
        $(document).on('change', '.change_language', function() {
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
    Catcool.checkBoxPermission();

    $(document).on("click", '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
});

