<?php

/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 08/12/16
 * Time: 04:13 PM
 */

namespace App\Http\Controllers\Products;


use App\Models\Sistema\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;
use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Product\Product;
use Illuminate\Support\Facades\Auth;

class ProductController  extends BaseController
{
    public function __construct()
    {

        $this->middleware('auth');
    }
    public function getProviders(Request $rq){

        return Provider::has("proveedor_product")->get();
    }
    
    public function listByProv($prov){

        return Product::with("prov")
            ->with("line")
            ->with("subLin")
            ->with("getType")
            ->where("prov_id",$prov)
            ->distinct("id")
            ->get();


    }


}