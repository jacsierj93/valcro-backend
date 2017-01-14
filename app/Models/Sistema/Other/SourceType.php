<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 10/05/2016
 * Time: 14:53
 */

namespace App\Models\Sistema\Other;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;


class SourceType extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table="tbl_tipo_origen";

    /**
     * busca el producto hasta que la descripcion sea != null
     **/
    public static function getDescripcion($producto){
        $tablas = SourceType::get();

        $ds =$producto->descripcion;
        $i = 0;
        while($ds != null ){
            if($i > 2){
                break;
            }
            $t = $tablas->get($producto->tipo_origen_id);
            $reg = DB::table($t->tbl)
                ->select('descripcion')
                ->where($t->cp_origen,$producto[$t->cp_origen]);
            if($t->cp_producto != null){
                $reg ->where($t->cp_producto,$producto[$t->cp_producto]);
            }
            //$reg = $reg ->first();
            $ds =  $reg;

            $i++;


        }
        return  $ds;
    }
}