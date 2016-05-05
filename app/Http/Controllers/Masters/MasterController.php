<?php
namespace App\Http\Controllers\Masters;


use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;
use App\Models\Sistema\Country;
use App\Models\Sistema\Monedas;
use App\Models\Sistema\ProviderType;
use App\Models\Sistema\ProvTipoEnvio;
use App\Models\Sistema\State;
use App\Models\Sistema\City;

class MasterController extends BaseController
{

	public function __construct()
    {

        $this->middleware('auth');
    }

	public function getCountries()
	{
		$country = new Country();
		$paises = $country->get();
		return $paises;
	}

	public function getProviderType()
	{
		$paises = ProviderType::select("id","nombre")->where("deleted_at",NULL)->get();
		return $paises;
	}

	public function getProviderTypeSend()
	{
		$paises = ProvTipoEnvio::select("id","nombre")->where("deleted_at",NULL)->get();
		return $paises;
	}
	public function getCoins()
	{
		return Monedas::select("id","nombre","simbolo","codigo")->get();
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
}