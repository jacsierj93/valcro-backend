<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Tariffs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tariff extends Model
{
    use SoftDeletes;
    protected $table = "tbl_tarifa";
    protected $dates = ['deleted_at'];

}

/*
--
-- Table structure for table `tbl_tarifa`
--

CREATE TABLE IF NOT EXISTS `tbl_tarifa` (
`id` int(11) NOT NULL,
  `fregth_forwarder` varchar(100) NOT NULL,
  `pais_id` int(11) NOT NULL,
  `puerto_id` int(11) NOT NULL,
  `moneda_id` int(11) NOT NULL,
  `tt` decimal(10,4) NOT NULL,
  `grt` decimal(10,4) NOT NULL,
  `documento` decimal(10,4) NOT NULL,
  `mensajeria` decimal(10,4) NOT NULL,
  `seguros` decimal(10,4) NOT NULL,
  `consolidacion` decimal(10,4) NOT NULL,
  `sd20` decimal(10,4) NOT NULL,
  `sd40` decimal(10,4) NOT NULL,
  `hc40` decimal(10,4) NOT NULL,
  `ot40` decimal(10,4) NOT NULL,
  `created_at` datetime NOT NULL,
  `vencimiento` date DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `naviera` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
*/