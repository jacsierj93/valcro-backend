
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
                                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px">Emission:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0px">
                                                {{$emision}}
                                            </p></td>
                                        <td width="30%" align="right" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Number:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$id}}
                                            </p></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold; ">Description:
                                            <p id="descripcion" style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$texto}}
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td  width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Title:
                                            <p id="titulo" style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0px;font-weight: normal;">
                                                {{$titulo}}
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Responsable:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                                {{$responsable}}
                                            </p>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr style="margin: 0;padding: 0px">
                                        <td width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Email:
                                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                                {{$correo}}</p>										</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr style="margin: 0;padding: 0px">
                                        <td  width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Articles:</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 0 0 0 8px ;border-top: 1px solid #e8e8e8">
                                    <tbody>
                                    <tr style="color: rgb(140,140,140); height: 32px;font-weight: bold;">
                                        <td style="text-align: left;">Code </td>
                                        <td style="text-align: left;">Descripcion</td>
                                        <td style="text-align: left;">quantity</td>
                                    </tr>
                                    @for ($i = 0; $i < sizeof($articulos); $i++)
                                        <tr style="height: 32px;font-weight: normal; font-size: 13px; @if($i % 2 == 0)  color: #000000;background: rgb(241,241,241) @endif">
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