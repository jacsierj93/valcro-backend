<div style="min-height: 100%;margin: 0;padding: 0px; text-align: center;">
    <table style="border-spacing: 0px;margin: auto;padding: 0px;">
        <tbody>
        <tr style="margin: 0;padding: 0px">
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0px" data-x-style-url="background-image: url(http://valcro.com.ve/mailer/images/sdw_top_left.jpg)"></td>
            <td height="5" style="color: rgb(140,140,140);background: repeat-x;margin: 0;padding: 0px" data-x-style-url="background-image: url(http://valcro.com.ve/mailer/images/sdw_top_center.jpg)"></td>
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0px" data-x-style-url="background-image: url(http://valcro.com.ve/mailer/images/sdw_top_right.jpg)"></td>
        </tr>
        <tr style="margin: 0;padding: 0px">
            <td width="5" style="color: rgb(140,140,140);background: repeat-y;margin: 0;padding: 0px" data-x-style-url="background-image: url(http://valcro.com.ve/mailer/images/sdw_left_center.jpg)">

            </td>
            <td style="color: rgb(140,140,140);margin: 0;padding: 0px">
                <table style="">
                    <tbody>
                    <tr style="margin: 0;padding: 0px">
                        <td style="color: rgb(140,140,140);margin: 0;padding: 12px">
                            <div style="width: 100%;margin: 0;padding: 0px">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="margin: 0;padding: 0px"><td align="center" width="30%" style="color: rgb(140,140,140);margin: 0;padding: 12px"><img width="204px" height="52px" style="margin: 0;padding: 0px" src='http://valcro.com.ve/images/logo-head.png' ></td>
                                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 12px">Emision:
                                            <p style="color: rgb(0,0,0)!important;font-size: 20px!important;margin: 0;padding: 0px">
                                                {{$emision}}
                                            </p></td>
                                        <td width="30%" align="right" style="color: rgb(140,140,140);margin: 0;padding: 12px">Nro. :
                                            <p style="color: rgb(0,0,0)!important;font-size: 20px!important;margin: 0;padding: 0px">
                                                {{$id}}
                                            </p></td>
                                    </tr></tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px">
                                        <td  width="90%"  align="center" height="1" style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;padding: 12px"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 12px; ">Descripcion:
                                            <p style="color: rgb(0,0,0)!important;font-size: 20px!important;margin: 0;padding: 0px">
                                                {{$texto}}
                                            </p></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px">
                                        <td  width="90%"  align="center" height="1" style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;padding: 12px"></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 12px">Responsable:
                                            <p style="color: rgb(0,0,0)!important;font-size: 20px!important;margin: 0;padding: 0px">
                                                {{$responsable}}
                                            </p>
                                        </td>
                                        <td width="60%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 12px">Correo:
                                            <p style="color: rgb(0,0,0)!important;font-size: 20px!important;margin: 0;padding: 0px">
                                                {{$correo}}</p>										</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td  width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 12px">Titulo:
                                            <p style="color: rgb(0,0,0)!important;font-size: 20px!important;margin: 0;padding: 0px">
                                                {{$titulo}}
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px">
                                        <td  width="90%" align="center" style="color: rgb(140,140,140);margin: 0;padding: 12px">Art&iacuteculos:</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 12px;padding: 0px;border-top: 1px solid #e8e8e8">
                                    <tbody>
                                    <tr style="color: rgb(140,140,140); height: 32px;">
                                        <td>Codigo </td>
                                        <td>Descripcion</td>
                                        <td>Cantidad</td>
                                    </tr>
                                    @for ($i = 0; $i < sizeof($articulos); $i++)
                                        <tr style="height: 32px; @if($i % 2 == 0)  color: #000000;background: rgb(241,241,241) @endif">
                                            <td  width="30%" style="text-align: left; " >
                                                {{$articulos[$i]['codigo_fabrica']}}
                                            </td>
                                            <td  width="30%" style="text-align: left;"  >
                                                {{$articulos[$i]['descripcion']}}

                                            </td>
                                            <td width="30%"  style=" text-align: left;">
                                                {{$articulos[$i]['cantidad']}}
                                            </td>
                                        </tr>
                                    @endfor

                                    </tbody>
                                </table>
                            </div>
                        </td>

                    </tr></tbody>
                </table></td>
            <td width="5" style="color: rgb(140,140,140);background: repeat-y;margin: 0;padding: 0px" data-x-style-url="background-image: url(http://valcro.com.ve/mailer/images/sdw_right_center.jpg)"></td>
        </tr>
        <tr style="margin: 0;padding: 0px"><td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0px" data-x-style-url="background-image: url(http://valcro.com.ve/mailer/images/sdw_bottom_left.jpg)"></td>
            <td height="5" style="color: rgb(140,140,140);background: repeat-x;margin: 0;padding: 0px" data-x-style-url="background-image: url(http://valcro.com.ve/mailer/images/sdw_bottom_center.jpg)"></td>
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0px" data-x-style-url="background-image: url(http://valcro.com.ve/mailer/images/sdw_bottom_right.jpg)"></td>
        </tr>
        </tbody>
    </table>
</div>