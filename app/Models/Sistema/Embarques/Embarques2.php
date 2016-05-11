<?php

namespace App\Models\Sistema\Embarques;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sistema\Embarques;

class Embarques2 extends Model
{
    use SoftDeletes;
    protected $table = "tbl_proveedor";

    public function nombres()
    {
        return $this->hasMany('App\Models\Sistema\NombreValcro', 'prov_id');
    }

    public function direcciones()
    {
        return $this->hasMany('App\Models\Sistema\ProviderAddress', 'prov_id');
    }
}