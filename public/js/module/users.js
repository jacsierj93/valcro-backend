/**
 * Created by delimce on 14/3/2016.
 */


/**
 * guarda datos basicos del usuario
  */
var saveBasic = function () {

    ////entrada de datos basicos
    var form = $('#form1');

    jQuery.ajax({
        url: PATHAPP + 'users/saveOrUpdate',
        type: 'POST',
        dataType: 'json',
        data: form.serialize(),
        beforeSend: function () {
        },
        success: function (response) {
            // response
            var msg = "";


        }
    });

};

var saveAccess = function () {

    ////entrada de datos basicos
    var form = $('#form2');

    jQuery.ajax({
        url: PATHAPP + 'users/saveOrUpdate',
        type: 'POST',
        dataType: 'json',
        data: form.serialize(),
        beforeSend: function () {
        },
        success: function (response) {
            // response
            var msg = "";


        }
    });

};

var savePreferences = function () {

    ////entrada de datos basicos
    var form = $('#form4');

    jQuery.ajax({
        url: PATHAPP + 'users/savePrefs',
        type: 'POST',
        dataType: 'json',
        data: form.serialize(),
        beforeSend: function () {
        },
        success: function (response) {
            // response
            var msg = "";


        }
    });

};



var deleteUser = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar Usuario",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'users/userDel',
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