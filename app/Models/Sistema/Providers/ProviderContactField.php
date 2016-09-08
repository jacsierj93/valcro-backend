<?php

/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 27/06/2016
 * Time: 11:29
 * @deprecated
 */
namespace App\Models\Sistema\Providers;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderContactField extends Model
{
    use SoftDeletes;
    protected $table="tbl_contacto_prov_campo";
}