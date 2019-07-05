var is_processing = false;
var Catcool = {
    item_id: null,
    group_code: null,
    offset: 0,
    status_name: null,
    loading: false,
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

        var manage = $('input[name="manage"]').val();
        if (manage.length <= 0) {
            return false;
        }

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
                    $.alert(response.msg, {'type':'error'}).fadeIn(1000);
                    $(obj).prop("checked", $(obj).attr("value"));
                    return false;
                }
                $.alert(response.msg).fadeIn(1000);
            },
            error: function (xhr, errorType, error) {
                is_processing = false;
            }
        });
    },
};

/* action - event */
$(function () {
    $(".alert-catcool").fadeIn(1000).delay(10000).fadeOut(1000);
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
});