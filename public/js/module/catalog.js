/**
 * Created by delimce on 14/3/2016.
 */
var saveOrUpdateDep = function () {

    ////entrada de datos
    var form = $('#form1');

    jQuery.ajax({
        url: PATHAPP + 'catalogs/departamentSave',
        type: 'POST',
        dataType: 'json',
        data: form.serialize(),
        /*        beforeSend: function (xhr) {
         // xhr.setRequestHeader( "Authorization", "BEARER " + access_token );
         },*/
        beforeSend: function () {
            $("#save").val("Enviando...")
        },
        success: function (response) {
            location.replace(PATHAPP + '/catalogs/departamentList')
        }
    });

};

var deleteDep = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar Departamento",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'catalogs/departamentDel',
                type: 'POST',
                data: {"id": id},
                success: function (response) {
                    location.reload();
                }

            });
        },
        cancel: function (button) {
            // nothing to do
        },
        confirmButton: "Si, lo estoy",
        cancelButton: "No",
        post: true,
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-default",
        dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
    });

}