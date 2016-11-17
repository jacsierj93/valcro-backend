<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Notifications;
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

class NotificationModule extends Model
{
    use SoftDeletes;
    protected $table = "tbl_noti_modulo";
    protected $dates = ['deleted_at'];


    /**
     *sennder
     */
    public function senders(){
        return $this->hasMany('App\Models\Sistema\Notifications\NotificationSenders', 'doc_id');
    }

    public function sendMail ($template,$sender){

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
           // dd($fileModel);
            $attPdf->put($fileModel->archivo, $pdf);
           // $attPdfModel = $attPdf->savePdf($attPdf);


            if(!array_key_exists('atts',$sender )){
                $sender['atts']= [];

            }

            $sender['atts'][] =['data'=>storage_path() . '/app/mail/backut/'.$fileModel->archivo, 'nombre'=>'offline.pdf'];
           // dd($sender);

           $this->sending($template, $sender);
            $model->send = Carbon::now();
            $model->save();
            return ['is'=>true];

        }
        catch (\Exception $e) {
            $model->send = null;
            $model->save();
            $model->failSend($template);
            return $e;
            return ['is'=>false, $e];
            return ['is'=>false];

        }
    }


    public function  failSend ($data){
        $store = Storage::disk('mail_fail');
        $store->put(''.$this->id, $data);
    }

    public function resend (){
        $store = Storage::disk('mail_fail');
        $template = $store->get(''.$this->id);
        $senders = ['subject' =>$this->asunto , 'to'=>[new NotificationSenders(['tipo'=>'to','doc_id'=>'78','email'=>'meqh1992@gmail.com','nombre'=>'miguel'])], 'cc'=>[], 'ccb'=>[]];
        $send = $this->senders()->get();


        foreach ($send->where('tipo','to') as $aux){
            $senders['to'][] = $aux;
        }
        foreach ($send->where('tipo','cc') as $aux){
            $senders['cc'][] = $aux;
        }
        foreach ($send->where('tipo','ccb') as $aux){
            $senders['ccb'][] = $aux;
        }

       // return $senders;
        try {   $this->sending($template,$senders);
            return ['is'=>true];
        }
        catch (\Exception $e) {
            return $e;
            return ['is'=>false, $e];
        }
        //$this->senders()->get();



    }
    private function sending ($template, $sender,$opc = []){
        $model = $this;
        Mail::send('emails.render', ['data'=>$template],function ($m) use($sender , $model){
            $m->subject($sender['subject']);

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
                foreach($sender['ccb'] as $aux)
                {
                    $m->ccb($aux->email, $aux->nombre);
                    $aux->send = 1;
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

    /*    public function view (){
            $model= new GenericModel($this->doc_tipo_id);

            $model = $model->getModel()->findOrFail($this->doc_id);
            return View::make($this->plantilla,['model'=>$model, 'noti'=>$this])->render();
        }*/
    public function send(){
/*        $model= new GenericModel($this->doc_tipo_id);
        $model = $model->getModel()->findOrFail($this->doc_id);

        $sender = ['subject'=>$this->asunto , 'to'=>$this->where('tipo','to'), 'cc'=>$this->where('tipo','cc'), 'ccb'=>$this->where('tipo','ccb')];
        $data =['model'=>$model, 'noti'=>$this];*/

/*
        $html = View::make($this->plantilla,$data)->render();
        $snappy = App::make('snappy.pdf');
        $archivo = response()->make($snappy->getOutputFromHtml($html), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="file.pdf"'
        ]);
        if(!array_key_exists('attsData',$sender )){
            $sender['attsData']= [];
        }
        $sender['attsData'][] =['data'=>$archivo,'name'=>'pdf'];
        $model = $this;


        Mail::send($this->plantilla,$data, function ($m) use( $data, $sender, $model ){
            $m->subject($sender['subject']);
            foreach($sender['to'] as $aux)
            {
                $m->to($aux['email'], $aux['name']);
            }
            if(array_key_exists('cc',$sender )){
                foreach($sender['cc'] as $aux)
                {
                    $m->cc($aux['email'], $aux['name']);
                }
            }
            if(array_key_exists('ccb',$sender )){
                foreach($sender['ccb'] as $aux)
                {
                    $m->ccb($aux['email'], $aux['name']);
                }
            }
            if(array_key_exists('attsData',$sender )){
                foreach($sender['attsData'] as $aux)
                {
                    $m->attachData($aux['data'], $aux['name'],(array_key_exists('opcs',$aux) ?$aux['opcs'] :[] ) );
                }
            }
            if(array_key_exists('atts',$sender )){
                foreach($sender['atts'] as $aux)
                {
                    $m->attach($aux['data'], $aux['name'],(array_key_exists('opcs',$aux) ?$aux['opcs'] :[] ) );
                }
            }
            $model->send_at = Carbon::now();
            $model->save();



        });*/
        //return $sender;
    }

/*    public function send_mail( $template ,$sender, $data ){

       $this->save();
        $html = View::make($template,$data)->render();
        $snappy = App::make('snappy.pdf');
        $archivo = response()->make($snappy->getOutputFromHtml($html), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="file.pdf"'
        ]);
        if(!array_key_exists('attsData',$sender )){
            $sender['attsData']= [];
        }
        $sender['attsData'][] =['data'=>$archivo,'name'=>'pdf'];
        $model = $this;


        Mail::send($template,$data, function ($m) use( $data, $sender, $model ){
            $m->subject($sender['subject']);
            foreach($sender['to'] as $aux)
            {
                $m->to($aux['email'], $aux['name']);
            }
            if(array_key_exists('cc',$sender )){
                foreach($sender['cc'] as $aux)
                {
                    $m->cc($aux['email'], $aux['name']);
                }
            }
            if(array_key_exists('ccb',$sender )){
                foreach($sender['ccb'] as $aux)
                {
                    $m->ccb($aux['email'], $aux['name']);
                }
            }
            if(array_key_exists('attsData',$sender )){
                foreach($sender['attsData'] as $aux)
                {
                    $m->attachData($aux['data'], $aux['name'],(array_key_exists('opcs',$aux) ?$aux['opcs'] :[] ) );
                }
            }
            if(array_key_exists('atts',$sender )){
                foreach($sender['atts'] as $aux)
                {
                    $m->attach($aux['data'], $aux['name'],(array_key_exists('opcs',$aux) ?$aux['opcs'] :[] ) );
                }
            }
            $model->send_at = Carbon::now();
            $model->save();



        });
        return $sender;
    }*/









}