<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Traits;
use Session;
use App\Models\Sistema\SysCustom\Approval;
trait Approvable
{
    /*funcion que setea como pendiente automaticamente al registrarse un cambio*/
    private static function setPending($model,$act){
        $modelName = class_basename(get_class($model));
        $usr = Session::get("DATAUSER");
        $set = new Approval();
        $set->user_id = $usr['id'];
        $set->estatus = 'pendiente';
        $set->accion = $act;
        $set->save();
        $model->isAprov()->save($set);
    }
    
    public function isAprov(){
        //dd($this->MorphMany('App\Models\Sistema\SysCustom\Approval','approvable','tabla','campo_id')->toSql());
        return $this->MorphMany('App\Models\Sistema\SysCustom\Approval','approvable','procedencia','aprov_id');//->latest();//->selectRaw('user_id,estatus,comentario,accion,fecha');
    }
    
     public static function bootApprovable(){

        static::created(function ($model) {
            self::setPending($model,"creado");
        });

        static::updated(function ($model) {
            //dd($model);
            self::setPending($model,"editado");
        });

        static::deleted(function ($model) {
            self::setPending($model,"eliminado");
        });

    }
    
}