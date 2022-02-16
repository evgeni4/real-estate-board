$(document).ready(function () {
    $('#spinner').hide()
    var searchRequest = null;
    $("#search_keywords").keyup(function () {
        console.log('ok')
        var minlength = 1;
        var that = this;
        var value = $(this).val();
        var entitySelector = $("#entitiesNavSm").html('');
        if (value.length >= minlength) {
            if (searchRequest != null)
                searchRequest.abort();
            searchRequest = $.ajax({
                type: "GET",
                url: "/search",
                data: {
                    'q': value
                },
                dataType: "text",
                success: function (msg) {
                    //we need to check if the value is the same
                    if (value == $(that).val()) {
                        var result = JSON.parse(msg);
                        $.each(result, function (key, arr) {
                            $.each(arr, function (id, value) {
                                if (key == 'entities') {
                                    if (id != 'error') {
                                        entitiesNavSm.classList.remove('display')
                                        entitySelector.append('<li id="res_sm_'+id+'" value="' + value + '" onClick="onClickAddSm('+id+')"><a  data-title="' + value + '" class="list-group-item">' + value + '</a></li>');
                                    } else {
                                        entitySelector.append('<li class="errorLi">' + value + '</li>');
                                    }
                                }
                            });
                        });
                    }
                }
            });
        }
    });
});
$(document).ready(function () {
    $('#spinner').hide()
    var searchRequest = null;
    $("#search_advanced_keywords").keyup(function () {
        console.log('ok')
        var minlength = 1;
        var that = this;
        var value = $(this).val();
        var entitySelector = $("#entitiesNav").html('');
        if (value.length >= minlength) {
            $('#spinner').show()
            if (searchRequest != null)
                searchRequest.abort();
            searchRequest = $.ajax({
                type: "GET",
                url: "/search",
                data: {
                    'q': value
                },
                dataType: "text",
                success: function (msg) {
                    //we need to check if the value is the same
                    if (value == $(that).val()) {
                        var result = JSON.parse(msg);
                        $.each(result, function (key, arr) {
                            $.each(arr, function (id, value) {
                                if (key == 'entities') {
                                    if (id != 'error') {
                                        entitiesNav.classList.remove('display')
                                        entitySelector.append('<li id="res_'+id+'" value="' + value + '" onClick="onClickAdd('+id+')"><a  data-title="' + value + '" class="list-group-item">' + value + '</a></li>');
                                    } else {
                                        entitySelector.append('<li class="errorLi">' + value + '</li>');
                                    }
                                }
                            });
                        });
                    }
                }
            });
        }
    });
});
function onClickAdd(id){
    let input = document.getElementById('search_advanced_keywords')
    let entitiesNav = document.getElementById('entitiesNav')
    input.value=document.getElementById('res_'+id).getAttribute("value")
    entitiesNav.classList.add('display')
}
function onClickAddSm(id){
    let input = document.getElementById('search_keywords')
    let entitiesNavSm = document.getElementById('entitiesNavSm')
    input.value=document.getElementById('res_sm_'+id).getAttribute("value")
    entitiesNavSm.classList.add('display')
}