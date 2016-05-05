<?php
namespace App\Http\Controllers\Providers;
use App\Models\Sistema\ProviderCreditLimit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Sistema\Provider;
use App\Models\Sistema\NombreValcro;
use App\Models\Sistema\Contactos;
use App\Models\Sistema\ProviderAddress as Address;
use App\Models\Sistema\BankAccount as Bank;
use App\Models\Sistema\ProviderCreditLimit as limCred;
use App\Models\Sistema\ProviderFactor as FactConv;
use App\Models\Sistema\Monedas;
use App\Models\Sistema\ProdTime;
use App\Models\Sistema\TiemAproTran;

use Session;
use Validator;

class ProvidersController extends BaseController
{
        public function __construct()
        {

            $this->middleware('auth');
        }

    public function getList()
    {
        $provs = new Provider();
        $data = $provs->get();
        /*   foreach($data as $k => $v){
            $v['nombreValcro']=$v->nombres_valcro()->get();
        }*/
        return $data;
    }

    public function getProv(request $prv)
    {
        $data = Provider::select("id","razon_social as description","contrapedido as contraped","limite_credito as limCred", "siglas","tipo_id as type","tipo_envio_id as envio")->where("id",$prv->id)->get()->first();
        $data->contraped = ($data->contraped == 1);
        return $data;
    }


    public function saveOrUpdateProv(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $prov =  Provider::findOrFail($req->id);
            $result['action']="update";
        }else{
            $prov =  new Provider();
        }
        $prov->razon_social = $req->description;
        $prov->tipo_id = $req->type;
        $prov->siglas = $req->siglas;
        $prov->tipo_envio_id = $req->envio;
        $prov->contrapedido = $req->contraped;

