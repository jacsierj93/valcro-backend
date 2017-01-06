<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\MailModels;
use App\Libs\Utils\Files;
use App\Libs\Utils\GenericModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Storage;

use Carbon\Carbon;
/**
this model sen mail on registre in tbl_noti_modulo

 **/

/**sender struct **/

//$sender  =
//    [
//    'subject'=>'', // string asunto
//
//        // destinatarios base
//    'to'=>
//        ['email'=>'', 'name'=>''], // email de destino nombre del destinario, // string asunto
//
//        // destinatarios de copia
//    'cc'=>
//        ['email'=>'', 'name'=>''], // email de destino nombre del destinario, // email de destino nombre del destinario, // string asunto
//
//        // destinatarios de copia oculta
//    'ccb'=>
//        ['email'=>'', 'name'=>''], // email de destino nombre del destinario//        // destinatarios de copia oculta
//  adjuntos por data
//    'attsData'=>
//        ['data'=>'', 'name'=>'' ,'opcs'=>[]] // email de destino nombre del destinario
//    ];
//  adjuntos por data
//    'atts'=>
//        ['data'=>'', 'name'=>'' ,'opcs'=>[]] // email de destino nombre del destinario
//    ];
//

class MailModule extends Model
{
    use SoftDeletes;
    protected $table = "tbl_mail_modulo";
    protected $dates = ['deleted_at'];


    /**
     *sennder
     */
    public function senders(){
        return $this->hasMany('App\Models\Sistema\MailModels\MailModuleDestinations', 'doc_id');
    }

    public function sendMail ($template,$sender =  []){

        $model = $this;
        try {
            $snappy = App::make('snappy.pdf');
            $pdf = response()->make($snappy->getOutputFromHtml($template), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            ]);
            $attPdf = Storage::disk('mail_backut');
            $files = new  Files('mail_backut');
            $fileModel= $files->pdf();
            $attPdf->put($fileModel->archivo, $pdf);
            if(!array_key_exists('atts',$sender )){
                $sender['atts']= [];
            }

            $ofline= ['data'=>storage_path() . '/app/mail/backut/'.$fileModel->archivo, 'nombre'=>'offline.pdf'];
            $sender['atts'][] =$ofline ;
            $this->backut = $fileModel->archivo;
            $this->sending($template, $sender);
            $model->send = Carbon::now();
            $model->save();
            return ['is'=>true, 'id'=>$model->id,'attOff'=>$ofline];
        }
        catch (\Exception $e) {
            $model->send = null;
            $model->save();
            $model->failSend($template);

            return ['is'=>false, 'id'=>$model->id,$e];
        }
    }


    public function  failSend ($data){
        $store = Storage::disk('mail_fail');
        $store->put(''.$this->id, $data);
    }

    public function resend (){
        $store = Storage::disk('mail_fail');
        $template = $store->get(''.$this->id);
        $senders = ['subject' =>$this->asunto , 'to'=>[], 'cc'=>[], 'ccb'=>[]];
        $send = $this->senders()->get();

        if(!array_key_exists('atts',$senders )){
            $sender['atts']= [];
        }
        $senders['atts'][] =['data'=>storage_path() . '/app/mail/backut/'.$this->backut, 'nombre'=>'offline.pdf'];

        foreach ($send->where('tipo','to') as $aux){
            $senders['to'][] = $aux;
        }
        foreach ($send->where('tipo','cc') as $aux){
            $senders['cc'][] = $aux;
        }
        foreach ($send->where('tipo','ccb') as $aux){
            $senders['ccb'][] = $aux;
        }
        try {   $this->sending($template,$senders);
            return ['is'=>true, 'id'=>$this->id ,'senders'=>$senders];
        }
        catch (\Exception $e) {

            return ['is'=>false, 'id'=>$this->id];
        }
    }
    private function sending ($template, $sender,$opc = []){
        $model = $this;
        Mail::send('emails.render', ['data'=>$template],function ($m) use($sender , $model){
            $m->subject($sender['subject']);

            if(array_key_exists('from' , $sender)){
                $m->from($sender['from']['email'],$sender['from']['nombre']);
            }
            foreach($sender['to'] as $aux)
            {
                $m->to($aux->email, $aux->nombre);
                $aux->send = 1;
            }
            if(array_key_exists('cc',$sender )){
                foreach($sender['cc'] as $aux)
                {
                    $m->cc($aux->email, $aux->nombre);
                    $aux->send = 1;
                }
            }
            if(array_key_exists('ccb',$sender )){
                if(array_key_exists('ccb',$sender )){
                    foreach($sender['ccb'] as $aux)
                    {
                        $m->cc($aux->email, $aux->nombre);
                        $aux->send = 1;
                    }
                }
            }
            if(array_key_exists('attsData',$sender )){
                foreach($sender['attsData'] as $aux)
                {
                    $m->attachData($aux['data'], $aux['nombre'],(array_key_exists('opcs',$aux) ?$aux['opcs'] :[] ) );
                }
            }
            if(array_key_exists('atts',$sender )){
                foreach($sender['atts'] as $aux)
                {
                    $m->attach($aux['data'],['as'=>$aux['nombre']]);
                }
            }


        });
        $model->send = Carbon::now();
        $model->save();
    }









}