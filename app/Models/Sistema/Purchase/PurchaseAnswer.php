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



class PurchaseAnswer extends Model
{
    use SoftDeletes;
    protected $table = "tbl_compra_orden_contestacion";
    protected $dates = ['deleted_at'];

    /**
     * adjuntos del documento
     */
    public function attachments(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseAnswerAttachment', 'doc_id');
    }
}



