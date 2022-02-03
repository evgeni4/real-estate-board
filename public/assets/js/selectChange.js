$(document).ready(function() {
    var $country = $('#property_form_country');
    $country.change(function () {
        var $form = $(this).closest('form');
        var data = {};
        data[$country.attr('name')] = $country.val();
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: data,
            success: function (html) {
                $('#property_form_state').replaceWith(
                    $(html).find('#property_form_state')
                );
            }
        });
    });
});
$(document).on('change','#property_form_state',function(){
    var $state = $('#property_form_state');
    var $form = $(this).closest('form');
    var data = {};
    data[$state.attr('name')] = $state.val();
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        success: function (html) {
            let sts = document.getElementById('property_form_state')
            $('#property_form_city').replaceWith(
                $(html).find('#property_form_city')
            );
            sts.classList.remove('is-invalid')
        }
    });
});
$(document).on('change','#property_form_city',function(){
    let sts = document.getElementById('property_form_city')
    sts.classList.remove('is-invalid')
});