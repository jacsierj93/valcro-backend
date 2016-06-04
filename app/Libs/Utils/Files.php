<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 3/6/2016
 * Time: 4:00 PM
 */

namespace app\Libs\Utils;

use Intervention\Image\Facades\Image;
use Storage;
use Request;
use Illuminate\Support\Facades\File;

class Files
{


    private $fileSystem;
    private $docsPath ="docs/"; ///ruta para los documentos
    private $imagePath="images/"; ///ruta para las imagenes

    /**
     * Files constructor.
     * @param $disk
     */
    public function __construct($disk)
    {

        $this->fileSystem = Storage::disk($disk);
    }


    /**subir archivo
     * @param $fileName
     */
    public function upload($fileName){

        $file = Request::file($fileName);

        $extension = $file->getClientOriginalExtension();
        $this->fileSystem->put($this->docsPath.$file->getFilename().'.'.$extension,  File::get($file));
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
    public function getFileList($path){

        $files = $this->fileSystem->files($path);
        return response()->json($files);

    }

    /**busca y muestra un archivo, dada su ruta
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFile($name){

        return response()->make($this->fileSystem->get($name), 200, [
            'Content-Type' => $this->fileSystem->mimeType($name),
            'Content-Disposition' => 'inline; '.$name,
        ]);

    }




}