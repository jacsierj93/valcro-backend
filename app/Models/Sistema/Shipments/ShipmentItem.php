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

class ShipmentItem extends Model
{
    use SoftDeletes;
    protected $table = "tbl_embarque_item";
    protected $dates = ['deleted_at'];

/*

CREATE TABLE valcro_db2.tbl_embarque_item (
  id int(11) NOT NULL AUTO_INCREMENT,
  tipo_origen_id int(11) DEFAULT NULL,
  embarque_id int(11) DEFAULT NULL,
  origen_item_id int(11) DEFAULT NULL,
  descripcion varchar(255) DEFAULT NULL,
  doc_origen_id int(11) DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  deleted_at datetime DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  saldo int(11) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 3
CHARACTER SET latin1
COLLATE latin1_swedish_ci;
*/
}