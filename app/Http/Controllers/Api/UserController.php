<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 5/11/2015
 * Time: 9:07 AM
 */
namespace App\Http\Controllers\Api;

use App\Libs\Api\RestApi;
use App\Models\Obra;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{


    public function info()
    {
        return phpinfo();
    }


}