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
use App\Models\Sistema\Order\OrderItem;
use App\Models\Sistema\Other\SourceType;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class MasterOrderController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *Obtiene la cantidad disponible para la compra de un producto
     * @param el producto item (tbl_contra_pedido_item) que posea el campo cantidad
     * @param el id del pedido a donde se va a assignar
     */
    public static function getQuantityAvailableProduct($producto, $pedido_id){
        $auxMonto =(float)$producto->cantidad;
        $auxDisp =(float)$producto->cantidad;
        $it=$producto;

        $it['asignado'] = false;
        $pediItem = OrderItem::where('pedido_id', $pedido_id)
            ->where('tipo_origen_id',$producto->tipo_origen_id)
            ->where('origen_item_id' , $producto->id)
            ->first();
        $OtherpediItem= OrderItem::where('pedido_id','<>', $pedido_id)
            ->where('tipo_origen_id',$producto->tipo_origen_id)
            ->where('origen_item_id' , $producto->id)
            ->get();

        foreach( $OtherpediItem as $other){

            $auxMonto -= (float)$other->cantidad;
            $auxDisp  -=(float)$other->cantidad;
        }

        if( $pediItem !== null){
            $auxMonto = (float) $pediItem->cantidad;
            $it['renglon_id']=$pediItem->id;
            $it['asignado'] = true;

        }
        $it['disponible']=  $auxDisp;
        $it['monto']=  $auxMonto ;

        return $it;
    }

    /**
     * @return el tipo de producto original
     */
    public static function getTypeProduct($producto){

        $idType=$producto->tipo_origen_id;

        if($idType == 4){
            $i=0;
            $aux= $producto;
            do {
                $aux= OrderItem::findOrFail($aux->origen_item_id);
                $idType=$aux->tipo_origen_id;
                $i++;

            } while ($idType == 4 && $i<3);
        }
        return SourceType::findOrFail($idType)->descripcion;

    }

    /**
     * @return el tipo de producto original
     */
    public static function getOriginalHead($producto){

        $idType=$producto->tipo_origen_id;
        $aux= $producto;
        if($idType == 4){
            $i=0;
            do {
                $aux= OrderItem::findOrFail($aux->origen_item_id);
                $idType=$aux->tipo_origen_id;
                $i++;

            } while ($idType == 4 && $i<3);
        }
        switch($aux->tipo_origen_id){
            case '2':
                return  CustomOrder::find($aux->doc_origen_id);
                break;
            case '3':
                return  KitchenBox::find($aux->doc_origen_id);
                break;
        }

        return $aux;

    }

    /**
     * @return el tipo de producto original
     */
    public static function getTypeProductId($producto){

        $idType=$producto->tipo_origen_id;

        if($idType == 4){
            $i=0;
            $aux= $producto;
            do {
                $aux= OrderItem::findOrFail($aux->origen_item_id);
                $idType=$aux->tipo_origen_id;
                $i++;

            } while ($idType == 4 && $i<3);
        }
        return SourceType::findOrFail($idType)->id;

    }

    /**
     * determina si el producto ya a sido asignado al pedido(kitchenBox)
     * @param el producto que posea el campo cantidad
     * @param el id del pedido a donde se va a assignar
     */
    public static function getAvailableProduct($producto, $pedido_id){
        $it=$producto;
        $it['asignado'] = false;

        $pediItem = OrderItem::
        where('tipo_origen_id',$producto->tipo_origen_id)
            ->where('origen_item_id' , $producto->id)
            ->first();
        if( $pediItem !== null){
            $it['renglon_id']=$pediItem->id;
            $it['asignado'] = true;
        }

        return $it;

    }


}