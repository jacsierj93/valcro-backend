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
use App\Http\Traits\Journal;

/**
this model sen mail on registre in tbl_noti_modulo

 **/

/**sender struct **/


class MailModuleAttachment extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table = "tbl_mail_modulo_adj";
    protected $dates = ['deleted_at'];

    // constructores
    function __construct()
    {


    }

}