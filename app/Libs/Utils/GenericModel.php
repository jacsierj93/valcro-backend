<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 3/6/2016
 * Time: 4:00 PM
 */

namespace App\Libs\Utils;

use App\Models\Sistema\CustomOrders\CustomOrder;
use App\Models\Sistema\KitchenBoxs\KitchenBox;
use App\Models\Sistema\Order\Order;
use App\Models\Sistema\Product\Product;
use App\Models\Sistema\Proforma;
use App\Models\Sistema\Purchase\Purchase;
use App\Models\Sistema\Shipments\Shipment;
use App\Models\Sistema\Solicitude\Solicitude;

class GenericModel
{
    private $tipo;
    private $model;


    public function __construct($tipo)
    {
        $this->tipo= $tipo;


        switch ($tipo){
            case '1':
                $this->model=  new Product ();
                ;break;
            case '2':
                $this->model= new CustomOrder();
                ;break;
            case '3':
                $this->model= new KitchenBox();
                ;break;
            case '4':
                $this->model= new Order();
                ;break;
            case '20':
                /*  $this->model= Product::class;*/
                ;break;
            case '21':
                $this->model=new  Solicitude();
                ;break;
            case '22':
                $this->model= new Proforma();
                ;break;
            case '23':
                $this->model= new Purchase();
                ;break;
            case '24':
                $this->model= new Shipment();
                ;break;
        };
    }


    public function getModel(){
        return $this->model;
    }
}
