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
use App\Models\Sistema\City;
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
		return json_encode($paises);
	}

	/*public function commonConuntries(){
	basandose en los paises de proveedores registrado, busca los que ya se han creado mas de 2 veces

	}*/

	public function getCountriesHaveProvider()
	{
		$data = Collection::make(array());
		$dirs = ProviderAddress::get();

		foreach($dirs as $aux){
			if(!$data->contains($aux->pais_id)){
				$data->push(Country::find($aux->pais_id));
			}
		}
		return json_encode($data);
	}

	public function getProviderType()
	{
		$type = ProviderType::select("id","nombre")->get();
		return json_encode($type);
	}

	public function getProviderTypeSend()
	{
		$send = ProvTipoEnvio::select("id","nombre")->get();
		return json_encode($send);
	}
	public function getCoins()
	{
		//return Monedas::select("id","nombre","simbolo","codigo")->get();
		return json_encode(Monedas::all());
	}

	public function getAddressType(){
		return json_encode(TypeAddress::all());
	}

	public function getLines(){
		return json_encode(Line::all()->prepend(array("id"=>"","linea"=>"TODAS","siglas"=>"todo")));
	}

	public function getStates($id){
		if($id){
			$states = Country::find($id)->states()->get();
			return json_encode(($states)?$states:[]);
		}else{
			return json_encode([]);
		}

	}

	public function getCities($id){
		if($id){
			$cities = State::find($id)->cities()->get();
			return json_encode(($cities)?$cities:[]);
		}else{
			return json_encode([]);
		}

	}

	public function getAllCities(){
		return json_encode(City::select("id","local_name")->get());
	}

	/**
	 * obtiene la moneda segun id
	 **/
	public function getCoin($id){
		return json_encode(Monedas::findOrFail($id));
	}

	/**
	 * obtiene la moneda segun id
	 **/
	public function getLanguajes(){
		return json_encode(Language::all());
	}

	public function getCargos(){
		return json_encode(CargoContact::all());
	}
	public function getPorts(){
		return json_encode(Ports::select("id","Main_port_name","pais_id")->get());
	}

	/*Maestros para modulo de pedido**/
	public function getReason(){  return OrderReason::get();}
	public function getCondition(){  return OrderCondition::get();}
	public function getStatus(){  return OrderStatus::get();}
	public function getPaymentType(){  return PaymentType::get();}



}