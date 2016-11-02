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
//        ['email'=>'', 'name'=>''] // email de destino nombre del destinario
//    ];
//

class NotificationModule extends Model
{
    use SoftDeletes;
    protected $table = "tbl_noti_modulo";
    protected $dates = ['deleted_at'];
    protected $template = "emails.modules.Order.Internal.ResumenDoc";



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

    public function send_mail($modulo, $template ,$sender, $data , $type= null , $model = null){

        if($model = null){

            $model = new NotificationModule();
        }



        $this->modulo= $modulo;
        $this->clave= $type;
        $this->save();

 /*       Mail::send(($template== null) ?$template :$this->template,$data, function ($m) use( $data, $sender, $type , $model){
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



        });*/
        return $sender;
    }









}