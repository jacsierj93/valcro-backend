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
use DB;
use Illuminate\Support\Facades\Mail;

class NotificationOrder extends Model
{
    use SoftDeletes;
    protected $table = "tbl_noti_pedido";
    protected $dates = ['deleted_at'];
    protected $template = "emails.modules.Order.Internal.ResumenDoc";


    public function send($data,$sender, $model, $type = null){
        Mail::send($this->template,$data, function ($m) use( $data, $sender, $type,$model ){
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



}