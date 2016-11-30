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



class MailPart extends Model
{
    use SoftDeletes;
    protected $table = "tbl_mail_part";
    protected $dates = ['deleted_at'];

    public function subjets (){
        return $this->hasMAny('App\Models\Sistema\MailModels\MailPartSubject','mail_part_id');
    }
    public function contents (){
        return $this->hasMAny('App\Models\Sistema\MailModels\MailPartContent','mail_part_id');
    }

}