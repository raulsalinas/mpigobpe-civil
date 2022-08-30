$(function () {
    $("#form-password").on("submit", function() {
        var data = $(this).serializeArray();
        data.push({
            _token:     csrf_token,
            _method:    "POST"
        });
        $.ajax({
            type: "POST",
            url : route('configs.change-password'),
            data: data,
            dataType: "JSON",
            beforeSend: function(){
                $(document.body).append('<span class="loading"><div></div></span>');
            },
            success: function (response) {
                $('.loading').remove();
                notify(response.alert, response.message);
                if (response.response == 'ok') {
                    $("#modal-password").modal("hide");
                }
            }
        }).fail( function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        });
        return false;
    });
});