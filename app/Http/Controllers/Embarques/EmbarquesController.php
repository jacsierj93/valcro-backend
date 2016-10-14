<?php

namespace App\Http\Controllers\Embarques;


//use App\Models\Sistema\NombreValcro;
use App\Models\Sistema\Providers\Provider;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;


class EmbarquesController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public  function  getProvList(){
        $prov  = Provider::where('id','<' ,100)->get();
        $data = [];

        return $prov;
    }

    /**@deprecated */
    public function getEmbarquesList(){
       /*$embarques = Embarques2::all();

        foreach($embarques AS $embarque){
            $embarque['nombres'] = $embarque->nombres()->get();
            $embarque['direcciones'] = $embarque-> direcciones()->get();
        }



        return $embarques;*/
    }





}