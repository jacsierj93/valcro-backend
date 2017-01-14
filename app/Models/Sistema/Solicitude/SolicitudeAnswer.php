<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Solicitude;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;




class SolicitudeAnswer extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table = "tbl_solicitud_contestacion";
    protected $dates = ['deleted_at'];
    /**
     * adjuntos del documento
     */
    public function attachments(){
        return $this->hasMany('App\Models\Sistema\Solicitude\SolicitudeAnswerAttachment', 'doc_id');
    }

}



