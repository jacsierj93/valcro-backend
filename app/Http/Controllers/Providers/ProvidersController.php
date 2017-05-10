<?php
namespace App\Http\Controllers\Providers;
use App\Models\Sistema\Masters\Country;
use App\Models\Sistema\Providers\Point;
use App\Models\Sistema\Providers\ProviderCreditLimit;
use App\Models\Sistema\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Providers\NombreValcro;
use App\Models\Sistema\Providers\Contactos;
use App\Models\Sistema\Providers\ProviderAddress as Address;
use App\Models\Sistema\Providers\BankAccount as Bank;
use App\Models\Sistema\Providers\ProviderCreditLimit as limCred;
use App\Models\Sistema\Providers\ProviderFactor as FactConv;
use App\Models\Sistema\Masters\Monedas;
use App\Models\Sistema\Providers\ProdTime;
use App\Models\Sistema\Providers\TiemAproTran;
use App\Models\Sistema\Providers\ProviderCondPay;
use App\Models\Sistema\Providers\ProviderCondPayItem;
use App\Models\Sistema\Providers\ContactField;
use App\Models\Sistema\Masters\Line;
use App\Libs\Utils\Files;
use App\Models\Sistema\Masters\FileModel;
use App\Models\Sistema\Providers\ProviderListPrice;

use Session;
use Validator;

class ProvidersController extends BaseController
{
    public function __construct()
    {

        $this->middleware('auth');
    }
    
    public function index(){
        return view("modules/proveedores/index",array("list"=>$this->getList()));
    }


    public function provUpload(Request $req){
        $archivo = new Files("prov");
        $archivo->upload("file"); ///probando
    }
    public function getFiles(){

        //return Files::getFileList("prov");
        $archivo = new Files("pay");
        $files = FileModel::all();
        foreach($files as $v){
            $v["archivo"] = str_replace(".jpg","_thumb.jpg",$v["archivo"]);
        }
        return $files;
    }

    public function getFile(){
        $archivo = new Files("pay");
        return $archivo->getFile("images/5-QEhW6CgSn28mm-1-2016-06-20_05_04_07.jpg"); ///probando
    }


    public function getList()
    {
        $data = Provider::all();
        foreach($data as $prov){
            $prov['limCred']=$prov->limitCredit()->max("limite");
        }
        return json_encode($data);
    }
    public static function holamundo()
    {
       return "hola mundo desde controller";
    }

