genericNoti
<?=HTML::style("http://fonts.googleapis.com/css?family=Roboto") ?>
<div style="min-height: 100%;margin: 0;padding: 0px; text-align: center; font-family: Roboto;">

    <table style="border-spacing: 0px;margin: auto;padding: 0;width: 600px;">
        <tbody>
        <tr style="margin: 0;padding: 0px">
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0;"></td>
            <td height="5" style="color: rgb(140,140,140);background: repeat-x;margin: 0;padding: 0; " ></td>
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0;background-image: url('http://valcro.com.ve/mailer/images/sdw_top_right.jpg')" ></td>
        </tr>
        <tr style="margin: 0;padding: 0px">
            <td width="5" style="color: rgb(140,140,140);background: repeat-y;margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_left_center.jpg')"></td>
            <td style="color: rgb(140,140,140);margin: 0;padding: 0px">
                <table style="width: 100%;">
                    <tbody>
                    <tr style="margin: 0;padding: 0px">
                        <td style="color: rgb(140,140,140);margin: 0;padding: 12px">
                            <div style="width: 100%;margin: 0;padding: 0">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td align="center" width="20%" style="color: rgb(140,140,140);margin: 0;padding: 10px 10px 10px 0; text-align: left;">
                                            <img width="150px"  style="margin: 0;padding: 0" src='http://valcro.com.ve/images/logo-head.png' ></td>
                                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px">Emision:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0px">
                                                {{vl_db_out_put_date($model->emision)}}
                                            </p></td>
                                        <td width="30%" align="right" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Nro.
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$model->id}}
                                            </p></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold; text-align: center;"> {{$texto}}

                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Responsable:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                                {{$user->nombre}}
                                            </p>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>

                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Correo:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$user->email}}
                                            </p>										</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px">
                                        <td  width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Art&iacuteculos:</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 0 0 0 8px ;border-top: 1px solid #e8e8e8">
                                    <tbody>
                                    <tr style="color: rgb(140,140,140); height: 32px;font-weight: bold;">
                                        <td style="text-align: left;"> </td>
                                        <td style="text-align: left;">Codigo </td>
                                        <td style="text-align: left;">Descripcion</td>
                                        <td style="text-align: left;">Cantidad</td>
                                    </tr>

                                    @for ($i = 0; $i < sizeof($articulos); $i++)
                                        <tr style="height: 32px;font-weight: normal; font-size: 13px; @if($i % 2 == 0)  color: #000000;background: rgb(241,241,241) @endif">
                                            <td  width="5%" style="text-align: left; " >
                                                {{$i + 1 }}
                                            </td>
                                            <td  width="30%" style="text-align: left; " >
                                                {{$articulos[$i]->producto['codigo_fabrica']}}
                                            </td>
                                            <td  width="30%" style="text-align: left;"  >
                                                {{$articulos[$i]->descripcion}}

                                            </td>
                                            <td width="30%"  style=" text-align: left;">
                                                {{$articulos[$i]['cantidad']}}
                                            </td>
                                        </tr>
                                    @endfor

                                    </tbody>
                                </table>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 16px;">
                                    <tbody>
                                    <tr>
                                        <td align="center" width="30%">
                                            <div style="color: #ffffff;text-align: center;font-size: 16px;border-radius: 10px;background: @if($model->fecha_aprob_gerencia != null)#00CD00 @else #e3e3e3  @endif ;margin: 0 5px 0 0;padding: 14px 10px;" align="center">Aprobado por<br>Gerente</div></td>
                                        <td align="center" width="30%">
                                            <div style="color: #ffffff;text-align: center;font-size: 16px;border-radius: 10px;background:@if($model->fecha_aprob_compras != null)#00CD00 @else #e3e3e3  @endif ;margin: 0 5px 0 0;padding: 14px 10px;" align="center">Aprobado por<br>Compras</div></td>
                                        <td align="center" width="30%">
                                            <div style="color: #ffffff;text-align: center;font-size: 16px;border-radius: 10px;background: @if($model->comentario_cancelacion != null)#00CD00 @else #e3e3e3  @endif ;margin: 0 5px 0 0;padding: 14px 10px;" align="center">Cancelado<br>&nbsp;</div></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding:0">
                                        <td  width="90%" align="center" style="color: rgb(140,140,140);margin: 0;padding: 10px 0 0 0 ;">
                                            <div style="text-align: center;font-size: 22px;border-radius: 10px;background: rgb(238,141,0);margin: 0 5px 0 0;padding: 14px 10px;" align="center">
                                                <a href="http://10.15.2.76/dev/External/Email?module=order&id={{$model->id}}&tipo={{$model->getTipoId()}}"  style="color: #ffffff;text-decoration: none;margin: 0;padding:0" target="_blank" tabindex="-1" rel="external nofollow">Click aqu&iacute para ver el Documento</a>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>

                    </tr></tbody>
                </table></td>
            <td width="5" style="color: rgb(140,140,140);background: repeat-y;margin: 0;padding: 0px; background-image: url('http://valcro.com.ve/mailer/images/sdw_right_center.jpg')" ></td>
        </tr>
        <tr style="margin: 0;padding: 0px">
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0;background-image: url('http://valcro.com.ve/mailer/images/sdw_bottom_left.jpg')" ></td>
            <td height="5" style="color: rgb(140,140,140);background: repeat-x;margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_bottom_center.jpg')"></td>
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_bottom_right.jpg')" ></td>
        </tr>
        </tbody>
    </table>
</div>