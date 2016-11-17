<?php
namespace App\Models\Sistema\Alerts;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class AlertItem extends Model
{

    use SoftDeletes;
    protected $table = 'tbl_alert_item';

    protected $dates = ['deleted_at'];

}