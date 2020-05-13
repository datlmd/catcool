var is_processing = false;


$('.social-list .social-item').on('click', function(e) {
    if (is_processing) {
        return false;
    }

    is_processing = true;
    $.ajax({
        url: base_url + '/members/social_login',
        type: 'POST',
        data: {type: $(this).attr('data-type')},
        success: function (data) {
            is_processing = false;

            var response = JSON.stringify(data);
            response = JSON.parse(response);

            if (response.status == 'ng') {
                $.notify(response.msg, {'type': 'danger'});
                return false;
            }

            if (response.auth_url != '') {
                window.location = response.auth_url;
                return false;
            } else if (response.status == 'redirect') {
                window.location = response.url;
                return false;
            } else {
                location.reload();
            }
        },
        error: function (xhr, errorType, error) {
            is_processing = false;
        }
    });
});

/* action - event */
$(function () {
    if ($("#list_category_sort").length) {
        $('#list_category_sort').nestable('serialize');
    }
    $('#list_category_sort').on('change', function(e) {
        if ($(e.target).closest('#list_category_sort .dd-nodrag').length != 0) {
            return false;
        }
        $("#btn_category_sort").show();
    });
});

