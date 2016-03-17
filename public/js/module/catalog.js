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
        beforeSend:  function () {
            $("#save").html("Enviando...");
            $('#save').prop('disabled', true);
        },
        success: function (response) {

            $("#save").html("Guardar");
            $('#save').prop('disabled', false);

            if(response.action=='new'){
                location.replace(PATHAPP+'catalogs/departamentList')
            }else{

            }


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