/**
 * Created by Leugim on 28/03/16.
 */
var saveOrUpdateProvType = function () {

    ////entrada de datos
    var form = $('#form1');

    jQuery.ajax({
        url: PATHAPP + 'catalogs/providerTypesSave',
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
                location.replace(PATHAPP+'catalogs/providerTypesList');
            }else{
                //alert("asdfasdf");
                showUpdateMsjProvTipe();
            }


        }, error: function(response){
            console.log(response);
        }

    });

};

var deleteProvTipe = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar Tipo de Provedor",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'catalogs/providerTypesDel',
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

function showUpdateMsjProvTipe () {
    $.confirm({
        text: "Actualizado",
        title: "Edicion de Tipo de Provedor",
        confirm: function () {
            location.replace(PATHAPP+'catalogs/providerTypesList');

        },
        cancel: function (button) {
            // nothing to do
        },
        confirmButton: "Continuar",
        post: false,
        confirmButtonClass: "btn-success",
        cancelButtonClass: "btn-default",
        dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
    });

}

