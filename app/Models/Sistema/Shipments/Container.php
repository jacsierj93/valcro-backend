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

class Container extends Model
{
    use SoftDeletes;
    protected $table = "tbl_container";
    protected $dates = ['deleted_at'];

/*
CREATE TABLE valcro_db2.tbl_container (
  id int(11) NOT NULL AUTO_INCREMENT,
  tipo varchar(100) DEFAULT NULL,
  peso decimal(10, 2) DEFAULT NULL,
  volumen decimal(10, 4) DEFAULT NULL,
  cantidad int(11) DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  deleted_at datetime DEFAULT NULL,
  embarque_id int(11) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 0
AVG_ROW_LENGTH = 2048

*/
}