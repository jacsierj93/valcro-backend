<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\MailModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App;
use Illuminate\Support\Facades\View;
/**
this model sen mail on registre in tbl_noti_modulo

 **/

/**sender struct **/


class MailModuleAttachment extends Model
{
    use SoftDeletes;
    protected $table = "tbl_mail_modulo_adj";
    protected $dates = ['deleted_at'];

    // constructores
    function __construct()
    {
        $a = func_get_args();
        if(sizeof($a > 0)){
            foreach ($a[0] as $key => $value){
              $this[$key]= $value;
            }
        }
        $this->save();

    }

}