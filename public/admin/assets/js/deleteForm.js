$(document).ready(function () {
    $('.btnDelete').click(function () {
         console.log($(this).data('id'))
        document.getElementById('confirmDelete').value = $(this).data('id');
    });
});
$(document).ready(function () {
    $('.btnShowTags').click(function () {
    document.getElementById('btnShowTagsElementId').innerHTML = $(this).data('id');
    });
});

$(document).ready(function () {
    $('.btnDeleteRow').click(function () {
        let item = "rowItem_"+$(this).data('id')
      document.getElementById( item ).remove();
    });
});
function deleteProduct(id) {
     console.log(id)
    document.getElementById('confirmDelete').value = id;
}
