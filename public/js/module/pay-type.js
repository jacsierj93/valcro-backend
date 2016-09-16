/**
 * Created by delimce on 14/3/2016.
 */
var saveOrUpdatePayType = function () {

    ////entrada de datos
    var form = $('#form1');

    jQuery.ajax({
        url: PATHAPP + 'catalogs/PayTypesSave',
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
                location.replace(PATHAPP+'catalogs/PayTypesList')
            }else{

            }


        }
    });

};


var deletepayType = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar Tipo de pago",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'catalogs/PayTypesDel',
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





var saveOrUpdatePos = function () {

    ////entrada de datos
    var form = $('#form1');

    jQuery.ajax({
        url: PATHAPP + 'catalogs/positionSave',
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
                location.replace(PATHAPP+'catalogs/positionList')
            }else{

            }


        }
    });

};


var deletePos = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar Cargo",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'catalogs/positionDel',
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



var saveOrUpdateSuc = function () {

    ////entrada de datos
    var form = $('#form1');

    jQuery.ajax({
        url: PATHAPP + 'catalogs/sucursalSave',
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
                location.replace(PATHAPP+'catalogs/sucursalList')
            }else{

            }


        }
    });

};

var deleteSuc = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar Sucursal",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'catalogs/sucursalDel',
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

