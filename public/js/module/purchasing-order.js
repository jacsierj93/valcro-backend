/**
 * Created by delimce on 14/3/2016.
 */

var itemsDel= new Array();// items eliminados
$(document).ready(function(){
    console.log("asdfasf");
    loadProduct($("#prov_id").val());

    $("#prov_id").change(function(){
        loadProduct($(this).val());
        loadDireccion($(this).val());
        //loadDireccion
    });

    $("#product_id").change(function(){
        $("#cod_prod").text($(this).val());

    });

    $("#addRow").click(addRow);

    $(".numer").keydown(soloNumeros);
    $(".nro_orden").keydown(verifGuadable);
    verifGuadable();

    $("#save").click(save);

    $(".opDel").on("click",function(e){
        e.preventDefault();
    });


});

var deleteOrderComp = function (id) {
    $.confirm({
        text: "Esta seguro que desea borrar este registro?",
        title: "Borrar Orden de Compra",
        confirm: function () {
            jQuery.ajax({
                url: PATHAPP + 'catalogs/PurchasingOrderDel',
                type: 'POST',
                data: {"id": id},
                success: function (response) {
                    //  location.reload();
                }

            });
            alert("");
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

function  isGuardable(){

    if($("#nro_orden").val().length<4){
        return false;
    }
    return true;
}

function  delRow(obj){
    var fila = $(obj).parents("tr");
    console.log('obj', fila);
    if(fila.attr('id')!='-1'){
        itemsDel.push(fila.attr('id'));
    }
    fila.remove();
}
function  editRow(obj){
    var fila = $(obj).parents("tr");
    console.log('obj', fila);
    if(fila.attr('id')!='-1'){
        $("#itemid").val(fila.attr('id'));
    }
    var celds= fila.contents('td');
    $("#cod_prod").text(celds.eq(0).text());
    $("#product_id").val(fila.attr("id"));
    $("#cant_prod").val(celds.eq(2).text());
    $("#uni_proc").val(celds.eq(3).text());
    $("#select2-product_id-container").val(celds.eq(1).text());

    console.log('celdas', celds);
    fila.remove();
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
    var codi= $("#cod_prod").text();
    var desc= $("#product_id option:selected").html();
    var cant= $("#cant_prod").val();
    var unidad= $("#uni_proc").val();
    var profit= $("#product_id").val();
    var tabla =$("#producProv  tbody");
   var id= $("#itemid").val();
    tabla.append(newRow(id,codi,desc,cant,unidad,profit ));
    $("#itemid").val('-1');
    verifGuadable();

}

function newRow(id, codi,desc, cant, unidad, profi){
    var fila = $("<tr id='"+id+"'></tr>");
    fila.html("" +
        "<td>"+codi+"</td>"+
        "<td id='"+profi+"'>"
        +desc+"</td>"+
        "<td>"+cant+"</td>"+
        "<td>"+unidad+"</td>"+
        "<td><input type='button' class='' style='background-color: white; border: 0px;' " +
        "onclick='javascript:delRow(this)' value='Borrar'/>" +
        "<input type='button' class='' style='background-color: white; border: 0px;' onclick='javascript:editRow(this)' value='Editar'/>" +
        "</td>"+
        "");
    return fila;
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
        success: function (response){
            var select= $("#product_id");
            select.html("");
            for(var i=0;i<response.length;i++){
                select.append("<option value="
                    +response[i]['id']+
                    ">"+response[i]['descripcion_profit']+"</option>")
            }
            verifGuadable();
            loadDireccion(id);

        }
    });
    verifGuadable();
}

/**carga los productos del provedor
 * segun provedor selecionado
 * */
function loadDireccion(id ){
    console.log(id);
    jQuery.ajax({
        url: PATHAPP + 'catalogs/ProviderAlmacenDir',
        type: 'POST',
        dataType: 'json',
        data:{id:id},
        beforeSend: function () {
        },
        success: function llenarProductos(response){
            var select= $("#direccion_id");
            select.html("");
            console.log(response);
            for(var i=0;i<response.length;i++){
                select.append("<option value="
                    +response[i]['id']+
                    ">"+response[i]['direccion']+"</option>")
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
                 location.replace(PATHAPP+'catalogs/PurchasingOrderList')
            }else{

            }
        }
    });

    function getData(){

        var data= {
            prov_id: $("#prov_id").val(),
            motivo_id:$("#motivo_id").val(),
            comentario:$("#coment").val(),
            nro_orden:$("#nro_orden").val(),
            direccion_id:$("#direccion_id").val(),
            items:getItems(),
            del:itemsDel

        }

        if($("#id").length>0){
           data.id=$("#id").val();
        }

        if($("#aprobada").checked){
            data.aprovada=1;
        }else {
            data.aprovada=0;
        }
        return data;

        function  getItems(){
            var filas =$("#producProv  tbody").contents().filter("tr");
            var data= new Array();
            var cod,cantida,unidad,id;
            console.log("data", filas);
            for(var i=0;i<filas.size();i++){
                var fila=$(filas[i]);
                console.log('fila ',fila);
                cod=$(fila).contents().filter("td").eq(0).text();
                cantida=$(fila).contents().filter("td").eq(2).text();
                unidad=$(fila).contents().filter("td").eq(3).text();
                id=fila.attr('id');
                console.log('id row',id);
                if(id != "-1"){
                     data.push({id:id,'producto_id':cod,'cantidad':cantida,'unidad':unidad});
                }else{
                    data.push({'producto_id':cod,'cantidad':cantida,'unidad':unidad});
                }

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