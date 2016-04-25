/**
 * Created by delimce on 14/3/2016.
 */

$(document).ready(function()
    {
        $(".numer").keydown(soloNumeros);
        $( "#min_dia" ).keydown(function() {
            minOrMax ();
            $( "#min_hid" ).prop( "hidden", true );

        });
        $( "#max_dia" ).keydown(function() {
            minOrMax ();
            $( "#max_hid" ).prop( "hidden", true );
        });
    }
);

var saveOrUpdateDep = function () {

    ////entrada de datos
    var form = $('#form1');
    console.log('frm', form.serialize());
   if( minOrMax()){
        //esta bien
    $.ajax({

        url: PATHAPP + 'catalogs/tiemAproTranSave',
        type: 'POST',
        dataType: 'JSON',
        data: form.serialize(),
        beforeSend:  function () {
            $("#save").html("Enviando...");
            $('#save').prop('disabled', true);

        },
        success: function (response) {
            console.log('error', response);
            $("#save").html("Guardar");
            $('#save').prop('disabled', false);

            if(response.success){
                minOrMax ();
                if(response.action=='new'){
                    location.replace(PATHAPP+'catalogs/tiemAproTranList')
                }else {

                    showUpdateMsjProvTiemTran ();
                }
            } else{
                showErrorMsjProvTipeEnv ();
            }
        },
       /* error: function(response){
            $("body").append(response.responseText)
            console.log('error', response);
        }*/
    });
   }else{
       //$('#save').prop('disabled', true);
   }
};


var deleteDep = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'catalogs/tiemAproTranDel',
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

function showUpdateMsjProvTiemTran () {
    $.confirm({
        text: "Actualizado",
        title: "Edición de Tiempo Aproximado de Transito",
        confirm: function () {
            location.replace(PATHAPP + 'catalogs/tiemAproTranList');

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

function showErrorMsjProvTipeEnv () {
    $.confirm({
        text: "Por favor llenar todos los campos",
        title: "Campos Obligatorios",
        confirm: function () {
           // location.replace(PATHAPP + 'catalogs/tiemAproTranList');

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

function soloNumeros(e)
{
    var key = window.Event ? e.which : e.keyCode
    if(!((key >= 48 && key <= 57) || (key==8)  || (key >= 96 && key <= 105))){
        e.preventDefault();
    }
}
//console.log('funcion', minOrMax());
function minOrMax (){
    var minimo= $('#min_dia').val();
   //console.log('valor', $('#min_dia').val());
    var min= parseInt(minimo);
   //console.log('valor',$('#max_dia').val());
    //console.log('min',min);
    var maximo= $('#max_dia').val();
    var max= parseInt(maximo);
    console.log('max',max);
    //valido
    var paso=true;


    //minimo mayor que maximo
    if((min >= max) ){
        $( "#min_dia" ).addClass( "alerta" );
        paso=false;
    }else{

            $( "#min_dia" ).removeClass( "alerta");
    }

    //valor entre 1 y 365 dias
   if ( (min > 365) ){

       $( "#min_hid" ).prop( "hidden", false );
       paso=false;
   }else{
       $( "#min_hid" ).prop( "hidden", true );
   }

    if((max > 365)){
        $("#dias_hid" ).prop( "hidden", false );
        paso=false;
    }else {

        $("#dias_hid").prop("hidden", true);
    }

    //maximo menor que minimo
    if ((max < min)){
        $( "#max_dia" ).addClass( "alerta" );
    }else{
        $( "#max_dia" ).removeClass( "alerta");

    }
    return paso;
}