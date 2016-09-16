<?php
namespace App\Models\Sistema\Masters;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Log;

final class FileModel extends Model
{

    use SoftDeletes;
    protected $table = 'tbl_archivo';

    protected $dates = ['deleted_at'];

    private $types = ["pdf", "docx", "pptx", "xlsx", "xls"]; ///agregar tipos de archivos a la lista
    private $docsTypes = [
        "pdf" => "Pdf.jpg",
        "docx" => "Word.jpg",
        "pptx" => "PowerPoint.jpg",
        "xlsx" => "Excel.jpg",
        "xls" => "Excel.jpg"]; //documentos


    public function getThumbName()
    {

        try {
            if ($this->isImage()) { ///es una imagen
                $name = explode('.', $this->archivo);
                $thumbName = $name[0] . '_thumb.' . $name[1];

            } else {

                if (in_array($this->getType(), $this->types)) ////si es un tipo conocido
                    $thumbName = $this->docsTypes[$this->getType()];
                else
                    $thumbName = 'ImageDefect.jpg';

            }
        } catch (\Exception $e) {
            Log::error("no se puede obtener el nombre");
        }

        return $thumbName;

    }


    private function isImage()
    {
        return ($this->tipo == "images/") ? true : false;
    }

    public function getType()
    {
        $type = explode('.', trim($this->archivo)); ////ext de archivo
        return Str::lower($type[1]);

    }


}