    public function getProv(request $prv)
    {
        $data = Provider::selectRaw("id,razon_social, siglas,tipo_id,tipo_envio_id, contrapedido, reserved")->find($prv->id);
        
        $data->contraped = ($data->contraped == 1);
        $data->limCred =$data->limitCredit()->max("limite");
        $data->nomValc = $data->nombres_valcro()->select("id","nombre as name","fav")->get();
        foreach($data->nomValc as $nom){
            $nom->departments = $nom->departamento()->selectRaw('tbl_departamento.id,tbl_departamento.nombre')->get();
        };
        $data->tiemposP = $data->prodTime()->selectRaw('id,prov_id,min_dias,max_dias,linea_id')->get();
        foreach ($data->tiemposP as $time){
            $time->lines;
        }
        $data->tiemposT = $data->transTime()->selectRaw('id,prov_id,min_dias,max_dias,id_pais')->get();
        foreach ($data->tiemposT as $time){
            $time->country;
        }
        $data->direcciones=$data->address()->selectRaw('id,prov_id,direccion,pais_id,tipo_dir,telefono, codigo_postal, aprov, user_aprov, coment_aprov')
                ->with("country")
                ->with("tipo")
                ->with(array("ports"=>function($q){
                    return $q->lists("puerto_id");
                }))
                
                ->get();
      
        $data->contacts = $data->contacts()
            ->selectRaw('tbl_contacto.id,nombre,pais_id,agente,responsabilidades, direccion, aprov, user_aprov, coment_aprov')
                ->with("country")
            ->get();
        foreach($data->contacts as $contact){
            $contact->languages=$contact->idiomas()->lists("languaje_id");
            $contact->emails=$contact->campos()->where("prov_id",$data->id)->where("campo","email")->get();
            $contact->phones=$contact->campos()->where("prov_id",$data->id)->where("campo","telefono")->get();
            $contact->cargos=$contact->campos()->where("prov_id",$data->id)->where("campo","cargos")->lists("valor");
            $dir = $contact->campos()->where("prov_id",$data->id)->where("campo","direccion")->first();
            $contact->direccion=($dir)?$dir->valor:"";
            $rep = $contact->campos()->where("prov_id",$data->id)->where("campo","responsabilidad")->first();
            $contact->responsabilidades=($rep)?$rep->valor:"";
            $rep = $contact->campos()->where("prov_id",$data->id)->where("campo","notas")->first();
            $contact->notas=($rep)?$rep->valor:"";
        }
        $data->banks = $data->bankAccount()->selectRaw('id,prov_id,banco,cuenta,swift, beneficiario, dir_banco, dir_beneficiario, ciudad_id, aprov, user_aprov, coment_aprov')
                
                ->get();
        
        foreach ($data->banks as $acc){
            $acc["ciudad"]=$acc->ciudad()->first();
            $acc["estado"] = $acc["ciudad"]->state()->first();
            $acc["pais"] = $acc["estado"]->country()->first();
        }
        $data->monedas = $data->getProviderCoin()->selectRaw('nombre,simbolo,codigo')->get();
        $data->limites = $data->limitCredit()->get();
        foreach ($data->limites as $lim){
            $lim->moneda = Monedas::find($lim->moneda_id);
            if($lim->linea_id){
                $lim->line = Line::find($lim->linea_id);
            }else{
                $lim->line = array("id"=>"0","linea"=>"TODAS","siglas"=>"todo");
            }
            //$lim->line = (Line::find($lim->linea_id))? Line::find($lim->linea_id): array("id"=>"0","linea"=>"TODAS","siglas"=>"todo");
        }
        $data->factors = $data->convertFact()->get();
        foreach($data->factors as $fact){
            $fact->moneda;
            if($fact->linea_id){
                $fact->linea;
            }else{
                $fact->linea = array("id"=>"0","linea"=>"TODAS","siglas"=>"todo");
            }
            //$fact->linea = ($fact->linea)?$fact->linea:array("id"=>"0","linea"=>"TODAS","siglas"=>"todo");
        }
        $data->points = $data->points()->get();
        foreach($data->points as $pnt){
            $pnt->moneda;
            if($pnt->linea_id){
                $pnt->linea;
            }else{
                $pnt->linea = array("id"=>"0","linea"=>"TODAS","siglas"=>"todo");
            }
            //$pnt->linea = ($pnt->linea)?$pnt->linea:array("id"=>"0","linea"=>"TODAS","siglas"=>"todo");
        }
        $data->prodTime = $data->prodTime()->get();
        foreach ($data->prodTime as $time) {
            if($time->linea_id){
                $time->lines;
            }else{
                $pnt->lines = array("id"=>"0","linea"=>"TODAS","siglas"=>"todo");
            }
            //$time->lines = ($time->linea)?$time->linea:array("id"=>"0","linea"=>"TODAS","siglas"=>"todo");
        }
        $data->transTime = $data->transTime()->get();
        foreach ($data->prodTime as $time) {
            $time->country;
        }
        $data->payCondition = $data->getPaymentCondition()->get();
        foreach ($data->payCondition as $cond) {
            $cond['items'] = $cond->getItems()->get();
            if($cond->linea_id){
                $cond->line;
            }else{ 
                $cond->line = array("id"=>"0","linea"=>"TODAS","siglas"=>"todo");
            }
        }
        $data->listPrice = $data->listPrice()->get();
        foreach ($data->listPrice as $list) {
            $list->files = $list->adjuntos()->select("archivo as file","archivo","archivo_id as id","tipo")->get();
            foreach ($list->files as $adj) {
                //dd($adj->getThumbName());
                $adj->thumb = $adj->getThumbName();
            }
        }

        return json_encode($data);
    }

    public function reservedProv(request $prv){
        $usr = $prv->session()->get('DATAUSER');

        Provider::where("reserved",$usr['id'])->update(array('reserved' => null));


        if($prv->prov && $prv->set){
            $prov =  Provider::findOrFail($prv->prov);
            $prov->reserved = $usr['id'];
            $prov->save();
        }


    }

