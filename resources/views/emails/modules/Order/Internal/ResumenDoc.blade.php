<?=HTML::style("http://fonts.googleapis.com/css?family=Roboto") ?>
<div style="width: 100%;min-height: 100%;margin: 0;padding: 0; font-family: Roboto;">
    <table style="border-spacing: 0;margin: auto;padding: 0; width: 600px;">
        <tbody>
        <tr style="margin: 0;padding: 0px"><td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_top_left.jpg');" ></td>
            <td height="5" style="color: rgb(140,140,140);background: repeat-x;margin: 0;padding: 0;background-image: url('http://valcro.com.ve/mailer/images/sdw_top_center.jpg');"></td>
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0;background-image: url('http://valcro.com.ve/mailer/images/sdw_top_right.jpg'); " ></td>
        </tr>
        <tr style="margin: 0;padding: 0px">
            <td width="5" style="color: rgb(140,140,140);background: repeat-y;margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_left_center.jpg')" ></td>
            <td style="color: rgb(140,140,140);margin: 0;padding: 0px">
                <table style="max-width: 100%;display: block;margin: auto;padding: 0px ;box-shadow: 0px 0px 14px rgb(241,241,241)">
                    <tbody>
                    <tr style="margin: 0;padding: 0px">
                        <td style="color: rgb(140,140,140);margin: 0;padding: 10px;">
                            <div style="width: 100%;margin: 0;padding: 0px">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px"><td align="center" width="30%" style="color: rgb(140,140,140);margin: 0;padding: 10px;; text-align: left;"><img width="150px"  style="margin: 0;padding: 0px" src='http://valcro.com.ve/images/logo-head.png' ></td>
                                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Emision:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$emision}}
                                            </p></td>
                                        <td width="30%" align="right" style="color: rgb(140,140,140);margin: 0;padding: 10px; font-weight: bold;">Nro.
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                                {{$id}}
                                            </p></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px">
                                        <td   width="90%" align="center" style="color: rgb(140,140,140);margin: 0;padding: 10px;">
                                            Notificacion de {{$accion}}
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td  width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Titulo:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$titulo}}
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Responsable:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                                {{$responsable}}
                                            </p></td>
                                        <td width="30" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Correo:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$correo}}</p>
                                        </td>
                                        <td   width="20%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Tipo Doc:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$documento}}</p>
                                        </td>
                                        <td width="10%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px; font-weight: bold;">Version:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$version}}
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>


                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px">
                                        <td width="60%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Proveedor:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$proveedor}}
                                            </p></td>
                                        <td width="30" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Pais:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$pais}}</p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px">
                                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Proforma:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                                {{$nro_proforma}}
                                            </p>
                                        </td>
                                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Factura:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                                {{$nro_factura}}</p>
                                        </td>
                                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;">Cond. Pago:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                                {{$condicion_pago}} </p>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="60%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Dir. Facturacion:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$dir_facturacion}}
                                            </p>
                                        </td>
                                        <td width="20%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Monto:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$monto}}</p>
                                        </td>
                                        <td width="10%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Tasa:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                                {{$tasa}} </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0; height: 10px;"></div>


                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td align="center" width="30%">
                                            <div style="color: #ffffff;text-align: center;font-size: 16px;border-radius: 10px;background: @if($aprob_gerencia)#00CD00 @else #e3e3e3  @endif ;margin: 0 5px 0 0;padding: 14px 10px;" align="center">Aprobado por<br>Gerente</div></td>
                                        <td align="center" width="30%">
                                            <div style="color: #ffffff;text-align: center;font-size: 16px;border-radius: 10px;background:@if($aprob_compras)#00CD00 @else #e3e3e3  @endif ;margin: 0 5px 0 0;padding: 14px 10px;" align="center">Aprobado por<br>Compras</div></td>
                                        <td align="center" width="30%">
                                            <div style="color: #ffffff;text-align: center;font-size: 16px;border-radius: 10px;background: @if($cancelado)#00CD00 @else #e3e3e3  @endif ;margin: 0 5px 0 0;padding: 14px 10px;" align="center">Cancelado<br>&nbsp;</div></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px">
                                        <td  width="90%" align="center" style="color: rgb(140,140,140);margin: 0;padding: 10px 0 0 0 ;">
                                            <div style="text-align: center;font-size: 22px;border-radius: 10px;background: rgb(238,141,0);margin: 0 5px 0 0;padding: 14px 10px;" align="center">
                                                <a href="http://10.15.2.76/dev/External/Email?module=order&id={{$id}}&tipo={{$tipo}}"  style="color: #ffffff;text-decoration: none;margin: 0;padding: 0px" target="_blank" tabindex="-1" rel="external nofollow">Click aqu&iacute para ver el Documento</a>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td width="5" style="color: rgb(140,140,140);background: repeat-y;margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_right_center.jpg');"></td>
        </tr>
        <tr style="margin: 0;padding: 0px">
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_bottom_left.jpg')" ></td>
            <td height="5" style="color: rgb(140,140,140);background: repeat-x;margin: 0;padding: 0;background-image: url('http://valcro.com.ve/mailer/images/sdw_bottom_center.jpg');" ></td>
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_bottom_right.jpg');"></td>
        </tr>
        </tbody>
    </table>
</div>