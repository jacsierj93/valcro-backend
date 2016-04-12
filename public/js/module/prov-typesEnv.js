/**
 * Created by delimce on 14/3/2016.
 */
var saveOrUpdateDep = function () {

    ////entrada de datos
    var form = $('#form1');

    $.ajax({

        url: PATHAPP + 'catalogs/providerTypesSendSave',
        type: 'POST',
        dataType: 'JSON',
        data: form.serialize(),
        beforeSend:  function () {
            $("#save").html("Enviando...");
            $('#save').prop('disabled', true);
        },
        success: function (response) {

            $("#save").html("Guardar");
            $('#save').prop('disabled', false);

            if(response.action=='new'){
                location.replace(PATHAPP+'catalogs/providerTypesSendList')
            }else{
                showUpdateMsjProvTipeEnv ();
            }


        },
        error: function(response){
            $("body").append(response.responseText)
            console.log('error', response);
        }
    });

};


var deleteDep = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar Tipo de Envio",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'catalogs/providerTypesSendDel',
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

function showUpdateMsjProvTipeEnv () {
    $.confirm({
        text: "Actualizado",
        title: "Edición de Tipos de Envíos",
        confirm: function () {
            location.replace(PATHAPP + 'catalogs/providerTypesSendList');

        },
        cancel: function (button) {
            // nothing to do
        },
        confirmButton: "Continuar",
        post: false,
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-default",
        dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
    });
}