    public function editedProv(request $prv){
        $usr = $prv->session()->get('DATAUSER');
        if($prv->prov){
            $prov =  Provider::findOrFail($prv->prov);
            $prov->edited = ($prv->set)?$usr['id']:null;
            $prov->save();
            dd($prv->set==true);
        }
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
        $prov->contrapedido = ($req->contraped)?1:0;

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

    public function aprovProvDir(request $req){
        $result = array("success" => "aprovacion/desaprovacion guardada con exito", "action" => "aprov","id"=>"$req->id");
        $addr = Address::find($req->id);
        $addr->aprov = $req->stat;
        $addr->coment_aprov = $req->coment;
        $addr->save();
        return $result;
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
        $valName->save();
        if($req->preFav){
            foreach($req->preFav as $prev){
                $temp = NombreValcro::find($prev["id"]);
                $temp->departamento()->updateExistingPivot($prev["dep"],array("fav"=>0));
                $temp->save();
            }

        }
        $departamentos = $req->departments;
        unset($departamentos[0]);
        $valName->departamento()->sync($departamentos);

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
                $contact->emails=$contact->campos()->where("prov_id",$id)->where("campo","email")->get();
                $contact->phones=$contact->campos()->where("prov_id",$id)->where("campo","telefono")->get();
                $contact->cargos=$contact->campos()->where("prov_id",$id)->where("campo","cargos")->lists("valor");
                $dir = $contact->campos()->where("prov_id",$id)->where("campo","direccion")->first();
                $contact->direccion=($dir)?$dir->valor:"";
                $rep = $contact->campos()->where("prov_id",$id)->where("campo","responsabilidad")->first();
                $contact->responsabilidades=($rep)?$rep->valor:"";
                $rep = $contact->campos()->where("prov_id",$id)->where("campo","notas")->first();
                $contact->notas=($rep)?$rep->valor:"";
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
            $contact = Contactos::find($req->id);
            $result['action']="upd";
        }else{
            $contact = new Contactos();
        }

        //if(!$contact->id){
            $contact->nombre = $req->nombreCont;
            $contact->pais_id = ($req->pais)?$req->pais:NULL;
            $contact->save();
            $contact->idiomas()->sync($req->languaje);
       // }
        //dd(array($contact->id=>$req->emailCont,$contact->id=>$req->contTelf,$contact->id=>$req->dirOff));
        if(!Provider::find($req->prov_id)->contacts()->find($contact->id)){
            Provider::find($req->prov_id)->contacts()->attach($contact->id);
        }

        $result['mails'] = $this->contactEmail($req->emailCont,$contact->id,$req->prov_id);
        $result['phones'] = $this->contactPhone($req->contTelf,$contact->id,$req->prov_id);
        //$result['cargos'] = $this->contactCargos($req->cargo,$contact->id,$req->prov_id);
        $this->contactCampos("direccion",$req->dirOff,$contact->id,$req->prov_id);
        $this->contactCampos("responsabilidad",$req->responsability,$contact->id,$req->prov_id);
        $this->contactCampos("notas",$req->notes,$contact->id,$req->prov_id);

        $result['id']=$contact->id;
        return $result;
    }

