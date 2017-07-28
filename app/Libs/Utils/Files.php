<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 3/6/2016
 * Time: 4:00 PM
 */

namespace app\Libs\Utils;

use App\Libs\Api\RestApi;
use App\Models\Sistema\Masters\FileModel;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Log;
use Request;
use Session;
use Storage;


class Files
{


    private $fileSystem;
    private $module;
    private $docsPath = "docs/"; ///ruta para los documentos
    private $imagePath = "images/"; ///ruta para las imagenes
    private $imagePathThumb = "/public/images/thumbs/"; //ruta para los archivos thumbnail
    private $imageThumbWidth = 72;
    private $currentFileName; ////nombre del ultimo archivo
    private $currentFileId; ///id en la tabla tbl_archivo del ultimo archivo subido
    private $currentFileType; ///tipo de archivo subido
    private $currentFileThumbName; ///nombre de la imagen en miniatura

    /**
     * Files constructor.
     * @param $disk
     */
    public function __construct($disk)
    {

        $this->fileSystem = Storage::disk($disk);
        $this->module = $disk;
        $this->imagePathThumb = base_path() . $this->imagePathThumb;
    }


    /**subir archivo
     * @param $fileName
     */
    public function upload($fileName)
    {

        $rest = new RestApi();

        try {

            Log::info("Subiendo archivo al servidor");

            $file = $fileName;
//dd($file->getMimeType());
            $mime = $file->getMimeType();


            $this->currentFileType = $mime;
            $type = (substr($mime, 0, 5) == "image") ? $this->imagePath : $this->docsPath;
            $extension = $file->getClientOriginalExtension();

            Log::info("archivo subido!! obteniendo datos del archivo");
//dd("hasta aqui");
            ///////generando nombre de archivo
            $archivo = new FileModel();
            $archivo->modulo = $this->module;
            $archivo->tipo = $type;
            $archivo->mime = $mime;
            $dataUser = Session::get("DATAUSER");
            $archivo->user_id = $dataUser["id"]; // id del ususario
            $archivo->archivo="TEMP".'-' . $dataUser["id"] . '-' . date("Y-m-d_h_i_s");
            $archivo->save();
            ////regla para el nombre
            $fileName = $archivo->id . '-' . str_random(13) . '-' . $dataUser["id"] . '-' . date("Y-m-d_h_i_s");


            ////en caso de ser una imagen hacer el redimensionado para obtener el thumbnail


          /*  if ($type == "images/") {
                Log::info("guardando imagen $fileName en thumb ");
                Image::make(File::get($file))->resize($this->imageThumbWidth, null, function ($constraint) {
                    $constraint->aspectRatio();

                })->save($this->imagePathThumb . $fileName . '_thumb' . '.' . $extension); ///guardando imagenes
            }*/


            if ($type == "images/") {
                Log::info("guardando imagen $fileName en thumb ");
                Image::make(File::get($file))->resize($this->imageThumbWidth, $this->imageThumbWidth)->save($this->imagePathThumb . $fileName . '_thumb' . '.' . $extension); ///guardando imagenes
            }


            $this->currentFileThumbName =  $fileName . '_thumb' . '.' . $extension;
            Log::info("nombre del thumb $this->currentFileThumbName");

            $fileName = $fileName . "." . $extension; ///extension
            /////subiendo archivo
            $this->fileSystem->put($type . $fileName, File::get($file));


            Log::info("guardando registro de archivo a base de datos");
            //////asignado el nombre
            $archivo->archivo = $fileName;
            $archivo->save();

            ////setiando nombre de archivo adjunto e ID
            $this->currentFileName = $fileName;
            $this->currentFileId = $archivo->id;

            $rest->setContent("ok");
           // dd($this);

        } catch (\Exception $e) {
            //dd("error");
            Log::error("Error guardando Archivo $fileName, Ref:" . $e);
            $rest->setError("fallo");

        }


        return $rest->responseJson();

    }

    public function pdf (){
        $archivo = new FileModel();
        $archivo->modulo = $this->module;
        $archivo->tipo = 'application/pdf';
        $archivo->mime = 'docs/';
        $dataUser = Session::get("DATAUSER");
        $archivo->user_id = $dataUser["id"]; // id del ususario
        $fileName = $archivo->id . '-' . str_random(13) . '-' . $dataUser["id"] . '-' . date("Y-m-d_h_i_s");
        $archivo->archivo = $fileName;
        $archivo->save();
        return FileModel::find($archivo->id);
    }


    /**borrar archivo
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete($name)
    {
        $this->fileSystem->delete($name);
        return response()->json('success');
    }


    /**traer lista
     * @param $path
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFileList($path)
    {

        $files = $this->fileSystem->files($path);
        return response()->json($files);

    }

    /**busca y muestra un archivo, dada su ruta
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFile($name)

    {

        try {

            Log::info("buscando archivo");

            $archivo = response()->make($this->fileSystem->get($name), 200, [
                'Content-Type' => $this->fileSystem->mimeType($name),
                'Content-Disposition' => 'inline; ' . $name,
            ]);

        } catch (\Exception $e) {

            Log::error("no se  encontro el archivo $name");
            $archivo = null;

        }

        return $archivo;


    }
    /**busca y muestra un archivo, dada su ruta
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAttach($name)

    {

        try {

            Log::info("buscando archivo");

            $archivo = response()->make($this->fileSystem->get($name), 200, [
                'Content-Type' => $this->fileSystem->mimeType($name),
                'Content-Disposition' => 'inline; ' . $name,
            ]);

        } catch (\Exception $e) {

            Log::error("no se  encontro el archivo $name");
            $archivo = null;

        }

        return $archivo;


    }

    /**
     * @return mixed
     */
    public function getCurrentFileName()
    {
        return $this->currentFileName;
    }

    /**
     * @return mixed
     */
    public function getCurrentFileId()
    {
        return $this->currentFileId;
    }

    /**
     * @return mixed
     */
    public function getCurrentFileType()
    {
        return $this->currentFileType;
    }

    /**
     * @return mixed
     */
    public function getCurrentFileThumbName()
    {
        return $this->currentFileThumbName;
    }


}