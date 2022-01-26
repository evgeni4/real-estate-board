// $(document).ready(function () {
//     $('.btnDelete').click(function () {
//          console.log($(this).data('id'))
//         document.getElementById('confirmDelete').value = $(this).data('id');
//     });
// });
// $(document).ready(function () {
//     $('.btnShowTags').click(function () {
//     document.getElementById('btnShowTagsElementId').innerHTML = $(this).data('id');
//     });
// });
//
// $(document).ready(function () {
//     $('.btnDeleteRow').click(function () {
//         let item = "rowItem_"+$(this).data('id')
//       document.getElementById( item ).remove();
//     });
// });
function deleteProduct(id) {
    let curl = document.getElementById('curl')
    let link = document.getElementById('link')
    curl.innerHTML = '<a href="/admin/'+link.value+'/delete/'+id+'" class ="btn btn-danger">OK</a>';
}