    private function contactEmail($reqs,$cont_id,$prov_id){
        //dd($reqs);
        $result = array();
        $exists = Contactos::find($cont_id)->campos()->where("prov_id",$prov_id)->where("campo","email")->get();
       // dd($exists->except(["45","43"]));
        $ids = [];
        foreach($reqs as $req){
            if($exists->contains($req["id"])){
                $ids[]=$req["id"];
                $email = Contactos::find($cont_id)->campos()->find($req["id"]);
            }else{
                $email = new ContactField();
            }
            $email->campo = "email";
            $email->cont_id = $cont_id;
            $email->prov_id = $req["prov_id"];
            $email->valor = $req["valor"];
            if($email->save()){
                $result[] = $email->id;
            }else{
                $result['success'] = false;
            }
        }

        foreach($exists->except($ids) as $k){
            ContactField::destroy($k->id);
        };



        return $result;
    }
    private function contactPhone($reqs,$cont_id,$prov_id){
        //dd($reqs);
        $result = array();
        $exists = Contactos::find($cont_id)->campos()->where("prov_id",$prov_id)->where("campo","telefono")->get();
        // dd($exists->except(["45","43"]));
        $ids = [];
        foreach($reqs as $req){
            if($exists->contains($req["id"])){
                $ids[]=$req["id"];
                $phone = Contactos::find($cont_id)->campos()->find($req["id"]);
            }else{
                $phone = new ContactField();
            }
            $phone->campo = "telefono";
            $phone->cont_id = $cont_id;
            $phone->prov_id = $req["prov_id"];
            $phone->valor = $req["valor"];
            if($phone->save()){
                $result[] = $phone->id;
            }else{
                $result['success'] = false;
            }
        }

        foreach($exists->except($ids) as $k){
            ContactField::destroy($k->id);
        };



        return $result;
    }
    private function contactCampos($field,$valor,$cont_id,$prov){
        $campo = Contactos::find($cont_id)->campos()->where("prov_id",$prov)->where("campo",$field)->first();
        if(!$campo){
            $campo = new ContactField();
        }
        $campo->campo = $field;
        $campo->cont_id = $cont_id;
        $campo->prov_id = $prov;
        $campo->valor = $valor;
        if($campo->save()){
            $result['id'] = $campo->id;
        }else{
            $result['success'] = false;
        }
        return $result;
    }
    private function contactCargos($reqs,$cont_id,$prov_id){
        //dd($reqs);
        $result = array();
        $exists = Contactos::find($cont_id)->campos()->where("prov_id",$prov_id)->where("campo","cargos")->delete();
        // dd($exists->except(["45","43"]));
        $ids = [];
        foreach($reqs as $req){
           /* if($exists->contains($req["id"])){
                $ids[]=$req["id"];
                $carg = Contactos::find($cont_id)->campos()->find($req["id"]);
            }else{*/
            $carg = new ContactField();
            //}
            $carg->campo = "cargos";
            $carg->cont_id = $cont_id;
            $carg->prov_id = $prov_id;
            $carg->valor = $req;
            if($carg->save()){
                $result[] = $carg->id;
            }else{
                $result['success'] = false;
            }
        }

       /* foreach($exists->except($ids) as $k){
            ContactField::destroy($k->id);
        };*/

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
//            dd($accounts);
            foreach ($accounts as $acc){
                $acc["ciudad"]=$acc->ciudad()->first();
                $acc["estado"] = $acc["ciudad"]->state()->first();
                $acc["pais"] = $acc["estado"]->country()->first();
            }
            return ($accounts)?json_encode($accounts):[];
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
        $bank->dir_beneficiario = $req->bankBenefAddr;
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
        $result = array("success" => "Registro desvinculado con éxito", "action" => "del","id"=>"$req->id");
        if(Provider::find($req->pivot['prov_id'])->getProviderCoin()->find($req->id)){

            Provider::find($req->pivot['prov_id'])->getProviderCoin()->detach($req->id);
        }
        return $result;
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
        $lim->linea_id = ($req->line!=0)?$req->line:null;

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
        $conds = [];

        if($req->id){
            $cond = ProviderCondPay::find($req->id);
            $result['action']="upd";
        }else{
            $cond = new ProviderCondPay();
        }
        $cond->titulo = $req->title;
        $cond->linea_id = ($req->line=='0')?NULL:$req->line;
        $cond->prov_id = $req->id_prov;

        $cond->save();


        foreach($req->items as $item ){
            $newItem =true;
            if($item['id']){
                $it = ProviderCondPayItem::find($item['id']);
                $newItem =false;
            }else{
                $it = new ProviderCondPayItem();
            }
            $it->porcentaje = $item['porcentaje'];
            $it->dias = $item['dias'];
            $it->descripcion = $item['id_condicion'];
            $it->id_condicion = $cond->id;

            $it->save();
            if($newItem){
                $conds[] = ($it->id);
            }

        }
        $result['items']=$conds;
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
        $lim->linea_id = ($req->line=='0')?NULL:$req->line;;

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
        $point->linea_id = ($req->line=='0')?NULL:$req->line;
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
            $countries = Provider::find($id)->address()->select("pais_id")->groupBy("pais_id")->get();
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
        $time->linea_id = ($req->line=='0')?NULL:$req->line;

        $time->save();
        $result['id']=$time->id;
        return $result;
    }

    public function delProdTime(request $req){
        $result = array("success" => "Registro desvinculado con éxito", "action" => "del","id"=>"$req->id");
        ProdTime::destroy($req->id);
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

    public function delTransTime(request $req){
        $result = array("success" => "Registro desvinculado con éxito", "action" => "del","id"=>"$req->id");
        TiemAproTran::destroy($req->id);
        return $result;
    }

    public function savePriceList(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $list = ProviderListPrice::find($req->id);
            $result['action']="upd";
        }else{
            $list = new ProviderListPrice();
        }

        $list->prov_id = $req->idProv;
        $list->referencia = $req->ref;
        $list->save();


        $list->adjuntos()->sync($req->adjs);
        $result['id']=$list->id;
        return $result;
    }



}