/**
 * Created by delimce on 14/3/2016.
 */

$(document).ready(function(){
    loadPedidos(1);
})

var deletePedido = function (id) {
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

/**carga los productos del provedor
 * segun provedor selecionado
 * */
function loadPedidos(id ){
    console.log(id);
    jQuery.ajax({
        url: PATHAPP + 'catalogs/OrderList',
        type: 'POST',
        dataType: 'json',
        data:{id:id},
        beforeSend: function () {
        },
        success: function (response){
            var tabla =$("#example1  tbody");
            tabla.html("");
            var fila;
            for (var i=0;i<response.length;i++){
                fila= $("<tr></tr>");
                fila.html("<td>" +"<div class='btn-group'>" +"<button type='button' class='btn btn-default btn-flat dropdown-toggle' data-toggle='dropdown'>" +
                    "<span class='caret'></span>" +
                    "<span class='sr-only'>Toggle Dropdown</span>" +
                    "</button>" +
                    "<ul class='dropdown-menu' role='menu'>" +
                    "<li><a href='OrderForm?id="+response[i]['id']+"' class='opEdit'>Editar</a></li>" +
                    "<li><a href='javascript:deletePedido('"+response[i]['id']+"') class='opDel'>Borrar</a></li>" +
                    "</ul>" +
                    "</div>" +
                    "</td>" +
                    "<td >" + response[i]['nro_doc'] +"</td>" +
                    "<td >" + response[i]['nro_proforma'] +"</td>" +
                    "<td >" + response[i]['emision'] +"</td>"+
                    "<td >" + response[i]['nro_factura'] +"</td>"+
                "<td >" + response[i]['monto'] +"</td>"
                );
                tabla.append(fila);
            }

            /** <th width="30px">&nbsp;</th>
             <th>Nro Pedido</th>
             <th>Proforma</th>
             <th>Emision </th>
             <th>Factura</th>
             <th>Monto</th>*/
            console.log(response);
        }, error: function(er){
            console.log('error');
        }

    });
}
