<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 3/6/2016
 * Time: 4:00 PM
 */

namespace app\Libs\Utils;

use App\Models\Sistema\FileModel;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Request;
use Storage;

class Files
{


    private $fileSystem;
    private $module;
    private $docsPath = "docs/"; ///ruta para los documentos
    private $imagePath = "images/"; ///ruta para las imagenes

    /**
     * Files constructor.
     * @param $disk
     */
    public function __construct($disk)
    {

        $this->fileSystem = Storage::disk($disk);
        $this->module = $disk;
    }


    /**subir archivo
     * @param $fileName
     */
    public function upload($fileName)
    {

        $file = Request::file($fileName);

        $type = (substr($file->getMimeType(), 0, 5) == "image") ? $this->imagePath : $this->docsPath;
        $extension = $file->getClientOriginalExtension();

        try {

            ///////generando nombre de archivo
            $archivo = new FileModel();
            $archivo->modulo = $this->module;
            $archivo->tipo = $type;
            $archivo->save();
            ////regla para el nombre
            $fileName = $archivo->id . '-' . md5($file->getFilename()) . '-' . date("Y-m-d_h_i_s") . "." . $extension;

            /////subiendo archivo
            $this->fileSystem->put($type . $fileName, File::get($file));

            //////asignado el nombre
            $archivo->archivo = $fileName;
            $archivo->save();

        } catch (\Exception $e) {


        }


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

        return response()->make($this->fileSystem->get($name), 200, [
            'Content-Type' => $this->fileSystem->mimeType($name),
            'Content-Disposition' => 'inline; ' . $name,
        ]);

    }


}