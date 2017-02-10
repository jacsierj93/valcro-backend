<?php

/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 26/01/17
 * Time: 02:14 PM
 */
namespace App\Models\Sistema\SysCustom;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;
use Carbon;
class CustomPivot extends Pivot
{
    use SoftDeletes;
    use Journal;
    public function delete()
    {
        return $this->getDeleteQuery()->update(array('deleted_at' => Carbon::now()));
    }
    public function getUpdatedAtColumn()
    {
        dd("dasdadas");
        return $this->parent->getUpdatedAtColumn();
    }
}