/**
 * Created by delimce on 14/3/2016.
 */


$(document).ready(function(){
    console.log("asdfasf");
    loadProduct($("#prov_id").val());

    $("#prov_id").change(function(){
        loadProduct($(this).val());
    });

    $("#product_id").change(function(){
        $("#cod_prod").text($(this).val());

    });

    $("#addRow").click(addRow);

    $(".numer").keydown(soloNumeros);
    $(".nro_orden").keydown(verifGuadable);
    verifGuadable();

    $("#save").click(save);

});


function  isGuardable(){

    if($("#nro_orden").val().length<4){
        return false;
    }
    return true;
}

function verifGuadable(){
    if(isGuardable()){
        $("#save").prop("disable", false);
    }else {
        $("#save").prop("disable", true);
    }
}
/**agrega una nueva fila*/
function addRow(){
    var codi= $("#product_id").val();
    var desc= $("#product_id option:selected").html();
    var cant= $("#cant_prod").val();
    var unidad= $("#uni_proc").val();
    var tabla =$("#producProv  tbody");
    //if(isValid((//codi,desc,cant,unidad))){
    tabla.append(newRow(codi,desc,cant,unidad));
    //}
    verifGuadable();

    function newRow(codi,desc, cant, unidad){

        var fila = $("<tr></tr>");
        fila.html("" +
            "<td>"+codi+"</td>"+
            "<td>"+desc+"</td>"+
            "<td>"+cant+"</td>"+
            "<td>"+unidad+"</td>"+
            "<td>" +"<div class='btn-group'>" +"<button type='button' class='btn btn-default btn-flat dropdown-toggle' data-toggle='dropdown'>" +
            "<span class='caret'></span>" +
            "<span class='sr-only'>Toggle Dropdown</span>" +
            "</button>" +
            "<ul class='dropdown-menu' role='menu'>" +
            "<li><a href='' class='opEdit'>Editar</a></li>" +
            "<li><a href='' class='opDel'>Borrar</a></li>" +
            "</ul>" +
            "</div>" +
            "</td>"+
            "");
        return fila;
    }
    function isValid(codi,desc, cant, unidad){
        if( unidad.length<1 || cant.length<1){
            return false;
        }
        if(parseInt(cant)<1){
            return false;
        }
        return true;
    }
}

/**carga los productos del provedor
 * segun provedor selecionado
 * */
function loadProduct(id ){
    console.log(id);
    jQuery.ajax({
        url: PATHAPP + 'catalogs/ProviderProduct',
        type: 'POST',
        dataType: 'json',
        data:{id:id},
        beforeSend: function () {
        },
        success: function llenarProductos(response){
            var select= $("#product_id");
            select.html("");
            for(var i=0;i<response.length;i++){
                select.append("<option value="
                    +response[i]['codigo_profit']+
                    ">"+response[i]['descripcion_profit']+"</option>")
            }
            verifGuadable();

        }
    });
    verifGuadable();


}

function save(){
    console.log("sadfas");
    ////entrada de datos
    jQuery.ajax({
        url: PATHAPP + 'catalogs/PurchasingOrderSave',
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
                //  location.replace(PATHAPP+'catalogs/departamentList')
            }else{

            }
        }
    });

    function getData(){
        var id=-1;
        if($("#id").length>0){
            id=$("#id").val();
            var data= {
                id:id,
                prov_id: $("#prov_id").val(),
                motivo_id:$("#motivo_id").val(),
                comentario:$("#coment").val(),
                aprob_venta:$("#ventas").val(),
                aprob_gerencia:$("#gerencia").val(),
                items:getItems()

            }
            return data;
        }else {
            var data= {
                prov_id: $("#prov_id").val(),
                motivo_id:$("#motivo_id").val(),
                comentario:$("#coment").val(),
                aprob_venta:$("#ventas").val(),
                aprob_gerencia:$("#gerencia").val(),
                items:getItems()

            }
            return data;
        }
        function  getItems(){
            var filas =$("#producProv  tbody").contents().filter("tr");
            var data= new Array();
            var cod,cantida,unidad;
            console.log("data", filas);
            for(var i=0;i<filas.size();i++){
                var fila=$(filas[i]);
                cod=$(fila).contents().filter("td").eq(0).text();
                cantida=$(fila).contents().filter("td").eq(2).text();
                unidad=$(fila).contents().filter("td").eq(3).text();
                data.push({'producto_id':cod,'cantidad':cantida,'unidad':unidad});
            }
            return data;
        }
    }
}
/*****para caomps numerico****/
function soloNumeros(e)
{
    var key = window.Event ? e.which : e.keyCode
    if(!((key >= 48 && key <= 57) || (key==8)  || (key >= 96 && key <= 105) )){
        e.preventDefault();
    }
}