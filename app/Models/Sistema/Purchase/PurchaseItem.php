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
use App\Http\Traits\Journal;




class PurchaseItem extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table = "tbl_compra_orden_item";
    protected $dates = ['deleted_at'];
    public function producto (){
        return $this->belongsTo('App\Models\Sistema\Product\Product', 'producto_id');
    }

    public function document(){
        return $this->belongsTo('App\Models\Sistema\Purchase\Purchase', 'doc_id');
    }
    //TODO normalizar
    public function tipo_producto(){
        return $this->belongsTo('App\Models\Sistema\Produc\ProductType', 'tipo_producto_id');
    }
/*
    public  function getAdvancePaymentProvider(){

        return $this->belongsTo('App\Models\Sistema\Purchase', 'compra_id');
    }

    public  function geProduct(){

        return $this->belongsTo('App\Models\Sistema\Product', 'productos_id');
    }*/

}



