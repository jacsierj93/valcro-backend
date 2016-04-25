/**
 * Created by Leugim on 28/03/16.
 */

var itemsDel= new Array();
$(document).ready(function()
    {
        $("#btadd").click(addrow);
        $("#titulo").keydown("change", function(){
            if(isGuardable()){
                $("#save").prop("disabled", false);
                $("#save").addClass("bg-orange");


            }else{
                $("#save").prop("disabled", true);
                $("#save").removeClass("bg-orange");

            }
        })
        $(".numer").keydown(soloNumeros);
        $(".item").on("click",loadData);
        $(".opDel").on("click",function(e){
            var fila= $(this).parents("tr");
            itemsDel.push($(this).attr('id'));
            fila.remove();
        });

        $(".opEdit").on("click",function(e){
            var fila= $(this).parents("tr");
            var por,di, des;
            por=$(fila).contents().filter("td").eq(1).text();
            di=$(fila).contents().filter("td").eq(2).text();
            des=$(fila).contents().filter("td").eq(3).text();
            $("#porcentaje").val($.trim(por));
            $("#dias").val($.trim(di));
            $("#descripcion").val($.trim(des));
            if(fila.attr("id")){
                $("#itemid").attr("value",fila.attr("id"));
            }else {
                $("#itemid").attr("value","-1");
            }
            fila.remove();
            if(isGuardable()){
                $("#save").prop("disabled", false);
                $("#save").addClass("bg-orange");
            }else{
                $("#save").prop("disabled", true);
                $("#save").removeClass("bg-orange");

            }
        });

    }
);


var saveOrUpdateProvPayCond = function () {

    jQuery.ajax({
        url: PATHAPP + 'catalogs/CondPagoProvSave',
        type: 'POST',
        dataType: 'json',
        data: getData(),
        beforeSend:  function () {
            $("#save").html("Enviando...");
            $('#save').prop('disabled', true);
        },
        success: function (response) {

            $("#save").html("Guardar");
            $('#save').prop('disabled', false);

            if(response.action=='new'){
                location.replace(PATHAPP+'catalogs/CondPagoProvList');
            }else{
                //alert("asdfasdf");
                showUpdateMsjProvCondiPay();
            }


        }, error: function(response){
            console.log(response);
        }

    });

};

var deleteProvPayCond = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar condicion de Pago a Provedor",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'catalogs/CondPagoProvDel',
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

