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
		$paises = $country->select("id","short_name as nombre")->get();
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

	public function getFullCountry(){
		$countries = Country::get();
		foreach ($countries as $country){
			$country["states"]=$country->states()->get();
			foreach ($country["states"] as $state){
				$state['cities'] = $state->cities()->get();
			}
		}

		//dd($countries);
		return $countries;
	}
}