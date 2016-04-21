/**
 * Created by delimce on 14/3/2016.
 */

var itemsDel= new Array();// items eliminados
$(document).ready(function(){
    loadOrdenesdeCompra(1);
    loadPaisesProv(1);
    loadMonedaProv(1);
    loadDirecciAlmcProv(1,235);
    loadCondPagoProv(1);

    $("#add").click(function(){
        var id=$("#items").val();
        loadOrder(id, function(response){
            var tabla= $("#example1 tbody");
            var fila= $("<tr></tr>");
            fila.attr('id',response['id']);
            fila.html("" +
                "<td width='30px'><input type='button' class='btn' value='Borrar' onclick='javascript:delRow(this)'></td>" +
                "<td>"+response['id']+"</td>"+
                "<td>"+response['nro_orden']+"</td>"+
                "<td>"+response['comentario']+"</td>"+
                "<td>"+response['emision']+"</td>"+
                "");
            tabla.append(fila);
            $("#items option[value='"+id+"']").remove();
        })

    })
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

    /*if($("#nro_orden").val().length<4){
     return false;
     }*/
    return true;
}

function  delRow(obj){
    var fila = $(obj).parents("tr");
    if(fila.attr('old')){
        itemsDel.push(fila.attr('id'));
    }
    fila.remove();
}

function  editRow(obj){
    var fila = $(obj).parents("tr");
    if(fila.attr('id')!='-1'){
        $("#itemid").val(fila.attr('id'));
    }
    var celds= fila.contents('td');
    $("#cod_prod").text(celds.eq(0).text());
    $("#product_id").val(fila.attr("id"));
    $("#cant_prod").val(celds.eq(2).text());
    $("#uni_proc").val(celds.eq(3).text());
    $("#select2-product_id-container").val(celds.eq(1).text());

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

/**
 * carga los paises del provedor
 * segun provedor selecionado
 * */
function loadPaisesProv(id ){
    jQuery.ajax({
        url: PATHAPP + 'catalogs/ProviderCountry',
        type: 'POST',
        dataType: 'json',
        data:{id:'1'},
        beforeSend: function () {
        },
        success: function (response){
            var select= $("#pais_id");
            select.html("");
            for(var i=0;i<response.length;i++){
                select.append("<option value="
                    +response[i]['id']+
                    ">"+response[i]['pais']+"</option>")
            };


        }, error: function(er){
            console.log('error');
        }

    });
    verifGuadable();
}
/**carga las getProviderCoin del proveedor
 * segun proveeodr selecionado*/

/**
 * carga la direccion de almacen del provedor
 * segun provedor selecionado
 * @param id id del proveedor
 * @param pais_id id del pais selecionado
 * */
function loadDirecciAlmcProv(id , pais_id ){
    jQuery.ajax({
        url: PATHAPP + 'catalogs/ProviderAdressStore',
        type: 'POST',
        dataType: 'json',
        data:{id:id, pais_id:pais_id},
        beforeSend: function () {
        },
        success: function (response){
            var select= $("#direccion_almacen_id");
            select.html("");
            for(var i=0;i<response.length;i++){
                select.append("<option value="
                    +response[i]['id']+
                    ">"+response[i]['direccion']+"</option>")
            };


        }, error: function(er){
            console.log('error');
        }

    });
    verifGuadable();
}
/**
 * carga los maestro de pago de un proveedor del provedor
 * segun provedor selecionado
 * @param id id del proveedor
 * @param pais_id id del pais selecionado
 * */
function loadCondPagoProv(id  ){
    jQuery.ajax({
        url: PATHAPP + 'catalogs/ProviderPaymentCondition',
        type: 'POST',
        dataType: 'json',
        data:{id:id},
        beforeSend: function () {
        },
        success: function (response){
            var select= $("#condicion_pago_id");
            select.html("");
            for(var i=0;i<response.length;i++){
                select.append("<option value="
                    +response[i]['id']+
                    ">"+response[i]['titulo']+"</option>")
            };


        }, error: function(er){
            console.log('error');
        }

    });
    verifGuadable();
}


/**
 * carga los maestro de pago de un proveedor del provedor
 * segun provedor selecionado
 * @param id id del proveedor
 * @param pais_id id del pais selecionado
 * */
function loadOrder(id , callback ){
    jQuery.ajax({
        url: PATHAPP + 'catalogs/PurchaseOrder',
        type: 'POST',
        dataType: 'json',
        data:{id:id},
        beforeSend: function () {
        },
        success: callback
        , error: function(er){
            console.log('error');
        }

    });
    verifGuadable();
}


/**carga las getProviderCoin del proveedor
 * segun proveeodr selecionado*/
function loadMonedaProv(id ){
    jQuery.ajax({
        url: PATHAPP + 'catalogs/ProviderCoins',
        type: 'POST',
        dataType: 'json',
        data:{id:'1'},
        beforeSend: function () {
        },
        success: function (response){
            var select= $("#prov_moneda_id");
            select.html("");
            for(var i=0;i<response.length;i++){
                select.append("<option value="
                    +response[i]['id']+
                    ">"+response[i]['nombre']+"</option>")
            };


        }, error: function(er){
            console.log('error');
        }

    });
    verifGuadable();
}

/**carga las ordenes de compra del provedor
 * segun provedor selecionado
 * */
function loadOrdenesdeCompra(id ){
    jQuery.ajax({
        url: PATHAPP + 'catalogs/ProviderOrder',
        type: 'POST',
        dataType: 'json',
        data:{id:id},
        beforeSend: function () {
        },
        success: function (response){
            var select= $("#items");
            select.html("");
            for(var i=0;i<response.length;i++){
                select.append("<option value="
                    +response[i]['id']+
                    ">"+response[i]['nro_orden']+"</option>")
            }


        }, error: function(er){
        }

    });
    verifGuadable();
}


function save(){
    ////entrada de datos
    jQuery.ajax({
        url: PATHAPP + 'catalogs/OrderSave',
        type: 'POST',
        dataType: 'json',
        data: getData(),
        beforeSend:  function () {
            $("#save").html("Enviando...");
         //   $('#save').prop('disabled', true);
        },
        success: function (response) {

            $("#save").html("Guardar");
            $('#save').prop('disabled', false);

            if(response.action=='new'){
                // location.replace(PATHAPP+'catalogs/PurchasingOrderList')
            }else{

            }
        }
    });

    function getData(){
        var id=-1;

        var data= {
            tipo_pedido_id: $("#tipo_id").val(),
            monto:$("#monto").val(),
            prov_id:$("#prov_id").val(),
            pais_id:$("#pais_id").val(),
            condicion_pago_id:$("#condicion_pago_id").val(),
            motivo_pedido_id:$("#motivo_pedido_id").val(),
            prioridad_id:$("#prioridad_id").val(),
            pedido_estado_id:$("#pedido_estado_id").val(),
            prov_moneda_id:$("#prov_moneda_id").val(),
            direccion_almacen_id:$("#direccion_almacen_id").val(),
            condicion_pedido_id:$("#condicion_pedido_id").val(),
            nro_proforma:$("#nro_proforma").val(),
            nro_factura:$("#nro_factura").val(),
            comentario:$("#comentario").val(),
            mt3:$("#mt3").val(),
            peso:$("#peso").val(),
            nro_doc:$("#nro_doc").val(),
            items:getItems(),

        }
        console.log(data);
        if($("#id").length>0){
            data.id=$("#id").val();
        }
        if($("#tasa_fija")[0].checked){
            data.tasa=$("#tasa").val();
        }
        if(itemsDel.length>0){
            data.del=itemsDel;
        }
        if($("#comentario_cancelacion").val().length>0 || $("#cancelacion").val().length>0 ){
            data.comentario_cancelacion=($("#comentario_cancelacion").val());
            data.cancelacion=($("#cancelacion").val());
        }

        return data;

        function  getItems(){
            var data= new Array();
            var filas =$("#example1  tbody").contents().filter("tr");

            var id;

            for(var i=0;i<filas.size();i++){
                var fila=$(filas[i]);
                console.log(fila.contents().filter("td"));
                id=$(fila).contents().filter("td").eq(1).text();
                if(fila.attr('old')){
                    data.push({
                        old:1, id:id
                    });
                }else{
                    data.push({
                        id:id
                    });
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