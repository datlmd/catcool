var is_processing = false;

$(function () {
    if ($('.country-changed').length && $('.province-changed').length) {
        $(document).on('change', '.country-changed', function(event) {
            event.preventDefault();
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: 'countries/provinces',
                data: {'country_id' : this.value},
                type:'POST',
                success: function (data) {
                    is_processing = false;
                    $('.province-changed').removeAttr("disabled").find('option').remove();
                    var response = JSON.stringify(data);
                    response = JSON.parse(response);
                    if (response.status == 'ng') {
                        $('.province-changed').attr("disabled","disabled");
                        $('.province-changed').append('<option>' + response.msg + '</option>');
                        return false;
                    }
                    if (response.provinces != null) {
                        $.each(response.provinces, function(index, value) {
                            $('.province-changed').append('<option value="' + index + '">' + value + '</option>');
                        });
                    }
                },
                error: function (xhr, errorType, error) {
                    is_processing = false;
                }
            });
        });
    }
});

