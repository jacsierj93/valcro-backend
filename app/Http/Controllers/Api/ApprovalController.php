<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;
/**
 * Description of ApprovalController
 *
 * @author jacsierj93
 */
use App\Models\Sistema\SysCustom\Approval;
use App\Models\Sistema\User;
class ApprovalController extends BaseController{
    public function __construct()
    {
            $this->middleware('auth');
    }
    
    public function getAprv(){
        $x = '\App\Models\Sistema\SysCustom\Approval';
        return $x::all();
    }
    
    public function approv(Request $rq){
        //dd($rq);
        $usr = $rq->session()->get('DATAUSER');
        $model = new $rq->target();
        $set = new Approval();
        $set->user_id = $usr['id'];
        $set->estatus = $rq->stat;
        $set->comentario = $rq->coment;
        $set->tabla = $model->getTable();
        
        $set->save();
        $model->find($rq->id)->isAprov()->delete();
        $model->find($rq->id)->isAprov()->save($set);
        return "ok";
    }
}
