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
                                        Solicitud de Presupuesto
                                    </td>
                                </tr>
                            </table>
                            @if ($texto)
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr style="margin: 0; padding: 0px;">
                                        <td align="center" height="1" style="border-top-width: 1px; border-top-color: #e8e8e8; border-top-style: solid; color: rgb(140,140,140); margin: 0; padding: 12px; text-align: left;text-indent: 25px;">
                                            {{$texto}}
                                        </td>
                                    </tr>
                                </table>
                            @endif
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td width="30%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Representante:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$responsable}}
                                        </p></td>
                                    <td width="30%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Correo:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {{$correo}}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">
                                        <p  style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px; text-align: center;">
                                            Articulos
                                        </p></td>
                                </tr>

                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <thead style="border: 50px">
                                <tr>
                                    <th  style="text-align: left;" >
                                        Codigo
                                    </th>
                                    <th  style="text-align: left;" >
                                        Descripcion
                                    </th >
                                    <th style="text-align: left;" >
                                        Cantidad
                                    </th>
                                </tr>
                                </thead>
                                <tbody >
                                @foreach($articulos as $aux)
                                <tr style="height: 32px;">
                                    <td style="width: 20%; text-align: left;" >
                                        {{$aux['codigo_fabrica']}}
                                    </td>
                                    <td  style="text-align: left;"  >
                                        {{$aux['descripcion']}}

                                    </td>
                                    <td  style="width: 20%; text-align: left;">
                                        {{$aux['cantidad']}}
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>

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