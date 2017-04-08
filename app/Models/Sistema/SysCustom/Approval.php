<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models\Sistema\SysCustom;

/**
 * Description of Approval
 *
 * @author jacsierj93
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Approval extends Model{
    use SoftDeletes;
    
    protected $table="tbl_aprobaciones";
   public function approvable()
    {
        return $this->morphTo();
    }
   public function user()
    {
        return $this->hasOne("App\Models\Sistema\User",'id','user_id');
    }
}
