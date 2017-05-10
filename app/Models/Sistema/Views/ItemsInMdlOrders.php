<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Views;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class ItemsInMdlOrders extends Model
{
    use SoftDeletes;
    protected $table = "view_items_en_mdl_pedidos";



}