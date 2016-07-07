<?php
namespace App\Http\Controllers\Masters;


use App\Libs\Utils\Files;
use App\Models\Sistema\FileModel;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;

use App\Models\Sistema\CargoContact;


class FilesController extends BaseController
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function  uploadFile( Request $req){


		$fil= array();
		$archivo = new Files($req->folder);
		$archivo->upload("file"); ///probando
		$resul['accion']= "upLoad";

		$fl = FileModel::findOrFail($archivo->getCurrentFileId());

		$fil['id']= $fl->id;
		$fil['file']= $fl->archivo;
		$fil['thumb']= $fl->getThumbName();
		$fil['tipo']= $fl->tipo;

		return $fil;
	}


    public function getFileId(Request $req){
        $file = FileModel::findOrFail($req->id);
        $archivo = new Files($file->modulo);

        return $archivo->getFile($file->tipo.$file->archivo);

    }
}