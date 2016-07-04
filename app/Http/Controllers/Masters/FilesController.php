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

		$fil['id']= $archivo->getCurrentFileId();
		$fil['file']= $archivo->getCurrentFileName();
		$fil['thumb']= $archivo->getCurrentFileThumbName();
		$fil['tipo']= $archivo->getCurrentFileType();
		$resul['file']= $fil;
		$resul['folder']= $req->folder;
		return $fil;
	}


    public function getFileId(Request $req){
        $file = FileModel::findOrFail($req->id);
        $archivo = new Files($file->modulo);

        return $archivo->getFile("images"."/".$file->archivo);

    }
}