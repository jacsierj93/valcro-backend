<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 28/06/2016
 * Time: 10:51
 */

namespace App\Models\Sistema;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactField extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_contacto_campo';
    protected $touches = ['contact'];
    protected $fillable = array('campo', 'valor', 'prov_id');
    public function contact()
    {
        return $this->belongsTo('App\Models\Sistema\Contactos','cont_id');
    }
}