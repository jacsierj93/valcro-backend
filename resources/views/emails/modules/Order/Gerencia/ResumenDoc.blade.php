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
                                    <td width="30%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Fecha:
                                        <p id="fec_emis" style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {fec_emis}
                                        </p></td>
                                    <td width="30%" align="right" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Nro:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {id}
                                        </p></td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td align="center" height="1" style="border-top-width: 1px; border-top-color: #e8e8e8; border-top-style: solid; color: rgb(140,140,140); margin: 0; padding: 12px;"></td>
                                </tr>
                            </table>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td width="30%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Vendedor:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {vendedor}
                                        </p></td>
                                    <td width="60%" align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Cliente:
                                        <p style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {cliente}
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
                                <tr>
                                    <td align="left" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Observación:
                                        <p id="observacion" style="color: rgb(0,0,0) !important; font-size: 20px !important; margin: 0; padding: 0px;">
                                            {observaciones}
                                        </p></td>
                                </tr>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td align="center" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Contrapedidos:</td>
                                </tr>
                            </table>
                            {ctrPed}

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td align="center" style="color: rgb(140,140,140); margin: 0; padding: 12px;">Documentos Relacionados:</td>
                                </tr>
                            </table>
                            {docRel}

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" width="25%">
                                        {aprobG}</td>
                                    <td align="center" width="25%">
                                        {aprobAdm}</td>
                                    <td align="center" width="25%">
                                        {aprobCmp}</td>
                                    <td align="center" width="25%">
                                        {aprobTec}</td>
                                </tr>
                            </table>

                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr style="margin: 0; padding: 0px;">
                                    <td align="center" style="color: rgb(140,140,140); margin: 0; padding: 12px;">
                                        <div class="btn" style="text-align: center; font-size: 22px; border-radius: 10px; background: rgb(238,141,0); margin: 0 5px 0 0; padding: 14px 12px;" align="center">
                                            <a href="http://sistema/arquitec2/" style="color: #ffffff; text-decoration: none; margin: 0; padding: 0px;">Click aquí para ver el Contrato</a>
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