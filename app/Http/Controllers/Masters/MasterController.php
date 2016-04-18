<?php
namespace App\Http\Controllers\Masters;

use App\Models\Sistema\Country;
use App\Models\Sistema\ProviderType;
use App\Models\Sistema\ProvTipoEnvio;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


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
}