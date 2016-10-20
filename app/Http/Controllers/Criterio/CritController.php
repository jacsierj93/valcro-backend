<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 20/10/16
 * Time: 04:03 PM
 */

namespace App\Http\Controllers\Criterio;


use App\Models\Sistema\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;

use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Criterios\CritCampos as Campos;

use App\Models\Sistema\Masters\Line;


class CritController extends BaseController
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function getCampos(){
        return Campos::all();
    }
}