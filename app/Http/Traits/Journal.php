<?php

/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 10/12/16
 * Time: 02:32 PM
 */
namespace App\Http\Traits;
use Session;
use App\Models\Sistema\Audittrail\Audittrail;
trait Journal
{
    private static function audit($model,$act){
        $toAudit = array();
        switch ($act){
            case "new":
                $date = $model->attributes["created_at"];
                break;
            case "upd":
                $date = $model->attributes["updated_at"];
                break;
            case "del":
                $date = $model->attributes["deleted_at"];
                break;
        }
        $usr = Session::get("DATAUSER");
        $key = $model->attributes[$model->primaryKey];

        $master = ($act=="del")?$model->original:$model->attributes;
        foreach ($master as $k => $att){

            if($k!="updated_at" && $k!="created_at" && $k!="deleted_at" && (!is_int($k))){
                $toAudit[]=array(
                            "datetime"=>$date,
                            "user" => $usr['id'],
                            "action" => $act,
                            "table" => $model->table,
                            "field" => $k,
                            "keyvalue" => $key,
                            "oldvalue" => ($act!="new")?$model->original[$k]:"",
                            "newValue" => ($act!="del")?$att:""
                        );
            }
        }
        Audittrail::insert($toAudit);
    }

    public static function bootJournal(){

        static::created(function ($model) {
            self::audit($model,"new");
        });

        static::updated(function ($model) {
            self::audit($model,"upd");
        });

        static::deleted(function ($model) {
            self::audit($model,"del");
        });
    }
}