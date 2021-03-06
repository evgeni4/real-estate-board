$(document).ready(function () {
    $('.add-field').click(function (e) {
        var list = $("#fields-list");
        var counter = list.data('widget-counter') | list.children().length;
        var newWidget = list.attr('data-prototype');
        newWidget = newWidget.replace(/__name__/g, counter);
        counter++;
        list.data('widget-counter', counter);
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
        newElem.append('<a id="deleteField" onClick="onClickRemove()" href="#" class="remove-tag remove-btn tolt"  data-microtip-position="left" data-tooltip="Remove Room" ><i class="fal fa-times-circle"></i></a>');

        $('.remove-tag').click(function (e) {
            e.preventDefault();
            $(this).parent().remove();
        });
    });
});
$(document).ready(function () {
    $('.add-field-plan').click(function (e) {
        var list = $("#fields-list-plan");
        var counter = list.data('widget-counter') | list.children().length;
        var newWidget = list.attr('data-prototype');
        newWidget = newWidget.replace(/__name__/g, counter);
        counter++;
        list.data('widget-counter', counter);
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
        newElem.append('<a id="deleteField" onClick="onClickRemove()" href="#" class="remove-tag-plan remove-btn tolt"  data-microtip-position="left" data-tooltip="Remove Room" ><i class="fal fa-times-circle"></i></a>');

        $('.remove-tag-plan').click(function (e) {
            e.preventDefault();
            $(this).parent().remove();
        });
    });
});