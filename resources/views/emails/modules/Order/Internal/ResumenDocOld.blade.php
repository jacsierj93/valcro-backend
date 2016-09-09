<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <title>Valcro</title>
</head>

<body style="width: 100%; height: 100%; margin: 0; padding: 0px;">
<table class="container1" style="border-spacing: 0px; margin: auto; padding: 0px;">
    <tr style="margin: 0; padding: 0px;">
        <td height="5" width="5" style="background-size: auto; color: rgb(140,140,140); background: url(http://valcro.com.ve/mailer/images/sdw_top_left.jpg); margin: 0; padding: 0px;"></td>
        <td height="5" style="background-size: auto; color: rgb(140,140,140); background: url(http://valcro.com.ve/mailer/images/sdw_top_center.jpg) repeat-x; margin: 0; padding: 0px;"></td>
        <td height="5" width="5" style="background-size: auto; color: rgb(140,140,140); background: url(http://valcro.com.ve/mailer/images/sdw_top_right.jpg); margin: 0; padding: 0px;"></td>
    </tr>
    <tr style="margin: 0; padding: 0px;">
        <td width="5" style="color: rgb(140,140,140); background: url(http://valcro.com.ve/mailer/images/sdw_left_center.jpg) repeat-y; margin: 0; padding: 0px;"></td>
        <td style="color: rgb(140,140,140); margin: 0; padding: 0px;">
            <table class="container1" style="max-width: 100%; display: block; margin: auto; padding: 0px;">
                <tr style="margin: 0; padding: 0px;">
                    <td style="color: rgb(140,140,140); margin: 0; padding: 12px;">
                        <div class="container2" style="width: 100%; margin: 0; padding: 0px;">

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td align="center" width="30%" style="color: rgb(140,140,140); margin: 0; padding: 12px;"><img width="204px" height="52px" src='http://valcro.com.ve/images/logo-head.png' style="margin: 0; padding: 0px;"></td>
                                    <td width="30%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Emision:
                                        <p id="fec_emis" style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$emision}}
                                        </p></td>
                                    <td width="30%" align="right" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Nro:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$id}}
                                        </p></td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td align="center" height="1" style="border-top-width: 1px; border-top-color: #e8e8e8; border-top-style: solid; color: rgb(140,140,140); margin: 0; padding: 12px;">
                                        Notificacion de {{$accion}}
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td width="30%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Responsable:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$responsable}}
                                        </p></td>
                                    <td width="30%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Correo:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$correo}}
                                        </p>
                                    </td>
                                    <td width="30%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Tipo documento:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$documento}}
                                        </p>
                                    </td>
                                    <td width="5%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Version:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$version}}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Proveedor:
                                        <p id="descripcion" style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$proveedor}}
                                        </p></td>
                                    <td width="30%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Pais:
                                        <p id="descripcion" style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$pais}}
                                        </p></td>
                                </tr>

                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Titulo:
                                        <p id="descripcion" style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$titulo}}
                                        </p></td>
                                </tr>

                            </table>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td width="25%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Proforma:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$nro_proforma}}
                                        </p></td>
                                    <td width="25%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Factura:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$nro_factura}}
                                        </p>
                                    </td>
                                    <td width="40%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Condicion de pago:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$condicion_pago}}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td width="40%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Dir. Facturacion:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$dir_facturacion}}
                                        </p>
                                    </td>
                                    <td width="25%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Monto:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$monto}}
                                        </p></td>
                                    <td width="25%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Tasa:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$tasa}}
                                        </p>
                                    </td>

                                </tr>
                            </table>

                            @if ($cancelado)
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr style="margin: 0; padding: 0px;">
                                        <td width="40%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Fecha Cancelación
                                            <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                                {{$fecha_cancelacion}}
                                            </p>
                                        </td>
                                        <td width="50%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Comentario Cancelación:
                                            <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                                {{$comentario_cancelacion}}
                                            </p></td>

                                    </tr>
                                </table>
                            @endif

                            @if ($aprob_compras)
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr style="margin: 0; padding: 0px;">
                                        <td width="20%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Fecha Aprobación Compras
                                            <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                                {{$fecha_aprobacion_compras}}
                                            </p>
                                        </td>
                                        <td width="20%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">N° Documento
                                            <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                                {{$nro_doc}}
                                            </p></td>

                                    </tr>
                                </table>
                            @endif
                            @if ($aprob_gerencia)
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr style="margin: 0; padding: 0px;">
                                        <td width="20%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Fecha Aprobación Compras
                                            <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                                {{$fecha_aprobacion_gerencia}}
                                            </p>
                                        </td>

                                    </tr>
                                </table>
                            @endif

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">
                                        <p  style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px; text-align: center;">
                                            Articulos
                                        </p></td>
                                </tr>

                            </table>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td width="20%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Todos
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$articulos}}
                                        </p>
                                    </td>

                                    <td width="20%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">KitchenBoxs
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$articulos_kitchenBox}}
                                        </p>
                                    </td>
                                    <td width="20%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Contra Pedidos
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$articulos_contraPedido}}
                                        </p>
                                    </td>

                                </tr>
                            </table>


                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td align="center" style="color: rgb(140,140,140); margin: 0; padding: 12px;">
                                        <div class="btn" style="text-align: center; font-size: 22px; border-radius: 10px; background: rgb(238,141,0); margin: 0 5px 0 0; padding: 14px 12px;" align="center">
                                            <a href="http://10.15.2.76/dev/External/Email?module=order&id={{$id}}&tipo={{$tipo}}" style="color: #ffffff; text-decoration: none; margin: 0; padding: 0px;">Click aquí para ir al documento</a>
                                        </div></td>
                                </tr>
                            </table>
                        </div></td>

                </tr>
            </table></td>
        <td width="5" style="color: rgb(140,140,140); background: url(http://valcro.com.ve/mailer/images/sdw_right_center.jpg) repeat-y; margin: 0; padding: 0px;"></td>
    </tr>
    <tr style="margin: 0; padding: 0px;">
        <td height="5" width="5" style="background-size: auto; color: rgb(140,140,140); background: url(http://valcro.com.ve/mailer/images/sdw_bottom_left.jpg); margin: 0; padding: 0px;"></td>
        <td height="5" style="background-size: auto; color: rgb(140,140,140); background: url(http://valcro.com.ve/mailer/images/sdw_bottom_center.jpg) repeat-x; margin: 0; padding: 0px;"></td>
        <td height="5" width="5" style="background-size: auto; color: rgb(140,140,140); background: url(http://valcro.com.ve/mailer/images/sdw_bottom_right.jpg); margin: 0; padding: 0px;"></td>
    </tr>
</table>
</body>
</html>