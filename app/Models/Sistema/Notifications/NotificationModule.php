<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Notifications;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App;
use Illuminate\Support\Facades\View;
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
    protected $template = "emails.modules.Order.Internal.ResumenDoc";


    /**
     *Container del embarq
     */
    public function data(){
        return $this->hasMany('App\Models\Sistema\Notifications\NotificationData', 'noti_modulo_id');
    }
    /**
     *Container del embarq
     */
    public function senders(){
        return $this->hasMany('App\Models\Sistema\Notifications\NotificationSenders', 'noti_modulo_id');
    }



    public function send($data,$sender, $model, $type = null, $template = null){
        Mail::send(($template== null) ?$template :$this->template,$data, function ($m) use( $data, $sender, $type,$model ){
            $m->subject($sender['subject']);
            foreach($sender['to'] as $aux)
            {
                $m->to($aux['email'], $aux['name']);
            }
            foreach($sender['cc'] as $aux)
            {
                $m->cc($aux['email'], $aux['name']);
            }
            foreach($sender['ccb'] as $aux)
            {
                $m->ccb($aux['email'], $aux['name']);
            }
            $model->clave= $type;
            $model->save();


        });
        return $sender;
    }

    public function send_mail( $template ,$sender, $data ){

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
    }









}