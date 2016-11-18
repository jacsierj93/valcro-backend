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



class MailAlert extends Model
{
    use SoftDeletes;
    protected $table = "tbl_mail_alert";
    protected $dates = ['deleted_at'];

    private  $model = null;

    /**
     *sennder
     */
    public function senders(){
        return $this->hasMany('App\Models\Sistema\MailModels\MailAlertDestinations', 'doc_id');
    }

    public function sendMail(){
        $html = $this->preview ();
        $sender = ['subject'=>$this->asunto,'to'=>[] ,'cc'=>[], 'ccb'=> [ ]];
        $dest = $this->senders()->get();
        foreach ($dest->where('tipo','to') as $aux){
            $sender['to'][] = $aux;
        }
        foreach ($dest->where('tipo','cc') as $aux){
            $sender['cc'][] = $aux;
        }
        foreach ($dest->where('tipo','ccb') as $aux){
            $sender['ccb'][] = $aux;
        }
        try{

            $this->sending($html,$sender);
            $this->send = Carbon::now();
            $this->save();
            return ['is'=>true, 'id'=>$this->id];
        }
        catch (\Exception $e) {
            return ['is'=>false, 'id'=>$this->id,$e];
        }

    }

    public function preview (){
        return View::make($this->plantilla,['noti'=>$this, 'model'=> $this->getmodel()]);
    }


    private function  getmodel(){
        $model = new GenericModel($this->tipo_origen_id);
        $model= $model->getModel()->findOrFail($this->doc_origen_id);
        $this->model= $this->parse_model($model);
        return $this->model;

    }

    private function parse_model ($model){
        if($model->emision != null){
            $model->emision = vl_db_out_put_date($model->emision);
        }
        return $model;
    }
    private function sending ( $html, $sender,$opc = []){
        $model = $this;
        $snappy = App::make('snappy.pdf');
        $pdf = response()->make($snappy->getOutputFromHtml($html), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition'   => 'attachment; filename="file.pdf"'
        ]);
        $sender['attsData'] =[['data'=>$pdf, 'nombre'=>'ofline.pdf']];
        Mail::send('emails.render', ['data'=>$html],function ($m) use($sender , $model){
            $m->subject($model->asunto);

            foreach($sender['to'] as $aux)
            {
                $m->to($aux->email, $aux->nombre);
            }
            if(array_key_exists('cc',$sender )){
                foreach($sender['cc'] as $aux)
                {
                    $m->cc($aux->email, $aux->nombre);

                }
            }
            if(array_key_exists('ccb',$sender )){
                foreach($sender['ccb'] as $aux)
                {
                    $m->ccb($aux->email, $aux->nombre);
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