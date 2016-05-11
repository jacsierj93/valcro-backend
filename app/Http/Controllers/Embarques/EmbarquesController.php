<?php

namespace App\Http\Controllers\Embarques;


use App\Models\Sistema\Embarques\Embarques2;
//use App\Models\Sistema\NombreValcro;
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

    public function getEmbarquesList(){
       $embarques = Embarques2::all();

        foreach($embarques AS $embarque){
            $embarque['nombres'] = $embarque->nombres()->get();
            $embarque['direcciones'] = $embarque-> direcciones()->get();
        }



        return $embarques;
    }





}