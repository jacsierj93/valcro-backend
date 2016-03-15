<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 25/12/2015
 * Time: 8:12 PM
 */

namespace App\Http\Middleware;

use Closure;


class RequiredModule
{

    protected $auth;


    public function __construct()
    {

    }

    public function handle($request, Closure $next, $required)
    {

        $modules = $request->session()->get('DATAUSER')->accesos; ///accesos del usuario

        if (!in_array($required, $modules)) {

            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('unauthorized'); ///pagina de no permitido el acceso
            }

        }

        return $next($request);
    }

}