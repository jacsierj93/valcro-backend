<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Alerts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Alert extends Model
{
    use SoftDeletes;
    protected $table = "tbl_alert";

    public function items(){
        return $this->hasMany('App\Models\Sistema\Alerts\AlertItem', 'doc_id');
    }

}