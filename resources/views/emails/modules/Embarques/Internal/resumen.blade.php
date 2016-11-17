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
                            {{$data['titulo']}}
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
                                {{$model->user->nombre}}
                            </p></td>
                        <td  align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Correo:
                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                {{$model->user->email}}</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr style="margin: 0;padding:0">
                        <td width="50%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Proveedor:
                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                {{$model->provider->razon_social}}
                            </p></td>
                        <td width="30" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold;">Pais:
                            <p style="color: rgb(0,0,0)!important;font-size: 15px!important;margin: 0;padding: 0;font-weight: normal;">
                                @if($model->country) {{$model->country->short_name}} @else No asignado @endif

                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div style="border-top-width: 1px;border-top-color: #e8e8e8;border-top-style: solid;color: rgb(140,140,140);margin: 0;"></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr>
                        <td  width="90%" align="left" style="color: rgb(140,140,140);margin: 0;padding: 10px;font-weight: bold; text-align: center;">Articulos

                        </td>
                    </tr>
                    </tbody>
                </table>

                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 0 0 8px 8px ;border-top: 1px solid #e8e8e8">
                    <tbody>
                    <tr style="color: rgb(140,140,140); height: 32px;font-weight: bold;">
                        <td width="5%" style="text-align: left;"> </td>
                        <td width="20%" style="text-align: left;">Codigo </td>
                        <td  style="text-align: left;">Descripcion</td>
                        <td  width="20%"style="text-align: left;">Cantidad</td>
                    </tr>
                    @for ($i = 0; $i < sizeof($model->items()->get()); $i++)
                        <tr style="height: 32px;font-weight: normal; font-size: 13px; @if($i % 2 == 0)  color: #000000;background: rgb(241,241,241) @endif">
                            <td  width="5%" style="text-align: center; background-color: white;border: solid 1.5px rgb(241, 241, 241);" >{{$i +1}}</td>
                            <td  width="20%" style="text-align: left; " >
                                {{$model->items[$i]['codigo_fabrica']}}
                            </td>
                            <td   style="text-align: left;"  >
                                {{$model->items[$i]['descripcion']}}

                            </td>
                            <td width="20%"  style=" text-align: left;">
                                {{$model->items[$i]['cantidad']}}
                            </td>
                        </tr>
                    @endfor

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
