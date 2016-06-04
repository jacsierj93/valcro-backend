<?php
namespace App\Http\Controllers\Providers;
use App\Models\Sistema\Point;
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
use App\Models\Sistema\ProviderCondPay;
use App\Models\Sistema\ProviderCondPayItem;
use App\Models\Sistema\Line;
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
        $data = Provider::all();
        foreach($data as $prov){
            $prov['limCred']=$prov->limitCredit()->max("limite");
        }
        return $data;
    }

    public function getProv(request $prv)
    {
        $data = Provider::find($prv->id);

        $data->contraped = ($data->contraped == 1);
        $data->limCred =$data->limitCredit()->max("limite");
        $data->nomValc = $data->nombres_valcro()->get();
        $data->tiemposP = $data->prodTime()->get();
        foreach ($data->tiemposP as $time){
            $time->lines;
        }
        $data->tiemposT = $data->transTime()->get();
        foreach ($data->tiemposT as $time){
            $time->country;
        }
        $data->direcciones=$data->address()->get();
        foreach ($data->direcciones as $dir){
            $dir->country;
            $dir->tipo;
        }
        $data->contacts = $data->contacts()->get();
        foreach ($data->contacts as $cont){
            $cont->cargos = $cont->cargos()->get();
        }
        $data->monedas = $data->getProviderCoin()->get();
        $data->limites = $data->limitCredit()->get();
        foreach ($data->limites as $lim){
            $lim->moneda = Monedas::find($lim->moneda_id);
        }
        $data->banks = $data->bankAccount()->get();
        return $data;
    }


    public function saveOrUpdateProv(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $prov =  Provider::findOrFail($req->id);
            $result['action']="upd";
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
            $result['action']="upd";
        }else{
            $addr = new Address();
        }
        $addr->direccion = $req->direccProv;
        $addr->prov_id = $req->id_prov;
        $addr->pais_id = $req->pais;
        $addr->tipo_dir = $req->tipo;
        $addr->telefono = $req->provTelf;
        $addr->codigo_postal = $req->zipCode;
        $addr->save();
        if($addr->tipo_dir == 2){
            $addr->ports()->sync($req->ports);
        }
        $result['id'] = $addr->id;
        return $result;
    }

    public function delProvDir(request $req){
        $result = array("success" => "Registro borrado con éxito", "action" => "del","id"=>"$req->id");
        Address::destroy($req->id);
        return $result;
    }

    public function listProvAddr($id)
    {
        if($id){
            $addrs = Provider::find($id)->address()->get();
            foreach($addrs as $v){
                $v['pais'] = $v->country()->first();
                $v->tipo;
                $v->ports = $v->ports()->lists("puerto_id");
            }
            return $addrs;
        }else{
            return [];
        }

    }

    public function saveValcroName(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $valName = NombreValcro::find($req->id);
            $result['action']="upd";
        }else{
            $valName = new NombreValcro();
        }
        $valName->prov_id = $req->prov_id;
        $valName->nombre = $req->name;
        $valName->fav = $req->fav;
        $valName->save();
        foreach($req->departments as $k=>$v){
            if(!$v){
                unset($req->departments[$k]);
            }
        }
        if($req->preFav){
            $temp = NombreValcro::find($req->preFav["id"]);
            $temp->departamento()->updateExistingPivot($req->preFav["dep"],array("fav"=>0));
            $temp->save();
        }
        $valName->departamento()->sync($req->departments);

        $result['id']=$valName->id;
        return $result;
    }

    public function delValcroName(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "del","id"=>"$req->id");
        NombreValcro::destroy($req->id);
        return $result;
    }

    public function listValcroName($id){
        if((bool)$id){
            $valName = Provider::find($id)->nombres_valcro()->select("id","nombre as name","fav")->get();
            foreach($valName as $nom){
                $nom->departments = $nom->departamento()->get();
            }
            return $valName;
        }
    }

    public function listAllValcroName(){
        $valName = NombreValcro::all();
        foreach($valName as $nom){
            $nom->departments = $nom->departamento()->get();
            $nom->providers;
        }
        return $valName;
    }

    public function listContacProv($id){
        if((bool)$id){
            $contacts = Provider::find($id)->contacts()->get();
            foreach($contacts as $contact){
                $contact->languages=$contact->idiomas()->lists("languaje_id");
                $contact->cargos=$contact->cargos()->lists("cargo_id");
            }
            return ($contacts)?$contacts:[];
        }
    }

    public function allContacts(){
        $contacts = Contactos::get();
        foreach($contacts as $contact){
            $contact['provs']=$contact->contacto_proveedor()->select("prov_id","siglas as prov")->get();
            $contact->languages=$contact->idiomas()->lists("languaje_id");
            $contact->cargos=$contact->cargos()->lists("cargo_id");
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
            $valName->pais_id = ($req->pais)?$req->pais:NULL;
            $valName->save();
            //echo $req->languaje;
            //if(count($req->languaje) > 0){
            $valName->idiomas()->sync($req->languaje);
            //}
            $valName->cargos()->sync($req->cargo);
        }
        if(!Provider::find($req->prov_id)->contacts()->find($valName->id)){
            Provider::find($req->prov_id)->contacts()->attach($valName->id);
        }
        $result['id']=$valName->id;
        return $result;
    }

    public function delProvContact(request $req){
        $result = array("success" => "Registro desvinculado con éxito", "action" => "del","id"=>"$req->id");
        Provider::find($req->prov_id)->contacts()->detach($req->id);
        return $result;
    }

    public function getBank($id){
        if((bool)$id){
            $accounts = Provider::find($id)->bankAccount()->get();
            return ($accounts)?$accounts:[];
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

    public function delInfoBank(request $req){
        $result = array("success" => "Registro desvinculado con éxito", "action" => "del","id"=>"$req->id");
        Bank::destroy($req->id);
        return $result;
    }

    public function getCoins($id){
        if((bool)$id) {
            $coins = Provider::find($id)->getProviderCoin()->get();
            return ($coins) ? $coins : [];
        }
    }

    public function saveCoin(request $req){
        if(!Provider::find($req->prov_id)->getProviderCoin()->find($req->coin)){
            Provider::find($req->prov_id)->getProviderCoin()->attach($req->coin);
        }
    }

    public function delCoin(request $req){
        if(!Provider::find($req->prov_id)->getProviderCoin()->find($req->id)){
            Provider::find($req->prov_id)->getProviderCoin()->detach($req->id);
        }
    }

    public function assignCoin($id){
        if((bool)$id) {
            $coins = Provider::find($id)->getProviderCoin()->lists("tbl_moneda.id");
            return ($coins) ? $coins : [];
        }
    }

    public function getCreditLimits($id){
        if((bool)$id) {
            $limits = Provider::find($id)->limitCredit()->get();
            foreach ($limits as $lim) {
                $lim['moneda'] = Monedas::find($lim->moneda_id);
                $lim->line = Line::find($lim->linea_id);
            }
            return ($limits) ? $limits : [];
        }
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
        $lim->linea_id = ($req->line!=0)?$req->line:NULL;

        $lim->save();
        $result['id']=$lim->id;
        return $result;
    }

    public function delLimCred(request $req){
        $result = array("success" => "Registro desvinculado con éxito", "action" => "del","id"=>"$req->id");
        limCred::destroy($req->id);
        return $result;
    }

    public function getConditions($id){
        if((bool)$id) {
            $conditions = Provider::find($id)->getPaymentCondition()->get();
            foreach ($conditions as $cond) {
                $cond['items'] = $cond->getItems()->get();
                $cond->line;
            }
            return ($conditions) ? $conditions : [];
        }
    }

    public function saveHeadCond(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $cond = ProviderCondPay::find($req->id);
            $result['action']="upd";
        }else{
            $cond = new ProviderCondPay();
        }
        $cond->titulo = $req->title;
        $cond->linea_id = $req->line;
        $cond->prov_id = $req->id_prov;

        $cond->save();
        $result['id']=$cond->id;
        return $result;
    }

    public function delHeadCondition(request $req){
        $result = array("success" => "Registro desvinculado con éxito", "action" => "del","id"=>"$req->id");
        ProviderCondPay::destroy($req->id);
        return $result;
    }


    public function saveItemCond(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $item = ProviderCondPayItem::find($req->id);
            $result['action']="upd";
        }else{
            $item = new ProviderCondPayItem();
        }
        $item->porcentaje = $req->percent;
        $item->dias = $req->days;
        $item->descripcion = $req->condit;
        $item->id_condicion = $req->id_head;

        $item->save();
        $result['id']=$item->id;
        return $result;
    }

    public function getFactorConvers($id){
        if($id) {
            $factor = Provider::find($id)->convertFact()->get();
            foreach($factor as $fact){
                $fact->moneda;
                $fact->linea;
            }

            return ($factor)?$factor:false;
        }
    }


    public function saveFactorConvert(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $lim = FactConv::find($req->id);
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
        $lim->linea_id = $req->line;

        $lim->save();
        $result['id']=$lim->id;
        return $result;
    }

    public function delConvFact(request $req){
        $result = array("success" => "Registro desvinculado con éxito", "action" => "del","id"=>"$req->id");
        FactConv::destroy($req->id);
        return $result;
    }

    public function savePoint(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $point = Point::find($req->id);
            $result['action']="upd";
        }else{
            $point = new Point();
        }

        $point->prov_id = $req->id_prov;
        $point->moneda_id = $req->coin;
        $point->linea_id = $req->line;
        $point->costo = $req->cost;
        $point->save();
        $result['id']=$point->id;
        return $result;
    }

    public function delPoint(request $req){
        $result = array("success" => "Registro desvinculado con éxito", "action" => "del","id"=>"$req->id");
        Point::destroy($req->id);
        return $result;
    }

    public function getPoints($id){
        if($id) {
            $points = Provider::find($id)->points()->get();
            foreach($points as $pnt){
                $pnt->moneda;
                $pnt->linea;
            }

            return ($points)?$points:false;
        }
    }

    public function provCountries($id){
        if((bool)$id) {
            $countries = Provider::find($id)->address()->groupBy("pais_id")->get();
            foreach ($countries as $country) {
                $country['pais'] = $country->country()->get()->first();
            }
            // dd($country);
            return ($countries) ? $countries : [];
        }
    }


    public function getProdTime($id){
        if((bool)$id) {
            $times = Provider::find($id)->prodTime()->get();
            foreach ($times as $time) {
                $time->lines;
            }

            return ($times) ? $times : [];
        }/*else{
            return [];
        }*/
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
        $time->linea_id = $req->line;

        $time->save();
        $result['id']=$time->id;
        return $result;
    }

    public function getTimeTrans($id){
        if((bool)$id) {
            $times = Provider::find($id)->transTime()->get();
            foreach ($times as $time) {
                $time->country;
            }

            return ($times) ? $times : [];
        }
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