$(document).ready(function () {
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
$(document).on('change', '#property_form_state', function () {
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
$(document).on('change', '#property_form_city', function () {
    let sts = document.getElementById('property_form_city')
    sts.classList.remove('is-invalid')
});
$(document).ready(function () {
    var $types = $('#property_form_types');
    var $token = $('#property_form__token');
    $types.change(function () {
        var $form = $(this).closest('form')
        var data = {}
        data[$token.attr('name')] = $token.val();
        data[$types.attr('name')] = $types.val();
        $.post($form.attr('action'), data).then(function (response) {
            $("#property_form_period").replaceWith(
                $(response).find("#property_form_period")
            )
        })
    })
});

function deleteAmenity(id) {
    let property = parseInt($('#property_form_amenity_' + id).attr("data-id"))
    $.ajax({
        url: "/dashboard/listing/amenity/" + id + '/' + property,
        type: "GET",
        dataType: 'json',
        cache: false,
        success: function (response) {

        },
        error: function (xhr, desc, err) {

        },
    });
}

// $(document).ready(function() {
//     var $types = $('#property_form_types');
//     var sts = document.getElementById('period')
//     $types.change(function () {
//         var $form = $(this).closest('form');
//         var data = {};
//         data[$types.attr('name')] = $types.val();
//         $.ajax({
//             url: $form.attr('action'),
//             type: $form.attr('method'),
//             data: data,
//             success: function (html) {
//                 $('#property_form_period').replaceWith(
//                     $(html).find('#property_form_period')
//                 );
//             }
//         });
//     });
// });