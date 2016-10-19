<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Shipments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sistema\Masters\FileModel;


class Shipment extends Model
{
    use SoftDeletes;
    protected $table = "tbl_embarque";
    protected $dates = ['deleted_at'];
    protected  $adjuntos =[];
    /**
     * adjuntos del documento
     */
    public function attachments(){
       // $this->adjuntos = $this->hasMany('App\Models\Sistema\Shipments\ShipmentAttachment', 'embarque_id')->get();
        return $this->hasMany('App\Models\Sistema\Shipments\ShipmentAttachment', 'embarque_id');

    }

    public function attachmentsFile($doc){
        $models= $this->attachments()->where('documento',$doc)->get();
        $data = [];

        foreach($models as $aux){
            $att = [];
            $file= FileModel::findOrFail($aux->archivo_id);
            $att['id'] = $aux->id;
            $att['archivo_id'] = $aux->archivo_id;
            $att['documento'] = $aux->documento;
            $att['comentario'] = $aux->comentario;
            $att['thumb']=$file->getThumbName();
            $att['tipo']=$file->tipo;
            $att['file'] = $file->archivo;
            $data[]= $att;
        }
        return $data;
    }
    /**
     *Container del embarq
     */
    public function containers(){
        return $this->hasMany('App\Models\Sistema\Shipments\Container', 'embarque_id');
    }

    public function Orders(){
        $data = [];
        $data[] = ['id'=>'', 'isTotal'=>false, 'articulos'=>[]];
        return $data;

    }

    /**

    CREATE TABLE IF NOT EXISTS `tbl_embarque` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `prov_id` int(11) DEFAULT NULL,
    `titulo` longtext,
    `pais_id` int(11) DEFAULT NULL,
    `puerto_id` int(11) DEFAULT NULL,
    `tarifa_id` int(11) DEFAULT NULL,
    `fecha_carga` date DEFAULT NULL,
    `fecha_vnz` date DEFAULT NULL,
    `fecha_tienda` date DEFAULT NULL,
    `nro_mbl` varchar(100) DEFAULT NULL,
    `nro_hbl` varchar(100) DEFAULT NULL,
    `nro_dua` varchar(100) DEFAULT NULL,
    `flete_tt` decimal(10,4) DEFAULT NULL,
    `moneda_id` int(11) DEFAULT NULL,
    `flete_nac` decimal(10,4) DEFAULT NULL,
    `flete_dua` varchar(100) DEFAULT NULL,
    `session_id` varchar(100) DEFAULT NULL,
    `usuario_conf_f_carga` int(11) DEFAULT NULL,
    `usuario_conf_f_vnz` int(11) DEFAULT NULL,
    `usuario_conf_f_tienda` int(11) DEFAULT NULL,
    `usuario_conf_monto_ft_tt` int(11) DEFAULT NULL,
    `usuario_conf_monto_ft_nac` int(11) DEFAULT NULL,
    `usuario_conf_monto_ft_dua` int(11) DEFAULT NULL,
    `usuario_id` int(11) DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    `deleted_at` datetime DEFAULT NULL,
    `emision` datetime DEFAULT NULL,
    `emsion_mbl` date DEFAULT NULL,
    `emision_hbl` date DEFAULT NULL,
    `emision_dua` date DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;


     */
}