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

class ShipmentAttachment extends Model
{
    use SoftDeletes;
    protected $table = "tbl_embarque_adj";
    protected $dates = ['deleted_at'];
    /*

CREATE TABLE IF NOT EXISTS `tbl_embarque_adj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento` varchar(50) DEFAULT NULL,
  `embarque_id` int(11) DEFAULT NULL,
  `archivo_id` int(11) DEFAULT NULL,
  `comentario` longtext,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_embaque_adj_tbl_archivo_FK` (`archivo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

    */

}