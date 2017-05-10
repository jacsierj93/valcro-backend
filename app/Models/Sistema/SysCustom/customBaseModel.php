<?php

/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 26/01/17
 * Time: 02:12 PM
 */
namespace App\Models\Sistema\SysCustom;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\SysCustom\CustomPivot;
class customBaseModel extends Model
{
    public function newPivot(Model $parent, array $attributes, $table, $exists)
    {
        
        return new CustomPivot($parent, $attributes, $table, $exists);
    }
}