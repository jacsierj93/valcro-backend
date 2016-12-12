<?php

/*
|--------------------------------------------------------------------------
| Controllador genereico para servicios financieros
|--------------------------------------------------------------------------
|
|
*/

namespace app\Http\Controllers\Masters;

use App\Models\Sistema\CustomOrders\CustomOrder;
use App\Models\Sistema\CustomOrders\CustomOrderItem;
use App\Models\Sistema\KitchenBoxs\KitchenBox;
use App\Models\Sistema\Order\Order;
use App\Models\Sistema\Order\OrderItem;
use App\Models\Sistema\Other\SourceType;
use App\Models\Sistema\Product\Product;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class MasterProductController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * crea un producto temporal para el provedor especificado
     **/
    public static  function createProduct($data){
        $ser = Product::where("prov_id", $data['prov_id'])
            ->where('tipo_producto_id',3)
            ->first();
        $prod = new Product();
        if($ser == null){
            $ser  = new Product();
            $ser->prov_id= $data['prov_id'];
            $ser->tipo_producto_id=3;
            $ser->save();
        }
        $prod->prov_id =$data['prov_id'];
        $prod->tipo_producto_id = 2;
        if(array_key_exists('codigo_profit',$data)){
            $prod->codigo_profit =$data['codigo_profit'];
        }
        if(array_key_exists('descripcion_profit',$data)){
            $prod->descripcion_profit =$data['descripcion_profit'];
        }
        if(array_key_exists('casas_id',$data)){
            $prod->casas_id =$data['casas_id'];
        }
        if(array_key_exists('lineas_id',$data)){
            $prod->lineas_id =$data['lineas_id'];
        }
        if(array_key_exists('sublinea_id',$data)){
            $prod->sublinea_id =$data['sublinea_id'];
        }
        if(array_key_exists('stock_min',$data)){
            $prod->stock_min =$data['stock_min'];
        }
        if(array_key_exists('codigo_barras',$data)){
            $prod->codigo_barras =$data['codigo_barras'];
        }
        if(array_key_exists('stock_min_hogar',$data)){
            $prod->stock_min_hogar =$data['stock_min_hogar'];
        }
        if(array_key_exists('almacenes_id',$data)){
            $prod->almacenes_id =$data['almacenes_id'];
        }
        if(array_key_exists('codigo_fabrica',$data)){
            $prod->codigo_fabrica =$data['codigo_fabrica'];
        }
        if(array_key_exists('precio',$data)){
            $prod->precio =$data['precio'];
        }
        if(array_key_exists('tamano',$data)){
            $prod->tamano =$data['tamano'];
        }
        if(array_key_exists('serie',$data)){
            $prod->serie =$data['serie'];
        }
        if(array_key_exists('colores_id',$data)){
            $prod->colores_id =$data['colores_id'];
        }
        if(array_key_exists('descripcion',$data)){
            $prod->descripcion =$data['descripcion'];
        }
        if(array_key_exists('cantidadPed',$data)){
            $prod->cantidadPed =$data['cantidadPed'];
        }
        if(array_key_exists('costoPed',$data)){
            $prod->costoPed =$data['costoPed'];
        }
        if(array_key_exists('co_cat',$data)){
            $prod->co_cat =$data['co_cat'];
        }
        $prod->save();
        return Product::find($prod->id) ;

    }

}