$(document).ready(function () {
    $('.clickD').click(function () {
        $.ajax({
            url: "/office/"+ $(this).data('url')+"/published",
            type: "POST",
            cache: false,
            success: function (response) {
                console.log('ok')
            },
            error: function (response) {
                $(".message").html(response)
            },
        });
    });
});
