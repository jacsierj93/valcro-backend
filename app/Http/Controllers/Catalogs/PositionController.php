<?php

namespace App\Http\Controllers\Catalogs;

use Laravel\Lumen\Routing\Controller as BaseController;


class PositionController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {
        return view('modules.catalogs.cargos-list');
    }


}
