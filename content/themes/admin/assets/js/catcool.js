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
    changePulish: function (obj) {

        if (is_processing) {
            return false;
        }
        var id = $(obj).attr("data-id");
        is_processing = true;

        $.ajax({
            url: this.action_gender + '&t=' + Date.now(),
            data: {gender: gender},
            success: function (response) {
                Simple.loading = false;
                Simple.loading_stop();
                var response = JSON.parse(response);
                if (response.status == "ng") {
                    $("#closet-caution-modal .modal-body").html(response.message);
                    Modal.show("#closet-caution-modal");

                    return false;
                }
                //window.location.reload();
                if (response.arr_deck_status) {
                    var html_status = Simple.getHtmlStatus(response.arr_deck_status, response.status_power);
                    $("#deck_info .osa_status").html(html_status);
                }
                $("#deck_image").attr("src", response.deck_avatar);
                $('#osa_tab_first').trigger('click');
            },
        });
    },
};

/* action - event */
$(function () {
    $(".make_slug").on("keyup", function () {
        Catcool.makeSlug(this);
    });
});