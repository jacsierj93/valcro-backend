<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 4:01 PM
 */

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Mail;

use Laravel\Lumen\Routing\Controller as BaseController;


class EmailController extends BaseController
{


    public function test()
    {
        Mail::send('emails.prueba', [], function ($m) {

            $m->to("luisnavarro.dg@gmail.com", "Luis Navarro")->subject('Prueba de correo desde valcro.co');
        });
    }




}