var is_processing = false;

$(function () {
    if ($('.country-changed').length && $('.zone-changed').length) {
        $(document).on('change', '.country-changed', function(event) {
            event.preventDefault();
            if (is_processing) {
                return false;
            }
            is_processing = true;
            $.ajax({
                url: 'countries/zones',
                data: {'id' : this.value},
                type:'POST',
                success: function (data) {
                    is_processing = false;
                    $('.zone-changed').removeAttr("disabled").find('option').remove();
                    var response = JSON.stringify(data);
                    response = JSON.parse(response);
                    if (response.status == 'ng') {
                        $('.zone-changed').attr("disabled","disabled");
                        $('.zone-changed').append('<option>' + response.msg + '</option>');
                        return false;
                    }
                    if (response.zones != null) {
                        $.each(response.zones, function(index, value) {
                            $('.zone-changed').append('<option value="' + index + '">' + value + '</option>');
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

