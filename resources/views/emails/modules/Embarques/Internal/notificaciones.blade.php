{{--
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
--}}

<?=HTML::style("http://fonts.googleapis.com/css?family=Roboto") ?>
<style type="text/css">
*{
    font-family: Roboto;
}
</style>

    <table style="border-spacing: 0;margin: auto;padding: 0; text-align: center; ">
        <tbody>
        <tr style="margin: 0;padding: 0">
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_top_left.jpg');" ></td>
            <td height="5" style="color: rgb(140,140,140);background: repeat-x;margin: 0;padding: 0;background-image: url('http://valcro.com.ve/mailer/images/sdw_top_center.jpg');"></td>
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0;background-image: url('http://valcro.com.ve/mailer/images/sdw_top_right.jpg'); " ></td>
        </tr>
        <tr style="margin: 0;padding: 0">
            <td width="5" style="color: rgb(140,140,140);background: repeat-y;margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_left_center.jpg')" ></td>
            <td style="color: rgb(140,140,140);margin: 0;padding:0">
                <table width="600" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr style="margin: 0;padding:0">
                        <td align="center" width="30%" style="color: rgb(140,140,140);margin: 0;padding: 10px;; text-align: left;"><img width="150px"  style="margin: 0;padding:0" src='http://valcro.com.ve/images/logo-head.png' ></td>
                        <td width="30%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Emision:
                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                {{$model->emision}}
                            </p>
                        </td>
                        <td width="30%" align="right" style="color: rgb(140,140,140);margin: 0;padding: 10px; font-weight: bold;">Nro.
                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                {{$model->id}}
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr style="margin: 0;padding:0">
                        <td   width="90%" align="center" style="color: rgb(140,140,140);margin: 0;padding: 10px;">
                            Actualizacion de Embarque
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
                                {{$model->titulo}}
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody><tr style="margin: 0;padding:0">
                        <td  align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Responsable:
                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0; font-weight: normal;">
                                {{$model->usuario->nombre}}
                            </p></td>
                        <td  align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Correo:
                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                {{$model->usuario->nombre}}</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr>
                        <td  width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold; text-align: center;">Acciones

                        </td>
                    </tr>
                    </tbody>
                </table>
                @foreach ($data as $aux)
                    <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td  width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">{{$aux['key']}}
                                @if(array_key_exists('value', $aux))
                                <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                    {{$aux['value']}}
                                </p>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>

                @endforeach

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr style="margin: 0;padding:0">
                        <td  width="100%" align="center" style="color: rgb(140,140,140);margin: 0;padding: 10px 0 0 0 ;">
                            <div style="text-align: center;font-size: 22px;border-radius: 10px;background: rgb(238,141,0);margin: 0 0 0 0;padding: 14px 10px;" align="center">
                                <a href="http://10.15.2.76/dev/External/Email?module=embarques&id={{$model->id}}"  style="color: #ffffff;text-decoration: none;margin: 0;padding:0" target="_blank" tabindex="-1" rel="external nofollow">Click aqu&iacute para ver el Documento</a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>


            </td>
            <td width="5" style="color: rgb(140,140,140);background: repeat-y;margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_right_center.jpg');"></td>
        </tr>
        <tr style="margin: 0;padding:0">
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_bottom_left.jpg')" ></td>
            <td height="5" style="color: rgb(140,140,140);background: repeat-x;margin: 0;padding: 0;background-image: url('http://valcro.com.ve/mailer/images/sdw_bottom_center.jpg');" ></td>
            <td height="5" width="5" style="color: rgb(140,140,140);margin: 0;padding: 0; background-image: url('http://valcro.com.ve/mailer/images/sdw_bottom_right.jpg');"></td>
        </tr>
        </tbody>
    </table>
