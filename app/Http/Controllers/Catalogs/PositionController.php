<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Sistema\Position;
use Laravel\Lumen\Routing\Controller as BaseController;


class PositionController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {

        $data = Position::all();

        return view('modules.catalogs.cargos-list', ['data' => $data]);
    }


}
