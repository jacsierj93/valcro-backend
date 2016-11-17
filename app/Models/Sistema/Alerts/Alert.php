<?php
namespace App\Models\Sistema\Alerts;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Alert extends Model
{

    use SoftDeletes;
    protected $table = 'tbl_alert';
    protected $dates = ['deleted_at'];

    public  function items(){
        return $this->hasMany('App\Models\Sistema\Alerts\AlertItem', 'doc_id');
    }
}