function showUpdateMsjProvCondiPay () {
    $.confirm({
        text: "Actualizado",
        title: "Edicion de Condicon de pago a Provedor",
        confirm: function () {
            location.replace(PATHAPP+'catalogs/CondPagoProvList');

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

/****************************************Funciones para el editar/crear condiciones de pago a provedor ***************************/
/**construye el json para pasar a la base de datos
 * @return objeto json
 * **/
function  getData(){
    if(isGuardable()){
        var hidden= $("#id");
        if(hidden.length==0){
            var data={
                titulo:$("#titulo").val(),
                items:getDataTable()
            }
            return data;
        }else{
            var data={
                titulo:$("#titulo").val(),
                items:getDataTable(),
                id: hidden.val(),
                del:itemsDel

            }
            return data
        }
    }
    //convierte los datos de la tabla a array de datos
    function getDataTable(){
        var data= new Array();
        var filas= $("#items tbody").contents().filter("tr");
        console.log("filas tableeee", filas);
        var por,di, des;
        var fila;
        for(var i=0;i<filas.size();i++){
            var fila=$(filas[i]);
            console.log("filas", fila);
            if(fila.attr("id")){
                por=$(fila).contents().filter("td").eq(1).text();
                di=$(fila).contents().filter("td").eq(2).text();
                des=$(fila).contents().filter("td").eq(3).text();
                data.push({id:fila.attr('id'),'porcentaje':por,'dias':di,'descripcion':des});
            }else {
                por=$(fila).contents().filter("td").eq(1).text();
                di=$(fila).contents().filter("td").eq(2).text();
                des=$(fila).contents().filter("td").eq(3).text();
                data.push({'porcentaje':por,'dias':di,'descripcion':des});
            }
        }



        /*$("#items tbody tr").each(function (index)
         {
         var campo1, campo2, campo3;
         $(this).children("td").each(function (index2)
         {
         switch (index2)
         {
         case 1: campo1 = $(this).text();
         break;
         case 2: campo2 = $(this).text();
         break;
         case 3: campo3 = $(this).text();
         break;
         }

         });
         data.push({'porcentaje':campo1,'dias':campo2,'descripcion':campo3})

         });*/

        return data;


    }


}

/******* verifica si es posible guardar la data
 * @return true o false
 * ****/
function  isGuardable(){
    if(getrestanta()!=0){
        console.log("faltan ",getrestanta());
        return false;
    }
    if($("#titulo").val().length<1){
        return false;
    }
    return true;
}

function getrestanta(){
    var allItem= $(".mntPorc");
    var total= 0;
    console.log(allItem);
    for(var i= 0;i<allItem.size();i++){
        total+=parseInt(allItem[i].innerHTML);

    }
    return 100-total;
}
///evento agrga la fila en
function addrow(e){
    if(isValido( parseInt($('#porcentaje').val()))) {
        var table = $("#items tbody");
        table.prepend(newRow($('#porcentaje').val(),$('#dias').val(),$('#descripcion').val() ));
        if(isGuardable()){
            $("#save").prop("disabled", false);
            $("#save").addClass("bg-orange");


        }else{
            $("#save").prop("disabled", true);
            $("#save").removeClass("bg-orange");

        }
    }
    /// validacion
    function isValido(newMonto){

        var allItem= $(".mntPorc");
        var total= 0;
        console.log(allItem);
        for(var i= 0;i<allItem.size();i++){
            total+=parseInt(allItem[i].innerHTML);

        }
        total+=newMonto;
        console.log(total);
        if(total<=100 && total>0){
            return true;
        }
        return false;
    }
    // agrga una fila s
    function newRow(porcentaje,dias, descripcion){
        var fila= $("<tr></tr>");
        if($("#itemid").attr("value")!="-1"){
            fila.attr("id", $("#itemid").attr("value") );
        }
        fila.html("<td>" +"<div class='btn-group'>" +"<button type='button' class='btn btn-default btn-flat dropdown-toggle' data-toggle='dropdown'>" +
            "<span class='caret'></span>" +
            "<span class='sr-only'>Toggle Dropdown</span>" +
            "</button>" +
            "<ul class='dropdown-menu' role='menu'>" +
            "<li><a href='' class='opEdit'>Editar</a></li>" +
            "<li><a href='' class='opDel'>Borrar</a></li>" +
            "</ul>" +
            "</div>" +
            "</td>" +
            "<td class='mntPorc'>" + porcentaje +"</td>" +
            "<td>" + dias +"</td>" +
            "<td>" +descripcion+"</td>");
        return fila;
    }


}

function soloNumeros(e)
{
    var key = window.Event ? e.which : e.keyCode
    if(!((key >= 48 && key <= 57) || (key==8)  || (key >= 96 && key <= 105) )){
        e.preventDefault();
    }
}

/****************************************Funciones para el list condiciones de pago a provedor ***************************/

function newRowNoOp(porcentaje,dias, descripcion){
    return $("<tr class='itemRow'>" +
        "<td class='mntPorc'>" +
        porcentaje
        +
        "</td>" +
        "<td>" +
        dias
        +
        "</td>" +
        "<td>" +
        descripcion
        +
        "</td>" +
        "</tr>");
}

function loadData(){
    jQuery.ajax({
        url: PATHAPP + 'catalogs/CondPagoProvItems',
        type: 'POST',
        dataType: 'json',
        data:{'id':$(this).attr('id')},
        success: function (response) {
            var table = $("#items tbody");

            table.html("");
            for(var i=0;i<response.length;i++){
                table.append(
                    newRowNoOp(
                        $.trim(response[i]['porcentaje']),
                        $.trim(response[i]['dias']),
                        $.trim(response[i]['descripcion'])
                    ));
            }
        }, error: function(response){
            console.log(response);
        }

    });
}

