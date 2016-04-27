<?php
namespace App\Http\Controllers\Masters;

use App\Models\Sistema\Country;
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
}