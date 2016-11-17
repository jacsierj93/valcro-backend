<?php
namespace App\Http\Controllers\Masters;


use App\Models\Sistema\Contactos;
use App\Models\Sistema\Ports;
use App\Models\Sistema\Provider;
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


class EmailController extends BaseController
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getProviderEmails(Request $req){

		$data = array();
		if($req->has('id')){
			$emails = array();
			$model =  Provider::findOrFail($req->id);

			$temp['id'] = $model->id;
			$temp['razon_social'] = $model->razon_social;
			foreach($model->contacts()->get() as $aux){
				$temp['email'] =$aux->email;
				$data[]= $temp;

			}

		}else{
			foreach(Provider::get() as $aux){
				$temp['id'] = $aux->id;
				$temp['razon_social'] = $aux->razon_social;
				foreach($aux->contacts()->get() as $aux2){
					$temp['email'] =$aux2->email;
					$data[]= $temp;
				}

			}
		}

		return $data;
	}




}