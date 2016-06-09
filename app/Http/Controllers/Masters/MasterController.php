<?php
namespace App\Http\Controllers\Masters;


use App\Models\Sistema\Order\OrderCondition;
use App\Models\Sistema\Order\OrderReason;
use App\Models\Sistema\Order\OrderStatus;
use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Ports;
use App\Models\Sistema\ProviderAddress;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;
use App\Models\Sistema\Country;
use App\Models\Sistema\Monedas;
use App\Models\Sistema\ProviderType;
use App\Models\Sistema\ProvTipoEnvio;
use App\Models\Sistema\State;
use App\Models\Sistema\TypeAddress;
use App\Models\Sistema\Line;
use App\Models\Sistema\Language;
use App\Models\Sistema\CargoContact;
use Illuminate\Database\Eloquent\Collection;


class MasterController extends BaseController
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getCountries()
	{
		$paises = Country::all();
		foreach($paises as $pais){
			$pais->areaCode;
		}
		return $paises;
	}

	public function getCountriesHaveProvider()
	{
		$data = Collection::make(array());
		$dirs = ProviderAddress::get();

		foreach($dirs as $aux){
			if(!$data->contains($aux->pais_id)){
				$data->push(Country::find($aux->pais_id));
			}
		}
		return $data;
	}

	public function getProviderType()
	{
		$paises = ProviderType::select("id","nombre")->get();
		return $paises;
	}

	public function getProviderTypeSend()
	{
		$paises = ProvTipoEnvio::select("id","nombre")->get();
		return $paises;
	}
	public function getCoins()
	{
		//return Monedas::select("id","nombre","simbolo","codigo")->get();
		return Monedas::all();
	}

	public function getAddressType(){
		return TypeAddress::all();
	}

	public function getLines(){
		return Line::all();
	}

	public function getStates($id){
		if($id){
			$states = Country::find($id)->states()->get();
			return ($states)?$states:[];
		}else{
			return [];
		}

	}

	public function getCities($id){
		if($id){
			$cities = State::find($id)->cities()->get();
			return ($cities)?$cities:[];
		}else{
			return [];
		}

	}

	/**
	 * obtiene la moneda segun id
	 **/
	public function getCoin($id){
		return Monedas::findOrFail($id);
	}

	/**
	 * obtiene la moneda segun id
	 **/
	public function getLanguajes(){
		return Language::all();
	}

	public function getCargos(){
		return CargoContact::all();
	}
	public function getPorts(){
		return Ports::select("id","Main_port_name","pais_id")->get();
	}

	/*Maestros para modulo de pedido**/
	public function getReason(){  return OrderReason::get();}
	public function getCondition(){  return OrderCondition::get();}
	public function getStatus(){  return OrderStatus::get();}
	public function getPaymentType(){  return PaymentType::get();}



}