        $prov->save();
        $result['id']=$prov->id;
        return $result;
    }

    public function saveProvDir(request $req)
    {
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");

        if($req->id){
            $addr = Address::findOrFail($req->id);
            $result['action']="update";
        }else{
            $addr = new Address();
        }
        $addr->direccion = $req->direccProv;
        $addr->prov_id = $req->id_prov;
        $addr->pais_id = $req->pais;
        $addr->tipo_dir = $req->tipo;
        $addr->telefono = $req->provTelf;
        $addr->save();

        $result['id'] = $addr->id;
        return $result;
    }

    public function listProvAddr($id)
    {
        if($id){
            $addrs = Provider::find($id)->address()->get();
            foreach($addrs as $v){
                $v['pais'] = $v->country()->first();
            }
            return $addrs;
        }else{
            return [];
        }

    }

    public function saveValcroName(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        $valName = new NombreValcro();
        $valName->prov_id = $req->prov_id;
        $valName->nombre = $req->name;
        $valName->fav = $req->fav;
        $valName->save();

        $result['id']=$valName->id;
        return $result;
    }

    public function delValcroName(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "del","id"=>"$req->id");
        NombreValcro::destroy($req->id);
        return $result;
    }

    public function listValcroName($provId){
        if($provId){
            $valName = Provider::find($provId)->nombres_valcro()->select("id","nombre as name","fav")->get();
            return $valName;
        }else{
            return [];
        }
    }

    public function listContacProv($provId){
        if($provId){
            $valName = Provider::find($provId)->contacts()->get();
            return ($valName)?$valName:[];
        }else{
            return [];
        }
    }

    public function allContacts(){
        $contacts = Contactos::get();
        foreach($contacts as $contact){
            $contact['provs']=$contact->contacto_proveedor()->select("siglas as prov")->get();
        }
        return ($contacts)?$contacts:[];
    }

    public function saveContact(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $valName = Contactos::find($req->id);
            $result['action']="upd";
        }else{
            $valName = new Contactos();
        }
        if($valName->agente != 1){
            $valName->email = $req->emailCont;
            $valName->nombre = $req->nombreCont;
            $valName->telefono = $req->contTelf;
            $valName->responsabilidades = $req->responsability;
            $valName->direccion = $req->dirOff;
            $valName->agente = $req->isAgent;
            $valName->pais_id = ($req->pais!="")?$req->pais!="":NULL;
            $valName->id_lang = $req->languaje;
            $valName->save();
        }
        if(!Provider::find($req->prov_id)->contacts()->find($valName->id)){
            Provider::find($req->prov_id)->contacts()->attach($valName->id);
        }
        $result['id']=$valName->id;
        return $result;
    }

    public function getBank($id){
        if($id!=0){
            $accounts = Provider::find($id)->bankAccount()->get();
            return ($accounts)?$accounts:[];
        }else{
            return [];
        }

    }

    public function saveInfoBank(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $bank = Bank::find($req->id);
            $result['action']="upd";
        }else{
            $bank = new Bank();
        }

        $bank->banco = $req->bankName;
        $bank->cuenta = $req->bankIban;
        $bank->swift = $req->bankSwift;
        $bank->beneficiario = $req->bankBenef;
        $bank->dir_banco = $req->bankAddr;
        $bank->dir_beneficiario = $req->dirBenef;
        $bank->ciudad_id = $req->ciudad;
        $bank->prov_id = $req->idProv;

        $bank->save();
        $result['id']=$bank->id;
        return $result;
    }

    public function getCoins($id){
        $coins = Provider::find($id)->getProviderCoin()->get();
        return ($coins)?$coins:[];
    }

    public function saveCoin(request $req){
        if(!Provider::find($req->prov_id)->contacts()->find($req->id)){
            Provider::find($req->prov_id)->contacts()->attach($req->id);
        }
    }

    public function delCoin(request $req){
        if(!Provider::find($req->prov_id)->contacts()->find($req->id)){
            Provider::find($req->prov_id)->contacts()->dettach($req->id);
        }
    }

    public function assignCoin($id){
        $coins = Provider::find($id)->getProviderCoin()->lists("tbl_moneda.id");
        return ($coins)?$coins:[];
    }

    public function getCreditLimits($id){
        $limits = Provider::find($id)->limitCredit()->get();
        foreach($limits as $lim){
            $lim['moneda']=Monedas::find($lim->moneda_id);
        }

        return ($limits)?$limits:[];
    }

    public function saveLimCred(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $lim = limCred::find($req->id);
            $result['action']="upd";
        }else{
            $lim = new limCred();
        }

        $lim->prov_id = $req->id_prov;
        $lim->moneda_id = $req->coin;
        $lim->limite = $req->amount;

        $lim->save();
        $result['id']=$lim->id;
        return $result;
    }

    public function getFactorConvers($id){
        $factors = Provider::find($id)->convertFact()->get();
        foreach($factors as $factor){
            $factor['moneda']=Monedas::find($factor->moneda_id);
        }

        return ($factors)?$factors:[];
    }


    public function saveFactorConvert(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $fact = FactConv::find($req->id);
            $result['action']="upd";
        }else{
            $lim = new FactConv();
        }

        $lim->prov_id = $req->id_prov;
        $lim->moneda_id = $req->coin;
        $lim->flete = $req->freight;
        $lim->gastos = $req->expens;
        $lim->ganancia = $req->gain;
        $lim->descuento = $req->disc;

        $lim->save();
        $result['id']=$lim->id;
        return $result;
    }

    public function provCountries($id){
        $countries = Provider::find($id)->address()->groupBy("pais_id")->get();
       foreach($countries as $country){
           $country['pais']=$country->country()->get()->first();
        }
       // dd($country);
        return ($countries)?$countries:[];
    }


    public function getProdTime($id){
        $times = Provider::find($id)->prodTime()->get();
        foreach($times as $time){
           $time->country;
        }

        return ($times)?$times:[];
    }


    public function saveProdTime(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $time = ProdTime::find($req->id);
            $result['action']="upd";
        }else{
            $time = new ProdTime();
        }

        $time->prov_id = $req->id_prov;
        $time->min_dias = $req->from;
        $time->max_dias = $req->to;
        $time->id_pais = $req->country;

        $time->save();
        $result['id']=$time->id;
        return $result;
    }

    public function getProdTrans($id){
        $times = Provider::find($id)->transTime()->get();
        foreach($times as $time){
            $time->country;
        }

        return ($times)?$times:[];
    }

    public function saveProdTrans(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $time = TiemAproTran::find($req->id);
            $result['action']="upd";
        }else{
            $time = new TiemAproTran();
        }

        $time->prov_id = $req->id_prov;
        $time->min_dias = $req->from;
        $time->max_dias = $req->to;
        $time->id_pais = $req->country;

        $time->save();
        $result['id']=$time->id;
        return $result;
    }

}