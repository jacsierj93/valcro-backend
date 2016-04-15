<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Purchase extends Model
{
    use SoftDeletes;
    protected $table = "tbl_compra";

    public function getItems(){
        return $this->hasMany('App\Models\Sistema\Purchaseitem', 'compra_id', 'id');
    }


}