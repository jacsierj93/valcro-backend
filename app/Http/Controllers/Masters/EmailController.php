<?php
namespace App\Http\Controllers\Masters;


use App\Models\Sistema\Contactos;
use App\Models\Sistema\MailModels\MailPart;
use App\Models\Sistema\Masters\Language;
use App\Models\Sistema\Ports;
use App\Models\Sistema\Provider;
use App\Models\Sistema\ProviderAddress;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;



class EmailController extends BaseController
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**@deprecated */
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

	/**
     * cosntruye los templates para los correos
     * @param $module
	*/
    public static function builtTemplates ($module, $reason, $calback){
        $files =emails_templates_lang($module,$reason) ;
        $templates =MailPart::where('modulo',$module)->where('proposito',$reason)->first();
        $good = [];
        $bad = [];

        foreach ($files as $aux){
            $lang = new Language();
            $lang = $lang->where('iso_lang', $aux['iso_lang'])->orWhere('iso_lang','like','%'.$aux['iso_lang'])->first();
            $subjet = $templates->subjets()->where(function($query) use ($aux)  {
                $query->where('iso_lang', $aux['iso_lang'])->orWhere('iso_lang','like','%'.$aux['iso_lang']);

            })->first();
            if($lang != null && $subjet !=null){
                $content = [
                    'lang'=>strtolower($lang->lang),
                    'iso_lang'=>strtolower ($lang->iso_lang),
                    'subjet'=>$subjet->texto,
                    'subjets'=>$templates->subjets()->where(function($query) use ($aux)  {
                        $query->where('iso_lang', $aux['iso_lang'])->orWhere('iso_lang','like','%'.$aux['iso_lang']);

                    })->orderByRaw('rand()')->lists('texto'),
                    'contents'=>$templates->contents()->where(function($query) use ($aux)  {
                        $query->where('iso_lang', $aux['iso_lang'])->orWhere('iso_lang','like','%'.$aux['iso_lang']);

                    })->orderByRaw('rand()')->lists('texto')
                ];
                $content['body'] = $calback($content, 'emails/'.$module.'/'.$reason.'/'.$aux['iso_lang'],$templates);
                $good[$aux['iso_lang']] = $content;
            }else{
                $bad[$aux['iso_lang']] = ['lang'=>$lang ,'$subjet'=>$subjet];
            }

        }
        $data['bad'] =$bad ;
        $data['good'] =$good ;
        return $data;
    }

    public static function senMail($data){
        
    }


}