<?php
namespace App\Models\Sistema\Masters;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monedas extends  Model
{

	use SoftDeletes;
	protected $table = 'tbl_moneda';

	////foreing key
	public function moneda_proveedor()
	{
		return $this->belongsToMany('App\Models\Sistema\Providers\Provider', 'tbl_prov_moneda', 'moneda_id','prov_id');
	}
}